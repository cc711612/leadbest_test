<?php
/**
 * @Author: Roy
 * @DateTime: 2023/1/31 下午 09:43
 */

namespace App\Http\Macro;

use App\Models\BalanceEntity;
use App\Models\Services\BalanceService;
use App\Http\Macro\Contracts\MacroAbstract;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Models\BalanceLogEntity;

class BalanceMacro extends MacroAbstract
{
    /**
     * @var \App\Models\BalanceEntity
     */
    public $CreditBalance;
    /**
     * @var \App\Models\BalanceEntity
     */
    public $DebitBalance;

    public $BalanceService;


    public function __construct()
    {
        $this->setBalanceService();
        $this->initResult();
    }

    /**
     * @return array
     * @Author: Roy
     * @DateTime: 2023/2/1 下午 09:15
     */
    public function calculate()
    {
        DB::transaction(function () {
            try {
                $this->setBalances();
                $this->validateBalance();
                $this->updateBalanceAndCreateLogs(floatval($this->getRequestByKey('money')));
                $this->setStatus(true);
            } catch (\Throwable $exception) {
                $this->setMessage($exception->getMessage());
            }
        });

        return $this->getResult();
    }

    private function setBalanceService(): void
    {
        if (is_null($this->BalanceService)) {
            $this->BalanceService = app(BalanceService::class);
        }
    }

    private function getBalanceService(): BalanceService
    {
        if (is_null($this->BalanceService)) {
            $this->setBalanceService();
        }
        return $this->BalanceService;
    }

    private function setBalances()
    {
        $BalanceService = $this->getBalanceService();
        $this->CreditBalance = $BalanceService->getLockForUpdateBalanceByUserId($this->getRequestByKey('CreditUser'));
        $this->DebitBalance = $BalanceService->getLockForUpdateBalanceByUserId($this->getRequestByKey('DebitUser'));
    }

    private function validateBalance(): bool
    {
        if (is_null($this->CreditBalance) || is_null($this->DebitBalance)) {
            throw new \Exception('應用程式發生問題，請稍後再試');
        }
        if (floatval($this->CreditBalance->balance) < floatval($this->getRequestByKey('money'))) {
            throw new \Exception('餘額不足');
        }
        return true;
    }

    private function updateBalanceAndCreateLogs(float $money): void
    {
        $this->CreditBalance->decrement('balance', $money);
        $this->DebitBalance->increment('balance', $money);
        $this->CreditBalance->save();
        $this->CreditBalance->balance_logs()->create([
            'transaction_type' => BalanceLogEntity::CREDIT,
            'amount'           => $money,
        ]);
        $this->DebitBalance->save();
        $this->DebitBalance->balance_logs()->create([
            'transaction_type' => BalanceLogEntity::DEBIT,
            'amount'           => $money,
        ]);
    }
}

<?php
/**
 * @Author: Roy
 * @DateTime: 2023/1/31 下午 05:48
 */

namespace App\Models\Services;

use App\Models\Services\Contracts\ServiceAbstract;
use Illuminate\Database\Eloquent\Model;
use App\Models\BalanceEntity;
use Illuminate\Support\Collection;

class BalanceService extends ServiceAbstract
{
    /**
     * @return \Illuminate\Database\Eloquent\Model
     * @Author: Roy
     * @DateTime: 2023/2/1 下午 07:54
     */
    protected function getEntity(): Model
    {
        if (app()->has(BalanceEntity::class) === false) {
            app()->singleton(BalanceEntity::class);
        }

        return app(BalanceEntity::class);
    }

    public function getLockForUpdateBalanceByUserId(int $user_id)
    {
        return BalanceEntity::lockForUpdate()
            ->where('user_id', $user_id)
            ->first();
    }

    /**
     * @param  int  $user_id
     *
     * @return \App\Models\BalanceEntity
     * @Author: Roy
     * @DateTime: 2023/2/1 下午 07:32
     */
    public function createByUserId(int $user_id): BalanceEntity
    {
        return $this->getEntity()
            ->create(['user_id' => $user_id]);
    }
}

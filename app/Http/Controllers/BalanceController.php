<?php
/**
 * @Author: Roy
 * @DateTime: 2023/1/31 下午 04:00
 */

namespace App\Http\Controllers;

use App\Http\Macro\BalanceMacro;

class BalanceController extends Controller
{
    public function solution()
    {
        $CreditUser = 1;
        $DebitUser = 2;
        $money = 5000;
        return response()->json(app(BalanceMacro::class)
            ->setRequest([
                'CreditUser' => $CreditUser,
                'DebitUser'  => $DebitUser,
                'money'      => $money,
            ])
            ->calculate());
    }
}

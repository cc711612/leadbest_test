<?php
/**
 * @Author: Roy
 * @DateTime: 2023/1/31 下午 04:03
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceEntity extends Model
{
    const Table = 'balances';

    protected $table = 'balances';

    protected $connection = 'mysql';

    protected $fillable = [
        'user_id',
        'balance',
        'created_at',
        'updated_at',
    ];

    public function balance_logs()
    {
        return $this->hasMany(BalanceLogEntity::class, 'user_id', 'user_id');
    }
}

<?php
/**
 * @Author: Roy
 * @DateTime: 2023/1/31 下午 04:03
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceLogEntity extends Model
{
    const Table  = 'balance_logs';
    const CREDIT = 'CREDIT';
    const DEBIT  = 'DEBIT';

    protected $table = 'balance_logs';

    protected $connection = 'mysql';

    protected $fillable = [
        'user_id',
        'transaction_type',
        'amount',
        'created_at',
        'updated_at',
    ];

    public function balance()
    {
        return $this->belongsTo(BalanceEntity::class,'user_id','user_id');
    }
}

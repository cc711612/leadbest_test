<?php
/**
 * @Author: Roy
 * @DateTime: 2023/1/31 下午 05:14
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\BalanceEntity;

class InitializationBalanceSeeder extends Seeder
{
    public function run()
    {
        $Inserts = [];
        for ($i = 1; $i <= 2; $i++) {
            $Inserts[] = [
                'user_id'    => $i,
                'balance'    => 10000,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        Schema::disableForeignKeyConstraints();
        BalanceEntity::truncate();
        BalanceEntity::insert($Inserts);
        Schema::enableForeignKeyConstraints();
    }
}

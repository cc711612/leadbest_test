<?php
/**
 * @Author: Roy
 * @DateTime: 2023/1/31 下午 05:14
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class InitializationUserSeeder extends Seeder
{
    public function run()
    {
        $Inserts = [];
        for ($i = 1; $i <= 2; $i++) {
            $Inserts[] = [
                'id'       => $i,
                'name'     => sprintf("M000%s", $i),
                'email'    => sprintf("M000%s@test.com", $i),
                'password' => Hash::make(Str::random(10)),
            ];
        }
        Schema::disableForeignKeyConstraints();
        User::truncate();
        User::insert($Inserts);
        Schema::enableForeignKeyConstraints();
    }
}

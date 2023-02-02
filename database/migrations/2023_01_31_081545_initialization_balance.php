<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InitializationBalance extends Migration
{
    protected $connection = 'mysql';
    protected $table = 'balances';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->create($this->table, function (Blueprint $table) {
            $table->integerIncrements('id')->unsigned()->commit('流水號');
            $table->unsignedInteger('user_id')->unique()->comment('users 的流水號');
            $table->decimal('balance')->comment('當前存款金額');
            $table->timestamps();
            $table->foreign('user_id')->on('users')->references('id');
        });

        DB::connection($this->connection)->statement("ALTER TABLE `{$this->table}` comment 'Balance 資料表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //刪除新的
        Schema::connection($this->connection)->dropIfExists($this->table);
    }
}

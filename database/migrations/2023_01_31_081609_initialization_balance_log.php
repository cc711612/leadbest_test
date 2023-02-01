<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InitializationBalanceLog extends Migration
{
    protected $connection = 'mysql';
    protected $table = 'balance_logs';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->create($this->table, function (Blueprint $table) {
            $table->integerIncrements('id')->unsigned()->commit('流水號');
            $table->unsignedInteger('user_id')->comment('users 的流水號');
            $table->enum('transaction_type',[\App\Models\BalanceLogEntity::CREDIT,\App\Models\BalanceLogEntity::DEBIT])->comment('交易類型');
            $table->decimal('amount')->comment('金額');
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

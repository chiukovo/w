<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetsUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->enum('game', ['威力彩', '大樂透', '今彩539'])->index(); // 快速查詢用
            $table->integer('bet_count'); //下注張數
            $table->bigInteger('total_cost'); //總花費
            $table->bigInteger('total_win'); //總中獎金額
            $table->bigInteger('net_profit'); //盈虧 (正負)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bets');
    }
}

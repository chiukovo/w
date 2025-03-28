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
            $table->foreignId('user_id')->constrained()->index();
            $table->string('game', 20)->index(); // 可用代碼代表遊戲，避免 enum 受限
            $table->unsignedBigInteger('bet_count')->default(0);
            $table->unsignedBigInteger('total_cost')->default(0);
            $table->unsignedBigInteger('total_win')->default(0);
            $table->bigInteger('net_profit')->default(0); // 可正負
            $table->date('stat_date')->nullable()->index(); // 可支援日統計
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

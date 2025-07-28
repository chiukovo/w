<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('refine_rankings', function (Blueprint $table) {
            $table->id();
            $table->string('nickname', 32)->unique(); // 暱稱唯一
            $table->unsignedInteger('refine_count'); // 精煉次數
            $table->timestamp('achieved_at'); // 達成+15的時間
            $table->unsignedBigInteger('total_cost')->default(0); // 達成時總花費
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('refine_rankings');
    }
};

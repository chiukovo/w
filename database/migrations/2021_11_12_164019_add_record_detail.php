<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecordDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->default(0);
            $table->integer('count');
            $table->integer('t_id');
            $table->string('account');
            $table->integer('gradeId');
            $table->date('date');
            $table->index(['date']);
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
        Schema::dropIfExists('record_detail');
    }
}

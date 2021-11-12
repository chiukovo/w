<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->default(0);
            $table->integer('count');
            $table->string('account');
            $table->integer('g_1')->default(0);
            $table->integer('g_2')->default(0);
            $table->integer('g_3')->default(0);
            $table->integer('g_4')->default(0);
            $table->integer('g_5')->default(0);
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
        Schema::dropIfExists('records');
    }
}

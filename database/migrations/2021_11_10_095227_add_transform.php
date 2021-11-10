<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransform extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transform', function (Blueprint $table) {
            $table->id();
            $table->integer('t_id')->unique();
            $table->string('name');
            $table->integer('gradeId');
            $table->text('image');
            $table->text('weaponTypeList');
            $table->text('buffBonusList');
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
        Schema::dropIfExists('transform');
    }
}

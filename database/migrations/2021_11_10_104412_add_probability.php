<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProbability extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('probability', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('gradeId')->unique();
            $table->decimal('probability', 16, 4);
            $table->timestamps();
        });

        $date = date('Y-m-d H:i:s');

        //紫變
        DB::table('probability')->insert([
            'gradeId' => 5,
            'name' => '紫變',
            'probability' => 0,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        //紅變
        DB::table('probability')->insert([
            'gradeId' => 4,
            'name' => '英雄',
            'probability' => 0.0082,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        //藍變
        DB::table('probability')->insert([
            'gradeId' => 3,
            'name' => '稀有',
            'probability' => 0.5509,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        //高級
        DB::table('probability')->insert([
            'gradeId' => 2,
            'name' => '高級',
            'probability' => 15,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        //一般
        DB::table('probability')->insert([
            'gradeId' => 1,
            'name' => '一般',
            'probability' => 84.4409,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('probability');
    }
}

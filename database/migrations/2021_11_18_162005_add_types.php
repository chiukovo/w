<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transform', function (Blueprint $table) {
            $table->integer('type')->default(0)->after('t_id');
        });

        Schema::dropIfExists('probability');

        Schema::create('probability', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->default(0);
            $table->string('name');
            $table->integer('gradeId');
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
            'probability' => 0.0882,
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
            'probability' => 20.2117,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        //一般
        DB::table('probability')->insert([
            'gradeId' => 1,
            'name' => '一般',
            'probability' => 79.1492,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        //紫變
        DB::table('probability')->insert([
            'gradeId' => 5,
            'name' => '紫變',
            'type' => 1,
            'probability' => 0,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        //紅變
        DB::table('probability')->insert([
            'gradeId' => 4,
            'name' => '英雄',
            'type' => 1,
            'probability' => 0.0882,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        //藍變
        DB::table('probability')->insert([
            'gradeId' => 3,
            'name' => '稀有',
            'type' => 1,
            'probability' => 0.5509,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        //高級
        DB::table('probability')->insert([
            'gradeId' => 2,
            'name' => '高級',
            'type' => 1,
            'probability' => 20.2117,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        //一般
        DB::table('probability')->insert([
            'gradeId' => 1,
            'name' => '一般',
            'type' => 1,
            'probability' => 79.1492,
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
        Schema::table('transform', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('probability', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}

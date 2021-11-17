<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('total_count')->default(0);
            $table->decimal('total_c_5', 16, 4)->default(0);
            $table->decimal('total_p_5', 16, 4)->default(0);
            $table->decimal('total_c_4', 16, 4)->default(0);
            $table->decimal('total_p_4', 16, 4)->default(0);
            $table->decimal('total_p_3', 16, 4)->default(0);
            $table->decimal('total_c_3', 16, 4)->default(0);
            $table->decimal('total_p_2', 16, 4)->default(0);
            $table->decimal('total_c_2', 16, 4)->default(0);
            $table->decimal('total_p_1', 16, 4)->default(0);
            $table->decimal('total_c_1', 16, 4)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('total_count');
            $table->dropColumn('total_p_5');
            $table->dropColumn('total_p_4');
            $table->dropColumn('total_p_3');
            $table->dropColumn('total_p_2');
            $table->dropColumn('total_p_1');
            $table->dropColumn('total_c_5');
            $table->dropColumn('total_c_4');
            $table->dropColumn('total_c_3');
            $table->dropColumn('total_c_2');
            $table->dropColumn('total_c_1');
        });
    }
}

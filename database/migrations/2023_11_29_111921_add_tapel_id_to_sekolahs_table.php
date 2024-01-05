<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTapelIdToSekolahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sekolah', function (Blueprint $table) {
            $table->unsignedBigInteger('tapel_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('term_id');

            $table->foreign('tapel_id')->references('id')->on('tapels');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('term_id')->references('id')->on('terms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sekolah', function (Blueprint $table) {
            $table->dropColumn('tapel_id');
            $table->dropColumn('semester_id');
            $table->dropColumn('term_id');
        });
    }
}

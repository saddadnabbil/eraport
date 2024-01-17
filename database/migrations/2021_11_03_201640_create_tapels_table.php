<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTapelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tapels', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_pelajaran', 9);
            $table->unsignedBigInteger('semester_id')->unsigned();
            $table->unsignedBigInteger('term_id')->unsigned();
            $table->timestamps();

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
        Schema::dropIfExists('tapels');
    }
}

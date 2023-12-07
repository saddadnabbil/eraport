<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSilabusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('silabuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembelajaran_id')->unsigned();
            $table->unsignedBigInteger('kelas_id')->unsigned();
            $table->unsignedBigInteger('mapel_id')->unsigned();
            $table->string('k_tigabelas')->nullable();
            $table->string('cambridge')->nullable();
            $table->string('edexcel')->nullable();
            $table->string('book_indo_siswa')->nullable();
            $table->string('book_english_siswa')->nullable();
            $table->string('book_indo_guru')->nullable();
            $table->string('book_english_guru')->nullable();
            $table->timestamps();

            $table->foreign('pembelajaran_id')->references('id')->on('pembelajaran');
            $table->foreign('kelas_id')->references('id')->on('kelas');
            $table->foreign('mapel_id')->references('id')->on('mapel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('silabuses');
    }
}

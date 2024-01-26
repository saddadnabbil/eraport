<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRencanaNilaiFormatifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rencana_nilai_formatifs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembelajaran_id')->unsigned();
            $table->unsignedBigInteger('semester_id')->unsigned();
            $table->unsignedBigInteger('term_id')->unsigned();
            $table->unsignedBigInteger('capaian_pembelajaran_id')->unsigned()->nullable();
            $table->string('kode_penilaian');
            $table->enum('teknik_penilaian', ['1', '2', '3', '4', '5']);
            $table->integer('bobot_teknik_penilaian');
            $table->timestamps();

            $table->foreign('pembelajaran_id')->references('id')->on('pembelajaran');
            $table->foreign('capaian_pembelajaran_id')->references('id')->on('capaian_pembelajarans');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('term_id')->references('id')->on('terms');

            // Teknik Penilaian
            // 1 = Parktik
            // 2 = Projek
            // 3 = Produk
            // 4 = Teknik 1
            // 5 = Teknik 2
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rencana_nilai_formatifs');
    }
}

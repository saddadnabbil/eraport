<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKmNilaiAkhirRaportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('km_nilai_akhir_raports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembelajaran_id')->unsigned();
            $table->unsignedBigInteger('anggota_kelas_id')->unsigned();
            $table->unsignedBigInteger('semester_id')->unsigned();
            $table->unsignedBigInteger('term_id')->unsigned();
            $table->integer('kkm');
            $table->integer('nilai_sumatif');
            $table->enum('predikat_sumatif', ['A', 'B', 'C', 'D']);
            $table->integer('nilai_formatif');
            $table->enum('predikat_formatif', ['A', 'B', 'C', 'D']);
            $table->integer('nilai_akhir_raport');
            $table->enum('predikat_akhir_raport', ['A', 'B', 'C', 'D']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pembelajaran_id')->references('id')->on('pembelajaran')->onDelete('cascade');
            $table->foreign('anggota_kelas_id')->references('id')->on('anggota_kelas')->onDelete('cascade');
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
        Schema::dropIfExists('km_nilai_akhir_raports');
    }
}

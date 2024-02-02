<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKmNilaiAkhirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('km_nilai_akhirs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembelajaran_id')->unsigned();
            $table->unsignedBigInteger('anggota_kelas_id')->unsigned();
            $table->unsignedBigInteger('semester_id')->unsigned();
            $table->unsignedBigInteger('term_id')->unsigned();
            $table->integer('nilai_akhir_formatif');
            $table->integer('nilai_akhir_sumatif');
            $table->integer('nilai_akhir_raport');
            $table->integer('nilai_akhir_revisi')->nullable();
            $table->timestamps();
            $table->softDeletes();            
            
            $table->foreign('anggota_kelas_id')->references('id')->on('anggota_kelas')->onDelete('cascade');
            $table->foreign('pembelajaran_id')->references('id')->on('pembelajaran')->onDelete('cascade');
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
        Schema::dropIfExists('km_nilai_akhirs');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKmDeskripsiNilaiSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('km_deskripsi_nilai_siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembelajaran_id')->unsigned();
            $table->unsignedBigInteger('term_id')->unsigned();
            $table->unsignedBigInteger('km_nilai_akhir_raport_id')->unsigned();
            $table->string('deskripsi_raport', 200)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pembelajaran_id')->references('id')->on('pembelajaran')->onDelete('cascade');
            $table->foreign('term_id')->references('id')->on('terms');
            $table->foreign('km_nilai_akhir_raport_id')->references('id')->on('km_nilai_akhir_raports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('km_deskripsi_nilai_siswas');
    }
}

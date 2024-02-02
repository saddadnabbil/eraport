<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKmNilaiFormatifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('km_nilai_formatifs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rencana_nilai_formatif_id')->unsigned();
            $table->unsignedBigInteger('anggota_kelas_id')->unsigned();
            $table->integer('nilai')->nullable();
            $table->timestamps();
            $table->softDeletes();            
            
            $table->foreign('rencana_nilai_formatif_id')->references('id')->on('rencana_nilai_formatifs')->onDelete('cascade');
            $table->foreign('anggota_kelas_id')->references('id')->on('anggota_kelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('km_nilai_formatifs');
    }
}

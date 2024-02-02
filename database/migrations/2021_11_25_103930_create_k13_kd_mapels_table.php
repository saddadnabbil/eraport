<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateK13KdMapelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k13_kd_mapel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mapel_id')->unsigned();
            $table->unsignedBigInteger('tingkatan_id')->unsigned();
            $table->enum('jenis_kompetensi', ['1', '2', '3', '4']);
            $table->enum('semester', ['1', '2']);
            $table->string('kode_kd', 10);
            $table->string('kompetensi_dasar');
            $table->string('ringkasan_kompetensi', 150);
            $table->timestamps();
            $table->softDeletes();            
            
            $table->foreign('mapel_id')->references('id')->on('mapel');
            $table->foreign('tingkatan_id')->references('id')->on('tingkatans');

            // Jenis Kompetensi
            // 1 = Sikap Spiritual
            // 2 = Sikap Sosial 
            // 3 = Pengetahuan
            // 4 = Keterampilan
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('k13_kd_mapel');
    }
}

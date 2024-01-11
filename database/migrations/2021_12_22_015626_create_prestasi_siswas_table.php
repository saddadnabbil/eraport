<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestasiSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestasi_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('anggota_kelas_id')->unsigned();
            $table->string('nama_prestasi', 100);
            $table->enum('jenis_prestasi', ['1', '2']);
            $table->enum('tingkat_prestasi', ['1', '2', '3', '4', '5']);
            $table->string('deskripsi', 200);
            $table->timestamps();

            $table->foreign('anggota_kelas_id')->references('id')->on('anggota_kelas');
        });

        // Jenis Prestasi 
        // 1 = Akademik 
        // 2 = Non Akademik

        // Tingkat Prestasi
        // 1 = Internasional
        // 2 = Nasional
        // 3 = Provinsi
        // 4 = Kabupaten
        // 5 = Kecamatan
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prestasi_siswa');
    }
}

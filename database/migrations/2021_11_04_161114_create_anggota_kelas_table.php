<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggota_kelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id')->unsigned();
            $table->unsignedBigInteger('kelas_id')->unsigned()->nullable();
            $table->unsignedBigInteger('tapel_id')->unsigned()->nullable();
            $table->enum('pendaftaran', ['1', '2', '3', '4', '5']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('tapel_id')->references('id')->on('tapels')->onDelete('cascade');
        });

        // Pendaftaran 
        // 1 = Siswa Baru
        // 2 = Pindahan 
        // 3 = Naik Kelas 
        // 4 = Lanjutan Semester
        // 5 = Mengulang 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anggota_kelas');
    }
}

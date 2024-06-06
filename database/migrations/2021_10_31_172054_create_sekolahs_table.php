<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSekolahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sekolah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tapel_id')->unsigned();
            $table->string('nama_sekolah', 100);
            $table->string('npsn', 10);
            $table->string('nss', 15)->nullable();
            $table->string('kode_pos', 5);
            $table->string('nomor_telpon', 13)->nullable();
            $table->string('alamat');
            $table->string('website', 100)->nullable();
            $table->string('email', 35)->nullable();
            $table->string('logo');
            $table->string('kepala_sekolah', 100);
            $table->string('nip_kepala_sekolah', 18);
            $table->string('ttd_kepala_sekolah')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tapel_id')->references('id')->on('tapels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sekolah');
    }
}

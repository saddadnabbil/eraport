<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->unsignedBigInteger('status_karyawan_id')->unsigned()->nullable();
            $table->unsignedBigInteger('unit_karyawan_id')->unsigned()->nullable();
            $table->unsignedBigInteger('position_karyawan_id')->unsigned()->nullable();
            $table->date('join_date')->nullable();
            $table->date('resign_date')->nullable();
            $table->date('permanent_date')->nullable();

            $table->string('kode_karyawan', 25)->nullable();
            $table->string('nama_lengkap', 255);
            $table->string('nik', 16)->nullable();
            $table->string('nomor_akun', 255)->nullable();
            $table->string('nomor_fingerprint')->nullable();

            $table->string('nomor_taxpayer', 255)->nullable();
            $table->string('nama_taxpayer', 255)->nullable();
            $table->string('nomor_bpjs_ketenagakerjaan', 255)->nullable();
            $table->string('iuran_bpjs_ketenagakerjaan', 255)->nullable();
            $table->string('nomor_bpjs_yayasan', 255)->nullable();
            $table->string('nomor_bpjs_pribadi', 255)->nullable();

            $table->enum('jenis_kelamin', ['MALE', 'FEMALE']);
            $table->enum('agama', ['1', '2', '3', '4', '5', '6', '7']);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat')->nullable();
            $table->string('alamat_sekarang')->nullable();
            $table->string('kota')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('nomor_phone')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('email_sekolah')->nullable();
            $table->string('warga_negara')->nullable();
            $table->enum('status_pernikahan', ['1', '2', '3', '4'])->nullable();
            $table->string('nama_pasangan')->nullable();
            $table->string('jumlah_anak')->nullable();
            $table->string('keterangan')->nullable();

            $table->string('pas_photo')->nullable();
            $table->string('photo_kartu_identitas')->nullable();
            $table->string('photo_taxpayer')->nullable();
            $table->string('photo_kk')->nullable();
            $table->string('other_document')->nullable();

            $table->boolean('status')->default(true);
            $table->string('avatar');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('status_karyawan_id')->references('id')->on('status_karyawans')->onDelete('cascade');
            $table->foreign('unit_karyawan_id')->references('id')->on('unit_karyawans')->onDelete('cascade');
            $table->foreign('position_karyawan_id')->references('id')->on('position_karyawans')->onDelete('cascade');

            // Agama
            // 1 = Islam 
            // 2 = Protestan
            // 3 = Katolik
            // 4 = Hindu
            // 5 = Budha
            // 6 = Khonghucu 
            // 7 = Lainnya
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('karyawans');
    }
}

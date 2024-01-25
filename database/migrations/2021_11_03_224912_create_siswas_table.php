<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            // student information
            $table->id();
            $table->unsignedBigInteger('user_id')->unique()->unsigned();
            $table->unsignedBigInteger('kelas_id')->unsigned()->nullable();
            $table->unsignedBigInteger('tingkatan_id')->unsigned()->nullable();
            $table->unsignedBigInteger('jurusan_id')->unsigned()->nullable();
            $table->enum('jenis_pendaftaran', ['1', '2']);
            $table->string('tahun_masuk');
            $table->string('semester_masuk');
            $table->string('kelas_masuk');

            $table->string('nis', 10)->unique();
            $table->string('nisn', 10)->unique()->nullable();
            $table->string('nama_lengkap', 100);
            $table->string('nama_panggilan', 100);
            $table->string('nik', 16)->unique();
            $table->enum('jenis_kelamin', ['Male', 'Female']);
            $table->enum('blood_type', ['A', 'B', 'AB', 'O'])->nullable();
            $table->enum('agama', ['1', '2', '3', '4', '5', '6', '7']);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->string('anak_ke', 2)->nullable();
            $table->string('jml_saudara_kandung', 2)->nullable();
            $table->string('warga_negara', 2)->nullable();
            $table->string('pas_photo')->nullable();

            // domicile information
            $table->string('alamat');
            $table->string('kota');
            $table->unsignedInteger('kode_pos');
            $table->unsignedInteger('jarak_rumah_ke_sekolah')->nullable();
            $table->string('email');
            $table->string('email_parent')->nullable();
            $table->string('nomor_hp', 13)->unique();
            $table->enum('tinggal_bersama', ['Parents', 'Others'])->nullable();
            $table->string('transportasi')->nullable();

            //// parent information
            // parent information father
            $table->string('nik_ayah', 16);
            $table->string('nama_ayah', 100);
            $table->string('tempat_lahir_ayah', 100)->nullable();
            $table->date('tanggal_lahir_ayah', 10)->nullable();
            $table->string('alamat_ayah', 100)->nullable();
            $table->string('nomor_hp_ayah', 13)->nullable();
            $table->enum('agama_ayah', ['1', '2', '3', '4', '5', '6', '7'])->nullable();
            $table->string('kota_ayah', 100)->nullable();
            $table->string('pendidikan_terakhir_ayah', 25)->nullable();
            $table->string('pekerjaan_ayah', 100)->nullable();
            $table->string('penghasil_ayah', 100)->nullable();
            // parent information mother
            $table->string('nik_ibu', 16);
            $table->string('nama_ibu', 100);
            $table->string('tempat_lahir_ibu', 100)->nullable();
            $table->date('tanggal_lahir_ibu', 10)->nullable();
            $table->string('alamat_ibu', 100)->nullable();
            $table->string('nomor_hp_ibu', 13)->nullable();
            $table->enum('agama_ibu', ['1', '2', '3', '4', '5', '6', '7'])->nullable();
            $table->string('kota_ibu', 100)->nullable();
            $table->string('pendidikan_terakhir_ibu', 25)->nullable();
            $table->string('pekerjaan_ibu', 100)->nullable();
            $table->string('penghasil_ibu', 100)->nullable();
            // parent information guardian
            $table->string('nik_wali', 16);
            $table->string('nama_wali', 100);
            $table->string('tempat_lahir_wali', 100)->nullable();
            $table->date('tanggal_lahir_wali', 10)->nullable();
            $table->string('alamat_wali', 100)->nullable();
            $table->string('nomor_hp_wali', 13)->nullable();
            $table->enum('agama_wali', ['1', '2', '3', '4', '5', '6', '7'])->nullable();
            $table->string('kota_wali', 100)->nullable();
            $table->string('pendidikan_terakhir_wali', 25)->nullable();
            $table->string('pekerjaan_wali', 100)->nullable();
            $table->string('penghasil_wali', 100)->nullable();

            // student medical condition information
            $table->unsignedInteger('tinggi_badan')->nullable();
            $table->unsignedInteger('berat_badan')->nullable();
            $table->string('spesial_treatment')->nullable();
            $table->string('note_kesehatan')->nullable();
            $table->string('file_document_kesehatan')->nullable();
            $table->string('file_list_pertanyaan')->nullable();

            // previeously formal school
            $table->date('tanggal_masuk_sekolah_lama', 100)->nullable();
            $table->date('tanggal_keluar_sekolah_lama', 100)->nullable();
            $table->string('nama_sekolah_lama', 100)->nullable();
            $table->string('prestasi_sekolah_lama', 100)->nullable();
            $table->string('tahun_prestasi_sekolah_lama', 100)->nullable();
            $table->string('sertifikat_number_sekolah_lama', 100)->nullable();
            $table->string('alamat_sekolah_lama', 100)->nullable();
            $table->string('no_sttb')->nullable();
            $table->unsignedInteger('nem')->nullable();
            $table->string('file_dokument_sekolah_lama')->nullable();

            $table->string('avatar');
            $table->enum('status', ['1', '2', '3']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('tingkatan_id')->references('id')->on('tingkatans');
            $table->foreign('kelas_id')->references('id')->on('kelas');
        });

        // Jenis Pendaftaran 
        // 1 = Siswa Baru
        // 2 = Pindahan

        // Agama
        // 1 = Islam 
        // 2 = Protestan
        // 3 = Katolik
        // 4 = Hindu
        // 5 = Budha
        // 6 = Khonghucu 
        // 7 = Kepercayaan

        // Status Dalam Keluarga 
        // 1 = Anak Kandung 
        // 2 = Anak Angkat 
        // 3 = Anak Tiri

        // Status
        // 1 = Aktif
        // 2 = Keluar
        // 3 = Lulus
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswa');
    }
}

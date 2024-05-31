<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\Tapel;
use Illuminate\Database\Seeder;

class SiswaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Siswa::create([
            'user_id' => 2,
            'kelas_id' => 1,
            'tingkatan_id' => 5,
            'jurusan_id' => 1,
            'jenis_pendaftaran' => '1',
            'tahun_masuk' => '2022',
            'semester_masuk' => '1',
            'kelas_masuk' => 'PA1',

            'nis' => '192007007',
            'nisn' => '0987654321',
            'nama_lengkap' => 'John Doe 1',
            'nama_panggilan' => 'John',
            'nik' => '1234567890123421',
            'email' => 'john.doe1@example.com',
            'nomor_hp' => '1234567891',
            'jenis_kelamin' => 'Male',
            'blood_type' => 'A',
            'agama' => '1',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2000-01-01',
            'anak_ke' => '01',
            'jml_saudara_kandung' => '02',
            'warga_negara' => 'ID',
            'alamat' => 'Jl. ABC No. 123',
            'kota' => 'Jakarta',
            'kode_pos' => 12345,
            'jarak_rumah_ke_sekolah' => 5,
            'tinggal_bersama' => 'Parents',
            'transportasi' => 'Car',

            'nama_ayah' => 'Dad Doe',
            'nama_ibu' => 'Mom Doe',
            'nama_wali' => 'Wali Doe',
            'nik_ayah' => '1234567890123454',
            'nik_ibu' => '1234567890123455',
            'nik_wali' => '1234567890123456',
            'email_parent' => 'dad.doe1@example.com',
            'nomor_hp_ayah' => '1234567891',
            'nomor_hp_ibu' => '1234567892',
            'nomor_hp_wali' => '1234567893',
            'pekerjaan_ayah' => 'Engineer',
            'pekerjaan_ibu' => 'Teacher',
            'pekerjaan_wali' => 'Doctor',
            'alamat_ayah' => 'Jl. ABC No. 123',
            'alamat_ibu' => 'Jl. ABC No. 123',
            'alamat_wali' => 'Jl. ABC No. 123',

            'tinggi_badan' => 170,
            'berat_badan' => 60,
            'spesial_treatment' => 'None',
            'note_kesehatan' => 'Healthy individual',
            'file_document_kesehatan' => 'health_document.pdf',
            'file_list_pertanyaan' => 'questionnaire.pdf',

            'prestasi_sekolah_lama' => 'School Championship',
            'tahun_prestasi_sekolah_lama' => '2010',
            'sertifikat_number_sekolah_lama' => 'ABC123',
            'tanggal_masuk_sekolah_lama' => '2010-01-01',
            'tanggal_keluar_sekolah_lama' => '2015-01-01',
            'nama_sekolah_lama' => 'Previous School',
            'alamat_sekolah_lama' => 'Jl. XYZ No. 456',
            'no_sttb' => 'STTB123',
            'nem' => 8.75,
            'file_dokument_sekolah_lama' => 'previous_school_document.pdf',

            'avatar' => 'default.png',
            'status' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Siswa::create([
            'user_id' => 3,
            'kelas_id' => 24,
            'tingkatan_id' => 1,
            'jurusan_id' => 3,
            'jenis_pendaftaran' => '1',
            'tahun_masuk' => '2022',
            'semester_masuk' => '1',
            'kelas_masuk' => 'PG',

            'nik' => '1234567890123457',
            'nis' => '1234567891',
            'nisn' => '0987654322',
            'nama_lengkap' => 'John Doe 2',
            'nama_panggilan' => 'John',
            'nik' => '1234567890123456',
            'email' => 'john.doe@example.com',
            'nomor_hp' => '1234567890',
            'jenis_kelamin' => 'Male',
            'blood_type' => 'A',
            'agama' => '1',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2000-01-01',
            'anak_ke' => '01',
            'jml_saudara_kandung' => '02',
            'warga_negara' => 'ID',
            'alamat' => 'Jl. ABC No. 123',
            'kota' => 'Jakarta',
            'kode_pos' => 12345,
            'jarak_rumah_ke_sekolah' => 5,
            'tinggal_bersama' => 'Parents',
            'transportasi' => 'Car',

            'nama_ayah' => 'Dad Doe',
            'nama_ibu' => 'Mom Doe',
            'nama_wali' => 'Wali Doe',
            'nik_ayah' => '1234567890123451',
            'nik_ibu' => '1234567890123452',
            'nik_wali' => '1234567890123453',
            'email_parent' => 'dad.do1e1@example.com',
            'nomor_hp_ayah' => '1234567890',
            'nomor_hp_ibu' => '1234567890',
            'nomor_hp_wali' => '1234567890',
            'pekerjaan_ayah' => 'Engineer',
            'pekerjaan_ibu' => 'Teacher',
            'pekerjaan_wali' => 'Doctor',

            'tinggi_badan' => 170,
            'berat_badan' => 60,
            'spesial_treatment' => 'None',
            'note_kesehatan' => 'Healthy individual',
            'file_document_kesehatan' => 'health_document.pdf',
            'file_list_pertanyaan' => 'questionnaire.pdf',

            'prestasi_sekolah_lama' => 'School Championship',
            'tahun_prestasi_sekolah_lama' => '2010',
            'sertifikat_number_sekolah_lama' => 'ABC123',
            'tanggal_masuk_sekolah_lama' => '2010-01-01',
            'tanggal_keluar_sekolah_lama' => '2015-01-01',
            'nama_sekolah_lama' => 'Previous School',
            'alamat_sekolah_lama' => 'Jl. XYZ No. 456',
            'no_sttb' => 'STTB123',
            'nem' => 8.75,
            'file_dokument_sekolah_lama' => 'previous_school_document.pdf',

            'avatar' => 'default.png',
            'status' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Siswa::create([
            'user_id' => 4,
            'kelas_id' => 2,
            'jurusan_id' => 1,
            'tingkatan_id' => 5,
            'tahun_masuk' => '2022',
            'semester_masuk' => '1',
            'kelas_masuk' => 'PA1',

            'jenis_pendaftaran' => '1',
            'nik' => '1234567890123123',
            'nis' => '0000000001',
            'nisn' => '1257654322',
            'nama_lengkap' => 'John Doe 3',
            'nama_panggilan' => 'John',
            'email' => 'john.doe3@example.com',
            'nomor_hp' => '1234567190',
            'jenis_kelamin' => 'Male',
            'blood_type' => 'A',
            'agama' => '1',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2000-01-01',
            'anak_ke' => '01',
            'jml_saudara_kandung' => '02',
            'warga_negara' => 'ID',
            'alamat' => 'Jl. ABC No. 123',
            'kota' => 'Jakarta',
            'kode_pos' => 12345,
            'jarak_rumah_ke_sekolah' => 5,
            'tinggal_bersama' => 'Parents',
            'transportasi' => 'Car',

            'nama_ayah' => 'Dad Doe',
            'nama_ibu' => 'Mom Doe',
            'nama_wali' => 'Wali Doe',
            'nik_ayah' => '1234567891233451',
            'nik_ibu' => '1234567890321452',
            'nik_wali' => '1234567890321453',
            'email_parent' => 'dad.do1e1@example.com',
            'nomor_hp_ayah' => '1234567123',
            'nomor_hp_ibu' => '1234567890',
            'nomor_hp_wali' => '1234567890',
            'pekerjaan_ayah' => 'Engineer',
            'pekerjaan_ibu' => 'Teacher',
            'pekerjaan_wali' => 'Doctor',
            'alamat_ayah' => 'Jl. ABC No. 123',
            'alamat_ibu' => 'Jl. ABC No. 123',
            'alamat_wali' => 'Jl. ABC No. 123',

            'tinggi_badan' => 170,
            'berat_badan' => 60,
            'spesial_treatment' => 'None',
            'note_kesehatan' => 'Healthy individual',
            'file_document_kesehatan' => 'health_document.pdf',
            'file_list_pertanyaan' => 'questionnaire.pdf',

            'prestasi_sekolah_lama' => 'School Championship',
            'tahun_prestasi_sekolah_lama' => '2010',
            'sertifikat_number_sekolah_lama' => 'ABC123',
            'tanggal_masuk_sekolah_lama' => '2010-01-01',
            'tanggal_keluar_sekolah_lama' => '2015-01-01',
            'nama_sekolah_lama' => 'Previous School',
            'alamat_sekolah_lama' => 'Jl. XYZ No. 456',
            'no_sttb' => 'STTB123',
            'nem' => 8.75,
            'file_dokument_sekolah_lama' => 'previous_school_document.pdf',

            'avatar' => 'default.png',
            'status' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Siswa::factory()->count(5)->create();
    }
}

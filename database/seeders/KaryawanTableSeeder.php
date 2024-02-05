<?php

namespace Database\Seeders;

use App\Karyawan;
use Illuminate\Database\Seeder;

class KaryawanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Karyawan::create([
            'user_id' => 7,
            'status_karyawan_id' => 1,
            'unit_karyawan_id' => 1,
            'position_karyawan_id' => 1,
            'join_date' => '2022-01-01',
            'permanent_date' => '2023-01-01',

            'kode_karyawan' => 'K001',
            'nama_lengkap' => 'John Doe',
            'nik' => '1234567890123456',
            'nomor_akun' => '123456789',
            'nomor_fingerprint' => 123,

            'nomor_taxpayer' => '123456789',
            'nama_taxpayer' => 'John Doe',
            'nomor_bpjs_ketenagakerjaan' => '123456789',
            'iuran_bpjs_ketenagakerjaan' => 'Rp. 100000',
            'nomor_bpjs_yayasan' => '123456789',
            'nomor_bpjs_pribadi' => '123456789',

            'jenis_kelamin' => 'MALE',
            'agama' => '1',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'alamat' => 'Jl. Contoh No. 123',
            'alamat_sekarang' => 'Jl. Contoh Sekarang No. 456',
            'kota' => 'Jakarta',
            'kode_pos' => 12345,
            'nomor_phone' => '081234567890',
            'nomor_hp' => '081234567890',
            'email' => 'john.doe@example.com',
            'email_sekolah' => 'john.doe@school.com',
            'warga_negara' => 'Indonesia',
            'status_pernikahan' => '1',
            'nama_pasangan' => 'Jane Doe',
            'jumlah_anak' => '2',
            'keterangan' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',

            'status' => true,
            'avatar' => 'default.png',
        ]);
    }
}

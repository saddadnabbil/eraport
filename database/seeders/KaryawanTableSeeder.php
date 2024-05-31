<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Karyawan;
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
            'user_id' => 1,
            'status_karyawan_id' => 1,
            'unit_karyawan_id' => 2,
            'position_karyawan_id' => 1,
            'join_date' => '2022-01-01',
            'resign_date' => null,
            'permanent_date' => '2023-01-01',

            'kode_karyawan' => 'K002',
            'nama_lengkap' => 'Administrator',
            'nik' => '1234567890123412',
            'nomor_akun' => '123456719',
            'nomor_fingerprint' => 123,
        ]);

        Karyawan::create([
            'user_id' => 5,
            'status_karyawan_id' => 1,
            'unit_karyawan_id' => 2,
            'position_karyawan_id' => 1,
            'join_date' => '2022-01-01',
            'resign_date' => null,
            'permanent_date' => '2023-01-01',

            'kode_karyawan' => '2307014',
            'nama_lengkap' => 'Teacher Bros',
            'nik' => '1234567890123456',
            'nomor_akun' => '123456789',
            'nomor_fingerprint' => 123,

            'nomor_taxpayer' => '123456789',
            'nama_taxpayer' => 'Teacher Bros',
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

        Karyawan::create([
            'user_id' => 6,
            'status_karyawan_id' => 1,
            'unit_karyawan_id' => 2,
            'position_karyawan_id' => 1,
            'join_date' => '2022-01-01',
            'resign_date' => null,
            'permanent_date' => '2023-01-01',

            'kode_karyawan' => 'K001212',
            'nama_lengkap' => 'Guru 2',
            'nik' => '1234567890123412',
            'nomor_akun' => '123456719',
            'nomor_fingerprint' => 123,
        ]);

        Karyawan::create([
            'user_id' => 7,
            'status_karyawan_id' => 1,
            'unit_karyawan_id' => 2,
            'position_karyawan_id' => 1,
            'join_date' => '2022-01-01',
            'resign_date' => null,
            'permanent_date' => '2023-01-01',

            'kode_karyawan' => 'K001212',
            'nama_lengkap' => 'Curriculum',
            'nik' => '1234567890123412',
            'nomor_akun' => '123456719',
            'nomor_fingerprint' => 123,
        ]);

        // Karyawan::factory()->count()->create();
    }
}

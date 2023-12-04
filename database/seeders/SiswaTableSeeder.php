<?php

namespace Database\Seeders;

use App\Siswa;
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
            'user_id' => 3,
            'kelas_id' => 1,
            'jenis_pendaftaran' => '1',
            'nis' => '1234567890',
            'nisn' => '0987654321',
            'nama_lengkap' => 'John Doe',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'L',
            'agama' => '1',
            'status_dalam_keluarga' => '1',
            'anak_ke' => '1',
            'alamat' => 'Jl. Contoh Alamat No. 123',
            'nomor_hp' => '081234567890',
            'nama_ayah' => 'John Doe Sr.',
            'nama_ibu' => 'Jane Doe',
            'pekerjaan_ayah' => 'PNS',
            'pekerjaan_ibu' => 'Ibu Rumah Tangga',
            'nama_wali' => 'Wali Doe',
            'pekerjaan_wali' => 'Wiraswasta',
            'avatar' => 'avatar.jpg',
            'status' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

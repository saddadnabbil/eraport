<?php

namespace Database\Seeders;

use App\Models\PrestasiSiswa;
use Illuminate\Database\Seeder;

class PrestasiSiswaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PrestasiSiswa::create([
            'anggota_kelas_id' => 1,
            'nama_prestasi' => 'Solo Vokal',
            'jenis_prestasi' => 1,
            'tingkat_prestasi' => 1,
            'deskripsi' => 'Prestasi 1 Internasional'
        ]);
    }
}

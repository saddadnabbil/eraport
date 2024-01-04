<?php

namespace Database\Seeders;

use App\AnggotaKelas;
use Illuminate\Database\Seeder;

class AnggotaKelasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnggotaKelas::create([
            'siswa_id' => 1,
            'kelas_id' => 1,
            'pendaftaran' => 1
        ]);

        AnggotaKelas::create([
            'siswa_id' => 2,
            'kelas_id' => 2,
            'pendaftaran' => 1
        ]);

        AnggotaKelas::create([
            'siswa_id' => 3,
            'kelas_id' => 2,
            'pendaftaran' => 1
        ]);
    }
}

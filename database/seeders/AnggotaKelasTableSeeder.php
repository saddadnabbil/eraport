<?php

namespace Database\Seeders;

use App\Models\AnggotaKelas;
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
            'tapel_id' => 1,
            'kelas_id' => 1,
            'pendaftaran' => 1
        ]);

        AnggotaKelas::create([
            'siswa_id' => 2,
            'tapel_id' => 1,
            'kelas_id' => 8,
            'pendaftaran' => 1
        ]);

        AnggotaKelas::create([
            'siswa_id' => 3,
            'tapel_id' => 1,
            'kelas_id' => 9,
            'pendaftaran' => 1
        ]);

        AnggotaKelas::factory()->count(2)->create();
    }
}

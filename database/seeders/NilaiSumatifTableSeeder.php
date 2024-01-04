<?php

namespace Database\Seeders;

use App\NilaiSumatif;
use App\NilaiFormatif;
use Illuminate\Database\Seeder;

class NilaiSumatifTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NilaiSumatif::create([
            'rencana_nilai_sumatif_id' => 1,
            'anggota_kelas_id' => 1,
            'nilai' => 50
        ]);

        NilaiSumatif::create([
            'rencana_nilai_sumatif_id' => 2,
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);

        NilaiSumatif::create([
            'rencana_nilai_sumatif_id' => 3,
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);

        NilaiSumatif::create([
            'rencana_nilai_sumatif_id' => 4,
            'anggota_kelas_id' => 2,
            'nilai' => 90
        ]);

        NilaiSumatif::create([
            'rencana_nilai_sumatif_id' => 4,
            'anggota_kelas_id' => 3,
            'nilai' => 90
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\NilaiFormatif;
use Illuminate\Database\Seeder;

class NilaiFormatifTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NilaiFormatif::create([
            'rencana_nilai_formatif_id' => 1,
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);

        NilaiFormatif::create([
            'rencana_nilai_formatif_id' => 2,
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);

        NilaiFormatif::create([
            'rencana_nilai_formatif_id' => 3,
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);

        NilaiFormatif::create([
            'rencana_nilai_formatif_id' => 4,
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);

        NilaiFormatif::create([
            'rencana_nilai_formatif_id' => 5,
            'anggota_kelas_id' => 2,
            'nilai' => 90
        ]);

        NilaiFormatif::create([
            'rencana_nilai_formatif_id' => 5,
            'anggota_kelas_id' => 3,
            'nilai' => 90
        ]);
    }
}

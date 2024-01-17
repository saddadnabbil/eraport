<?php

namespace Database\Seeders;

use App\NilaiSumatif;
use App\NilaiFormatif;
use Illuminate\Database\Seeder;

class KmNilaiSumatifTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // term 1
        NilaiSumatif::create([
            'rencana_nilai_sumatif_id' => 1,
            'anggota_kelas_id' => 1,
            'nilai' => 90
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
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);
        NilaiSumatif::create([
            'rencana_nilai_sumatif_id' => 5,
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);
        NilaiSumatif::create([
            'rencana_nilai_sumatif_id' => 6,
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);

        NilaiSumatif::create([
            'rencana_nilai_sumatif_id' => 7,
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);
        NilaiSumatif::create([
            'rencana_nilai_sumatif_id' => 8,
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);
        NilaiSumatif::create([
            'rencana_nilai_sumatif_id' => 9,
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);

        // // term 2
        // NilaiSumatif::create([
        //     'rencana_nilai_sumatif_id' => 10,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);
        // NilaiSumatif::create([
        //     'rencana_nilai_sumatif_id' => 11,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);
        // NilaiSumatif::create([
        //     'rencana_nilai_sumatif_id' => 12,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);

        // NilaiSumatif::create([
        //     'rencana_nilai_sumatif_id' => 13,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);
        // NilaiSumatif::create([
        //     'rencana_nilai_sumatif_id' => 14,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);
        // NilaiSumatif::create([
        //     'rencana_nilai_sumatif_id' => 15,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);

        // NilaiSumatif::create([
        //     'rencana_nilai_sumatif_id' => 16,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);
        // NilaiSumatif::create([
        //     'rencana_nilai_sumatif_id' => 17,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);
        // NilaiSumatif::create([
        //     'rencana_nilai_sumatif_id' => 18,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);
    }
}

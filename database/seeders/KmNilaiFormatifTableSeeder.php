<?php

namespace Database\Seeders;

use App\NilaiFormatif;
use Illuminate\Database\Seeder;

class KmNilaiFormatifTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // term 1
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
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);
        NilaiFormatif::create([
            'rencana_nilai_formatif_id' => 6,
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);

        NilaiFormatif::create([
            'rencana_nilai_formatif_id' => 7,
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);
        NilaiFormatif::create([
            'rencana_nilai_formatif_id' => 8,
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);
        NilaiFormatif::create([
            'rencana_nilai_formatif_id' => 9,
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);

        // // term 2
        // NilaiFormatif::create([
        //     'rencana_nilai_formatif_id' => 10,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);
        // NilaiFormatif::create([
        //     'rencana_nilai_formatif_id' => 11,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);
        // NilaiFormatif::create([
        //     'rencana_nilai_formatif_id' => 12,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);

        // NilaiFormatif::create([
        //     'rencana_nilai_formatif_id' => 13,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);
        // NilaiFormatif::create([
        //     'rencana_nilai_formatif_id' => 14,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);
        // NilaiFormatif::create([
        //     'rencana_nilai_formatif_id' => 15,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);

        // NilaiFormatif::create([
        //     'rencana_nilai_formatif_id' => 16,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);
        // NilaiFormatif::create([
        //     'rencana_nilai_formatif_id' => 17,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);
        // NilaiFormatif::create([
        //     'rencana_nilai_formatif_id' => 18,
        //     'anggota_kelas_id' => 1,
        //     'nilai' => 90
        // ]);
    }
}

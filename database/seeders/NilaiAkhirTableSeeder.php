<?php

namespace Database\Seeders;

use App\NilaiAkhir;
use Illuminate\Database\Seeder;

class NilaiAkhirTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NilaiAkhir::create([
            'anggota_kelas_id' => 1,
            'nilai_akhir_formatif' => 90,
            'nilai_akhir_sumatif' => 90,
            'nilai_akhir_raport' => 90,
            'nilai_akhir_revisi' => null
        ]);

        NilaiAkhir::create([
            'anggota_kelas_id' => 1,
            'nilai_akhir_formatif' => 90,
            'nilai_akhir_sumatif' => 50,
            'nilai_akhir_raport' => 78,
            'nilai_akhir_revisi' => null
        ]);

        NilaiAkhir::create([
            'anggota_kelas_id' => 1,
            'nilai_akhir_formatif' => 90,
            'nilai_akhir_sumatif' => 90,
            'nilai_akhir_raport' => 90,
            'nilai_akhir_revisi' => null
        ]);

        NilaiAkhir::create([
            'anggota_kelas_id' => 1,
            'nilai_akhir_formatif' => 90,
            'nilai_akhir_sumatif' => 90,
            'nilai_akhir_raport' => 90,
            'nilai_akhir_revisi' => null
        ]);

        NilaiAkhir::create([
            'anggota_kelas_id' => 1,
            'nilai_akhir_formatif' => 90,
            'nilai_akhir_sumatif' => 90,
            'nilai_akhir_raport' => 90,
            'nilai_akhir_revisi' => null
        ]);
    }
}

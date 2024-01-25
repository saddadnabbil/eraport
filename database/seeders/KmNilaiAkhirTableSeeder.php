<?php

namespace Database\Seeders;

use App\NilaiAkhir;
use Illuminate\Database\Seeder;

class KmNilaiAkhirTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NilaiAkhir::create([
            'pembelajaran_id' => 1,
            'anggota_kelas_id' => 1,
            'term_id' => 1,
            'nilai_akhir_formatif' => 90,
            'nilai_akhir_sumatif' => 90,
            'nilai_akhir_raport' => 90,
            'nilai_akhir_revisi' => null
        ]);

        NilaiAkhir::create([
            'pembelajaran_id' => 2,
            'anggota_kelas_id' => 1,
            'term_id' => 1,
            'nilai_akhir_formatif' => 90,
            'nilai_akhir_sumatif' => 90,
            'nilai_akhir_raport' => 90,
            'nilai_akhir_revisi' => null
        ]);

        NilaiAkhir::create([
            'pembelajaran_id' => 3,
            'term_id' => 1,
            'anggota_kelas_id' => 1,
            'nilai_akhir_formatif' => 90,
            'nilai_akhir_sumatif' => 90,
            'nilai_akhir_raport' => 90,
            'nilai_akhir_revisi' => null
        ]);

        NilaiAkhir::create([
            'pembelajaran_id' => 4,
            'anggota_kelas_id' => 1,
            'term_id' => 1,
            'nilai_akhir_formatif' => 90,
            'nilai_akhir_sumatif' => 90,
            'nilai_akhir_raport' => 90,
            'nilai_akhir_revisi' => null
        ]);

        NilaiAkhir::create([
            'pembelajaran_id' => 1,
            'anggota_kelas_id' => 1,
            'term_id' => 1,
            'nilai_akhir_formatif' => 90,
            'nilai_akhir_sumatif' => 90,
            'nilai_akhir_raport' => 90,
            'nilai_akhir_revisi' => null
        ]);


        // term 2
        NilaiAkhir::create([
            'pembelajaran_id' => 1,
            'anggota_kelas_id' => 1,
            'term_id' => 2,
            'nilai_akhir_formatif' => 90,
            'nilai_akhir_sumatif' => 90,
            'nilai_akhir_raport' => 90,
            'nilai_akhir_revisi' => null
        ]);

        NilaiAkhir::create([
            'pembelajaran_id' => 2,
            'anggota_kelas_id' => 1,
            'term_id' => 2,
            'nilai_akhir_formatif' => 90,
            'nilai_akhir_sumatif' => 90,
            'nilai_akhir_raport' => 90,
            'nilai_akhir_revisi' => null
        ]);

        NilaiAkhir::create([
            'pembelajaran_id' => 3,
            'term_id' => 2,
            'anggota_kelas_id' => 1,
            'nilai_akhir_formatif' => 90,
            'nilai_akhir_sumatif' => 90,
            'nilai_akhir_raport' => 90,
            'nilai_akhir_revisi' => null
        ]);

        NilaiAkhir::create([
            'pembelajaran_id' => 4,
            'anggota_kelas_id' => 1,
            'term_id' => 2,
            'nilai_akhir_formatif' => 90,
            'nilai_akhir_sumatif' => 90,
            'nilai_akhir_raport' => 90,
            'nilai_akhir_revisi' => null
        ]);

        NilaiAkhir::create([
            'pembelajaran_id' => 1,
            'anggota_kelas_id' => 1,
            'term_id' => 2,
            'nilai_akhir_formatif' => 90,
            'nilai_akhir_sumatif' => 90,
            'nilai_akhir_raport' => 90,
            'nilai_akhir_revisi' => null
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\KmNilaiAkhirRaport;
use Illuminate\Database\Seeder;

class KmNilaiAkhirRaportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KmNilaiAkhirRaport::create([
            'pembelajaran_id' => 1,
            'anggota_kelas_id' => 1,
            'semester_id' => 1,
            'term_id' => 1,
            'kkm' => 75,
            'nilai_sumatif' => 90,
            'predikat_sumatif' => 'A',
            'nilai_formatif' => 90,
            'predikat_formatif' => 'A',
            'nilai_akhir_raport' => 90,
            'predikat_akhir_raport' => 'B',
        ]);

        KmNilaiAkhirRaport::create([
            'pembelajaran_id' => 2,
            'anggota_kelas_id' => 1,
            'semester_id' => 1,
            'term_id' => 1,
            'kkm' => 75,
            'nilai_sumatif' => 90,
            'predikat_sumatif' => 'A',
            'nilai_formatif' => 90,
            'predikat_formatif' => 'A',
            'nilai_akhir_raport' => 90,
            'predikat_akhir_raport' => 'A',
        ]);

        KmNilaiAkhirRaport::create([
            'pembelajaran_id' => 3,
            'anggota_kelas_id' => 1,
            'semester_id' => 1,
            'term_id' => 1,
            'kkm' => 75,
            'nilai_sumatif' => 90,
            'predikat_sumatif' => 'A',
            'nilai_formatif' => 90,
            'predikat_formatif' => 'A',
            'nilai_akhir_raport' => 90,
            'predikat_akhir_raport' => 'A',
        ]);

        KmNilaiAkhirRaport::create([
            'pembelajaran_id' => 4,
            'anggota_kelas_id' => 2,
            'semester_id' => 1,
            'term_id' => 1,
            'kkm' => 75,
            'nilai_sumatif' => 90,
            'predikat_sumatif' => 'A',
            'nilai_formatif' => 90,
            'predikat_formatif' => 'A',
            'nilai_akhir_raport' => 90,
            'predikat_akhir_raport' => 'A',
        ]);

        KmNilaiAkhirRaport::create([
            'pembelajaran_id' => 4,
            'anggota_kelas_id' => 3,
            'semester_id' => 1,
            'term_id' => 1,
            'kkm' => 75,
            'nilai_sumatif' => 90,
            'predikat_sumatif' => 'A',
            'nilai_formatif' => 90,
            'predikat_formatif' => 'A',
            'nilai_akhir_raport' => 90,
            'predikat_akhir_raport' => 'A',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // term 2
        KmNilaiAkhirRaport::create([
            'pembelajaran_id' => 1,
            'anggota_kelas_id' => 1,
            'semester_id' => 1,
            'term_id' => 2,
            'kkm' => 75,
            'nilai_sumatif' => 90,
            'predikat_sumatif' => 'A',
            'nilai_formatif' => 90,
            'predikat_formatif' => 'A',
            'nilai_akhir_raport' => 90,
            'predikat_akhir_raport' => 'B',
        ]);

        KmNilaiAkhirRaport::create([
            'pembelajaran_id' => 2,
            'anggota_kelas_id' => 1,
            'semester_id' => 1,
            'term_id' => 2,
            'kkm' => 75,
            'nilai_sumatif' => 90,
            'predikat_sumatif' => 'A',
            'nilai_formatif' => 90,
            'predikat_formatif' => 'A',
            'nilai_akhir_raport' => 90,
            'predikat_akhir_raport' => 'A',
        ]);

        KmNilaiAkhirRaport::create([
            'pembelajaran_id' => 3,
            'anggota_kelas_id' => 1,
            'semester_id' => 1,
            'term_id' => 2,
            'kkm' => 75,
            'nilai_sumatif' => 90,
            'predikat_sumatif' => 'A',
            'nilai_formatif' => 90,
            'predikat_formatif' => 'A',
            'nilai_akhir_raport' => 90,
            'predikat_akhir_raport' => 'A',
        ]);

        KmNilaiAkhirRaport::create([
            'pembelajaran_id' => 4,
            'anggota_kelas_id' => 2,
            'semester_id' => 1,
            'term_id' => 2,
            'kkm' => 75,
            'nilai_sumatif' => 90,
            'predikat_sumatif' => 'A',
            'nilai_formatif' => 90,
            'predikat_formatif' => 'A',
            'nilai_akhir_raport' => 90,
            'predikat_akhir_raport' => 'A',
        ]);

        KmNilaiAkhirRaport::create([
            'pembelajaran_id' => 4,
            'anggota_kelas_id' => 3,
            'semester_id' => 1,
            'term_id' => 2,
            'kkm' => 75,
            'nilai_sumatif' => 90,
            'predikat_sumatif' => 'A',
            'nilai_formatif' => 90,
            'predikat_formatif' => 'A',
            'nilai_akhir_raport' => 90,
            'predikat_akhir_raport' => 'A',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

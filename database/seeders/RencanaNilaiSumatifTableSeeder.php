<?php

namespace Database\Seeders;

use App\Models\Pembelajaran;
use App\Models\RencanaNilaiSumatif;
use Illuminate\Database\Seeder;

class RencanaNilaiSumatifTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // term 1
        // Pembelajaran 1
        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 1,
            'semester_id' => 1,
            'term_id' => 1,
            'kode_penilaian' => 'S1',
            'teknik_penilaian' => '1',
            'bobot_teknik_penilaian' => 40
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 1,
            'semester_id' => 1,
            'term_id' => 1,
            'kode_penilaian' => 'S2',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 1,
            'semester_id' => 1,
            'term_id' => 1,
            'kode_penilaian' => 'S3',
            'teknik_penilaian' => '3',
            'bobot_teknik_penilaian' => 30
        ]);

        // Pembelajaran 2
        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 2,
            'semester_id' => 1,
            'term_id' => 1,
            'kode_penilaian' => 'S1',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 2,
            'semester_id' => 1,
            'term_id' => 1,
            'kode_penilaian' => 'S2',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 2,
            'semester_id' => 1,
            'term_id' => 1,
            'kode_penilaian' => 'S3',
            'teknik_penilaian' => '3',
            'bobot_teknik_penilaian' => 30
        ]);

        // Pembelajaran 3
        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 3,
            'semester_id' => 1,
            'term_id' => 1,
            'kode_penilaian' => 'P1',
            'teknik_penilaian' => '1',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 3,
            'semester_id' => 1,
            'term_id' => 1,
            'kode_penilaian' => 'S2',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 3,
            'semester_id' => 1,
            'term_id' => 1,
            'kode_penilaian' => 'S3',
            'teknik_penilaian' => '3',
            'bobot_teknik_penilaian' => 30
        ]);

        // Pembelajaran 4
        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 4,
            'semester_id' => 1,
            'term_id' => 1,
            'kode_penilaian' => 'S1',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 4,
            'semester_id' => 1,
            'term_id' => 1,
            'kode_penilaian' => 'S2',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 4,
            'semester_id' => 1,
            'term_id' => 1,
            'kode_penilaian' => 'S3',
            'teknik_penilaian' => '3',
            'bobot_teknik_penilaian' => 30
        ]);

        // term 2
        // Pembelajaran 1
        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 1,
            'semester_id' => 1,
            'term_id' => 2,
            'kode_penilaian' => 'S1',
            'teknik_penilaian' => '1',
            'bobot_teknik_penilaian' => 40
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 1,
            'semester_id' => 1,
            'term_id' => 2,
            'kode_penilaian' => 'S2',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 1,
            'semester_id' => 1,
            'term_id' => 2,
            'kode_penilaian' => 'S3',
            'teknik_penilaian' => '3',
            'bobot_teknik_penilaian' => 30
        ]);

        // Pembelajaran 2
        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 2,
            'semester_id' => 1,
            'term_id' => 2,
            'kode_penilaian' => 'S1',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 2,
            'semester_id' => 1,
            'term_id' => 2,
            'kode_penilaian' => 'S2',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 2,
            'semester_id' => 1,
            'term_id' => 2,
            'kode_penilaian' => 'S3',
            'teknik_penilaian' => '3',
            'bobot_teknik_penilaian' => 30
        ]);

        // Pembelajaran 3
        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 3,
            'semester_id' => 1,
            'term_id' => 2,
            'kode_penilaian' => 'P1',
            'teknik_penilaian' => '1',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 3,
            'semester_id' => 1,
            'term_id' => 2,
            'kode_penilaian' => 'S2',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 3,
            'semester_id' => 1,
            'term_id' => 2,
            'kode_penilaian' => 'S3',
            'teknik_penilaian' => '3',
            'bobot_teknik_penilaian' => 30
        ]);

        // Pembelajaran 4
        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 4,
            'semester_id' => 1,
            'term_id' => 2,
            'kode_penilaian' => 'S1',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 4,
            'semester_id' => 1,
            'term_id' => 2,
            'kode_penilaian' => 'S2',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 4,
            'semester_id' => 1,
            'term_id' => 2,
            'kode_penilaian' => 'S3',
            'teknik_penilaian' => '3',
            'bobot_teknik_penilaian' => 30
        ]);


        // semester 2
        // term 1
        // Pembelajaran 1
        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 1,
            'semester_id' => 2,
            'term_id' => 1,
            'kode_penilaian' => 'S1',
            'teknik_penilaian' => '1',
            'bobot_teknik_penilaian' => 40
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 1,
            'semester_id' => 2,
            'term_id' => 1,
            'kode_penilaian' => 'S2',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 1,
            'semester_id' => 2,
            'term_id' => 1,
            'kode_penilaian' => 'S3',
            'teknik_penilaian' => '3',
            'bobot_teknik_penilaian' => 30
        ]);

        // Pembelajaran 2
        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 2,
            'semester_id' => 2,
            'term_id' => 1,
            'kode_penilaian' => 'S1',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 2,
            'semester_id' => 2,
            'term_id' => 1,
            'kode_penilaian' => 'S2',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 2,
            'semester_id' => 2,
            'term_id' => 1,
            'kode_penilaian' => 'S3',
            'teknik_penilaian' => '3',
            'bobot_teknik_penilaian' => 30
        ]);

        // Pembelajaran 3
        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 3,
            'semester_id' => 2,
            'term_id' => 1,
            'kode_penilaian' => 'P1',
            'teknik_penilaian' => '1',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 3,
            'semester_id' => 2,
            'term_id' => 1,
            'kode_penilaian' => 'S2',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 3,
            'semester_id' => 2,
            'term_id' => 1,
            'kode_penilaian' => 'S3',
            'teknik_penilaian' => '3',
            'bobot_teknik_penilaian' => 30
        ]);

        // Pembelajaran 4
        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 4,
            'semester_id' => 2,
            'term_id' => 1,
            'kode_penilaian' => 'S1',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 4,
            'semester_id' => 2,
            'term_id' => 1,
            'kode_penilaian' => 'S2',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 4,
            'semester_id' => 2,
            'term_id' => 1,
            'kode_penilaian' => 'S3',
            'teknik_penilaian' => '3',
            'bobot_teknik_penilaian' => 30
        ]);

        // term 2
        // Pembelajaran 1
        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 1,
            'semester_id' => 2,
            'term_id' => 2,
            'kode_penilaian' => 'S1',
            'teknik_penilaian' => '1',
            'bobot_teknik_penilaian' => 40
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 1,
            'semester_id' => 2,
            'term_id' => 2,
            'kode_penilaian' => 'S2',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 1,
            'semester_id' => 2,
            'term_id' => 2,
            'kode_penilaian' => 'S3',
            'teknik_penilaian' => '3',
            'bobot_teknik_penilaian' => 30
        ]);

        // Pembelajaran 2
        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 2,
            'semester_id' => 2,
            'term_id' => 2,
            'kode_penilaian' => 'S1',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 2,
            'semester_id' => 2,
            'term_id' => 2,
            'kode_penilaian' => 'S2',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 2,
            'semester_id' => 2,
            'term_id' => 2,
            'kode_penilaian' => 'S3',
            'teknik_penilaian' => '3',
            'bobot_teknik_penilaian' => 30
        ]);

        // Pembelajaran 3
        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 3,
            'semester_id' => 2,
            'term_id' => 2,
            'kode_penilaian' => 'P1',
            'teknik_penilaian' => '1',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 3,
            'semester_id' => 2,
            'term_id' => 2,
            'kode_penilaian' => 'S2',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 3,
            'semester_id' => 2,
            'term_id' => 2,
            'kode_penilaian' => 'S3',
            'teknik_penilaian' => '3',
            'bobot_teknik_penilaian' => 30
        ]);

        // Pembelajaran 4
        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 4,
            'semester_id' => 2,
            'term_id' => 2,
            'kode_penilaian' => 'S1',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 4,
            'semester_id' => 2,
            'term_id' => 2,
            'kode_penilaian' => 'S2',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 4,
            'semester_id' => 2,
            'term_id' => 2,
            'kode_penilaian' => 'S3',
            'teknik_penilaian' => '3',
            'bobot_teknik_penilaian' => 30
        ]);
    }
}

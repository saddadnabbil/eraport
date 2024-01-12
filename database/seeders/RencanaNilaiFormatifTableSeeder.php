<?php

namespace Database\Seeders;

use App\RencanaNilaiFormatif;
use Illuminate\Database\Seeder;

class RencanaNilaiFormatifTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pembelajaran 1
        RencanaNilaiFormatif::create([
            'pembelajaran_id' => 1,
            'term_id' => 1,
            'teknik_penilaian' => '1',
            'kode_penilaian' => 'F1',
            'bobot_teknik_penilaian' => 40
        ]);

        RencanaNilaiFormatif::create([
            'pembelajaran_id' => 1,
            'term_id' => 1,
            'teknik_penilaian' => '2',
            'kode_penilaian' => 'F2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiFormatif::create([
            'pembelajaran_id' => 1,
            'term_id' => 1,
            'teknik_penilaian' => '3',
            'kode_penilaian' => 'F3',
            'bobot_teknik_penilaian' => 30
        ]);

        // Pembelajaran 2
        RencanaNilaiFormatif::create([
            'pembelajaran_id' => 2,
            'term_id' => 1,
            'teknik_penilaian' => '1',
            'kode_penilaian' => 'F1',
            'bobot_teknik_penilaian' => 30
        ]);
        RencanaNilaiFormatif::create([
            'pembelajaran_id' => 2,
            'term_id' => 1,
            'teknik_penilaian' => '2',
            'kode_penilaian' => 'F2',
            'bobot_teknik_penilaian' => 30
        ]);
        RencanaNilaiFormatif::create([
            'pembelajaran_id' => 2,
            'term_id' => 1,
            'teknik_penilaian' => '3',
            'kode_penilaian' => 'F3',
            'bobot_teknik_penilaian' => 30
        ]);

        // Pembelajaran 3
        RencanaNilaiFormatif::create([
            'pembelajaran_id' => 3,
            'term_id' => 1,
            'teknik_penilaian' => '1',
            'kode_penilaian' => 'F1',
            'bobot_teknik_penilaian' => 30
        ]);
        RencanaNilaiFormatif::create([
            'pembelajaran_id' => 3,
            'term_id' => 1,
            'teknik_penilaian' => '2',
            'kode_penilaian' => 'F2',
            'bobot_teknik_penilaian' => 30
        ]);
        RencanaNilaiFormatif::create([
            'pembelajaran_id' => 3,
            'term_id' => 1,
            'teknik_penilaian' => '3',
            'kode_penilaian' => 'F3',
            'bobot_teknik_penilaian' => 30
        ]);

        // Pembelajaran 4
        RencanaNilaiFormatif::create([
            'pembelajaran_id' => 4,
            'term_id' => 1,
            'teknik_penilaian' => '1',
            'kode_penilaian' => 'F1',
            'bobot_teknik_penilaian' => 30
        ]);
        RencanaNilaiFormatif::create([
            'pembelajaran_id' => 4,
            'term_id' => 1,
            'teknik_penilaian' => '2',
            'kode_penilaian' => 'F2',
            'bobot_teknik_penilaian' => 30
        ]);
        RencanaNilaiFormatif::create([
            'pembelajaran_id' => 4,
            'term_id' => 1,
            'teknik_penilaian' => '3',
            'kode_penilaian' => 'F3',
            'bobot_teknik_penilaian' => 30
        ]);
    }
}

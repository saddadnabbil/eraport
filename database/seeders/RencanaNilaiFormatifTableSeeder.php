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
        RencanaNilaiFormatif::create([
            'pembelajaran_id' => 1,
            'term_id' => 1,
            'teknik_penilaian' => '1',
            'kode_penilaian' => 'P1',
            'bobot_teknik_penilaian' => 40
        ]);

        RencanaNilaiFormatif::create([
            'pembelajaran_id' => 1,
            'term_id' => 1,
            'teknik_penilaian' => '2',
            'kode_penilaian' => 'P2',
            'bobot_teknik_penilaian' => 40
        ]);

        RencanaNilaiFormatif::create([
            'pembelajaran_id' => 2,
            'term_id' => 1,
            'teknik_penilaian' => '1',
            'kode_penilaian' => 'P2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiFormatif::create([
            'pembelajaran_id' => 3,
            'term_id' => 1,
            'teknik_penilaian' => '1',
            'kode_penilaian' => 'P1',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiFormatif::create([
            'pembelajaran_id' => 4,
            'term_id' => 1,
            'teknik_penilaian' => '1',
            'kode_penilaian' => 'P1',
            'bobot_teknik_penilaian' => 30
        ]);
    }
}

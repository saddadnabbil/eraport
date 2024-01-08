<?php

namespace Database\Seeders;

use App\RencanaNilaiSumatif;
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

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 1,
            'term_id' => 1,
            'kode_penilaian' => 'P1',
            'teknik_penilaian' => '1',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 2,
            'term_id' => 1,
            'kode_penilaian' => 'P1',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 3,
            'term_id' => 1,
            'kode_penilaian' => 'P1',
            'teknik_penilaian' => '1',
            'bobot_teknik_penilaian' => 30
        ]);

        RencanaNilaiSumatif::create([
            'pembelajaran_id' => 4,
            'term_id' => 1,
            'kode_penilaian' => 'P1',
            'teknik_penilaian' => '2',
            'bobot_teknik_penilaian' => 30
        ]);
    }
}

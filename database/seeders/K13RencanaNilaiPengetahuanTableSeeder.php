<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\K13RencanaNilaiPengetahuan;

class K13RencanaNilaiPengetahuanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        K13RencanaNilaiPengetahuan::create([
            'pembelajaran_id' => 1,
            'k13_kd_mapel_id' => 1,
            'kode_penilaian' => 'P1',
            'teknik_penilaian' => 1,
            'bobot_teknik_penilaian' => 30
        ]);
    }
}

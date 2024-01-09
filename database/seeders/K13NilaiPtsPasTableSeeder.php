<?php

namespace Database\Seeders;

use App\K13NilaiPtsPas;
use Illuminate\Database\Seeder;

class K13NilaiPtsPasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        K13NilaiPtsPas::create([
            'pembelajaran_id' => 1,
            'anggota_kelas_id' => 1,
            'nilai_pts' => 90,
            'nilai_pas' => 80
        ]);
    }
}

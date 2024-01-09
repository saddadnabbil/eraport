<?php

namespace Database\Seeders;

use App\K13NilaiAkhirRaport;
use Illuminate\Database\Seeder;

class K13NilaiAkhirRaportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        K13NilaiAkhirRaport::create([
            'pembelajaran_id' => 1,
            'anggota_kelas_id' => 1,
            'kkm' => 75,
            'nilai_pengetahuan' => 80,
            'predikat_pengetahuan' => 'A',
            'nilai_keterampilan' => 90,
            'predikat_keterampilan' => 'A',
            'nilai_spiritual' => 4,
            'nilai_sosial' => 4
        ]);
    }
}

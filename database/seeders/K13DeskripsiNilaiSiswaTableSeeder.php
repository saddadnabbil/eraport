<?php

namespace Database\Seeders;

use App\K13DeskripsiNilaiSiswa;
use Illuminate\Database\Seeder;

class K13DeskripsiNilaiSiswaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        K13DeskripsiNilaiSiswa::create([
            'pembelajaran_id' => 1,
            'k13_nilai_akhir_raport_id' => 1,
            'deskripsi_pengetahuan' => 'Memiliki penguasaan pengetahuan sangat baik, terutama dalam testingtestingtestingtesting',
            'deskripsi_keterampilan' => 'Memiliki penguasaan keterampilan sangat baik, terutama dalam testingtestingtestingtesting'
        ]);
    }
}

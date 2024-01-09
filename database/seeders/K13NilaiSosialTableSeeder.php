<?php

namespace Database\Seeders;

use App\K13NilaiSosial;
use Illuminate\Database\Seeder;

class K13NilaiSosialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        K13NilaiSosial::create([
            'k13_rencana_nilai_sosial_id' => 1,
            'anggota_kelas_id' => 1,
            'nilai' => 4
        ]);
    }
}

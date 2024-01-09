<?php

namespace Database\Seeders;

use App\K13NilaiKeterampilan;
use Illuminate\Database\Seeder;

class K13NilaiKeterampilanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        K13NilaiKeterampilan::create([
            'k13_rencana_nilai_keterampilan_id' => 1,
            'anggota_kelas_id' => 1,
            'nilai' => 90
        ]);
    }
}

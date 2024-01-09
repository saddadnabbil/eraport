<?php

namespace Database\Seeders;

use App\K13NilaiPengetahuan;
use Illuminate\Database\Seeder;

class K13NilaiPengetahuanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        K13NilaiPengetahuan::create([
            'k13_rencana_nilai_pengetahuan_id' => 1,
            'anggota_kelas_id' => 1,
            'nilai' => 80
        ]);
    }
}

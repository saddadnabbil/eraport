<?php

namespace Database\Seeders;

use App\K13NilaiSpiritual;
use Illuminate\Database\Seeder;

class K13NilaiSpiritualTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        K13NilaiSpiritual::create([
            'k13_rencana_nilai_spiritual_id' => 1,
            'anggota_kelas_id' => 1,
            'nilai' => 4
        ]);
    }
}

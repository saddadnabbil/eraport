<?php

namespace Database\Seeders;

use App\K13RencanaNilaiSosial;
use Illuminate\Database\Seeder;

class K13RencanaNilaiSosialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        K13RencanaNilaiSosial::create([
            'pembelajaran_id' => 1,
            'k13_butir_sikap_id' => 2,
        ]);
    }
}

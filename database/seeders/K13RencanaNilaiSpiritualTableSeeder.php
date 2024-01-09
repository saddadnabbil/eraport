<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\K13RencanaNilaiSpiritual;

class K13RencanaNilaiSpiritualTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        K13RencanaNilaiSpiritual::create([
            'pembelajaran_id' => 1,
            'k13_butir_sikap_id' => 1,
        ]);
    }
}

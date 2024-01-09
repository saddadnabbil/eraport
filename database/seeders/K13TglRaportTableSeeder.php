<?php

namespace Database\Seeders;

use App\K13TglRaport;
use Illuminate\Database\Seeder;

class K13TglRaportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        K13TglRaport::create([
            'tapel_id' => 1,
            'tempat_penerbitan' => 'Kelas',
            'tanggal_pembagian' => now(),
        ]);
    }
}

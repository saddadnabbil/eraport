<?php

namespace Database\Seeders;

use App\Tapel;
use Illuminate\Database\Seeder;

class TapelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tapel::create([
            'tahun_pelajaran' => '2023-2024',
            'semester_id' => 1
        ]);
    }
}

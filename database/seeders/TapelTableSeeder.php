<?php

namespace Database\Seeders;

use App\Models\Tapel;
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
            'semester_id' => 1,
            'term_id' => 1,
            'status' => 1
        ]);

        Tapel::create([
            'tahun_pelajaran' => '2024-2025',
            'semester_id' => 1,
            'term_id' => 1,
            'status' => 1
        ]);
    }
}

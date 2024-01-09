<?php

namespace Database\Seeders;

use App\K13MappingMapel;
use Illuminate\Database\Seeder;

class K13MappingMapelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        K13MappingMapel::create([
            'mapel_id' => 1,
            'kelompok' => 'A',
            'nomor_urut' => 1
        ]);

        K13MappingMapel::create([
            'mapel_id' => 2,
            'kelompok' => 'B',
            'nomor_urut' => 2
        ]);

        K13MappingMapel::create([
            'mapel_id' => 3,
            'kelompok' => 'A',
            'nomor_urut' => 3
        ]);
    }
}

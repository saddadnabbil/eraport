<?php

namespace Database\Seeders;

use App\Models\KmMappingMapel;
use Illuminate\Database\Seeder;

class KmMappingMapelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KmMappingMapel::create([
            'mapel_id' => 1,
            'kelompok' => 'A',
            'nomor_urut' => 1
        ]);

        KmMappingMapel::create([
            'mapel_id' => 2,
            'kelompok' => 'A',
            'nomor_urut' => 1
        ]);

        KmMappingMapel::create([
            'mapel_id' => 3,
            'kelompok' => 'B',
            'nomor_urut' => 1
        ]);
    }
}

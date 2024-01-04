<?php

namespace Database\Seeders;

use App\KmKkmMapel;
use Illuminate\Database\Seeder;

class KmKkmMapelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KmKkmMapel::create([
            'mapel_id' => 1,
            'kelas_id' => 1,
            'kkm' => 75
        ]);

        KmKkmMapel::create([
            'mapel_id' => 1,
            'kelas_id' => 2,
            'kkm' => 75
        ]);

        KmKkmMapel::create([
            'mapel_id' => 2,
            'kelas_id' => 1,
            'kkm' => 75
        ]);

        KmKkmMapel::create([
            'mapel_id' => 2,
            'kelas_id' => 1,
            'kkm' => 75
        ]);

        KmKkmMapel::create([
            'mapel_id' => 3,
            'kelas_id' => 1,
            'kkm' => 75
        ]);
    }
}

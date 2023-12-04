<?php

namespace Database\Seeders;

use App\K13KkmMapel;
use Illuminate\Database\Seeder;

class K13KkmTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        K13KkmMapel::create([
            'mapel_id' => 1,
            'kelas_id' => 1,
            'kkm' => 75
        ]);

        K13KkmMapel::create([
            'mapel_id' => 2,
            'kelas_id' => 1,
            'kkm' => 75
        ]);

        K13KkmMapel::create([
            'mapel_id' => 2,
            'kelas_id' => 1,
            'kkm' => 75
        ]);
    }
}

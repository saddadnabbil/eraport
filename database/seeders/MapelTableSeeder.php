<?php

namespace Database\Seeders;

use App\Mapel;
use Illuminate\Database\Seeder;

class MapelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mapel::create([
            'tapel_id' => 1,
            'nama_mapel' => 'Informatic',
            'ringkasan_mapel' => 'it',
        ]);

        Mapel::create([
            'tapel_id' => 1,
            'nama_mapel' => 'Religion',
            'ringkasan_mapel' => 'religion',
        ]);

        Mapel::create([
            'tapel_id' => 1,
            'nama_mapel' => 'Math',
            'ringkasan_mapel' => 'math',
        ]);
    }
}

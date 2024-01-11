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
            'nama_mapel_indonesian' => 'Informatika',
            'ringkasan_mapel' => 'it',
        ]);

        Mapel::create([
            'tapel_id' => 1,
            'nama_mapel' => 'Religion',
            'nama_mapel_indonesian' => 'Agama',
            'ringkasan_mapel' => 'religion',
        ]);

        Mapel::create([
            'tapel_id' => 1,
            'nama_mapel' => 'Math',
            'nama_mapel_indonesian' => 'Matematika',
            'ringkasan_mapel' => 'math',
        ]);
    }
}

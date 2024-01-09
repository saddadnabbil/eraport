<?php

namespace Database\Seeders;

use App\K13KdMapel;
use Illuminate\Database\Seeder;

class K13KdMapelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        K13KdMapel::create([
            'mapel_id' => 1,
            'tingkatan_id' => 1,
            'jenis_kompetensi' => 1,
            'semester' => 1,
            'kode_kd' => '1.1.1',
            'kompetensi_dasar' => 'testingtestingtestingtesting',
            'ringkasan_kompetensi' => 'testingtestingtestingtesting',
        ]);

        K13KdMapel::create([
            'mapel_id' => 1,
            'tingkatan_id' => 1,
            'jenis_kompetensi' => 2,
            'semester' => 1,
            'kode_kd' => '1.2',
            'kompetensi_dasar' => 'testingtestingtesting',
            'ringkasan_kompetensi' => 'testingtestingtestingtesting',
        ]);

        K13KdMapel::create([
            'mapel_id' => 1,
            'tingkatan_id' => 1,
            'jenis_kompetensi' => 3,
            'semester' => 1,
            'kode_kd' => '1.3',
            'kompetensi_dasar' => 'testingtestingtestingtestingtesting',
            'ringkasan_kompetensi' => 'testingtestingtestingtestingtesting',
        ]);

        K13KdMapel::create([
            'mapel_id' => 1,
            'tingkatan_id' => 1,
            'jenis_kompetensi' => 4,
            'semester' => 1,
            'kode_kd' => '1.4',
            'kompetensi_dasar' => 'testingtestingtestingtestingtesting',
            'ringkasan_kompetensi' => 'testingtestingtestingtestingtesting',
        ]);
    }
}

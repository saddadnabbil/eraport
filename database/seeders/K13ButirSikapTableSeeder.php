<?php

namespace Database\Seeders;

use App\K13ButirSikap;
use Illuminate\Database\Seeder;

class K13ButirSikapTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        K13ButirSikap::create([
            'jenis_kompetensi' => 1,
            'kode' => '1.1.1',
            'butir_sikap' => 'Sikap Spiritual',
        ]);

        K13ButirSikap::create([
            'jenis_kompetensi' => 2,
            'kode' => '1.1.2',
            'butir_sikap' => 'Sikap Spiritual',
        ]);
    }
}

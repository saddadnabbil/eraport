<?php

namespace Database\Seeders;

use App\Pembelajaran;
use Illuminate\Database\Seeder;

class PembelajaranTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pembelajaran::create([
            'kelas_id' => 1,
            'mapel_id' => 1,
            'guru_id' => 1,
            'status' => true
        ]);

        Pembelajaran::create([
            'kelas_id' => 1,
            'mapel_id' => 2,
            'guru_id' => 1,
            'status' => true
        ]);

        Pembelajaran::create([
            'kelas_id' => 1,
            'mapel_id' => 3,
            'guru_id' => 1,
            'status' => true
        ]);
    }
}

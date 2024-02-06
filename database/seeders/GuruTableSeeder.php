<?php

namespace Database\Seeders;

use App\Guru;
use Illuminate\Database\Seeder;

class GuruTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Guru::create([
            'karyawan_id' => 1,
        ]);
    }
}

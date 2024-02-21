<?php

namespace Database\Seeders;

use App\AnggotaKelas;
use Illuminate\Database\Seeder;

class AnggotaKelasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnggotaKelas::factory()->count(40)->create();
    }
}

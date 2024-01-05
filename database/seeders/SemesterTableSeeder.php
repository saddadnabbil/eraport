<?php

namespace Database\Seeders;

use App\Semester;
use App\Tapel;
use Illuminate\Database\Seeder;

class SemesterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Semester::create([
            'semester' => 1,
        ]);

        Semester::create([
            'semester' => 2,
        ]);
    }
}

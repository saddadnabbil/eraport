<?php

namespace Database\Seeders;

use App\Models\Semester;
use App\Models\Tapel;
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

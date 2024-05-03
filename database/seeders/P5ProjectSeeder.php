<?php

namespace Database\Seeders;

use App\Models\P5Project;
use Illuminate\Database\Seeder;

class P5ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subelement_data = [
            [
                'subelement_id' => 1,
                'has_active' => false,
            ],
            [
                'subelement_id' => 2,
                'has_active' => true,
            ],
        ];

        $projects = [
            [
                'p5_tema_id' => 1,
                'kelas_id' => 1,
                'guru_id' => 1,
                'name' => 'Project 1',
                'description' => 'Description of Project 1',
            ],
            [
                'p5_tema_id' => 2,
                'kelas_id' => 2,
                'guru_id' => 2,
                'name' => 'Project 2',
                'description' => 'Description of Project 2',
            ],
        ];

        foreach ($projects as $project) {
            P5Project::create([
                'p5_tema_id' => $project['p5_tema_id'],
                'kelas_id' => $project['kelas_id'],
                'guru_id' => $project['guru_id'],
                'name' => $project['name'],
                'description' => $project['description'],
                'subelement_data' => json_encode($subelement_data), // Encode subelement_data to JSON
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

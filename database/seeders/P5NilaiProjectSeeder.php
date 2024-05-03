<?php

namespace Database\Seeders;

use App\Models\P5NilaiProject;
use Illuminate\Database\Seeder;

class P5NilaiProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grades = [
            [
                'subelement_id' => 1,
                'grade' => 90
            ],
            [
                'subelement_id' => 2,
                'grade' => 80
            ],
            [
                'subelement_id' => 3,
                'grade' => 70
            ],
            [
                'subelement_id' => 4,
                'grade' => 60
            ],
        ];

        P5NilaiProject::create([
            'anggota_kelas_id' => 1,
            'p5_project_id' => 1,
            'grade_data' => json_encode($grades),
            'catatan_proses' => 'Catatan Proses Project 1'
        ]);
    }
}

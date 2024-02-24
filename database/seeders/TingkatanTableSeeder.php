<?php

namespace Database\Seeders;

use App\Models\Tingkatan;
use Illuminate\Database\Seeder;

class TingkatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nama_tingkatan = [
            "Playgroup",
            "Kindergarten",
            "Primary School",
            "Junior High School",
            "Senior High School"
        ];

        foreach ($nama_tingkatan as $nama) {
            Tingkatan::create([
                'nama_tingkatan' => $nama,
                'term_id' => 1,
                'semester_id' => 1
            ]);
        }
    }
}

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
        $datas = [
            ["nama_tingkatan" => "Playgroup", "sekolah_id" => 1],
            ["nama_tingkatan" => "Kindergarten A", "sekolah_id" => 1],
            ["nama_tingkatan" => "Kindergarten B", "sekolah_id" => 1],
            ["nama_tingkatan" => "Primary School", "sekolah_id" => 2],
            ["nama_tingkatan" => "Junior High School", "sekolah_id" => 3],
            ["nama_tingkatan" => "Senior High School", "sekolah_id" => 4],
        ];

        foreach ($datas as $data) {
            Tingkatan::create([
                'nama_tingkatan' => $data['nama_tingkatan'],
                'term_id' => 1,
                'semester_id' => 1,
                'sekolah_id' => $data['sekolah_id'],
            ]);
        }
    }
}

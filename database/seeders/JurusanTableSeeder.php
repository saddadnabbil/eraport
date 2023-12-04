<?php

namespace Database\Seeders;

use App\Jurusan;
use Illuminate\Database\Seeder;

class JurusanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nama_jurusan = [
            "IPA",
            "IPS",
            "NON",
        ];

        foreach ($nama_jurusan as $nama) {
            Jurusan::create([
                'nama_jurusan' => $nama
            ]);
        }
    }
}

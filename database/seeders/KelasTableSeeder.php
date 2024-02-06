<?php

namespace Database\Seeders;

use App\Kelas;
use Illuminate\Database\Seeder;

class KelasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kelas::create([
            'tingkatan_id' => 5,
            'jurusan_id' => 1,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'SHS1',
        ]);

        Kelas::create([
            'tingkatan_id' => 5,
            'jurusan_id' => 1,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'SHS2',
        ]);
    }
}

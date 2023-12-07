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
            'tingkatan_id' => 1,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'PA1',
        ]);

        Kelas::create([
            'tingkatan_id' => 2,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 2,
            'nama_kelas' => 'PA2',
        ]);
    }
}

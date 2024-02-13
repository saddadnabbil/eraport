<?php

namespace Database\Seeders;

use App\JadwalPelajaran;
use Illuminate\Database\Seeder;

class JadwalPelajaranTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JadwalPelajaran::firstOrCreate([
            'id' => 1,
        ], [
            'tapel_id' => 1,
            'kelas_id' => 1,
            'nama' => 'SHS 1 IPA',
        ]);
    }
}

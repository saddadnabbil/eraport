<?php

namespace Database\Seeders;

use App\NilaiEkstrakulikuler;
use Illuminate\Database\Seeder;

class NilaiEkstrakulikulerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 'ekstrakulikuler_id',
        // 'anggota_ekstrakulikuler_id',
        // 'nilai',
        // 'deskripsi'

        NilaiEkstrakulikuler::create([
            'ekstrakulikuler_id' => 1,
            'anggota_ekstrakulikuler_id' => 1,
            'nilai' => 90,
            'deskripsi' => 'Sangat Baik'
        ]);
    }
}

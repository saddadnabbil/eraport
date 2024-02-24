<?php

namespace Database\Seeders;

use App\Models\AnggotaEkstrakulikuler;
use Illuminate\Database\Seeder;

class AnggotaEkstrakulikulerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnggotaEkstrakulikuler::create([
            'anggota_kelas_id' => 1,
            'ekstrakulikuler_id' => 1
        ]);
    }
}

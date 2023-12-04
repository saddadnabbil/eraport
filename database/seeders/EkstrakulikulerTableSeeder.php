<?php

namespace Database\Seeders;

use App\Ekstrakulikuler;
use Illuminate\Database\Seeder;

class EkstrakulikulerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ekstrakulikuler::create([
            'tapel_id' => 1,
            'pembina_id' => 1,
            'nama_ekstrakulikuler' => 'Web Design',
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\TkPembelajaran;
use Illuminate\Database\Seeder;

class TkPembelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TkPembelajaran::create([
            'tk_topic_id' => 1,
            'guru_id' => 1,
            'tingkatan_id' => 1,
            'kelas_id' => 1,
        ]);
    }
}

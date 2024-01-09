<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\K13RencanaBobotPenilaian;

class K13RencanaBobotPenilaianTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        K13RencanaBobotPenilaian::create([
            'pembelajaran_id' => 1,
            'bobot_ph' => 1,
            'bobot_pts' => 2,
            'bobot_pas' => 2
        ]);
    }
}

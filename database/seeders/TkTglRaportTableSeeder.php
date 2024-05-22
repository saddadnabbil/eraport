<?php

namespace Database\Seeders;

use App\Models\TkTglRaport;
use Illuminate\Database\Seeder;

class TkTglRaportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TkTglRaport::create([
            'tapel_id' => 1,
            'tempat_penerbitan' => 'Serang',
            'tanggal_pembagian' => now(),
        ]);
    }
}

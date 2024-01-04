<?php

namespace Database\Seeders;

use App\KmTglRaport;
use Illuminate\Database\Seeder;

class KmTglRaportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KmTglRaport::create([
            'tapel_id' => 1,
            'tempat_penerbitan' => 'Kelas',
            'tanggal_pembagian' => now(),
        ]);
    }
}

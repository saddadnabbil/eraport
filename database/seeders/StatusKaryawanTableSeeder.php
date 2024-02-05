<?php

namespace Database\Seeders;

use App\StatusKaryawan;
use Illuminate\Database\Seeder;

class StatusKaryawanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusKaryawan::create([
            'status_kode' => '001',
            'status_nama' => 'Karyawan Tetap'
        ]);

        StatusKaryawan::create([
            'status_kode' => '002',
            'status_nama' => 'Karyawan Kontrak'
        ]);

        StatusKaryawan::create([
            'status_kode' => '003',
            'status_nama' => 'Karyawan Outsource'
        ]);

        StatusKaryawan::create([
            'status_kode' => '004',
            'status_nama' => 'Karyawan Part Time'
        ]);
    }
}

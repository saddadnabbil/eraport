<?php

namespace Database\Seeders;

use App\UnitKaryawan;
use Illuminate\Database\Seeder;

class UnitKaryawanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnitKaryawan::create(['unit_kode' => 'E01', 'unit_nama' => 'Extracurricular Teacher']);
        UnitKaryawan::create(['unit_kode' => 'G01', 'unit_nama' => 'Playgroup - Kindergarten']);
        UnitKaryawan::create(['unit_kode' => 'G02', 'unit_nama' => 'Primary']);
        UnitKaryawan::create(['unit_kode' => 'G03', 'unit_nama' => 'Junior High School']);
        UnitKaryawan::create(['unit_kode' => 'G04', 'unit_nama' => 'Senior High School']);
        UnitKaryawan::create(['unit_kode' => 'HR1', 'unit_nama' => 'HRD']);
        UnitKaryawan::create(['unit_kode' => 'K01', 'unit_nama' => 'Finance Admin']);
        UnitKaryawan::create(['unit_kode' => 'L01', 'unit_nama' => 'Librarian']);
        UnitKaryawan::create(['unit_kode' => 'M01', 'unit_nama' => 'Admission']);
        UnitKaryawan::create(['unit_kode' => 'S01', 'unit_nama' => 'Security']);
        UnitKaryawan::create(['unit_kode' => 'S02', 'unit_nama' => 'Suster']);
        UnitKaryawan::create(['unit_kode' => 'S03', 'unit_nama' => 'Sauber']);
        UnitKaryawan::create(['unit_kode' => 'T01', 'unit_nama' => 'IT Staff']);
        UnitKaryawan::create(['unit_kode' => 'U01', 'unit_nama' => 'General Affair']);
        UnitKaryawan::create(['unit_kode' => 'U02', 'unit_nama' => 'Cleaner']);
    }
}

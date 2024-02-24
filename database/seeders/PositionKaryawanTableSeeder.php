<?php

namespace Database\Seeders;

use App\Models\PositionKaryawan;
use Illuminate\Database\Seeder;

class PositionKaryawanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PositionKaryawan::create(['position_kode' => '000', 'position_nama' => 'CURRICULUM PLAN DEVELOPMENT']);
        PositionKaryawan::create(['position_kode' => '100', 'position_nama' => 'PRINCIPAL']);
        PositionKaryawan::create(['position_kode' => '150', 'position_nama' => 'SENIOR VICE PRINCIPAL']);
        PositionKaryawan::create(['position_kode' => '200', 'position_nama' => 'VICE PRINCIPAL STUDENT AFFAIR']);
        PositionKaryawan::create(['position_kode' => '300', 'position_nama' => 'HOMEROOM']);
        PositionKaryawan::create(['position_kode' => '310', 'position_nama' => 'VICE PRINCIPAL CURRICULUM']);
        PositionKaryawan::create(['position_kode' => '400', 'position_nama' => 'TEACHER']);
        PositionKaryawan::create(['position_kode' => '410', 'position_nama' => 'EXTRACURRICULAR TEACHER']);
        PositionKaryawan::create(['position_kode' => '500', 'position_nama' => 'CLASS ASSISTANT']);
        PositionKaryawan::create(['position_kode' => '900', 'position_nama' => 'ADMIN UNIT']);
        PositionKaryawan::create(['position_kode' => '901', 'position_nama' => 'REPRESENTATIVE BOARD OF FOUNDATION']);
        PositionKaryawan::create(['position_kode' => '910', 'position_nama' => 'GENERAL AFFAIR']);
        PositionKaryawan::create(['position_kode' => '911', 'position_nama' => 'CLEANER']);
        PositionKaryawan::create(['position_kode' => '920', 'position_nama' => 'NURSE']);
        PositionKaryawan::create(['position_kode' => '930', 'position_nama' => 'SECURITY']);
        PositionKaryawan::create(['position_kode' => '940', 'position_nama' => 'CCTV MONITOR']);
        PositionKaryawan::create(['position_kode' => '950', 'position_nama' => 'COUNSELOR']);
        PositionKaryawan::create(['position_kode' => '960', 'position_nama' => 'ADMISSION STAFF']);
        PositionKaryawan::create(['position_kode' => '990', 'position_nama' => 'CONTENT CREATOR']);
        PositionKaryawan::create(['position_kode' => '991', 'position_nama' => 'PROGRAMMER']);
        PositionKaryawan::create(['position_kode' => '992', 'position_nama' => 'IT SUPPORT']);
        PositionKaryawan::create(['position_kode' => 'CSO', 'position_nama' => 'CUSTOMER SERVICE OFFICER']);
        PositionKaryawan::create(['position_kode' => 'DR1', 'position_nama' => 'DRIVER']);
        PositionKaryawan::create(['position_kode' => 'FNA', 'position_nama' => 'FINANCE ADMIN']);
        PositionKaryawan::create(['position_kode' => 'L01', 'position_nama' => 'LIBRARIAN']);
        PositionKaryawan::create(['position_kode' => 'L02', 'position_nama' => 'LAB ASSISTANT']);
        PositionKaryawan::create(['position_kode' => 'L03', 'position_nama' => 'LEADER']);
        PositionKaryawan::create(['position_kode' => 'WRA', 'position_nama' => 'WAREHOUSE ADMIN']);
    }
}

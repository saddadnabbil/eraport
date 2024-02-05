<?php

namespace Database\Seeders;

use App\PositionKaryawan;
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
        PositionKaryawan::create(['position_kode' => '000', 'position_nama' => 'Curriculum Plan Development']);
        PositionKaryawan::create(['position_kode' => '100', 'position_nama' => 'Principal']);
        PositionKaryawan::create(['position_kode' => '150', 'position_nama' => 'Senior Vice Principal']);
        PositionKaryawan::create(['position_kode' => '200', 'position_nama' => 'Vice Principal Student Affair']);
        PositionKaryawan::create(['position_kode' => '300', 'position_nama' => 'Homeroom']);
        PositionKaryawan::create(['position_kode' => '310', 'position_nama' => 'Vice Principal Curriculum']);
        PositionKaryawan::create(['position_kode' => '400', 'position_nama' => 'Teacher']);
        PositionKaryawan::create(['position_kode' => '410', 'position_nama' => 'Extracurricular Teacher']);
        PositionKaryawan::create(['position_kode' => '500', 'position_nama' => 'Class Assistant']);
        PositionKaryawan::create(['position_kode' => '900', 'position_nama' => 'Admin Unit']);
        PositionKaryawan::create(['position_kode' => '901', 'position_nama' => 'Representative Board of Foundation']);
        PositionKaryawan::create(['position_kode' => '910', 'position_nama' => 'General Affair']);
        PositionKaryawan::create(['position_kode' => '911', 'position_nama' => 'Cleaner']);
        PositionKaryawan::create(['position_kode' => '920', 'position_nama' => 'Nurse']);
        PositionKaryawan::create(['position_kode' => '930', 'position_nama' => 'Security']);
    }
}

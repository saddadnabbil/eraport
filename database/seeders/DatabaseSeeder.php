<?php

use App\Kelas;
use App\Semester;
use App\AnggotaKelas;
use App\PrestasiSiswa;


use App\KmNilaiAkhirRaport;
use App\CapaianPembelajaran;
use Illuminate\Database\Seeder;
use Database\Seeders\SilabusSeeder;
use Database\Seeders\GuruTableSeeder;
use Database\Seeders\TermTableSeeder;
use Database\Seeders\AdminTableSeeder;
use Database\Seeders\KelasTableSeeder;
use Database\Seeders\MapelTableSeeder;
use Database\Seeders\SiswaTableSeeder;
use Database\Seeders\TapelTableSeeder;
use Database\Seeders\JurusanTableSeeder;
use Database\Seeders\KaryawanTableSeeder;
use Database\Seeders\SemesterTableSeeder;
use Database\Seeders\TingkatanTableSeeder;
use Database\Seeders\KmKkmMapelTableSeeder;
use Database\Seeders\NilaiAkhirTableSeeder;
use Database\Seeders\KmTglRaportTableSeeder;
use Database\Seeders\AnggotaKelasTableSeeder;
use Database\Seeders\KmNilaiAkhirTableSeeder;
use Database\Seeders\NilaiSumatifTableSeeder;
use Database\Seeders\PembelajaranTableSeeder;
use Database\Seeders\UnitKaryawanTableSeeder;
use Database\Seeders\PrestasiSiswaTableSeeder;
use Database\Seeders\KmMappingMapelTableSeeder;
use Database\Seeders\KmNilaiSumatifTableSeeder;
use Database\Seeders\StatusKaryawanTableSeeder;
use UsersTableSeeder as GlobalUsersTableSeeder;
use Database\Seeders\EkstrakulikulerTableSeeder;
use Database\Seeders\JadwalPelajaranTableSeeder;
use Database\Seeders\KmNilaiFormatifTableSeeder;
use Database\Seeders\PositionKaryawanTableSeeder;
use Database\Seeders\KmNilaiAkhirRaportTableSeeder;
use SekolahTableSeeder as GlobalSekolahTableSeeder;
use Database\Seeders\CapaianPembelajaranTableSeeder;
use Database\Seeders\JadwalPelajaranSlotTableSeeder;
use Database\Seeders\RencanaNilaiSumatifTableSeeder;
use Database\Seeders\NilaiEkstrakulikulerTableSeeder;
use Database\Seeders\RencanaNilaiFormatifTableSeeder;
use Database\Seeders\KmDeskripsiNilaiSiswaTableSeeder;
use Database\Seeders\AnggotaEkstrakulikulerTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // Master Data Seeder
            JurusanTableSeeder::class,
            SemesterTableSeeder::class,
            TermTableSeeder::class,
            TapelTableSeeder::class,
            TingkatanTableSeeder::class,
            GlobalUsersTableSeeder::class,
            AdminTableSeeder::class,
            StatusKaryawanTableSeeder::class,
            UnitKaryawanTableSeeder::class,
            PositionKaryawanTableSeeder::class,
            KaryawanTableSeeder::class,
            GuruTableSeeder::class,
            KelasTableSeeder::class,
            SiswaTableSeeder::class,
            AnggotaKelasTableSeeder::class,
            PrestasiSiswaTableSeeder::class,
            EkstrakulikulerTableSeeder::class,
            AnggotaEkstrakulikulerTableSeeder::class,
            MapelTableSeeder::class,
            PembelajaranTableSeeder::class,
            GlobalSekolahTableSeeder::class,

            NilaiEkstrakulikulerTableSeeder::class,

            // KM Seeder
            KmKkmMapelTableSeeder::class,
            SilabusSeeder::class,
            CapaianPembelajaranTableSeeder::class,
            RencanaNilaiSumatifTableSeeder::class,
            RencanaNilaiFormatifTableSeeder::class,
            KmNilaiFormatifTableSeeder::class,
            KmNilaiSumatifTableSeeder::class,
            KmNilaiAkhirRaportTableSeeder::class,
            KmDeskripsiNilaiSiswaTableSeeder::class,
            KmNilaiAkhirTableSeeder::class,
            KmMappingMapelTableSeeder::class,
            KmTglRaportTableSeeder::class,

            // Timetable
            JadwalPelajaranSlotTableSeeder::class,
        ]);
    }
}

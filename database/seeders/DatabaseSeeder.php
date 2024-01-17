<?php

use App\Kelas;
use App\Semester;
use App\AnggotaKelas;
use App\PrestasiSiswa;
use App\K13NilaiPtsPas;
use App\K13NilaiSosial;
use App\K13NilaiSpiritual;
use App\KmNilaiAkhirRaport;
use App\CapaianPembelajaran;
use App\K13NilaiPengetahuan;
use App\K13NilaiKeterampilan;
use App\NilaiEkstrakulikuler;
use App\KmDeskripsiNilaiSiswa;
use Illuminate\Database\Seeder;
use App\K13RencanaNilaiPengetahuan;
use Database\Seeders\SilabusSeeder;
use Database\Seeders\GuruTableSeeder;
use Database\Seeders\TermTableSeeder;
use Database\Seeders\AdminTableSeeder;
use Database\Seeders\KelasTableSeeder;
use Database\Seeders\MapelTableSeeder;
use Database\Seeders\SiswaTableSeeder;
use Database\Seeders\TapelTableSeeder;
use Database\Seeders\K13KkmTableSeeder;
use Database\Seeders\JurusanTableSeeder;
use Database\Seeders\SemesterTableSeeder;
use Database\Seeders\TingkatanTableSeeder;
use Database\Seeders\K13KdMapelTableSeeder;
use Database\Seeders\KmKkmMapelTableSeeder;
use Database\Seeders\NilaiAkhirTableSeeder;
use Database\Seeders\KmTglRaportTableSeeder;
use Database\Seeders\AnggotaKelasTableSeeder;
use Database\Seeders\K13TglRaportTableSeeder;
use Database\Seeders\NilaiSumatifTableSeeder;
use Database\Seeders\PembelajaranTableSeeder;
use Database\Seeders\K13ButirSikapTableSeeder;
use Database\Seeders\KmNilaiFormatifTableSeeder;
use Database\Seeders\PrestasiSiswaTableSeeder;
use Database\Seeders\K13NilaiPtsPasTableSeeder;
use Database\Seeders\K13NilaiSosialTableSeeder;
use Database\Seeders\KmMappingMapelTableSeeder;
use UsersTableSeeder as GlobalUsersTableSeeder;
use Database\Seeders\EkstrakulikulerTableSeeder;
use Database\Seeders\K13MappingMapelTableSeeder;
use Database\Seeders\K13NilaiSpiritualTableSeeder;
use Database\Seeders\KmNilaiAkhirRaportTableSeeder;
use SekolahTableSeeder as GlobalSekolahTableSeeder;
use Database\Seeders\CapaianPembelajaranTableSeeder;
use Database\Seeders\K13NilaiAkhirRaportTableSeeder;
use Database\Seeders\K13NilaiPengetahuanTableSeeder;
use Database\Seeders\RencanaNilaiSumatifTableSeeder;
use Database\Seeders\K13NilaiKeterampilanTableSeeder;
use Database\Seeders\NilaiEkstrakulikulerTableSeeder;
use Database\Seeders\RencanaNilaiFormatifTableSeeder;
use Database\Seeders\K13RencanaNilaiSosialTableSeeder;
use Database\Seeders\KmDeskripsiNilaiSiswaTableSeeder;
use Database\Seeders\AnggotaEkstrakulikulerTableSeeder;
use Database\Seeders\K13DeskripsiNilaiSiswaTableSeeder;
use Database\Seeders\K13RencanaBobotPenilaianTableSeeder;
use Database\Seeders\K13RencanaNilaiSpiritualTableSeeder;
use Database\Seeders\K13RencanaNilaiPengetahuanTableSeeder;
use Database\Seeders\K13RencanaNilaiKeterampilanTableSeeder;
use Database\Seeders\KmNilaiAkhirTableSeeder;
use Database\Seeders\KmNilaiSumatifTableSeeder;

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

            // K13 Seeder
            K13KkmTableSeeder::class,
            K13MappingMapelTableSeeder::class,
            K13KdMapelTableSeeder::class,
            K13ButirSikapTableSeeder::class,
            K13TglRaportTableSeeder::class,
            K13RencanaNilaiKeterampilanTableSeeder::class,
            K13RencanaNilaiPengetahuanTableSeeder::class,
            K13RencanaNilaiSpiritualTableSeeder::class,
            K13RencanaNilaiSosialTableSeeder::class,
            K13RencanaBobotPenilaianTableSeeder::class,
            K13NilaiPengetahuanTableSeeder::class,
            K13NilaiKeterampilanTableSeeder::class,
            K13NilaiSosialTableSeeder::class,
            K13NilaiSpiritualTableSeeder::class,
            K13NilaiPtsPasTableSeeder::class,
            NilaiEkstrakulikulerTableSeeder::class,
            K13NilaiAkhirRaportTableSeeder::class,
            K13DeskripsiNilaiSiswaTableSeeder::class,

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
        ]);
    }
}

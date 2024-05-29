<?php

use App\Models\Kelas;
use App\Models\P5Tema;
use App\Models\TkPoint;
use App\Models\Semester;


use App\Models\TkElement;
use App\Models\AnggotaKelas;
use App\Models\TkSetTeacher;
use App\Models\PrestasiSiswa;
use App\Models\P5NilaiProject;
use App\Models\TkPembelajaran;
use Illuminate\Database\Seeder;
use App\Models\KmNilaiAkhirRaport;
use Database\Seeders\P5TemaSeeder;
use App\Models\CapaianPembelajaran;
use Database\Seeders\SilabusSeeder;
use Database\Seeders\TkEventSeeder;
use Database\Seeders\TkPointSeeder;
use Database\Seeders\TkTopicSeeder;
use Database\Seeders\GuruTableSeeder;
use Database\Seeders\P5DimensiSeeder;
use Database\Seeders\P5ElementSeeder;
use Database\Seeders\P5ProjectSeeder;
use Database\Seeders\RoleTableSeeder;
use Database\Seeders\TermTableSeeder;
use Database\Seeders\TkElementSeeder;
use Database\Seeders\AdminTableSeeder;
use Database\Seeders\KelasTableSeeder;
use Database\Seeders\MapelTableSeeder;
use Database\Seeders\SiswaTableSeeder;
use Database\Seeders\TapelTableSeeder;
use Database\Seeders\TkSubtopicSeeder;
use Database\Seeders\JurusanTableSeeder;
use Database\Seeders\P5SubelementSeeder;
use Database\Seeders\TkSetTeacherSeeder;
use Database\Seeders\KaryawanTableSeeder;
use Database\Seeders\SemesterTableSeeder;
use Database\Seeders\P5NilaiProjectSeeder;
use Database\Seeders\TingkatanTableSeeder;
use Database\Seeders\TkPembelajaranSeeder;
use Database\Seeders\KmKkmMapelTableSeeder;
use Database\Seeders\NilaiAkhirTableSeeder;
use Database\Seeders\PermissionTableSeeder;
use Spatie\Permission\Contracts\Permission;
use Database\Seeders\KmTglRaportTableSeeder;
use Database\Seeders\TkTglRaportTableSeeder;
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
            // Roles
            PermissionTableSeeder::class,
            RoleTableSeeder::class,

            // Master Data Seeder
            JurusanTableSeeder::class,
            SemesterTableSeeder::class,
            TermTableSeeder::class,
            TapelTableSeeder::class,
            TingkatanTableSeeder::class,
            GlobalUsersTableSeeder::class,
            GlobalSekolahTableSeeder::class,

            StatusKaryawanTableSeeder::class,
            UnitKaryawanTableSeeder::class,
            PositionKaryawanTableSeeder::class,
            KaryawanTableSeeder::class,

            // GuruTableSeeder::class,
            KelasTableSeeder::class,
            // SiswaTableSeeder::class,
            // AnggotaKelasTableSeeder::class,
            // PrestasiSiswaTableSeeder::class,
            // EkstrakulikulerTableSeeder::class,
            // AnggotaEkstrakulikulerTableSeeder::class,
            // MapelTableSeeder::class,
            // PembelajaranTableSeeder::class,

            // NilaiEkstrakulikulerTableSeeder::class,

            // // KM Seeder
            // KmKkmMapelTableSeeder::class,
            // SilabusSeeder::class,
            // CapaianPembelajaranTableSeeder::class,
            // RencanaNilaiSumatifTableSeeder::class,
            // RencanaNilaiFormatifTableSeeder::class,
            // KmNilaiFormatifTableSeeder::class,
            // KmNilaiSumatifTableSeeder::class,
            // KmNilaiAkhirRaportTableSeeder::class,
            // KmDeskripsiNilaiSiswaTableSeeder::class,
            // KmNilaiAkhirTableSeeder::class,
            // KmMappingMapelTableSeeder::class,
            // KmTglRaportTableSeeder::class,

            // // Timetable
            // JadwalPelajaranSlotTableSeeder::class,

            // // Tk report
            // TkElementSeeder::class,
            // TkTopicSeeder::class,
            // TkSubtopicSeeder::class,
            // TkPointSeeder::class,
            // TkPembelajaranSeeder::class,
            // TkEventSeeder::class,
            // TkTglRaportTableSeeder::class,

            // // P5BK
            // P5DimensiSeeder::class,
            // P5ElementSeeder::class,
            // P5SubelementSeeder::class,
            // P5TemaSeeder::class,
            // P5ProjectSeeder::class,
            // P5NilaiProjectSeeder::class,
        ]);
    }
}

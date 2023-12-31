<?php

use App\Kelas;
use App\AnggotaKelas;
use App\CapaianPembelajaran;
use Illuminate\Database\Seeder;
use Database\Seeders\SilabusSeeder;
use Database\Seeders\GuruTableSeeder;
use Database\Seeders\AdminTableSeeder;
use Database\Seeders\KelasTableSeeder;
use Database\Seeders\MapelTableSeeder;
use Database\Seeders\SiswaTableSeeder;
use Database\Seeders\TapelTableSeeder;
use Database\Seeders\K13KkmTableSeeder;
use Database\Seeders\JurusanTableSeeder;
use Database\Seeders\TingkatanTableSeeder;
use Database\Seeders\AnggotaKelasTableSeeder;
use Database\Seeders\PembelajaranTableSeeder;
use UsersTableSeeder as GlobalUsersTableSeeder;
use Database\Seeders\EkstrakulikulerTableSeeder;
use SekolahTableSeeder as GlobalSekolahTableSeeder;
use Database\Seeders\CapaianPembelajaranTableSeeder;
use Database\Seeders\RencanaNilaiSumatifTableSeeder;
use Database\Seeders\RencanaNilaiFormatifTableSeeder;
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
            TingkatanTableSeeder::class,
            JurusanTableSeeder::class,
            TapelTableSeeder::class,
            GlobalUsersTableSeeder::class,
            AdminTableSeeder::class,
            GuruTableSeeder::class,
            KelasTableSeeder::class,
            SiswaTableSeeder::class,
            AnggotaKelasTableSeeder::class,
            EkstrakulikulerTableSeeder::class,
            AnggotaEkstrakulikulerTableSeeder::class,
            MapelTableSeeder::class,
            PembelajaranTableSeeder::class,
            GlobalSekolahTableSeeder::class,
            K13KkmTableSeeder::class,
            SilabusSeeder::class,
            CapaianPembelajaranTableSeeder::class,
            RencanaNilaiSumatifTableSeeder::class,
            RencanaNilaiFormatifTableSeeder::class,
        ]);
    }
}

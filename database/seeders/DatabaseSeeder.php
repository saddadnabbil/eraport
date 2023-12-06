<?php

use App\Kelas;
use App\AnggotaKelas;
use Illuminate\Database\Seeder;
use Database\Seeders\GuruTableSeeder;
use Database\Seeders\AdminTableSeeder;
use Database\Seeders\AnggotaEkstrakulikulerTableSeeder;
use Database\Seeders\KelasTableSeeder;
use Database\Seeders\MapelTableSeeder;
use Database\Seeders\SiswaTableSeeder;
use Database\Seeders\TapelTableSeeder;
use Database\Seeders\JurusanTableSeeder;
use Database\Seeders\TingkatanTableSeeder;
use Database\Seeders\AnggotaKelasTableSeeder;
use Database\Seeders\EkstrakulikulerTableSeeder;
use Database\Seeders\K13KkmTableSeeder;
use Database\Seeders\PembelajaranTableSeeder;
use Database\Seeders\SilabusSeeder;
use UsersTableSeeder as GlobalUsersTableSeeder;
use SekolahTableSeeder as GlobalSekolahTableSeeder;

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
            SilabusSeeder::class
        ]);
    }
}

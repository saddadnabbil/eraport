<?php

namespace Database\Seeders;

use App\CapaianPembelajaran;
use Illuminate\Database\Seeder;

class CapaianPembelajaranTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CapaianPembelajaran::create([
            'pembelajaran_id' => 1,
            'semester' => '1',
            'kode_cp' => 'CP1',
            'capaian_pembelajaran' => 'lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, doloribus? ',
            'ringkasan_cp' => 'Pembelajaran 1',
        ]);

        CapaianPembelajaran::create([
            'pembelajaran_id' => 2,
            'semester' => '1',
            'kode_cp' => 'CP2',
            'capaian_pembelajaran' => 'lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, doloribus? ',
            'ringkasan_cp' => 'Pembelajaran 2',
        ]);

        CapaianPembelajaran::create([
            'pembelajaran_id' => 3,
            'semester' => '1',
            'kode_cp' => 'CP3',
            'capaian_pembelajaran' => 'lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, doloribus? ',
            'ringkasan_cp' => 'Pembelajaran 3',
        ]);

        CapaianPembelajaran::create([
            'pembelajaran_id' => 4,
            'semester' => '1',
            'kode_cp' => 'CP4',
            'capaian_pembelajaran' => 'lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, doloribus? ',
            'ringkasan_cp' => 'Pembelajaran 4',
        ]);
    }
}

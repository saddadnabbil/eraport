<?php

namespace Database\Seeders;

use App\KmDeskripsiNilaiSiswa;
use Illuminate\Database\Seeder;

class KmDeskripsiNilaiSiswaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KmDeskripsiNilaiSiswa::create([
            'pembelajaran_id' => 1,
            'km_nilai_akhir_raport_id' => 1,
            'deskripsi_raport' => 'Deskripsi Formatif, Deskripsi Formatif, Deskripsi Formatif',
        ]);

        KmDeskripsiNilaiSiswa::create([
            'pembelajaran_id' => 2,
            'km_nilai_akhir_raport_id' => 2,
            'deskripsi_raport' => 'Deskripsi Formatif, Deskripsi Formatif, Deskripsi Formatif',
        ]);

        KmDeskripsiNilaiSiswa::create([
            'pembelajaran_id' => 3,
            'km_nilai_akhir_raport_id' => 3,
            'deskripsi_raport' => 'Deskripsi Formatif, Deskripsi Formatif, Deskripsi Formatif',
        ]);

        KmDeskripsiNilaiSiswa::create([
            'pembelajaran_id' => 4,
            'km_nilai_akhir_raport_id' => 4,
            'deskripsi_raport' => 'Deskripsi Formatif, Deskripsi Formatif, Deskripsi Formatif',
        ]);

        KmDeskripsiNilaiSiswa::create([
            'pembelajaran_id' => 4,
            'km_nilai_akhir_raport_id' => 5,
            'deskripsi_raport' => 'Deskripsi Formatif, Deskripsi Formatif, Deskripsi Formatif',
        ]);
    }
}

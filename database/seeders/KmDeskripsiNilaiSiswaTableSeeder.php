<?php

namespace Database\Seeders;

use App\Models\KmDeskripsiNilaiSiswa;
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
        // term 1
        KmDeskripsiNilaiSiswa::create([
            'pembelajaran_id' => 1,
            'term_id' => 1,
            'km_nilai_akhir_raport_id' => 1,
            'deskripsi_raport' => 'Capaian Pembelajaran Deskripsi',
        ]);

        KmDeskripsiNilaiSiswa::create([
            'pembelajaran_id' => 2,
            'term_id' => 1,
            'km_nilai_akhir_raport_id' => 2,
            'deskripsi_raport' => 'Capaian Pembelajaran Deskripsi',
        ]);

        KmDeskripsiNilaiSiswa::create([
            'pembelajaran_id' => 3,
            'term_id' => 1,
            'km_nilai_akhir_raport_id' => 3,
            'deskripsi_raport' => 'Capaian Pembelajaran Deskripsi',
        ]);

        KmDeskripsiNilaiSiswa::create([
            'pembelajaran_id' => 4,
            'term_id' => 1,
            'km_nilai_akhir_raport_id' => 4,
            'deskripsi_raport' => 'Capaian Pembelajaran Deskripsi',
        ]);

        KmDeskripsiNilaiSiswa::create([
            'pembelajaran_id' => 4,
            'term_id' => 1,
            'km_nilai_akhir_raport_id' => 5,
            'deskripsi_raport' => 'Capaian Pembelajaran Deskripsi',
        ]);

        // term 2
        KmDeskripsiNilaiSiswa::create([
            'pembelajaran_id' => 1,
            'term_id' => 2,
            'km_nilai_akhir_raport_id' => 6,
            'deskripsi_raport' => 'Capaian Pembelajaran Deskripsi',
        ]);

        KmDeskripsiNilaiSiswa::create([
            'pembelajaran_id' => 2,
            'term_id' => 2,
            'km_nilai_akhir_raport_id' => 7,
            'deskripsi_raport' => 'Capaian Pembelajaran Deskripsi',
        ]);

        KmDeskripsiNilaiSiswa::create([
            'pembelajaran_id' => 3,
            'term_id' => 2,
            'km_nilai_akhir_raport_id' => 8,
            'deskripsi_raport' => 'Capaian Pembelajaran Deskripsi',
        ]);

        KmDeskripsiNilaiSiswa::create([
            'pembelajaran_id' => 4,
            'term_id' => 2,
            'km_nilai_akhir_raport_id' => 9,
            'deskripsi_raport' => 'Capaian Pembelajaran Deskripsi',
        ]);

        KmDeskripsiNilaiSiswa::create([
            'pembelajaran_id' => 4,
            'term_id' => 2,
            'km_nilai_akhir_raport_id' => 10,
            'deskripsi_raport' => 'Capaian Pembelajaran Deskripsi',
        ]);
    }
}

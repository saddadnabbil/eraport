<?php

namespace Database\Seeders;

use App\Models\P5Dimensi;
use Illuminate\Database\Seeder;

class P5DimensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dimensi = [
            'Beriman, Bertakwa Kepada Tuhan Yang Maha Esa, dan Berahlak Mulia',
            'Berkebinekaan Global',
            'Bergotong Royong',
            'Mandiri',
            'Bernalar Kritis',
            'Kreatif',
        ];

        // Hapus duplikat
        $dimensi = array_unique($dimensi);

        // Masukkan data ke dalam database
        foreach ($dimensi as $item) {
            P5Dimensi::create([
                'name' => $item,
            ]);
        }
    }
}

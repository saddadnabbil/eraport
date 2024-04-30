<?php

namespace Database\Seeders;

use App\Models\P5Element;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class P5ElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $elements = [
            // Beriman, Bertakwa Kepada Tuhan Yang Maha Esa, dan Berahlak Mulia
            ['p5_dimensi_id' => 1, 'name' => 'Akhlak beragama'],
            ['p5_dimensi_id' => 1, 'name' => 'Akhlak Pribadi'],
            ['p5_dimensi_id' => 1, 'name' => 'Akhlak kepada manusia'],
            ['p5_dimensi_id' => 1, 'name' => 'Akhlak kepada alam'],
            ['p5_dimensi_id' => 1, 'name' => 'Akhlak bernegara'],
            // Berkebinekaan Global
            ['p5_dimensi_id' => 2, 'name' => 'Mengenal dan menghargai budaya'],
            ['p5_dimensi_id' => 2, 'name' => 'Komunikasi dan interaksi antar budaya'],
            ['p5_dimensi_id' => 2, 'name' => 'Refleksi dan bertanggung jawab terhadap pengalaman kebinekaan'],
            ['p5_dimensi_id' => 2, 'name' => 'Berkeadilan Sosial'],
            // Bergotong Royong
            ['p5_dimensi_id' => 3, 'name' => 'Kolaborasi'],
            ['p5_dimensi_id' => 3, 'name' => 'Kepedulian'],
            ['p5_dimensi_id' => 3, 'name' => 'Berbagi'],
            // Mandiri
            ['p5_dimensi_id' => 4, 'name' => 'Pemahaman diri dan situasi yang dihadapi'],
            ['p5_dimensi_id' => 4, 'name' => 'Regulasi Diri'],
            // Bernalar Kritis
            ['p5_dimensi_id' => 5, 'name' => 'Memperoleh dan memproses informasi dan gagasan'],
            ['p5_dimensi_id' => 5, 'name' => 'Menganalisis dan mengevaluasi penalaran dan prosedurnya'],
            ['p5_dimensi_id' => 5, 'name' => 'Refleksi pemikiran dan proses berpikir'],
            // Kreatif
            ['p5_dimensi_id' => 6, 'name' => 'Menghasilkan gagasan yang orisinal'],
            ['p5_dimensi_id' => 6, 'name' => 'Mengeksplorasi gagasan yang orisinal'],
            ['p5_dimensi_id' => 6, 'name' => 'Memiliki keluwesan berpikir dalam mencari alternatif solusi permasalahan'],
        ];

        // Masukkan data ke dalam tabel p5_element
        foreach ($elements as $element) {
            P5Element::create($element);
        }
    }
}

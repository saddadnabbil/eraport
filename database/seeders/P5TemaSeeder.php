<?php

namespace Database\Seeders;

use App\Models\P5Tema;
use Illuminate\Database\Seeder;

class P5TemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $temas = [
            'Gaya Hidup Berkelanjutan',
            'Kearifan Lokal',
            'Bhineneka Tunggal Ika',
            'Bangunlah Jiwa dan Raganya',
            'Suara Demokrasi',
            'Berekayasa dan Berteknologi untuk Membangun NKRI',
            'Kewirausahaan',
        ];

        foreach ($temas as $tema) {
            P5Tema::create([
                'name' => $tema
            ]);
        }
    }
}

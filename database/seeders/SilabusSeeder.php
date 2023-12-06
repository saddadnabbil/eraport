<?php

namespace Database\Seeders;

use App\Silabus;
use Illuminate\Database\Seeder;

class SilabusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Silabus::create([
            'kelas_id' => '1',
            'mapel_id' => '1',
            'k_tigabelas' => 'testing.pdf',
            'cambridge' => 'testing.pdf',
            'edexcel' => 'testing.pdf',
            'book_indo_siswa' => 'testing.pdf',
            'book_english_siswa' => 'testing.pdf',
            'book_indo_guru' => 'testing.pdf',
            'book_english_guru' => 'testing.pdf'
        ]);
    }
}

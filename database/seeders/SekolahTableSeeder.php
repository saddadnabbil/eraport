<?php

use App\Sekolah;
use Illuminate\Database\Seeder;

class SekolahTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sekolah::create([
            'nama_sekolah' => 'Global Indonesia School',
            'npsn' => '0000000000',
            'kode_pos' => '62001',
            'alamat' => 'Perumahan Emerald Lake, Jl. Raya Tasikardi, Pelamunan, Kramatwatu, Serang-Banten, 42161 Kabupaten Serang, Banten.',
            // 'logo' => 'logo.png',
            'nomor_telpon' => '0254-7941564',
            'email' => 'admin@gis.com',
            'kepala_sekolah' => 'IVAN SENEVIRATNE, M.ED',
            'tapel_id' => 1,
        ]);
    }
}

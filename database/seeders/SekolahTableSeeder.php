<?php

namespace Database\Seeders;

use App\Models\Sekolah;
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
        // PG/KG
        Sekolah::create([
            'tapel_id' => 1,
            'nama_sekolah' => 'Global Indonesia PG/KG',
            'npsn' => '0000000000',
            'kode_pos' => '62001',
            'alamat' => 'Perumahan Emerald Lake, Jl. Raya Tasikardi, Pelamunan, Kramatwatu, Serang-Banten, 42161 Kabupaten Serang, Banten.',
            // 'logo' => 'logo.png',
            'nomor_telpon' => '0254-7941564',
            'email' => 'admin@gis.com',
            'kepala_sekolah' => 'IVAN SENEVIRATNE, M.ED',
        ]);

        // SD
        Sekolah::create([
            'tapel_id' => 1,
            'nama_sekolah' => 'Global Indonesia Primary School',
            'npsn' => '0000000000',
            'kode_pos' => '62001',
            'alamat' => 'Perumahan Emerald Lake, Jl. Raya Tasikardi, Pelamunan, Kramatwatu, Serang-Banten, 42161 Kabupaten Serang, Banten.',
            // 'logo' => 'logo.png',
            'nomor_telpon' => '0254-7941564',
            'email' => 'admin@gis.com',
            'kepala_sekolah' => 'IVAN SENEVIRATNE, M.ED',
        ]);

        // smp
        Sekolah::create([
            'tapel_id' => 1,
            'nama_sekolah' => 'Global Indonesia Junior High School',
            'npsn' => '0000000000',
            'kode_pos' => '62001',
            'alamat' => 'Perumahan Emerald Lake, Jl. Raya Tasikardi, Pelamunan, Kramatwatu, Serang-Banten, 42161 Kabupaten Serang, Banten.',
            // 'logo' => 'logo.png',
            'nomor_telpon' => '0254-7941564',
            'email' => 'admin@gis.com',
            'kepala_sekolah' => 'IVAN SENEVIRATNE, M.ED',
        ]);

        // sma
        Sekolah::create([
            'tapel_id' => 1,
            'nama_sekolah' => 'Global Indonesia Senior High School',
            'npsn' => '0000000000',
            'kode_pos' => '62001',
            'alamat' => 'Perumahan Emerald Lake, Jl. Raya Tasikardi, Pelamunan, Kramatwatu, Serang-Banten, 42161 Kabupaten Serang, Banten.',
            // 'logo' => 'logo.png',
            'nomor_telpon' => '0254-7941564',
            'email' => 'admin@gis.com',
            'kepala_sekolah' => 'IVAN SENEVIRATNE, M.ED',
        ]);
    }
}

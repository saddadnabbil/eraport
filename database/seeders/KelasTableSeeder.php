<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed data for PG
        Kelas::create([
            'tingkatan_id' => 1,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'PG',
        ]);

        // Seed data for KG
        Kelas::create([
            'tingkatan_id' => 2,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'KG-A1',
        ]);

        Kelas::create([
            'tingkatan_id' => 2,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'KG-A2',
        ]);

        Kelas::create([
            'tingkatan_id' => 2,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'KG-A3',
        ]);

        Kelas::create([
            'tingkatan_id' => 3,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'KG-B1',
        ]);

        Kelas::create([
            'tingkatan_id' => 3,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'KG-B2',
        ]);

        Kelas::create([
            'tingkatan_id' => 3,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'KG-B3',
        ]);

        // id 8 ke atas
        // Seed data for P
        Kelas::create([
            'tingkatan_id' => 4,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 2,
            'nama_kelas' => 'P-1A',
        ]);

        Kelas::create([
            'tingkatan_id' => 4,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'P-1B',
        ]);

        Kelas::create([
            'tingkatan_id' => 4,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'P-1C',
        ]);

        Kelas::create([
            'tingkatan_id' => 4,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'P-2A',
        ]);

        Kelas::create([
            'tingkatan_id' => 4,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'P-2B',
        ]);

        Kelas::create([
            'tingkatan_id' => 4,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'P-3A',
        ]);

        Kelas::create([
            'tingkatan_id' => 4,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'P-3B',
        ]);

        Kelas::create([
            'tingkatan_id' => 4,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'P-4A',
        ]);

        Kelas::create([
            'tingkatan_id' => 4,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'P-4B',
        ]);

        Kelas::create([
            'tingkatan_id' => 4,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'P-5A',
        ]);

        Kelas::create([
            'tingkatan_id' => 4,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'P-6A',
        ]);
        // Seed data for JHS
        Kelas::create([
            'tingkatan_id' => 5,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'JHS-7A',
        ]);

        Kelas::create([
            'tingkatan_id' => 5,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'JHS-7B',
        ]);

        Kelas::create([
            'tingkatan_id' => 5,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'JHS-8A',
        ]);

        Kelas::create([
            'tingkatan_id' => 5,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'JHS-8B',
        ]);

        Kelas::create([
            'tingkatan_id' => 5,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'JHS-9A',
        ]);

        Kelas::create([
            'tingkatan_id' => 5,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'JHS-9B',
        ]);

        // Seed data for SHS
        Kelas::create([
            'tingkatan_id' => 6,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'SHS-10A',
        ]);

        Kelas::create([
            'tingkatan_id' => 6,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'SHS-10B',
        ]);

        Kelas::create([
            'tingkatan_id' => 6,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'SHS-11A',
        ]);

        Kelas::create([
            'tingkatan_id' => 6,
            'jurusan_id' => 3,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'SHS-11B',
        ]);

        Kelas::create([
            'tingkatan_id' => 6,
            'jurusan_id' => 1,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'SHS-12IPA',
        ]);

        Kelas::create([
            'tingkatan_id' => 6,
            'jurusan_id' => 2,
            'tapel_id' => 1,
            'guru_id' => 1,
            'nama_kelas' => 'SHS-12IPS',
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Guru;
use Illuminate\Database\Seeder;

class GuruTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Guru::create([
            'user_id' => 2,
            'nama_lengkap' => 'Ricky Firmansyah',
            'gelar' => 'S.Kom',
            'nip' => '111111111111111111',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'nuptk' => '1111111111111111',
            'alamat' => 'Alamat',
            'avatar' => 'default.png',
        ]);
    }
}

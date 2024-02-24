<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'user_id' => '1',
            'nama_lengkap' => 'Admin',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1998-05-30',
            'email' => 'admin@mail.com',
            'nomor_hp' => '085232077932',
            'avatar' => 'default.png',
        ]);
    }
}

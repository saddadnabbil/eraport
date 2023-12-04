<?php

use App\Guru;
use App\User;
use App\Admin;
use App\Siswa;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'password' => bcrypt('admin123456'),
            'role' => '1',
            'status' => true,
        ]);

        User::create([
            'username' => 'guru',
            'password' => bcrypt('123456'),
            'role' => '2',
            'status' => true,
        ]);

        User::create([
            'username' => 'siswa',
            'password' => bcrypt('123456'),
            'role' => '3',
            'status' => true,
        ]);
    }
}

<?php

use App\User;
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
        // admins
        User::create([
            'username' => 'admin',
            'password' => bcrypt('admin123456'),
            'role' => '1',
            'status' => true,
        ]);

        // siswas
        User::create([
            'username' => 'siswa',
            'password' => bcrypt('123456'),
            'role' => '3',
            'status' => true,
        ]);

        User::create([
            'username' => 'siswa2',
            'password' => bcrypt('123456'),
            'role' => '3',
            'status' => true,
        ]);

        User::create([
            'username' => 'siswa3',
            'password' => bcrypt('123456'),
            'role' => '3',
            'status' => true,
        ]);

        User::create([
            'username' => 'guru',
            'password' => bcrypt('123456'),
            'role' => '2',
            'status' => true,
        ]);
    }
}

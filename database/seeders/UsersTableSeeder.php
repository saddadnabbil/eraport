<?php

use App\Models\User;
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
        $admin = User::create([
            'username' => 'admin',
            'password' => bcrypt('admin123456'),
            'status' => true,
        ]);
        $admin->assignRole('Admin');

        // siswas
        $siswa = User::create([
            'username' => 'siswa',
            'password' => bcrypt('123456'),
            'status' => true,
        ]);
        $siswa->assignRole('Student');

        User::create([
            'username' => 'siswa2',
            'password' => bcrypt('123456'),
            'status' => true,
        ]);

        User::create([
            'username' => 'siswa3',
            'password' => bcrypt('123456'),
            'status' => true,
        ]);

        $guru = User::create([
            'username' => 'guru',
            'password' => bcrypt('123456'),
            'status' => true,
        ]);
        $guru->assignRole('Teacher');

        $curriculum = User::create([
            'username' => 'curriculum',
            'password' => bcrypt('123456'),
            'status' => true,
        ]);
        $curriculum->assignRole('Curriculum');
    }
}

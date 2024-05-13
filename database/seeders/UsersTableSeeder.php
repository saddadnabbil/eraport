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
        $admin->givePermissionTo('admin-access');

        // siswas
        $siswa = User::create([
            'username' => 'siswa',
            'password' => bcrypt('123456'),
            'status' => true,
        ]);
        $siswa->assignRole('Student');
        $admin->givePermissionTo('student-access');

        User::create([
            'username' => 'siswa2',
            'password' => bcrypt('123456'),
            'status' => true,
        ]);
        $siswa->assignRole('Student');
        $admin->givePermissionTo('student-access');

        User::create([
            'username' => 'siswa3',
            'password' => bcrypt('123456'),
            'status' => true,
        ]);
        $siswa->assignRole('Student');
        $admin->givePermissionTo('student-access');

        $guru = User::create([
            'username' => 'guru',
            'password' => bcrypt('123456'),
            'status' => true,
        ]);
        $guru->assignRole('Teacher');
        $admin->givePermissionTo(['homeroom-pg-kg', 'teacher-pg-kg']);

        $curriculum = User::create([
            'username' => 'curriculum',
            'password' => bcrypt('123456'),
            'status' => true,
        ]);
        $curriculum->assignRole('Curriculum');
        $curriculum->givePermissionTo('masterdata-management');
    }
}

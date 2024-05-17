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
        $admin->givePermissionTo([
            'admin-access',
            'admin-access',
            'user-management',
            'employee-management',
            'masterdata-management',
            'teacher-pg-kg',
            'teacher-km',
            'homeroom-pg-kg',
            'homeroom-km',
            'student-access',
        ]);

        // siswas
        $siswa = User::create([
            'username' => 'siswa',
            'password' => bcrypt('123456'),
            'status' => true,
        ]);
        $siswa->assignRole('Student');
        $siswa->givePermissionTo('student-access');

        $siswa = User::create([
            'username' => 'siswa2',
            'password' => bcrypt('123456'),
            'status' => true,
        ]);
        $siswa->assignRole('Student');
        $siswa->givePermissionTo('student-access');

        $siswa = User::create([
            'username' => 'siswa3',
            'password' => bcrypt('123456'),
            'status' => true,
        ]);
        $siswa->assignRole('Student');
        $siswa->givePermissionTo('student-access');

        $guru = User::create([
            'username' => 'guru',
            'password' => bcrypt('123456'),
            'status' => true,
        ]);
        $guru->assignRole('Teacher');
        $guru->givePermissionTo(['homeroom-pg-kg', 'teacher-pg-kg']);

        $guru = User::create([
            'username' => 'guru1',
            'password' => bcrypt('123456'),
            'status' => true,
        ]);
        $guru->assignRole('Teacher');
        $guru->givePermissionTo(['teacher-km']);

        $curriculum = User::create([
            'username' => 'curriculum',
            'password' => bcrypt('123456'),
            'status' => true,
        ]);
        $curriculum->assignRole('Curriculum');
        $curriculum->givePermissionTo('masterdata-management');
    }
}

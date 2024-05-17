<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo([
            'admin-access'
        ]);

        $guru = Role::create(['name' => 'Teacher']);
        $guru->givePermissionTo([
            'teacher-km', 'homeroom-km', 'homeroom-pg-kg', 'teacher-pg-kg'
        ]);

        $guru = Role::create(['name' => 'Co-Teacher']);
        $guru->givePermissionTo([
            'teacher-km', 'homeroom-km', 'homeroom-pg-kg', 'teacher-pg-kg'
        ]);

        $siswa = Role::create(['name' => 'Student']);
        $siswa->givePermissionTo([
            'student-access'
        ]);

        $curriculum = Role::create(['name' => 'Curriculum']);
        $curriculum->givePermissionTo([
            'masterdata-management'
        ]);
    }
}

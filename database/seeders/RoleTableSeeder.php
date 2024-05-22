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

        // Akademik
        $guru = Role::create(['name' => 'Teacher']);
        $guru->givePermissionTo([
            'teacher-km', 'homeroom-km'
        ]);

        $guru = Role::create(['name' => 'Co-Teacher']);
        $guru->givePermissionTo([
            'teacher-km', 'homeroom-km'
        ]);

        $guru = Role::create(['name' => 'Teacher PG-KG']);
        $guru->givePermissionTo([
            'homeroom-pg-kg', 'teacher-pg-kg'
        ]);

        $guru = Role::create(['name' => 'Co-Teacher PG-KG']);
        $guru->givePermissionTo([
            'homeroom-pg-kg', 'teacher-pg-kg'
        ]);

        $siswa = Role::create(['name' => 'Student']);
        $siswa->givePermissionTo([
            'student-access'
        ]);

        $curriculum = Role::create(['name' => 'Curriculum']);
        $curriculum->givePermissionTo([
            'masterdata-management'
        ]);

        // Non Akademik
        $hrd = Role::create(['name' => 'HRD']);

        $personel = Role::create(['name' => 'Personel']);

        $finance = Role::create(['name' => 'Finance']);

        $librarian = Role::create(['name' => 'Librarian']);

        $admission = Role::create(['name' => 'Admission']);

        $ga = Role::create(['name' => 'General Affair']);

        $it = Role::create(['name' => 'IT']);
    }
}

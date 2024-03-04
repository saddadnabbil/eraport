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
            'admin'
        ]);

        $guru = Role::create(['name' => 'Teacher']);
        $guru->givePermissionTo([
            'guru'
        ]);

        $siswa = Role::create(['name' => 'Student']);
        $siswa->givePermissionTo([
            'siswa'
        ]);

        $curriculum = Role::create(['name' => 'Curriculum']);
        $curriculum->givePermissionTo([
            'curriculum'
        ]);

        $hrd = Role::create(['name' => 'HRD']);
        $hrd->givePermissionTo([
            'hrd'
        ]);

        $finance = Role::create(['name' => 'Finance']);
        $finance->givePermissionTo([
            'finance'
        ]);

        $admission = Role::create(['name' => 'Admission']);
        $admission->givePermissionTo([
            'admission'
        ]);

        $itStaff = Role::create(['name' => 'IT Staff']);
        $itStaff->givePermissionTo([
            'it-staff'
        ]);

        $staff = Role::create(['name' => 'Staff']);
        $staff->givePermissionTo([
            'staff'
        ]);
    }
}

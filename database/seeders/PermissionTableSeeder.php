<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // admin
            'admin-access',
            'user-management',
            'employee-management',

            // kurikulum
            'masterdata-management',

            // guru
            'teacher-pg-kg',
            'teacher-km',

            // wali kelas
            'homeroom-pg-kg',
            'homeroom-km',

            // siswa
            'student-access'
        ];

        // Looping and Inserting Array's Permissions into Permission Table
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}

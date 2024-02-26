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
        $guru = Role::create(['name' => 'Guru']);
        $curriculum = Role::create(['name' => 'Curriculum']);
        $siswa = Role::create(['name' => 'Siswa']);

        $admin->givePermissionTo([
            'admin'
        ]);

        $guru->givePermissionTo([
            'guru'
        ]);

        $curriculum->givePermissionTo([
            'curriculum'
        ]);

        $siswa->givePermissionTo([
            'siswa'
        ]);
    }
}

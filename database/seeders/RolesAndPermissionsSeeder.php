<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat roles
        $roles = [
            'superadmin',
            'admin',
            'member',
            'employee',
        ];

        foreach ($roles as $roleName) {
            Role::create(['name' => $roleName]);
        }
    }
}

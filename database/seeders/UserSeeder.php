<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'superadmin',
            'admin',
            'member',
            'employee',
        ];

        foreach ($roles as $roleName) {
            // Buat user untuk setiap role
            $user = User::factory()->create([
                'name' => ucfirst($roleName) . ' User',
                'email' => strtolower($roleName) . '@example.com',
            ]);

            // Assign role ke user
            $user->assignRole($roleName);
        }
    }
}

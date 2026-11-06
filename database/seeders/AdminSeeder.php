<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => env('ADMIN_NAME', 'Administrator Sistem'),
                'username' => env('ADMIN_USERNAME', 'admin'),
                'email' => env('ADMIN_EMAIL', 'admin@uim.ac.id'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'admin123')),
                'role' => 'Admin',
                'grup' => 'Administrator',
                'status' => true,
            ],
            [
                'name' => 'Super Administrator',
                'username' => 'superadmin',
                'email' => 'superadmin@uim.ac.id',
                'password' => Hash::make(env('SUPERADMIN_PASSWORD', 'superadmin123')),
                'role' => 'Admin',
                'grup' => 'Administrator',
                'status' => true,
            ],
        ];

        foreach ($admins as $adminData) {
            User::updateOrCreate(
                ['username' => $adminData['username']],
                $adminData
            );
        }
    }
}


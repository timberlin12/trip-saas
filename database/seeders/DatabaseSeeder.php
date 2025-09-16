<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
        ]);

        $superadmin = User::updateOrCreate(
            ['email' => 'superadmin@test.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('superadmin@123'),
                'email_verified_at' => Carbon::now(),
            ]
        );
        $superadmin->assignRole('superadmin');

        $admin = User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Company',
                'password' => Hash::make('admin@123'),
                'email_verified_at' => Carbon::now(),
            ]
        );
        $admin->assignRole('company');

        $user = User::updateOrCreate(
            ['email' => 'user@test.com'],
            [
                'name' => 'User',
                'password' => Hash::make('user@123'),
                'email_verified_at' => Carbon::now(),
            ]
        );
        $user->assignRole('user');
    }
}

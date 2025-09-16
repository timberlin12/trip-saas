<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Define roles you want
        $roles = ['superadmin', 'company', 'user'];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role], // search by role name
                ['name' => $role]  // if not found, create it
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Permission list
        $permissions = [
            'view-dashboard',
            'create-user',
            'edit-user',
            'delete-user',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Create superadmin role
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin']);

        // Attach all permissions to superadmin role
        $allPermissions = Permission::all();
        $superAdminRole->permissions()->sync($allPermissions->pluck('id'));

        // Create superadmin user
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'), // change to secure password
            ]
        );

        // Attach role to user
        $superAdmin->roles()->sync([$superAdminRole->id]);
    }
}

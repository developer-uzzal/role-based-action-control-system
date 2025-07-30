<?php

namespace Database\Seeders;

use App\Models\Role;
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
         $admin = User::where('email', 'superadmin@gmail.com')->first();

        $adminRole = Role::where('name', 'admin')->first();
        $admin->roles()->attach($adminRole->id);
    }
}

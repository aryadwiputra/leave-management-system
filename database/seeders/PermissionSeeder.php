<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // dashboard
        Permission::create(['name' => 'dashboard-access']);

        // User Management
        Permission::create(['name' => 'user-access']);
        Permission::create(['name' => 'user-store']);
        Permission::create(['name' => 'user-update']);
        Permission::create(['name' => 'user-destroy']);

        // User Profile
        Permission::create(['name' => 'profile-access']);

        // Role Management
        Permission::create(['name' => 'role-access']);
        Permission::create(['name' => 'role-store']);
        Permission::create(['name' => 'role-update']);
        Permission::create(['name' => 'role-destroy']);

        // Permission Management
        Permission::create(['name' => 'permission-access']);
        Permission::create(['name' => 'permission-store']);
        Permission::create(['name' => 'permission-update']);
        Permission::create(['name' => 'permission-destroy']);
    }
}

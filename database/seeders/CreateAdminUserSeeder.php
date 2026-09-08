<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Alexander Reed',
                'designation' => 'Lead Superintendent & Executive Admin',
                'password' => bcrypt('password'),
                'phone_no' => '+8801700000000',
                'address' => 'Dhaka Financial District, Bangladesh',
                'description' => 'Super Administrator with full operations and site governance permissions.',
                'email_verified_at' => now(),
            ]
        );

        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web'], ['description' => 'Full administrative access to all system features and user management.']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web'], ['description' => 'Operations administrator with project management and editorial rights.']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web'], ['description' => 'General team member or site viewer.']);

        $superadminUser->assignRole('superadmin');

        // Superadmin has access to every permission
        $allPermissions = Permission::pluck('name')->all();
        $superAdminRole->syncPermissions($allPermissions);

        // Admin has access to operational modules
        $adminPermissions = Permission::whereNotIn('name', [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'assignrole-list',
            'assignrole-create',
            'user-delete',
        ])->pluck('name')->all();
        $adminRole->syncPermissions($adminPermissions);
    }
}

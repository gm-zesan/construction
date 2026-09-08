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
        // 1. Define Standard Roles
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'superadmin', 'guard_name' => 'web'],
            ['description' => 'Full administrative access to all system features and user management.']
        );

        $adminRole = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'web'],
            ['description' => 'Operations administrator with project management and editorial rights.']
        );

        $managerRole = Role::firstOrCreate(
            ['name' => 'project-manager', 'guard_name' => 'web'],
            ['description' => 'Project manager overseeing worksite progress, services, and inquiries.']
        );

        $userRole = Role::firstOrCreate(
            ['name' => 'user', 'guard_name' => 'web'],
            ['description' => 'General team member or client viewer.']
        );

        // 2. Assign Permissions to Roles
        $allPermissions = Permission::pluck('name')->all();
        $superAdminRole->syncPermissions($allPermissions);

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

        $managerPermissions = Permission::whereIn('module', [
            'project',
            'service',
            'milestone',
            'contact',
            'blog',
            'client-review',
        ])->pluck('name')->all();
        $managerRole->syncPermissions($managerPermissions);

        $userPermissions = Permission::whereIn('name', [
            'project-list',
            'service-list',
            'blog-list',
        ])->pluck('name')->all();
        $userRole->syncPermissions($userPermissions);

        // 3. Seed Users and Assign Roles
        // Super Administrator
        $superadminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Alexander Reed',
                'designation' => 'Lead Superintendent & Executive Admin',
                'password' => bcrypt('password'),
                'phone_no' => '01700000000',
                'address' => 'House 40/A, Road 20, Mohakhali DOHS, Dhaka',
                'description' => 'Super Administrator with full operations and site governance permissions.',
                'email_verified_at' => now(),
            ]
        );
        $superadminUser->syncRoles(['superadmin']);

        // Operations Admin
        $adminUser = User::firstOrCreate(
            ['email' => 'sarah@gmail.com'],
            [
                'name' => 'Sarah Jenkins',
                'designation' => 'Senior Operations & Projects Manager',
                'password' => bcrypt('password'),
                'phone_no' => '01700000001',
                'address' => 'House 12, Road 4, Banani, Dhaka',
                'description' => 'Operations manager in charge of site workflows and service allocations.',
                'email_verified_at' => now(),
            ]
        );
        $adminUser->syncRoles(['admin']);

        // Project Manager / Lead Engineer
        $managerUser = User::firstOrCreate(
            ['email' => 'marcus@gmail.com'],
            [
                'name' => 'Marcus Vance',
                'designation' => 'Lead Structural Site Engineer',
                'password' => bcrypt('password'),
                'phone_no' => '01700000002',
                'address' => 'House 28, Road 11, Uttara, Dhaka',
                'description' => 'Site engineer handling construction project planning, technical oversight, and client inquiries.',
                'email_verified_at' => now(),
            ]
        );
        $managerUser->syncRoles(['project-manager']);

        // Standard Client / Observer User
        $clientUser = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'David Chen',
                'designation' => 'Client Representative & Field Observer',
                'password' => bcrypt('password'),
                'phone_no' => '01700000003',
                'address' => 'Plot 5, Gulshan 2, Dhaka',
                'description' => 'Client stakeholder accessing site progress logs and portfolio reports.',
                'email_verified_at' => now(),
            ]
        );
        $clientUser->syncRoles(['user']);
    }
}

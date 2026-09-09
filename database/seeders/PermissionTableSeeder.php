<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // 1. Role Management
            ['name' => 'role-list', 'display_name' => 'Role list', 'module' => 'role'],
            ['name' => 'role-create', 'display_name' => 'Role create', 'module' => 'role'],
            ['name' => 'role-edit', 'display_name' => 'Role edit', 'module' => 'role'],
            ['name' => 'role-delete', 'display_name' => 'Role delete', 'module' => 'role'],

            // 2. Assign Role
            ['name' => 'assignrole-list', 'display_name' => 'Assign role list', 'module' => 'assign-role'],
            ['name' => 'assignrole-create', 'display_name' => 'Assign role save', 'module' => 'assign-role'],

            // 3. User Management
            ['name' => 'user-list', 'display_name' => 'User list', 'module' => 'user'],
            ['name' => 'user-create', 'display_name' => 'User create', 'module' => 'user'],
            ['name' => 'user-edit', 'display_name' => 'User edit', 'module' => 'user'],
            ['name' => 'user-delete', 'display_name' => 'User delete', 'module' => 'user'],

            // 4. Project Portfolio
            ['name' => 'project-list', 'display_name' => 'Project list', 'module' => 'project'],
            ['name' => 'project-create', 'display_name' => 'Project create', 'module' => 'project'],
            ['name' => 'project-edit', 'display_name' => 'Project edit', 'module' => 'project'],
            ['name' => 'project-delete', 'display_name' => 'Project delete', 'module' => 'project'],

            // 5. Project Milestones
            ['name' => 'milestone-list', 'display_name' => 'Milestone list', 'module' => 'milestone'],
            ['name' => 'milestone-create', 'display_name' => 'Milestone create', 'module' => 'milestone'],
            ['name' => 'milestone-edit', 'display_name' => 'Milestone edit', 'module' => 'milestone'],
            ['name' => 'milestone-delete', 'display_name' => 'Milestone delete', 'module' => 'milestone'],

            // 6. Core Services
            ['name' => 'service-list', 'display_name' => 'Service list', 'module' => 'service'],
            ['name' => 'service-create', 'display_name' => 'Service create', 'module' => 'service'],
            ['name' => 'service-edit', 'display_name' => 'Service edit', 'module' => 'service'],
            ['name' => 'service-delete', 'display_name' => 'Service delete', 'module' => 'service'],

            // 7. News & Articles
            ['name' => 'article-list', 'display_name' => 'Article list', 'module' => 'blog'],
            ['name' => 'article-create', 'display_name' => 'Article create', 'module' => 'blog'],
            ['name' => 'article-edit', 'display_name' => 'Article edit', 'module' => 'blog'],
            ['name' => 'article-delete', 'display_name' => 'Article delete', 'module' => 'blog'],

            // 8. Article Categories
            ['name' => 'article-category-list', 'display_name' => 'Article Category list', 'module' => 'blog'],
            ['name' => 'article-category-create', 'display_name' => 'Article Category create', 'module' => 'blog'],
            ['name' => 'article-category-edit', 'display_name' => 'Article Category edit', 'module' => 'blog'],
            ['name' => 'article-category-delete', 'display_name' => 'Article Category delete', 'module' => 'blog'],

            // 9. Client Inquiries & Contact Messages
            ['name' => 'contact-list', 'display_name' => 'Inquiry list', 'module' => 'contact'],
            ['name' => 'contact-delete', 'display_name' => 'Inquiry delete', 'module' => 'contact'],

            // 10. Client Reviews & Testimonials
            ['name' => 'client-review-list', 'display_name' => 'Review list', 'module' => 'client-review'],
            ['name' => 'client-review-create', 'display_name' => 'Review create', 'module' => 'client-review'],
            ['name' => 'client-review-edit', 'display_name' => 'Review edit', 'module' => 'client-review'],
            ['name' => 'client-review-delete', 'display_name' => 'Review delete', 'module' => 'client-review'],

            // 11. Executive & Project Team Members
            ['name' => 'team-member-list', 'display_name' => 'Team Member list', 'module' => 'team-member'],
            ['name' => 'team-member-create', 'display_name' => 'Team Member create', 'module' => 'team-member'],
            ['name' => 'team-member-edit', 'display_name' => 'Team Member edit', 'module' => 'team-member'],
            ['name' => 'team-member-delete', 'display_name' => 'Team Member delete', 'module' => 'team-member'],

            // 11. Media Library
            ['name' => 'media-list', 'display_name' => 'Media list', 'module' => 'media'],
            ['name' => 'media-create', 'display_name' => 'Media upload', 'module' => 'media'],
            ['name' => 'media-edit', 'display_name' => 'Media edit', 'module' => 'media'],
            ['name' => 'media-delete', 'display_name' => 'Media delete', 'module' => 'media'],

            // 12. Activity Logs
            ['name' => 'activity-list', 'display_name' => 'Activity logs', 'module' => 'activity-log'],

            // 13. Global Website Settings
            ['name' => 'website-setting-list', 'display_name' => 'Website Settings list', 'module' => 'website-setting'],
            ['name' => 'website-setting-edit', 'display_name' => 'Website Settings edit', 'module' => 'website-setting'],
            ['name' => 'website-setting-create', 'display_name' => 'Website Settings field create', 'module' => 'website-setting'],
            ['name' => 'website-setting-delete', 'display_name' => 'Website Settings field delete', 'module' => 'website-setting'],

            // 14. Website Content Management (CMS)
            ['name' => 'website-content-list', 'display_name' => 'Website Content list', 'module' => 'website-content'],
            ['name' => 'website-content-create', 'display_name' => 'Website Content field create', 'module' => 'website-content'],
            ['name' => 'website-content-edit', 'display_name' => 'Website Content edit', 'module' => 'website-content'],
            ['name' => 'website-content-delete', 'display_name' => 'Website Content field delete', 'module' => 'website-content'],

            // 15. Theme & Brand Settings
            ['name' => 'theme-list', 'display_name' => 'Theme list', 'module' => 'theme'],
            ['name' => 'theme-create', 'display_name' => 'Theme create', 'module' => 'theme'],
            ['name' => 'theme-edit', 'display_name' => 'Theme edit', 'module' => 'theme'],
            ['name' => 'theme-delete', 'display_name' => 'Theme delete', 'module' => 'theme'],
            ['name' => 'theme-active', 'display_name' => 'Theme activate', 'module' => 'theme'],
        ];

        // Create or update all active module permissions
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                [
                    'display_name' => $permission['display_name'],
                    'module' => $permission['module'],
                    'guard_name' => 'web',
                ]
            );
        }
    }
}

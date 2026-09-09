<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->first();
        $adminId = $admin ? $admin->id : null;

        $services = [
            [
                'title' => 'Design & Planning',
                'slug' => 'design-and-planning',
                'icon' => 'ri-compasses-2-line',
                'short_description' => 'Project planning, architectural drafting, structural calculations, and technical site preparation.',
                'description' => '<p>Our multidisciplinary design studio bridges conceptual vision and technical constructability. We execute detailed architectural drafting, MEP coordination, structural calculations, and regulatory permitting.</p>',
                'sort_order' => 1,
                'featured' => true,
                'is_published' => true,
                'meta_title' => 'Design & Planning | Antigravity Construction',
                'meta_description' => 'Comprehensive architectural design, structural calculations, and project planning.',
                'created_by' => $adminId,
            ],
            [
                'title' => 'General Construction',
                'slug' => 'general-construction',
                'icon' => 'ri-building-4-line',
                'short_description' => 'Direct site execution, reinforced concrete framing, steel erection, and superintendent management.',
                'description' => '<p>We deliver comprehensive general contracting for large-scale commercial and civil structures with full-time site supervision and rigorous QA/QC protocols.</p>',
                'sort_order' => 2,
                'featured' => true,
                'is_published' => true,
                'meta_title' => 'General Construction & Contracting',
                'meta_description' => 'Direct site execution, reinforced concrete framing, and superintendent management.',
                'created_by' => $adminId,
            ],
            [
                'title' => 'Project Management',
                'slug' => 'project-management',
                'icon' => 'ri-tools-line',
                'short_description' => 'Critical-path milestone scheduling, trade coordination, and site safety compliance.',
                'description' => '<p>Full-cycle construction project management delivering on-time milestones, cost-effective resource allocation, and zero-compromise safety oversight.</p>',
                'sort_order' => 3,
                'featured' => true,
                'is_published' => true,
                'meta_title' => 'Construction Project Management',
                'meta_description' => 'Critical-path milestone scheduling, trade coordination, and site safety compliance.',
                'created_by' => $adminId,
            ],
            [
                'title' => 'Renovation',
                'slug' => 'renovation',
                'icon' => 'ri-paint-brush-line',
                'short_description' => 'Interior and structural renovation work, commercial fit-outs, and architectural adaptive reuse.',
                'description' => '<p>High-end commercial renovation, structural retrofits, spatial remodeling, and interior fit-outs executed with minimal disruption to operations.</p>',
                'sort_order' => 4,
                'featured' => true,
                'is_published' => true,
                'meta_title' => 'Commercial Renovation & Fit-Out',
                'meta_description' => 'Interior and structural renovation work, commercial fit-outs, and architectural adaptive reuse.',
                'created_by' => $adminId,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::updateOrCreate(
                ['slug' => $serviceData['slug']],
                $serviceData
            );
        }
    }
}

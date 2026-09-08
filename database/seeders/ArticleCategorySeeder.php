<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->first();
        $adminId = $admin ? $admin->id : null;

        $categories = [
            [
                'name' => 'Site Progress',
                'slug' => 'site-progress',
                'description' => 'Real-time structural topping out, ground stabilization, and high-rise envelope field updates.',
                'created_by' => $adminId,
            ],
            [
                'name' => 'Engineering & Tech',
                'slug' => 'engineering-and-tech',
                'description' => 'BIM 5D coordination, post-tensioned slab mechanics, and seismic isolator engineering insights.',
                'created_by' => $adminId,
            ],
            [
                'name' => 'Sustainable Build',
                'slug' => 'sustainable-build',
                'description' => 'LEED Platinum benchmarking, solar thermal integration, and low-carbon embodied concrete.',
                'created_by' => $adminId,
            ],
            [
                'name' => 'Safety & Protocols',
                'slug' => 'safety-and-protocols',
                'description' => 'Zero-incident site protocols, crane anti-collision telemetry, and deep excavation monitoring.',
                'created_by' => $adminId,
            ],
            [
                'name' => 'Company & Awards',
                'slug' => 'company-and-awards',
                'description' => 'Corporate milestone celebrations, civic construction awards, and client partnerships.',
                'created_by' => $adminId,
            ],
        ];

        foreach ($categories as $data) {
            ArticleCategory::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}

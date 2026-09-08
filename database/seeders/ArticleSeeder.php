<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->first();
        $adminId = $admin ? $admin->id : null;

        $catProgress = ArticleCategory::where('slug', 'site-progress')->first();
        $catTech = ArticleCategory::where('slug', 'engineering-and-tech')->first();
        $catGreen = ArticleCategory::where('slug', 'sustainable-build')->first();
        $catSafety = ArticleCategory::where('slug', 'safety-and-protocols')->first();

        $defaultCatId = $catProgress?->id ?? ArticleCategory::first()?->id;

        $articles = [
            [
                'category_id' => $catProgress?->id ?? $defaultCatId,
                'title' => 'Site Progress Update: Vertex Commercial Tower Superstructure Enclosure',
                'slug' => 'site-progress-update-vertex-commercial-tower-superstructure-enclosure',
                'author_name' => 'Engr. Mahbubur Rahman, Lead PM',
                'summary' => 'Core shear wall concrete pours reach level 28 topping out with perimeter unitized curtain wall installation actively progressing across the lower twenty tiers.',
                'content' => '<p>The structural core of the <strong>Vertex Corporate Tower</strong> has officially topped out at level 28 rooftop level. The continuous post-tensioned floor slabs were cast using self-consolidating high-performance concrete with 28-day cylinder compressive strengths exceeding 65 MPa.</p><h3>Envelope &amp; Glazing Operations</h3><p>Concurrently, the tower envelope crew has hoisted and secured over 800 double-glazed unitized glass panels utilizing precision mono-rail perimeter hoists. Thermal breaks and Low-E solar coatings are undergoing pressurized air and water infiltration field chamber tests to verify zero leakage under extreme typhoon wind loads.</p><p>Mechanical, electrical, and plumbing (MEP) vertical risers and central HVAC chillers in the level 3 basement are currently undergoing pre-commissioning pressure tests ahead of full tenant fit-out mobilization.</p>',
                'published_at' => now()->subDays(12),
                'read_time' => 4,
                'featured' => true,
                'is_published' => true,
                'sort_order' => 1,
                'views_count' => 1240,
                'meta_title' => 'Vertex Corporate Tower Construction Field Update',
                'meta_description' => 'Real-time structural topping out and unitized facade engineering progress on the 28-story Vertex Tower.',
                'meta_keywords' => 'superstructure topping out, unitized curtain wall, concrete pour, civil engineering',
                'created_by' => $adminId,
            ],
            [
                'category_id' => $catTech?->id ?? $defaultCatId,
                'title' => 'Deploying 5D BIM & Drone Photogrammetry on Large-Span Industrial Hubs',
                'slug' => 'deploying-5d-bim-and-drone-photogrammetry-on-large-span-industrial-hubs',
                'author_name' => 'Tariq Hasan, BIM Systems Director',
                'summary' => 'How real-time RTK drone topographic point clouds integrated into Revit 5D models eliminate on-site clash detections and optimize laser-screed floor levelness.',
                'content' => '<p>Modern logistics and automated fulfillment centers require unprecedented floor flatness tolerances (FF/FL numbers exceeding 65/50). On our 350,000 sq.ft <strong>Highland Logistics Hub</strong>, the integration of autonomous RTK drone survey flights and 5D BIM clash detection workflows has dramatically accelerated execution timelines.</p><h3>Real-Time Volumetric Calculation</h3><p>Weekly aerial photogrammetry scans generate dense 3D point cloud meshes that are overlaid directly with structural IFC design models. This enables millimeter-accurate earthwork cut/fill balancing and verifies pre-engineered steel column anchor bolt alignments prior to portal frame delivery.</p>',
                'published_at' => now()->subDays(20),
                'read_time' => 5,
                'featured' => true,
                'is_published' => true,
                'sort_order' => 2,
                'views_count' => 890,
                'meta_title' => '5D BIM & Drone Photogrammetry in Modern Construction',
                'meta_description' => 'Engineering case study on leveraging aerial lidar, point clouds, and 5D BIM for heavy industrial warehousing.',
                'meta_keywords' => '5D BIM, drone photogrammetry, clash detection, laser screed flooring',
                'created_by' => $adminId,
            ],
            [
                'category_id' => $catGreen?->id ?? $defaultCatId,
                'title' => 'Low-Carbon Geopolymer Concrete & LEED Platinum Benchmarks in Urban Civil Projects',
                'slug' => 'low-carbon-geopolymer-concrete-and-leed-platinum-benchmarks',
                'author_name' => 'Dr. Farhana Yasmin, Sustainability Lead',
                'summary' => 'Benchmarking fly-ash and slag-activated geopolymer mixes that reduce embodied carbon by 42% while enhancing chemical resistance against saline groundwater.',
                'content' => '<p>Decarbonizing heavy civil infrastructure requires moving beyond conventional Portland cement. On our waterfront projects along Hatirjheel and Chattogram coastline, our engineering materials laboratory has successfully specified and poured blast-furnace slag blended geopolymer concrete.</p><h3>Durability &amp; Environmental Impact</h3><p>In addition to curtailing lifecycle carbon emissions by over 40%, the geopolymer binder matrix exhibits superior resistance against chloride ion migration and sulfate attack in high-water-table conditions.</p>',
                'published_at' => now()->subDays(28),
                'read_time' => 3,
                'featured' => true,
                'is_published' => true,
                'sort_order' => 3,
                'views_count' => 1560,
                'meta_title' => 'Low Carbon Geopolymer Concrete Innovation',
                'meta_description' => 'Sustainable materials research and LEED Platinum civil engineering case studies.',
                'meta_keywords' => 'geopolymer concrete, embodied carbon, LEED Platinum, green building',
                'created_by' => $adminId,
            ],
            [
                'category_id' => $catSafety?->id ?? $defaultCatId,
                'title' => 'Deep Foundation Excavation Safety Protocols & Diaphragm Wall Telemetry',
                'slug' => 'deep-foundation-excavation-safety-protocols-and-diaphragm-wall-telemetry',
                'author_name' => 'Kazi Arman, HSE Lead Auditor',
                'summary' => 'Continuous inclinometer monitoring and digital strut load-cell telemetry maintaining 100% geotechnical integrity throughout 3-level basement excavations.',
                'content' => '<p>Deep basement excavations adjacent to high-density arterial roads demand rigorous geotechnical safety governance. Our multi-point wireless sensor networks continuously transmit real-time lateral displacement, pore water pressure, and strut load telemetry to the site engineering command center.</p>',
                'published_at' => now()->subDays(35),
                'read_time' => 4,
                'featured' => false,
                'is_published' => true,
                'sort_order' => 4,
                'views_count' => 640,
                'meta_title' => 'Deep Excavation Safety Telemetry & Monitoring',
                'meta_description' => 'Geotechnical instrumentation and zero-incident HSE protocols in deep urban excavation.',
                'meta_keywords' => 'excavation safety, inclinometer telemetry, diaphragm wall, HSE',
                'created_by' => $adminId,
            ],
        ];

        $imageMap = [
            'site-progress-update-vertex-commercial-tower-superstructure-enclosure' => public_path('images/blog-1.jpg'),
            'deploying-5d-bim-and-drone-photogrammetry-on-large-span-industrial-hubs' => public_path('images/blog-2.jpg'),
            'low-carbon-geopolymer-concrete-and-leed-platinum-benchmarks' => public_path('images/blog-3.jpg'),
            'deep-foundation-excavation-safety-protocols-and-diaphragm-wall-telemetry' => public_path('images/project-commercial-tower.jpg'),
        ];

        foreach ($articles as $data) {
            $article = Article::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );

            if (isset($imageMap[$article->slug])) {
                $imgPath = $imageMap[$article->slug];
                if (file_exists($imgPath) && $article->getMedia('image')->isEmpty()) {
                    $article->copyMedia($imgPath)->toMediaCollection('image');
                }
            }
        }
    }
}

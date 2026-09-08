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
                'title' => 'Commercial Construction & Contracting',
                'slug' => 'commercial-construction-contracting',
                'icon' => 'ri-building-4-line',
                'short_description' => 'Turnkey commercial construction solutions for corporate headquarters, high-rise office towers, and mixed-use developments.',
                'description' => '<p>We deliver comprehensive general contracting and design-build services for large-scale commercial structures. Our multidisciplinary engineering teams coordinate structural framing, MEP installations, architectural glass facades, and LEED-certified sustainable building methods to ensure projects are delivered on-schedule and within rigorous quality standards.</p>',
                'sort_order' => 1,
                'featured' => true,
                'is_published' => true,
                'meta_title' => 'Commercial Construction Services | Antigravity Construction',
                'meta_description' => 'Specialized commercial general contracting and engineering services for corporate towers, retail parks, and institutional facilities.',
                'created_by' => $adminId,
            ],
            [
                'title' => 'Structural Steel & Heavy Framing',
                'slug' => 'structural-steel-heavy-framing',
                'icon' => 'ri-tools-line',
                'short_description' => 'Precision fabrication, high-tolerance crane erection, and structural reinforcement for industrial facilities and long-span trusses.',
                'description' => '<p>Our structural engineering division handles heavy industrial steel fabrication, seismic retrofitting, and high-rise core framing. Utilizing automated CNC cutting and robotic weld verification, we fabricate members capable of sustaining extreme mechanical loads and environmental stresses.</p>',
                'sort_order' => 2,
                'featured' => true,
                'is_published' => true,
                'meta_title' => 'Structural Steel & Heavy Framing | Construction Specialists',
                'meta_description' => 'Precision fabrication, erection, and engineering of structural steel frames for industrial and commercial projects.',
                'created_by' => $adminId,
            ],
            [
                'title' => 'Civil Infrastructure & Roadwork',
                'slug' => 'civil-infrastructure-roadwork',
                'icon' => 'ri-road-map-line',
                'short_description' => 'Public works, asphalt highway paving, bridge overpasses, utility conduits, and stormwater retention civil engineering.',
                'description' => '<p>From major arterial roadway expansions to reinforced concrete flyovers and heavy stormwater drainage canals, we execute public and private civil infrastructure projects that support sustainable community growth and high vehicular throughput.</p>',
                'sort_order' => 3,
                'featured' => true,
                'is_published' => true,
                'meta_title' => 'Civil Infrastructure & Highway Engineering',
                'meta_description' => 'Comprehensive civil works, bridge construction, heavy earthmoving, and urban infrastructure developments.',
                'created_by' => $adminId,
            ],
            [
                'title' => 'Architectural Design & Space Planning',
                'slug' => 'architectural-design-space-planning',
                'icon' => 'ri-compasses-2-line',
                'short_description' => 'Integrated architectural schematics, photorealistic 3D visualization, space optimization, and regulatory permitting.',
                'description' => '<p>Our design studio bridges conceptual vision and technical constructability. Working closely with clients and municipal building authorities, we craft distinctive architectural expressions that maximize daylight, spatial efficiency, and programmatic flow.</p>',
                'sort_order' => 4,
                'featured' => false,
                'is_published' => true,
                'meta_title' => 'Architectural Design & Space Planning',
                'meta_description' => 'Innovative architectural masterplanning, 3D visualizations, and constructability consulting.',
                'created_by' => $adminId,
            ],
            [
                'title' => 'Interior Fit-Out & Commercial Renovation',
                'slug' => 'interior-fit-out-commercial-renovation',
                'icon' => 'ri-paint-brush-line',
                'short_description' => 'High-end interior fit-outs, acoustic ceiling treatments, HVAC duct routing, and bespoke millwork for corporate offices.',
                'description' => '<p>We transform bare shells into inspiring work environments. Our interior teams orchestrate electrical, mechanical, glass partitions, fire suppression, and acoustic assemblies with minimum disruption to adjacent operational facilities.</p>',
                'sort_order' => 5,
                'featured' => false,
                'is_published' => true,
                'meta_title' => 'Interior Fit-Out & Commercial Renovation',
                'meta_description' => 'Turnkey corporate interior fit-out, MEP consolidation, and modern office transformations.',
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

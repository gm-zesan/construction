<?php

namespace Database\Seeders;

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->first();
        $adminId = $admin ? $admin->id : null;

        $projects = [
            [
                'title' => 'Vertex Corporate Tower',
                'slug' => 'vertex-corporate-tower',
                'category' => 'Commercial',
                'client_name' => 'Apex Holdings Ltd.',
                'location' => 'Gulshan Avenue, Dhaka',
                'start_date' => '2023-01-15',
                'completion_date' => '2025-06-30',
                'status' => ProjectStatus::COMPLETED,
                'short_description' => 'A landmark 28-story Grade-A corporate tower featuring double-glazed curtain wall systems, seismic damping, and LEED Platinum specifications.',
                'description' => '<p>The Vertex Corporate Tower stands as an iconic architectural benchmark on the skyline. Spanning over 420,000 square feet of prime commercial workspace, the structure combines post-tensioned reinforced concrete slabs with a central shear core engineered to withstand severe seismic and cyclonic lateral forces.</p><p>Key highlights include a quadruple-height atrium lobby, eight high-speed destination-dispatch elevators, intelligent building management automation, and a rooftop solar array that offsets 18% of base building electrical loads.</p>',
                'featured' => true,
                'is_published' => true,
                'sort_order' => 1,
                'meta_title' => 'Vertex Corporate Tower | Commercial Landmark Project',
                'meta_description' => 'Detailed case study and specifications of the 28-story Vertex Corporate Tower built by Antigravity Construction.',
                'created_by' => $adminId,
            ],
            [
                'title' => 'Highland Logistics & Industrial Distribution Hub',
                'slug' => 'highland-logistics-industrial-distribution-hub',
                'category' => 'Industrial',
                'client_name' => 'TransGlobal Freight Corp.',
                'location' => 'Gazipur Industrial Zone, Dhaka',
                'start_date' => '2024-03-01',
                'completion_date' => null,
                'status' => ProjectStatus::ONGOING,
                'short_description' => 'State-of-the-art 350,000 sq.ft automated fulfillment facility with heavy load-bearing laser-screed flooring and 40 cross-dock bay doors.',
                'description' => '<p>Commissioned to support regional supply chain modernization, the Highland Logistics Center features a clear interior height of 14 meters, clear-span steel portals, and superflat laser-screeded concrete slabs designed for high-density automated racking systems.</p><p>Currently in the structural assembly phase, the project includes specialized refrigerated cold-storage chambers, advanced ESFR fire sprinkler loops, and extensive heavy truck marshalling aprons.</p>',
                'featured' => true,
                'is_published' => true,
                'sort_order' => 2,
                'meta_title' => 'Highland Logistics Hub | Industrial Construction Case Study',
                'meta_description' => 'Modern automated warehouse and logistics center construction with heavy-duty laser-screed concrete flooring.',
                'created_by' => $adminId,
            ],
            [
                'title' => 'Riverside Civic Cultural Center & Amphitheater',
                'slug' => 'riverside-civic-cultural-center-amphitheater',
                'category' => 'Institutional',
                'client_name' => 'Municipal Development Board',
                'location' => 'Hatirjheel Waterfront, Dhaka',
                'start_date' => '2025-10-01',
                'completion_date' => null,
                'status' => ProjectStatus::UPCOMING,
                'short_description' => 'A sculptural open-air civic pavilion and 1,800-seat amphitheater crafted from board-formed exposed architectural concrete.',
                'description' => '<p>The Riverside Civic Cultural Center integrates waterfront recreational plazas with an acoustic amphitheater shell and exhibition galleries. Designed as a public cultural nexus, the facility utilizes board-formed white architectural concrete juxtaposed with native stone terraces.</p><p>Groundwork and deep driven piling works are scheduled to mobilize in Q3, ensuring strict protection of waterfront biodiversity and zero river runoff during execution.</p>',
                'featured' => false,
                'is_published' => true,
                'sort_order' => 3,
                'meta_title' => 'Riverside Civic Cultural Center | Public Infrastructure',
                'meta_description' => 'Iconic cultural venue and open-air waterfront amphitheater project in Hatirjheel.',
                'created_by' => $adminId,
            ],
            [
                'title' => 'Bayfront Luxury Residences & Marina',
                'slug' => 'bayfront-luxury-residences-marina',
                'category' => 'Residential',
                'client_name' => 'Prime Living Realty Consortium',
                'location' => 'Marine Drive, Chattogram',
                'start_date' => '2024-06-15',
                'completion_date' => null,
                'status' => ProjectStatus::ONGOING,
                'short_description' => 'Dual 18-story seaside luxury residential towers with marine-grade cathodic concrete protection and private yacht dockage.',
                'description' => '<p>Overlooking the Bay of Bengal, the Bayfront Residences deliver 72 ultra-luxury residences featuring expansive cantilevered balconies. Due to severe coastal salinity exposure, the structure incorporates marine-grade silica fume blended concrete, epoxy-coated rebar, and sacrificial zinc anodes across foundation piles.</p>',
                'featured' => true,
                'is_published' => true,
                'sort_order' => 4,
                'meta_title' => 'Bayfront Luxury Residences | Coastal Marine Construction',
                'meta_description' => 'Luxury coastal residential high-rise construction with advanced marine corrosion prevention engineering.',
                'created_by' => $adminId,
            ],
        ];

        $imageMap = [
            'vertex-corporate-tower' => [
                'main' => public_path('images/project-commercial-tower.jpg'),
                'gallery' => [public_path('images/hero-project-main.jpg'), public_path('images/about-main.jpg')],
            ],
            'highland-logistics-industrial-distribution-hub' => [
                'main' => public_path('images/project-industrial-hub.jpg'),
                'gallery' => [public_path('images/why-choose-crane.jpg'), public_path('images/experience-team.jpg')],
            ],
            'riverside-civic-cultural-center-amphitheater' => [
                'main' => public_path('images/project-civic-center.jpg'),
                'gallery' => [public_path('images/hero-project-detail.jpg')],
            ],
            'bayfront-luxury-residences-marina' => [
                'main' => public_path('images/project-transit-terminal.jpg'),
                'gallery' => [public_path('images/why-choose-engineers.jpg')],
            ],
        ];

        foreach ($projects as $projectData) {
            $project = Project::updateOrCreate(
                ['slug' => $projectData['slug']],
                $projectData
            );

            $slug = $project->slug;
            if (isset($imageMap[$slug])) {
                $mainPath = $imageMap[$slug]['main'];
                if (file_exists($mainPath) && $project->getMedia('main_image')->isEmpty()) {
                    $project->copyMedia($mainPath)->toMediaCollection('main_image');
                }

                if (isset($imageMap[$slug]['gallery']) && $project->getMedia('gallery')->isEmpty()) {
                    foreach ($imageMap[$slug]['gallery'] as $galleryPath) {
                        if (file_exists($galleryPath)) {
                            $project->copyMedia($galleryPath)->toMediaCollection('gallery');
                        }
                    }
                }
            }
        }
    }
}

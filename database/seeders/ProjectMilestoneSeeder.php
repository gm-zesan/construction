<?php

namespace Database\Seeders;

use App\Enums\MilestoneStatus;
use App\Models\Project;
use App\Models\ProjectMilestone;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectMilestoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->first();
        $adminId = $admin ? $admin->id : null;

        $vertexProject = Project::where('slug', 'vertex-corporate-tower')->first();
        $highlandProject = Project::where('slug', 'highland-logistics-industrial-distribution-hub')->first();
        $riversideProject = Project::where('slug', 'riverside-civic-cultural-center-amphitheater')->first();

        // Fallback to first available project if slugs differ
        $defaultProject = Project::first();
        $p1 = $vertexProject ?: $defaultProject;
        $p2 = $highlandProject ?: $defaultProject;
        $p3 = $riversideProject ?: $defaultProject;

        if (!$defaultProject) {
            return;
        }

        $milestones = [
            // ==========================================
            // Vertex Corporate Tower Milestones
            // ==========================================
            [
                'project_id' => $p1->id,
                'title' => 'Subsurface Geotechnical Piling & Deep Excavation',
                'slug' => 'subsurface-geotechnical-piling-deep-excavation',
                'description' => 'Execution of 120 deep bored cast-in-situ piles (diameter 1200mm to 48m depth) and diaphragm perimeter wall for 3-level basement excavation.',
                'target_date' => '2023-04-30',
                'completion_date' => '2023-04-25',
                'status' => MilestoneStatus::COMPLETED,
                'progress_percentage' => 100,
                'sort_order' => 1,
                'is_published' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],
            [
                'project_id' => $p1->id,
                'title' => 'Mat Foundation & Basement Superstructure Waterproofing',
                'slug' => 'mat-foundation-basement-superstructure-waterproofing',
                'description' => 'Continuous monolithic concrete pour of 3,800m³ raft slab with crystalline integral waterproofing and Bentonite membrane protection.',
                'target_date' => '2023-09-15',
                'completion_date' => '2023-09-10',
                'status' => MilestoneStatus::COMPLETED,
                'progress_percentage' => 100,
                'sort_order' => 2,
                'is_published' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],
            [
                'project_id' => $p1->id,
                'title' => 'Reinforced Concrete Core & 28-Story Structural Topping Out',
                'slug' => 'reinforced-concrete-core-28-story-structural-topping-out',
                'description' => 'Completion of cast-in-place central shear core walls and post-tensioned floor slabs up to level 28 rooftop plant room.',
                'target_date' => '2024-07-20',
                'completion_date' => '2024-07-15',
                'status' => MilestoneStatus::COMPLETED,
                'progress_percentage' => 100,
                'sort_order' => 3,
                'is_published' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],
            [
                'project_id' => $p1->id,
                'title' => 'Unitized Double-Glazed Facade & Exterior Enclosure',
                'slug' => 'unitized-double-glazed-facade-exterior-enclosure',
                'description' => 'Installation of 18,500m² unitized curtain wall glazing with thermal break aluminum mullions and Low-E acoustic solar coatings.',
                'target_date' => '2024-12-10',
                'completion_date' => '2024-12-05',
                'status' => MilestoneStatus::COMPLETED,
                'progress_percentage' => 100,
                'sort_order' => 4,
                'is_published' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],
            [
                'project_id' => $p1->id,
                'title' => 'MEP Commissioning, LEED Platinum Certification & Handover',
                'slug' => 'mep-commissioning-leed-platinum-certification-handover',
                'description' => 'Comprehensive testing and balancing of HVAC chillers, emergency generators, fire suppression, and official occupancy handover to client.',
                'target_date' => '2025-06-30',
                'completion_date' => '2025-06-28',
                'status' => MilestoneStatus::COMPLETED,
                'progress_percentage' => 100,
                'sort_order' => 5,
                'is_published' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],

            // ==========================================
            // Highland Logistics Hub Milestones
            // ==========================================
            [
                'project_id' => $p2->id,
                'title' => 'Site Grading, Drainage Network & Foundation Footings',
                'slug' => 'site-grading-drainage-network-foundation-footings',
                'description' => 'Earthwork compaction of 25-acre logistics yard, storm retention basins, and reinforced pad footings for clear-span steel columns.',
                'target_date' => '2024-05-31',
                'completion_date' => '2024-05-25',
                'status' => MilestoneStatus::COMPLETED,
                'progress_percentage' => 100,
                'sort_order' => 1,
                'is_published' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],
            [
                'project_id' => $p2->id,
                'title' => 'Clear-Span Structural Steel Portal Frame Erection',
                'slug' => 'clear-span-structural-steel-portal-frame-erection',
                'description' => 'Assembly and erection of 45-meter clear-span primary steel trusses, gantry crane rails, and roof purlin support systems.',
                'target_date' => '2024-09-30',
                'completion_date' => '2024-09-28',
                'status' => MilestoneStatus::COMPLETED,
                'progress_percentage' => 100,
                'sort_order' => 2,
                'is_published' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],
            [
                'project_id' => $p2->id,
                'title' => 'Laser-Screed Superflat Industrial Concrete Flooring',
                'slug' => 'laser-screed-superflat-industrial-concrete-flooring',
                'description' => 'Precision laser-screed pouring of 350,000 sq.ft jointless steel-fiber reinforced floor slabs compliant with DIN 15185 high-density VNA racking.',
                'target_date' => '2024-12-15',
                'completion_date' => null,
                'status' => MilestoneStatus::IN_PROGRESS,
                'progress_percentage' => 75,
                'sort_order' => 3,
                'is_published' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],
            [
                'project_id' => $p2->id,
                'title' => 'Automated Dock Levelers, Insulated Wall Panels & ESFR Fire Loops',
                'slug' => 'automated-dock-levelers-insulated-wall-panels-esfr-fire-loops',
                'description' => 'Installation of 40 hydraulic dock levelers, PIR sandwich wall insulation panels, and overhead Early Suppression Fast Response sprinkler arrays.',
                'target_date' => '2025-03-30',
                'completion_date' => null,
                'status' => MilestoneStatus::IN_PROGRESS,
                'progress_percentage' => 40,
                'sort_order' => 4,
                'is_published' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],
            [
                'project_id' => $p2->id,
                'title' => 'Refrigerated Cold-Storage Zone & Final Facility Commissioning',
                'slug' => 'refrigerated-cold-storage-zone-final-facility-commissioning',
                'description' => 'Testing of multi-temperature ammonia/CO2 cascade refrigeration systems, solar roof integration, and municipal occupancy permitting.',
                'target_date' => '2025-07-31',
                'completion_date' => null,
                'status' => MilestoneStatus::PENDING,
                'progress_percentage' => 0,
                'sort_order' => 5,
                'is_published' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],

            // ==========================================
            // Riverside Civic Cultural Center Milestones
            // ==========================================
            [
                'project_id' => $p3->id,
                'title' => 'Architectural Working Drawings & Environmental Approvals',
                'slug' => 'architectural-working-drawings-environmental-approvals',
                'description' => 'Finalization of acoustic simulation modeling, riverfront environmental impact clearances, and civic heritage authority approvals.',
                'target_date' => '2025-01-31',
                'completion_date' => null,
                'status' => MilestoneStatus::IN_PROGRESS,
                'progress_percentage' => 85,
                'sort_order' => 1,
                'is_published' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],
            [
                'project_id' => $p3->id,
                'title' => 'Riverbank Sheet Piling & Amphitheater Ground Improvement',
                'slug' => 'riverbank-sheet-piling-amphitheater-ground-improvement',
                'description' => 'Vibratory driving of interlocking steel sheet piles along 350m of riverfront to stabilize amphitheater slope against flood surges.',
                'target_date' => '2025-05-31',
                'completion_date' => null,
                'status' => MilestoneStatus::PENDING,
                'progress_percentage' => 0,
                'sort_order' => 2,
                'is_published' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],
            [
                'project_id' => $p3->id,
                'title' => 'Acoustic Timber Shell & Tensioned Fabric Canopy Assembly',
                'slug' => 'acoustic-timber-shell-tensioned-fabric-canopy-assembly',
                'description' => 'Prefabrication and on-site tensioning of architectural PTFE canopy roof over the 2,500-seat outdoor amphitheater.',
                'target_date' => '2025-11-30',
                'completion_date' => null,
                'status' => MilestoneStatus::PENDING,
                'progress_percentage' => 0,
                'sort_order' => 3,
                'is_published' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],
        ];

        $milestoneImageMap = [
            'subsurface-geotechnical-piling-deep-excavation' => public_path('images/why-choose-crane.jpg'),
            'mat-foundation-basement-superstructure-waterproofing' => public_path('images/why-choose-engineers.jpg'),
            'reinforced-concrete-core-28-story-structural-topping-out' => public_path('images/project-commercial-tower.jpg'),
            'unitized-double-glazed-facade-exterior-enclosure' => public_path('images/hero-project-detail.jpg'),
            'mep-commissioning-leed-platinum-certification-handover' => public_path('images/about-engineer-tablet.jpg'),
            'site-clearing-grading-stormwater-retention-ponds' => public_path('images/project-industrial-hub.jpg'),
            'heavy-duty-subbase-laser-screed-flooring-pour' => public_path('images/experience-team.jpg'),
            'pre-engineered-steel-portal-frame-erection' => public_path('images/features-team-collaboration.jpg'),
            'automated-dock-levelers-insulated-wall-panels-esfr-fire-loops' => public_path('images/why-choose-crane.jpg'),
            'refrigerated-cold-storage-zone-final-facility-commissioning' => public_path('images/why-choose-engineers.jpg'),
            'architectural-working-drawings-environmental-approvals' => public_path('images/about-consulting-duo.jpg'),
            'riverbank-sheet-piling-amphitheater-ground-improvement' => public_path('images/project-civic-center.jpg'),
            'acoustic-timber-shell-tensioned-fabric-canopy-assembly' => public_path('images/hero-project-main.jpg'),
        ];

        foreach ($milestones as $data) {
            $milestone = ProjectMilestone::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );

            if (isset($milestoneImageMap[$milestone->slug])) {
                $imgPath = $milestoneImageMap[$milestone->slug];
                if (file_exists($imgPath) && $milestone->getMedia('image')->isEmpty()) {
                    $milestone->copyMedia($imgPath)->toMediaCollection('image');
                }
            }
        }
    }
}

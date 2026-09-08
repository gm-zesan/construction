<?php

namespace Database\Seeders;

use App\Models\ClientReview;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->first();
        $adminId = $admin ? $admin->id : null;

        $vertexTower = Project::where('slug', 'vertex-corporate-tower')->first();
        $highlandHub = Project::where('slug', 'highland-logistics-industrial-distribution-hub')->first();
        $bayfrontRes = Project::where('slug', 'bayfront-luxury-residences-marina')->first();
        $riversideCivic = Project::where('slug', 'riverside-civic-cultural-center-amphitheater')->first();

        $reviews = [
            [
                'client_name' => 'Tariq Al-Mansoor',
                'designation' => 'Chief Development Officer',
                'company_name' => 'Apex Holdings Ltd.',
                'review' => 'Antigravity Construction delivered our 28-story corporate headquarters with astonishing structural precision and zero safety incidents. Their post-tensioning and seismic engineering capabilities set a standard that very few general contractors in the region can match.',
                'rating' => 5,
                'project_id' => $vertexTower?->id,
                'featured' => true,
                'is_published' => true,
                'sort_order' => 1,
                'photo' => public_path('images/testimonial-1.jpg'),
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],
            [
                'client_name' => 'Elena Rostova',
                'designation' => 'VP of Global Logistics & Infrastructure',
                'company_name' => 'TransGlobal Freight Corp.',
                'review' => 'Constructing a 350,000 sq.ft automated fulfillment center requires strict laser-screed floor flatness and heavy-duty structural tolerances. The engineering team exceeded every KPI and finished our structural framework two weeks ahead of schedule.',
                'rating' => 5,
                'project_id' => $highlandHub?->id,
                'featured' => true,
                'is_published' => true,
                'sort_order' => 2,
                'photo' => public_path('images/testimonial-2.jpg'),
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],
            [
                'client_name' => 'Marcus Vance',
                'designation' => 'Managing Director',
                'company_name' => 'Prime Living Realty Consortium',
                'review' => 'Coastal high-rise construction presents severe corrosion and tidal water challenges. Antigravity implemented marine-grade silica fume concrete and sacrificial zinc anode piling that give our investors total long-term confidence. Exceptional team.',
                'rating' => 5,
                'project_id' => $bayfrontRes?->id,
                'featured' => true,
                'is_published' => true,
                'sort_order' => 3,
                'photo' => public_path('images/testimonial-3.jpg'),
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],
            [
                'client_name' => 'Farhana Rahman',
                'designation' => 'Principal Urban Architect',
                'company_name' => 'Studio Metropolis Design',
                'review' => 'Their mastery of complex board-formed architectural concrete and acoustic structural shells made our civic amphitheater vision come to life effortlessly. Proactive communication and transparent BIM clash detection made all the difference.',
                'rating' => 5,
                'project_id' => $riversideCivic?->id,
                'featured' => false,
                'is_published' => true,
                'sort_order' => 4,
                'photo' => public_path('images/about-engineer-tablet.jpg'),
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],
            [
                'client_name' => 'David Sterling',
                'designation' => 'Senior Vice President of Operations',
                'company_name' => 'Vanguard Asset Management',
                'review' => 'Outstanding craftsmanship, rigorous safety protocols on site, and meticulous budget control. We have partnered with Antigravity on multiple heavy civil developments and they remain our preferred EPC contractor.',
                'rating' => 5,
                'project_id' => null,
                'featured' => true,
                'is_published' => true,
                'sort_order' => 5,
                'photo' => public_path('images/about-consulting-duo.jpg'),
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],
            [
                'client_name' => 'Rezaul Karim',
                'designation' => 'Infrastructure Project Director',
                'company_name' => 'City Urban Transit Authority',
                'review' => 'Thorough QA/QC inspection regimes, robust steel fabrication quality, and rapid mobilization on site. Highly recommend their heavy civil and deep foundation engineering division.',
                'rating' => 4,
                'project_id' => null,
                'featured' => false,
                'is_published' => true,
                'sort_order' => 6,
                'photo' => null,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ],
        ];

        foreach ($reviews as $item) {
            $photoPath = $item['photo'];
            unset($item['photo']);

            $review = ClientReview::updateOrCreate(
                [
                    'client_name' => $item['client_name'],
                    'company_name' => $item['company_name'],
                ],
                $item
            );

            if ($photoPath && file_exists($photoPath) && $review->getMedia('client_photo')->isEmpty()) {
                $review->copyMedia($photoPath)->toMediaCollection('client_photo');
            }
        }
    }
}

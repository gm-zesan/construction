<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->first();
        $adminId = $admin ? $admin->id : null;

        $members = [
            [
                'name' => 'Harry Son',
                'designation' => 'Design Vision',
                'department' => 'Architecture & BIM Planning',
                'bio' => 'Leading structural architectural concepting and multidisciplinary project planning across high-density urban zones.',
                'email' => 'harry.son@agency.com',
                'phone' => '+1 (555) 234-5671',
                'linkedin_url' => 'https://linkedin.com',
                'twitter_url' => 'https://x.com',
                'facebook_url' => null,
                'sort_order' => 1,
                'is_active' => true,
                'is_featured' => true,
                'photo' => public_path('images/team-1.jpg'),
            ],
            [
                'name' => 'John Doe',
                'designation' => 'Concept Development',
                'department' => 'Structural Engineering',
                'bio' => 'Specialist in 3D BIM modeling, clash-detection, geotechnical telemetry, and preconstruction structural drafting.',
                'email' => 'john.doe@agency.com',
                'phone' => '+1 (555) 234-5672',
                'linkedin_url' => 'https://linkedin.com',
                'twitter_url' => null,
                'facebook_url' => null,
                'sort_order' => 2,
                'is_active' => true,
                'is_featured' => true,
                'photo' => public_path('images/team-2.jpg'),
            ],
            [
                'name' => 'Stive Smith',
                'designation' => 'Project Manager',
                'department' => 'Construction Operations',
                'bio' => 'Overseeing large-scale commercial framing, trade subcontractors, logistical staging, and zero-incident site safety governance.',
                'email' => 'stive.smith@agency.com',
                'phone' => '+1 (555) 234-5673',
                'linkedin_url' => 'https://linkedin.com',
                'twitter_url' => 'https://x.com',
                'facebook_url' => null,
                'sort_order' => 3,
                'is_active' => true,
                'is_featured' => true,
                'photo' => public_path('images/team-3.jpg'),
            ],
            [
                'name' => 'Alexander Reed',
                'designation' => 'Executive Chairman',
                'department' => 'Executive Board',
                'bio' => 'Over 22 years directing heavy civil engineering contracts, deep foundation infrastructure, and enterprise portfolio delivery.',
                'email' => 'alexander.reed@agency.com',
                'phone' => '+1 (555) 234-5674',
                'linkedin_url' => 'https://linkedin.com',
                'twitter_url' => 'https://x.com',
                'facebook_url' => null,
                'sort_order' => 4,
                'is_active' => true,
                'is_featured' => true,
                'photo' => public_path('images/about-engineer-tablet.jpg'),
            ],
            [
                'name' => 'Mahbubur Rahman',
                'designation' => 'Chief Structural Engineer',
                'department' => 'Structural Engineering',
                'bio' => 'Specialist in post-tensioned reinforced concrete slabs, seismic bracing systems, and high-performance 65+ MPa mix designs.',
                'email' => 'mahbub.rahman@agency.com',
                'phone' => '+1 (555) 234-5675',
                'linkedin_url' => 'https://linkedin.com',
                'twitter_url' => null,
                'facebook_url' => null,
                'sort_order' => 5,
                'is_active' => true,
                'is_featured' => true,
                'photo' => public_path('images/about-consulting-duo.jpg'),
            ],
            [
                'name' => 'Dr. Farhana Yasmin',
                'designation' => 'LEED & Materials QA',
                'department' => 'Quality Assurance & Sustainability',
                'bio' => 'Championing low-carbon geopolymer concrete mixes, autonomous drone field surveys, and LEED Platinum building certifications.',
                'email' => 'farhana.yasmin@agency.com',
                'phone' => '+1 (555) 234-5676',
                'linkedin_url' => 'https://linkedin.com',
                'twitter_url' => 'https://x.com',
                'facebook_url' => null,
                'sort_order' => 6,
                'is_active' => true,
                'is_featured' => true,
                'photo' => public_path('images/why-choose-engineers.jpg'),
            ],
        ];

        foreach ($members as $data) {
            $photoPath = $data['photo'];
            unset($data['photo']);

            $data['created_by'] = $adminId;
            $data['updated_by'] = $adminId;

            $teamMember = TeamMember::updateOrCreate(
                ['name' => $data['name'], 'designation' => $data['designation']],
                $data
            );

            // Attach photo to Spatie MediaLibrary if file exists and member has no media
            if ($photoPath && File::exists($photoPath) && $teamMember->getMedia('photo')->isEmpty()) {
                $teamMember->copyMedia($photoPath)->toMediaCollection('photo');
            }
        }
    }
}

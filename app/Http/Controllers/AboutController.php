<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use App\Models\WebsiteSetting;
use Illuminate\View\View;

use App\Models\TeamMember;

class AboutController extends Controller
{
    /**
     * Display the About Us page with corporate history, Chairman speech,
     * core pillars, milestones timeline, and leadership profiles.
     */
    public function index(): View
    {
        $teamMembers = TeamMember::with('media')
            ->active()
            ->ordered()
            ->get();

        $leadership = $teamMembers->map(function (TeamMember $member) {
            return [
                'id' => $member->id,
                'name' => $member->name,
                'role' => $member->designation,
                'credentials' => $member->department ?? $member->designation,
                'bio' => $member->bio,
                'image' => $member->photo_url ?: asset('images/team-1.jpg'),
                'linkedin' => $member->linkedin_url ?: 'https://linkedin.com',
            ];
        })->all();

        $accreditations = [
            [
                'year' => '2024',
                'title' => 'BUILD OF THE YEAR',
                'category' => 'Commercial High-Rise Development',
                'status' => 'Winner',
                'image' => asset('images/project-commercial-tower.jpg'),
            ],
            [
                'year' => '2023',
                'title' => 'TOP BUILD AWARD',
                'category' => 'Sustainable Civil & Structural Engineering',
                'status' => 'Winner',
                'image' => asset('images/project-civic-center.jpg'),
            ],
            [
                'year' => '2022',
                'title' => 'BEST DESIGN OF THE YEAR',
                'category' => 'Architectural Innovation & BIM Execution',
                'status' => 'Winner',
                'image' => asset('images/hero-project-main.jpg'),
            ],
            [
                'year' => '2022',
                'title' => 'BEST BUILDING PROJECT',
                'category' => 'Industrial Logistics & Smart Hub Facility',
                'status' => 'Winner',
                'image' => asset('images/project-industrial-hub.jpg'),
            ],
            [
                'year' => '2021',
                'title' => 'CONSTRUCTION HONORS',
                'category' => 'Preconstruction & Safety Distinction',
                'status' => 'Runner Up',
                'image' => asset('images/about-main.jpg'),
            ],
            [
                'year' => '2020',
                'title' => 'ISO 9001 & LEED PLATINUM',
                'category' => 'Quality Management & Green Compliance',
                'status' => 'Certified',
                'image' => asset('images/hero-project-detail.jpg'),
            ],
        ];

        $companyName = WebsiteSetting::get('company_name', 'COMPANY NAME');
        $title = "About Us | {$companyName} — Engineering & Construction Heritage";

        return view('about', compact('leadership', 'accreditations', 'title'));
    }
}

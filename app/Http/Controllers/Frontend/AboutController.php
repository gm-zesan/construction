<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\WebsiteSetting;
use Illuminate\View\View;

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
                'year' => get_content('about', 'accreditations', 'item_1_year', '2024'),
                'title' => get_content('about', 'accreditations', 'item_1_title', 'BUILD OF THE YEAR'),
                'category' => get_content('about', 'accreditations', 'item_1_category', 'Commercial High-Rise Development'),
                'status' => get_content('about', 'accreditations', 'item_1_status', 'Winner'),
                'image' => get_content_image('about', 'accreditations', 'item_1_image', asset('images/project-commercial-tower.jpg')),
            ],
            [
                'year' => get_content('about', 'accreditations', 'item_2_year', '2023'),
                'title' => get_content('about', 'accreditations', 'item_2_title', 'TOP BUILD AWARD'),
                'category' => get_content('about', 'accreditations', 'item_2_category', 'Sustainable Civil & Structural Engineering'),
                'status' => get_content('about', 'accreditations', 'item_2_status', 'Winner'),
                'image' => get_content_image('about', 'accreditations', 'item_2_image', asset('images/project-civic-center.jpg')),
            ],
            [
                'year' => get_content('about', 'accreditations', 'item_3_year', '2022'),
                'title' => get_content('about', 'accreditations', 'item_3_title', 'BEST DESIGN OF THE YEAR'),
                'category' => get_content('about', 'accreditations', 'item_3_category', 'Architectural Innovation & BIM Execution'),
                'status' => get_content('about', 'accreditations', 'item_3_status', 'Winner'),
                'image' => get_content_image('about', 'accreditations', 'item_3_image', asset('images/hero-project-main.jpg')),
            ],
            [
                'year' => get_content('about', 'accreditations', 'item_4_year', '2022'),
                'title' => get_content('about', 'accreditations', 'item_4_title', 'BEST BUILDING PROJECT'),
                'category' => get_content('about', 'accreditations', 'item_4_category', 'Industrial Logistics & Smart Hub Facility'),
                'status' => get_content('about', 'accreditations', 'item_4_status', 'Winner'),
                'image' => get_content_image('about', 'accreditations', 'item_4_image', asset('images/project-industrial-hub.jpg')),
            ],
            [
                'year' => get_content('about', 'accreditations', 'item_5_year', '2021'),
                'title' => get_content('about', 'accreditations', 'item_5_title', 'CONSTRUCTION HONORS'),
                'category' => get_content('about', 'accreditations', 'item_5_category', 'Preconstruction & Safety Distinction'),
                'status' => get_content('about', 'accreditations', 'item_5_status', 'Runner Up'),
                'image' => get_content_image('about', 'accreditations', 'item_5_image', asset('images/about-main.jpg')),
            ],
            [
                'year' => get_content('about', 'accreditations', 'item_6_year', '2020'),
                'title' => get_content('about', 'accreditations', 'item_6_title', 'ISO 9001 & LEED PLATINUM'),
                'category' => get_content('about', 'accreditations', 'item_6_category', 'Quality Management & Green Compliance'),
                'status' => get_content('about', 'accreditations', 'item_6_status', 'Certified'),
                'image' => get_content_image('about', 'accreditations', 'item_6_image', asset('images/hero-project-detail.jpg')),
            ],
        ];

        $companyName = WebsiteSetting::get('company_name', 'COMPANY NAME');
        $title = "About Us | {$companyName} — Engineering & Construction Heritage";

        return theme_view('about', compact('leadership', 'accreditations', 'title'));
    }
}

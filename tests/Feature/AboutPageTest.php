<?php

use App\Models\TeamMember;
use App\Models\WebsiteContent;
use App\Models\WebsiteSetting;

it('renders about us page successfully with chairman speech and all dynamic sections', function () {
    // Ensure team members exist for test assertion
    TeamMember::factory()->create([
        'name' => 'Harry Son',
        'designation' => 'Design Vision',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $response = $this->get('/about');

    $response->assertStatus(200);

    // Assert Page title
    $response->assertSee('About Us');

    // Assert Chairman Speech Section
    $response->assertSee("Chairman's Address");
    $response->assertSee('Alexander Joseph Reed');
    $response->assertSee('Founder & Executive Chairman');
    $response->assertSee('Building With Purpose');

    // Assert Corporate Narrative / Story
    $response->assertSee('Our Origins & Mission');
    $response->assertSee('Pioneering Heavy Civil');

    // Assert Core Values
    $response->assertSee('Our Pillars of Practice');
    $response->assertSee('Zero-Incident HSE Governance');
    $response->assertSee('BIM 5D & Clash Detection');

    // Assert Timeline
    $response->assertSee('Evolution of Excellence');
    $response->assertSee('2012');
    $response->assertSee('Enterprise Founding');

    // Assert Leadership & Team Members
    $response->assertSee('OUR EXPERIENCE TEAM');
    $response->assertSee('Leaders Driving Future');
    $response->assertSee('Building Excellence');
    $response->assertSee('Harry Son');

    // Assert Accreditations & Honors
    $response->assertSee('Accreditations &amp; Honors', false);
    $response->assertSee('BUILD OF THE YEAR');
    $response->assertSee('TOP BUILD AWARD');
    $response->assertSee('BEST DESIGN OF THE YEAR');
});


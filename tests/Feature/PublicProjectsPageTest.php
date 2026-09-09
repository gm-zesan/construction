<?php

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\ProjectMilestone;

it('renders public projects index page successfully with dynamic portfolio items and sections', function () {
    // Create test projects across categories
    $project1 = Project::factory()->create([
        'title' => 'Metropolitan Skyrise Commercial Hub',
        'category' => 'Commercial',
        'status' => ProjectStatus::COMPLETED,
        'featured' => true,
        'client_name' => 'Skyrise Global Developments',
        'location' => 'Metropolitan Financial District',
    ]);

    $project2 = Project::factory()->create([
        'title' => 'Automated Logistics Fulfillment Hub',
        'category' => 'Industrial',
        'status' => ProjectStatus::ONGOING,
        'featured' => false,
        'client_name' => 'TransGlobal Freight Corp',
        'location' => 'Northern Cargo Terminal',
    ]);

    $response = $this->get('/projects');

    $response->assertStatus(200);

    // Verify Title & Hero Content
    $response->assertSee('PROJECT PORTFOLIO &amp; CASE STUDIES', false);
    $response->assertSee('Engineering Skylines', false);

    // Verify Dynamic Category Filters & Projects
    $response->assertSee('Commercial');
    $response->assertSee('Industrial');
    $response->assertSee('Metropolitan Skyrise Commercial Hub');
    $response->assertSee('Automated Logistics Fulfillment Hub');

    // Verify Sections
    $response->assertSee('COMPLETE ARCHITECTURAL INDEX', false);
    $response->assertSee('Explore Full Case Study');
});

it('filters projects by category query parameter', function () {
    Project::factory()->create([
        'title' => 'Unique Mega Bridge Span',
        'category' => 'Infrastructure',
        'status' => ProjectStatus::COMPLETED,
    ]);

    Project::factory()->create([
        'title' => 'Highrise Residential Complex',
        'category' => 'Residential',
        'status' => ProjectStatus::COMPLETED,
    ]);

    $response = $this->get('/projects?category=Infrastructure');

    $response->assertStatus(200);
    $response->assertSee('Unique Mega Bridge Span');
    $response->assertDontSee('Highrise Residential Complex');
});

it('renders project detail case study page successfully with milestones and technical parameters', function () {
    $project = Project::factory()->create([
        'title' => 'Civic Arts & Cultural Center',
        'slug' => 'civic-arts-cultural-center',
        'category' => 'Civic',
        'client_name' => 'Department of Cultural Affairs',
        'location' => 'Capital City Arts Plaza',
        'status' => ProjectStatus::COMPLETED,
        'short_description' => 'A premier municipal cultural complex engineered with acoustic decoupling.',
        'description' => 'Detailed engineering narrative detailing seismic isolation, steel trusses, and LEED Gold certification.',
    ]);

    // Add milestones
    ProjectMilestone::create([
        'project_id' => $project->id,
        'title' => 'Substructure Foundation Piling',
        'description' => 'Completed 120 deep friction piles with zero settlement variance.',
        'target_date' => now()->subMonths(6),
        'completed_at' => now()->subMonths(6),
    ]);

    $response = $this->get('/projects/civic-arts-cultural-center');

    $response->assertStatus(200);
    $response->assertSee('Civic Arts &amp; Cultural Center', false);
    $response->assertSee('Department of Cultural Affairs');
    $response->assertSee('Capital City Arts Plaza');
    $response->assertSee('Technical Data Sheet');
    $response->assertSee('Substructure Foundation Piling');
    $response->assertSee('Completed 120 deep friction piles');
});

it('returns 404 for non-existent project slug', function () {
    $response = $this->get('/projects/non-existent-project-slug');

    $response->assertStatus(404);
});

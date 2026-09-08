<?php

use App\Enums\EnquiryStatus;
use App\Enums\ProjectStatus;
use App\Models\ActivityLog;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ClientEnquiry;
use App\Models\ClientReview;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->artisan('db:seed');
    Storage::fake('public');

    $this->superadmin = User::role('superadmin')->first();
    $this->unauthorizedUser = User::factory()->create();
});

test('authenticated user can access admin dashboard with correct database counts', function () {
    // Clear and create known dataset
    Project::query()->delete();
    Service::query()->delete();
    ClientEnquiry::query()->delete();
    Article::query()->delete();
    ClientReview::query()->delete();

    // 1. Projects
    $p1 = Project::create([
        'title' => 'Ongoing High-Rise Tower',
        'slug' => 'ongoing-high-rise-tower',
        'category' => 'Commercial',
        'location' => 'Gulshan Avenue',
        'status' => ProjectStatus::ONGOING,
        'created_by' => $this->superadmin->id,
    ]);

    $p2 = Project::create([
        'title' => 'Completed Logistics Warehouse',
        'slug' => 'completed-logistics-warehouse',
        'category' => 'Industrial',
        'location' => 'Gazipur Zone',
        'status' => ProjectStatus::COMPLETED,
        'created_by' => $this->superadmin->id,
    ]);

    $p3 = Project::create([
        'title' => 'Upcoming Civic Center',
        'slug' => 'upcoming-civic-center',
        'category' => 'Institutional',
        'location' => 'Hatirjheel Waterfront',
        'status' => ProjectStatus::UPCOMING,
        'created_by' => $this->superadmin->id,
    ]);

    // 2. Services
    $s1 = Service::create([
        'title' => 'General Contracting & EPC',
        'slug' => 'general-contracting-epc',
        'icon' => 'ri-building-line',
        'is_published' => true,
        'created_by' => $this->superadmin->id,
    ]);

    // 3. Client Enquiries
    $e1 = ClientEnquiry::create([
        'name' => 'John Bradley',
        'email' => 'bradley@apexcorp.com',
        'subject' => 'Foundation Piling Tender Proposal',
        'message' => 'Seeking contractor for 40m deep pile boring.',
        'service_id' => $s1->id,
        'status' => EnquiryStatus::NEW,
        'submitted_at' => now(),
    ]);

    $e2 = ClientEnquiry::create([
        'name' => 'Sarah Connor',
        'email' => 'sarah@skynet.com',
        'subject' => 'Steel Fabrication Quotation',
        'message' => 'Need 500 tons of structural I-beams.',
        'service_id' => $s1->id,
        'status' => EnquiryStatus::CONTACTED,
        'submitted_at' => now()->subDay(),
    ]);

    // 4. Articles
    $cat = ArticleCategory::first() ?? ArticleCategory::create([
        'name' => 'Civil Engineering',
        'slug' => 'civil-engineering',
        'is_active' => true,
        'created_by' => $this->superadmin->id,
    ]);

    Article::create([
        'category_id' => $cat->id,
        'title' => 'Deep Foundation Seismic Isolation Best Practices',
        'slug' => 'deep-foundation-seismic-isolation-best-practices',
        'is_published' => true,
        'created_by' => $this->superadmin->id,
    ]);

    // 5. Client Reviews
    ClientReview::create([
        'client_name' => 'Arthur Vance',
        'company_name' => 'Vance Holdings',
        'review' => 'Excellent delivery and structural execution.',
        'rating' => 5,
        'project_id' => $p1->id,
        'is_published' => true,
        'created_by' => $this->superadmin->id,
    ]);

    $initialLogCount = ActivityLog::count();

    $response = $this->actingAs($this->superadmin)->get('/dashboard');

    $response->assertStatus(200);
    $response->assertSee('Dashboard Overview');
    $response->assertSee('Total Projects');
    $response->assertSee('Ongoing Projects');
    $response->assertSee('Completed Projects');
    $response->assertSee('Upcoming Projects');
    $response->assertSee('New Enquiries');

    // Assert view has exact counts
    $response->assertViewHas('stats', function ($stats) {
        return $stats['total_projects'] === 3
            && $stats['ongoing_projects'] === 1
            && $stats['completed_projects'] === 1
            && $stats['upcoming_projects'] === 1
            && $stats['total_services'] === 1
            && $stats['new_enquiries'] === 1
            && $stats['total_articles'] === 1
            && $stats['total_reviews'] === 1;
    });

    // Assert recent projects and enquiries are passed
    $response->assertSee('Ongoing High-Rise Tower');
    $response->assertSee('John Bradley');
    $response->assertSee('Foundation Piling Tender Proposal');

    // Assert viewing dashboard did NOT create new activity logs
    expect(ActivityLog::count())->toBe($initialLogCount);
});

test('unauthenticated user is redirected from dashboard', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('dashboard handles empty database state cleanly without errors', function () {
    Project::query()->delete();
    Service::query()->delete();
    ClientEnquiry::query()->delete();
    Article::query()->delete();
    ClientReview::query()->delete();

    $response = $this->actingAs($this->superadmin)->get('/dashboard');

    $response->assertStatus(200);
    $response->assertSee('No projects yet');
    $response->assertSee('No enquiries yet');

    $response->assertViewHas('stats', function ($stats) {
        return $stats['total_projects'] === 0
            && $stats['ongoing_projects'] === 0
            && $stats['completed_projects'] === 0
            && $stats['upcoming_projects'] === 0
            && $stats['new_enquiries'] === 0;
    });
});

test('authorized user can clear cache via dashboard route', function () {
    $response = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/clear-cache');

    $response->assertStatus(200)
        ->assertJson(['success' => true]);
});

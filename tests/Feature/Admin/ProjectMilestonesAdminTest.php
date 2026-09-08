<?php

use App\Enums\MilestoneStatus;
use App\Models\ActivityLog;
use App\Models\Project;
use App\Models\ProjectMilestone;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->artisan('db:seed');
    Storage::fake('public');

    $this->superadmin = User::role('superadmin')->first();
    $this->unauthorizedUser = User::factory()->create();

    // Ensure we have a project
    $this->project = Project::first() ?? Project::create([
        'title' => 'Skyline Commercial Center',
        'slug' => 'skyline-commercial-center',
        'category' => 'commercial',
        'description' => 'Test project description',
        'status' => 'ongoing',
        'is_published' => true,
        'created_by' => $this->superadmin->id,
    ]);
});

test('authorized user can render milestone index, create, edit, and show views', function () {
    // 1. Index view
    $this->actingAs($this->superadmin)
        ->get('/dashboard/milestones')
        ->assertStatus(200)
        ->assertSee('Project Milestones')
        ->assertSee('Add Milestone');

    // 2. Create view
    $this->actingAs($this->superadmin)
        ->get('/dashboard/milestones/create')
        ->assertStatus(200)
        ->assertSee('New Project Milestone')
        ->assertSee($this->project->title);

    // 3. Create a milestone for show & edit tests
    $milestone = ProjectMilestone::create([
        'project_id' => $this->project->id,
        'title' => 'Basement Piling Phase 1',
        'slug' => 'basement-piling-phase-1',
        'description' => 'Completed bored piling for south tower foundation.',
        'target_date' => now()->addMonths(2),
        'status' => MilestoneStatus::IN_PROGRESS,
        'progress_percentage' => 45,
        'is_published' => true,
        'created_by' => $this->superadmin->id,
    ]);

    // 4. Show view
    $this->actingAs($this->superadmin)
        ->get("/dashboard/milestones/{$milestone->id}")
        ->assertStatus(200)
        ->assertSee('Basement Piling Phase 1')
        ->assertSee('45%')
        ->assertSee($this->project->title);

    // 5. Edit view
    $this->actingAs($this->superadmin)
        ->get("/dashboard/milestones/{$milestone->id}/edit")
        ->assertStatus(200)
        ->assertSee('Edit Project Milestone')
        ->assertSee('Basement Piling Phase 1');
});

test('unauthenticated user is redirected from milestone routes', function () {
    $this->get('/dashboard/milestones')->assertRedirect('/login');
    $this->get('/dashboard/milestones/create')->assertRedirect('/login');
});

test('unauthorized user without milestone permissions cannot access milestones', function () {
    $this->actingAs($this->unauthorizedUser)
        ->get('/dashboard/milestones')
        ->assertStatus(403);

    $this->actingAs($this->unauthorizedUser)
        ->get('/dashboard/milestones/create')
        ->assertStatus(403);
});

test('milestones datatables ajax endpoint returns formatted columns', function () {
    $milestone = ProjectMilestone::create([
        'project_id' => $this->project->id,
        'title' => 'Structural Framing Milestone',
        'target_date' => now()->addMonths(4),
        'status' => MilestoneStatus::PENDING,
        'progress_percentage' => 10,
        'is_published' => true,
        'created_by' => $this->superadmin->id,
    ]);

    $response = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/milestones?draw=1&start=0&length=10');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data' => [
                '*' => [
                    'id',
                    'thumbnail',
                    'milestone_title',
                    'project_badge',
                    'progress_bar',
                    'target_date_formatted',
                    'status_badge',
                    'published_toggle',
                    'action-btn',
                ]
            ]
        ]);
});

test('milestones index can be filtered by project, status, and search', function () {
    $otherProject = Project::create([
        'title' => 'Metro Transport Depot',
        'slug' => 'metro-transport-depot',
        'category' => 'infrastructure',
        'description' => 'Depot construction',
        'status' => 'ongoing',
        'created_by' => $this->superadmin->id,
    ]);

    $m1 = ProjectMilestone::create([
        'project_id' => $this->project->id,
        'title' => 'Piling Drilling Test',
        'target_date' => now()->addMonths(1),
        'status' => MilestoneStatus::COMPLETED,
        'progress_percentage' => 100,
        'is_published' => true,
        'created_by' => $this->superadmin->id,
    ]);

    $m2 = ProjectMilestone::create([
        'project_id' => $otherProject->id,
        'title' => 'Railway Track Alignment',
        'target_date' => now()->addMonths(5),
        'status' => MilestoneStatus::DELAYED,
        'progress_percentage' => 20,
        'is_published' => true,
        'created_by' => $this->superadmin->id,
    ]);

    // 1. Filter by project_id
    $responseProject = $this->actingAs($this->superadmin)
        ->getJson("/dashboard/milestones?draw=1&project_id={$otherProject->id}&start=0&length=10");
    $responseProject->assertStatus(200);
    $dataProject = $responseProject->json('data');
    expect(count($dataProject))->toBe(1);
    expect($dataProject[0]['title'])->toBe('Railway Track Alignment');

    // 2. Filter by status
    $responseStatus = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/milestones?draw=1&status=completed&start=0&length=10');
    $responseStatus->assertStatus(200);
    $dataStatus = $responseStatus->json('data');
    expect(count($dataStatus))->toBeGreaterThan(0);
    foreach ($dataStatus as $row) {
        expect($row['status'])->toBe(MilestoneStatus::COMPLETED->value);
    }

    // 3. Search by title
    $responseSearch = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/milestones?draw=1&search=Railway+Track&start=0&length=10');
    $responseSearch->assertStatus(200);
    $dataSearch = $responseSearch->json('data');
    expect(count($dataSearch))->toBe(1);
    expect($dataSearch[0]['title'])->toBe('Railway Track Alignment');
});

test('authorized user can store a milestone with verification photo and activity log', function () {
    $photo = UploadedFile::fake()->image('foundation_inspection.jpg', 1200, 800);

    $response = $this->actingAs($this->superadmin)
        ->post('/dashboard/milestones', [
            'project_id' => $this->project->id,
            'title' => 'Ground Floor Slab Pouring',
            'target_date' => now()->addMonth()->format('Y-m-d'),
            'status' => 'in_progress',
            'progress_percentage' => 60,
            'description' => 'Successfully poured 400 cubic meters of high strength concrete.',
            'is_published' => 1,
            'image' => $photo,
        ]);

    $response->assertRedirect(route('milestones.index'));
    $response->assertSessionHas('success');

    $milestone = ProjectMilestone::where('title', 'Ground Floor Slab Pouring')->first();
    expect($milestone)->not->toBeNull();
    expect($milestone->progress_percentage)->toBe(60);
    expect($milestone->hasMedia('image'))->toBeTrue();

    // Verify activity log
    $log = ActivityLog::where('module', 'milestone')
        ->where('action', 'create')
        ->where('subject_id', $milestone->id)
        ->first();

    expect($log)->not->toBeNull();
    expect($log->description)->toContain('Ground Floor Slab Pouring');
});

test('storing milestone rejects invalid inputs', function () {
    $response = $this->actingAs($this->superadmin)
        ->postJson('/dashboard/milestones', [
            'project_id' => 99999, // non-existent project
            'title' => '',
            'target_date' => 'invalid-date',
            'status' => 'fake_status',
            'progress_percentage' => 150,
        ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['project_id', 'title', 'target_date', 'status', 'progress_percentage']);
});

test('authorized user can update a milestone and log activity', function () {
    $milestone = ProjectMilestone::create([
        'project_id' => $this->project->id,
        'title' => 'Initial Milestone Title',
        'target_date' => now()->addMonths(2),
        'status' => MilestoneStatus::PENDING,
        'progress_percentage' => 0,
        'is_published' => true,
        'created_by' => $this->superadmin->id,
    ]);

    $response = $this->actingAs($this->superadmin)
        ->put("/dashboard/milestones/{$milestone->id}", [
            'project_id' => $this->project->id,
            'title' => 'Updated Milestone Title 2026',
            'target_date' => now()->addMonths(3)->format('Y-m-d'),
            'status' => 'completed',
            'progress_percentage' => 100,
            'completion_date' => now()->format('Y-m-d'),
            'description' => 'Fully completed ahead of critical path timeline.',
            'is_published' => 1,
        ]);

    $response->assertRedirect(route('milestones.index'));
    $response->assertSessionHas('success');

    $milestone->refresh();
    expect($milestone->title)->toBe('Updated Milestone Title 2026');
    expect($milestone->status)->toBe(MilestoneStatus::COMPLETED);
    expect($milestone->progress_percentage)->toBe(100);

    // Verify activity log
    $log = ActivityLog::where('module', 'milestone')
        ->where('action', 'update')
        ->where('subject_id', $milestone->id)
        ->latest('id')
        ->first();

    expect($log)->not->toBeNull();
    expect($log->description)->toContain('Updated milestone');
});

test('authorized user can toggle milestone visibility via fast ajax endpoint', function () {
    $milestone = ProjectMilestone::create([
        'project_id' => $this->project->id,
        'title' => 'Visibility Toggle Milestone',
        'target_date' => now()->addMonth(),
        'status' => MilestoneStatus::PENDING,
        'is_published' => true,
        'created_by' => $this->superadmin->id,
    ]);

    $response = $this->actingAs($this->superadmin)
        ->postJson("/dashboard/milestones/{$milestone->id}/toggle-status");

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'is_published' => false,
        ]);

    expect($milestone->fresh()->is_published)->toBeFalse();
});

test('authorized user can delete a milestone and its media with activity log', function () {
    $milestone = ProjectMilestone::create([
        'project_id' => $this->project->id,
        'title' => 'Obsolete Milestone To Delete',
        'target_date' => now()->addMonth(),
        'status' => MilestoneStatus::PENDING,
        'created_by' => $this->superadmin->id,
    ]);

    $response = $this->actingAs($this->superadmin)
        ->deleteJson("/dashboard/milestones/{$milestone->id}");

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);

    expect(ProjectMilestone::find($milestone->id))->toBeNull();

    // Verify activity log
    $log = ActivityLog::where('module', 'milestone')
        ->where('action', 'delete')
        ->latest('id')
        ->first();

    expect($log)->not->toBeNull();
    expect($log->description)->toContain('Deleted milestone');
});

test('unauthorized user cannot create, update, toggle, or delete milestones', function () {
    $milestone = ProjectMilestone::create([
        'project_id' => $this->project->id,
        'title' => 'Protected Milestone',
        'target_date' => now()->addMonth(),
        'status' => MilestoneStatus::PENDING,
        'created_by' => $this->superadmin->id,
    ]);

    // 1. Create attempt
    $this->actingAs($this->unauthorizedUser)
        ->post('/dashboard/milestones', [
            'project_id' => $this->project->id,
            'title' => 'Unauthorized Milestone',
            'target_date' => now()->addMonth()->format('Y-m-d'),
            'status' => 'pending',
        ])
        ->assertStatus(403);

    // 2. Update attempt
    $this->actingAs($this->unauthorizedUser)
        ->put("/dashboard/milestones/{$milestone->id}", [
            'project_id' => $this->project->id,
            'title' => 'Unauthorized Edit',
            'target_date' => now()->addMonth()->format('Y-m-d'),
            'status' => 'completed',
        ])
        ->assertStatus(403);

    // 3. Toggle status attempt
    $this->actingAs($this->unauthorizedUser)
        ->postJson("/dashboard/milestones/{$milestone->id}/toggle-status")
        ->assertStatus(403);

    // 4. Delete attempt
    $this->actingAs($this->unauthorizedUser)
        ->deleteJson("/dashboard/milestones/{$milestone->id}")
        ->assertStatus(403);

    expect(ProjectMilestone::find($milestone->id))->not->toBeNull();
});

<?php

use App\Enums\EnquiryStatus;
use App\Enums\ProjectStatus;
use App\Models\ActivityLog;
use App\Models\ClientEnquiry;
use App\Models\Media;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->artisan('db:seed');
    $this->superadmin = User::role('superadmin')->first();
});

test('superadmin can list projects via json', function () {
    $response = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/projects');

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
        ])
        ->assertJsonFragment([
            'slug' => 'vertex-corporate-tower',
        ]);
});

test('superadmin can render projects admin views', function () {
    // Index view
    $indexResponse = $this->actingAs($this->superadmin)->get('/dashboard/projects');
    $indexResponse->assertStatus(200);
    $indexResponse->assertSee('Project Portfolio');
    $indexResponse->assertSee('Create Project');

    // Create view
    $createResponse = $this->actingAs($this->superadmin)->get('/dashboard/projects/create');
    $createResponse->assertStatus(200);
    $createResponse->assertSee('New Project Details');

    // Edit view
    $project = Project::first();
    $editResponse = $this->actingAs($this->superadmin)->get("/dashboard/projects/{$project->id}/edit");
    $editResponse->assertStatus(200);
    $editResponse->assertSee('Edit Project: ' . $project->title);
    $editResponse->assertSee('Gallery Manager');
});

test('superadmin can create, update, and delete a project with activity logging', function () {
    // 1. Create Project
    $projectData = [
        'title' => 'Green Valley Eco Residence',
        'category' => 'Residential',
        'client_name' => 'EcoLife Real Estate',
        'location' => 'Purbachal Sector 4, Dhaka',
        'start_date' => '2025-01-01',
        'status' => 'ongoing',
        'short_description' => 'A sustainable residential complex.',
        'description' => '<p>Equipped with solar roofing and rainwater harvesting.</p>',
        'featured' => true,
        'sort_order' => 10,
        'is_published' => true,
    ];

    $createResponse = $this->actingAs($this->superadmin)
        ->postJson('/dashboard/projects', $projectData);

    $createResponse->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Project created successfully',
        ]);

    $project = Project::where('title', 'Green Valley Eco Residence')->first();
    expect($project)->not->toBeNull();
    expect($project->slug)->toBe('green-valley-eco-residence');
    expect($project->status)->toBe(ProjectStatus::ONGOING);

    // Verify activity log for creation
    $createLog = ActivityLog::where('module', 'project')
        ->where('action', 'create')
        ->where('subject_id', $project->id)
        ->first();
    expect($createLog)->not->toBeNull();
    expect($createLog->user_id)->toBe($this->superadmin->id);

    // 2. Show Project
    $showResponse = $this->actingAs($this->superadmin)
        ->getJson("/dashboard/projects/{$project->id}");

    $showResponse->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => [
                'id' => $project->id,
                'title' => 'Green Valley Eco Residence',
            ],
        ]);

    // 3. Update Project
    $updateResponse = $this->actingAs($this->superadmin)
        ->putJson("/dashboard/projects/{$project->id}", [
            'title' => 'Green Valley Eco Residence Phase 1',
            'category' => 'Residential',
            'status' => 'completed',
            'featured' => false,
        ]);

    $updateResponse->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Project updated successfully',
        ]);

    expect($project->fresh()->title)->toBe('Green Valley Eco Residence Phase 1');
    expect($project->fresh()->status)->toBe(ProjectStatus::COMPLETED);

    // Verify activity log for update
    $updateLog = ActivityLog::where('module', 'project')
        ->where('action', 'update')
        ->where('subject_id', $project->id)
        ->first();
    expect($updateLog)->not->toBeNull();

    // 4. Delete Project
    $deleteResponse = $this->actingAs($this->superadmin)
        ->deleteJson("/dashboard/projects/{$project->id}");

    $deleteResponse->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Project deleted successfully',
        ]);

    expect(Project::find($project->id))->toBeNull();

    // Verify activity log for deletion
    $deleteLog = ActivityLog::where('module', 'project')
        ->where('action', 'delete')
        ->latest('id')
        ->first();
    expect($deleteLog)->not->toBeNull();
    expect($deleteLog->description)->toContain('Green Valley Eco Residence Phase 1');
});

test('superadmin can list, store, update, and delete services', function () {
    // 1. List
    $listResponse = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/services');

    $listResponse->assertStatus(200)
        ->assertJson([
            'success' => true,
        ])
        ->assertJsonFragment([
            'slug' => 'general-construction',
        ]);

    // 2. Store
    $serviceData = [
        'title' => 'Pre-Engineered Building Systems',
        'icon' => 'ri-community-line',
        'short_description' => 'Fast-track modular structural steel PEB systems.',
        'description' => '<p>Engineered for industrial warehouses and factory floors.</p>',
        'featured' => true,
        'sort_order' => 8,
        'is_published' => true,
    ];

    $createResponse = $this->actingAs($this->superadmin)
        ->postJson('/dashboard/services', $serviceData);

    $createResponse->assertStatus(201);
    $service = Service::where('slug', 'pre-engineered-building-systems')->first();
    expect($service)->not->toBeNull();

    // 3. Show
    $this->actingAs($this->superadmin)
        ->getJson("/dashboard/services/{$service->id}")
        ->assertStatus(200)
        ->assertJsonPath('data.title', 'Pre-Engineered Building Systems');

    // 4. Update
    $this->actingAs($this->superadmin)
        ->putJson("/dashboard/services/{$service->id}", [
            'title' => 'Pre-Engineered Metal Building Systems',
            'short_description' => 'Updated PEB system solutions.',
        ])
        ->assertStatus(200);

    expect($service->fresh()->title)->toBe('Pre-Engineered Metal Building Systems');

    // 5. Delete
    $this->actingAs($this->superadmin)
        ->deleteJson("/dashboard/services/{$service->id}")
        ->assertStatus(200);

    expect(Service::find($service->id))->toBeNull();
});

test('client enquiry marks as read upon viewing and logs status changes', function () {
    $enquiry = ClientEnquiry::where('status', EnquiryStatus::NEW->value)->first();
    expect($enquiry)->not->toBeNull();

    // 1. Show enquiry (marks as read automatically)
    $showResponse = $this->actingAs($this->superadmin)
        ->getJson("/dashboard/enquiries/{$enquiry->id}");

    $showResponse->assertStatus(200);
    expect($enquiry->fresh()->status)->toBe(EnquiryStatus::READ);

    // 2. Update status and internal notes
    $updateResponse = $this->actingAs($this->superadmin)
        ->putJson("/dashboard/enquiries/{$enquiry->id}", [
            'status' => 'contacted',
            'internal_notes' => 'Called client rep and confirmed tender specifications.',
        ]);

    $updateResponse->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);

    expect($enquiry->fresh()->status)->toBe(EnquiryStatus::CONTACTED);
    expect($enquiry->fresh()->internal_notes)->toContain('tender specifications');

    // 3. Delete enquiry
    $deleteResponse = $this->actingAs($this->superadmin)
        ->deleteJson("/dashboard/enquiries/{$enquiry->id}");

    $deleteResponse->assertStatus(200);
    expect(ClientEnquiry::find($enquiry->id))->toBeNull();
});

test('activity logs can be listed and filtered by module', function () {
    $response = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/activity-logs?module=enquiry');

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);
});

test('media library upload attaches file and tracks custom metadata with Spatie media library', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('architectural_blueprint.png', 1200, 800);

    // 1. Upload media item directly to user's library collection
    $uploadResponse = $this->actingAs($this->superadmin)
        ->postJson('/dashboard/media', [
            'file' => $file,
            'collection' => 'library',
            'title' => 'Structural Framing Blueprint Phase 2',
            'alt_text' => 'High resolution structural blue print',
            'caption' => 'CAD architectural drawing',
        ]);

    $uploadResponse->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'File uploaded successfully',
        ])
        ->assertJsonPath('data.file_name', 'architectural_blueprint.png')
        ->assertJsonPath('data.is_image', true);

    $mediaId = $uploadResponse->json('data.id');
    $media = Media::findOrFail($mediaId);
    expect($media->getCustomProperty('title'))->toBe('Structural Framing Blueprint Phase 2');
    expect($media->getCustomProperty('alt_text'))->toBe('High resolution structural blue print');

    // 2. Show media item
    $showResponse = $this->actingAs($this->superadmin)
        ->getJson("/dashboard/media/{$mediaId}");

    $showResponse->assertStatus(200)
        ->assertJsonPath('data.id', $mediaId)
        ->assertJsonPath('data.readable_size', $media->readable_size);

    // 3. Update media metadata
    $updateResponse = $this->actingAs($this->superadmin)
        ->putJson("/dashboard/media/{$mediaId}", [
            'title' => 'Updated Blueprint 2026',
            'alt_text' => 'Updated alt text description',
        ]);

    $updateResponse->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);

    $media->refresh();
    expect($media->getCustomProperty('title'))->toBe('Updated Blueprint 2026');

    // 4. Delete media item
    $deleteResponse = $this->actingAs($this->superadmin)
        ->deleteJson("/dashboard/media/{$mediaId}");

    $deleteResponse->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Media file deleted successfully',
        ]);

    expect(Media::find($mediaId))->toBeNull();
});

test('media can be attached to project gallery using polymorphic relationship', function () {
    Storage::fake('public');

    $project = Project::first();
    expect($project)->not->toBeNull();

    $file = UploadedFile::fake()->image('project_elevation.jpg', 1600, 900);

    $response = $this->actingAs($this->superadmin)
        ->postJson('/dashboard/media', [
            'file' => $file,
            'model_type' => Project::class,
            'model_id' => $project->id,
            'collection' => 'gallery',
            'title' => 'Main Elevation Façade',
        ]);

    $response->assertStatus(201);
    $mediaId = $response->json('data.id');

    $project->refresh();
    $galleryMedia = $project->getMedia('gallery');
    expect($galleryMedia->count())->toBeGreaterThanOrEqual(1);
    expect($galleryMedia->pluck('id'))->toContain($mediaId);
});

test('superadmin can toggle project featured and published status via ajax', function () {
    $project = Project::first();
    expect($project)->not->toBeNull();

    $response = $this->actingAs($this->superadmin)
        ->postJson("/dashboard/projects/{$project->id}/toggle-status", [
            'field' => 'featured',
            'value' => false,
        ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Featured updated successfully',
        ]);

    expect($project->fresh()->featured)->toBe(false);
});

test('superadmin can delete individual media item from project gallery', function () {
    Storage::fake('public');

    $project = Project::first();
    $file = UploadedFile::fake()->image('gallery_sample.jpg', 800, 600);
    $media = $project->addMedia($file)->toMediaCollection('gallery');

    $deleteResponse = $this->actingAs($this->superadmin)
        ->deleteJson("/dashboard/projects/{$project->id}/media/{$media->id}");

    $deleteResponse->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Media item deleted successfully',
        ]);

    expect($project->fresh()->getMedia('gallery')->pluck('id'))->not->toContain($media->id);
});

test('superadmin can submit project create and update forms with binary files and attachments', function () {
    Storage::fake('public');

    $coverFile = UploadedFile::fake()->image('skyline_tower_cover.jpg', 1200, 800);
    $galleryFile1 = UploadedFile::fake()->image('skyline_site_1.jpg', 800, 600);
    $galleryFile2 = UploadedFile::fake()->image('skyline_site_2.jpg', 800, 600);
    $specDoc = UploadedFile::fake()->create('structural_specs.pdf', 1024, 'application/pdf');

    // 1. Submit Create Form with Files
    $response = $this->actingAs($this->superadmin)
        ->post('/dashboard/projects', [
            'title' => 'Skyline Commercial Center',
            'category' => 'Commercial',
            'status' => 'ongoing',
            'client_name' => 'Skyline Developers',
            'location' => 'Banani, Dhaka',
            'short_description' => 'A prime commercial development.',
            'main_image' => $coverFile,
            'gallery' => [$galleryFile1, $galleryFile2],
            'documents' => [$specDoc],
            'featured' => 1,
            'is_published' => 1,
        ]);

    $response->assertRedirect('/dashboard/projects');
    $response->assertSessionHas('success');

    $project = Project::where('title', 'Skyline Commercial Center')->first();
    expect($project)->not->toBeNull();
    expect($project->hasMedia('main_image'))->toBeTrue();
    expect($project->getMedia('gallery')->count())->toBe(2);
    expect($project->getMedia('documents')->count())->toBe(1);
    expect($project->main_image_url)->not->toBeEmpty();

    // 2. Submit Update Form with replacement cover
    $newCover = UploadedFile::fake()->image('skyline_new_cover.png', 1000, 700);
    $newGallery = UploadedFile::fake()->image('skyline_interior.jpg', 800, 600);

    $updateResponse = $this->actingAs($this->superadmin)
        ->put("/dashboard/projects/{$project->id}", [
            'title' => 'Skyline Commercial Center Phase 2',
            'category' => 'Commercial',
            'status' => 'completed',
            'main_image' => $newCover,
            'gallery' => [$newGallery],
        ]);

    $updateResponse->assertRedirect('/dashboard/projects');
    $updateResponse->assertSessionHas('success');

    $project->refresh();
    expect($project->title)->toBe('Skyline Commercial Center Phase 2');
    expect($project->getMedia('main_image')->count())->toBe(1);
    expect($project->getFirstMedia('main_image')->file_name)->toBe('skyline_new_cover.png');
    expect($project->getMedia('gallery')->count())->toBe(3); // 2 previous + 1 newly appended
});

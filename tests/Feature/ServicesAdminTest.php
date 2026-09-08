<?php

use App\Models\ActivityLog;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->artisan('db:seed');
    $this->superadmin = User::role('superadmin')->first();
});

test('superadmin can render services admin index, create, and edit views', function () {
    // 1. Index view
    $indexResponse = $this->actingAs($this->superadmin)->get('/dashboard/services');
    $indexResponse->assertStatus(200);
    $indexResponse->assertSee('Core Services');
    $indexResponse->assertSee('Create Service');

    // 2. Create view
    $createResponse = $this->actingAs($this->superadmin)->get('/dashboard/services/create');
    $createResponse->assertStatus(200);
    $createResponse->assertSee('New Service Details');
    $createResponse->assertSee('Icon Class');

    // 3. Edit view
    $service = Service::first();
    $editResponse = $this->actingAs($this->superadmin)->get("/dashboard/services/{$service->id}/edit");
    $editResponse->assertStatus(200);
    $editResponse->assertSee('Edit Service: ' . $service->title);
    $editResponse->assertSee('Main Service Image');
    $editResponse->assertSee('Gallery');

    // 4. Show view
    $showResponse = $this->actingAs($this->superadmin)->get("/dashboard/services/{$service->id}");
    $showResponse->assertStatus(200);
    $showResponse->assertSee('Service Details: ' . $service->title);
});

test('services index datatables ajax endpoint returns formatted columns', function () {
    $response = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/services?draw=1&start=0&length=10');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data' => [
                '*' => [
                    'id',
                    'thumbnail',
                    'title_details',
                    'short_description_text',
                    'sort_order_badge',
                    'featured_toggle',
                    'published_toggle',
                    'action-btn',
                ]
            ]
        ]);
});

test('superadmin can create a service with main image and gallery uploads', function () {
    Storage::fake('public');

    $mainImage = UploadedFile::fake()->image('civil_main.jpg', 800, 600);
    $galleryImage1 = UploadedFile::fake()->image('civil_gallery_1.jpg', 800, 600);
    $galleryImage2 = UploadedFile::fake()->image('civil_gallery_2.jpg', 800, 600);

    $response = $this->actingAs($this->superadmin)
        ->post('/dashboard/services', [
            'title' => 'Civil Infrastructure Development',
            'short_description' => 'Heavy civil and transport engineering services.',
            'description' => '<p>Specialized highway, bridge, and transit construction.</p>',
            'icon' => 'ri-road-map-line',
            'featured' => 1,
            'sort_order' => 2,
            'is_published' => 1,
            'meta_title' => 'Civil Infrastructure | Construction Co.',
            'meta_description' => 'Leading civil infrastructure engineering solutions.',
            'image' => $mainImage,
            'gallery' => [$galleryImage1, $galleryImage2],
        ]);

    $response->assertRedirect('/dashboard/services');
    $response->assertSessionHas('success');

    $service = Service::where('slug', 'civil-infrastructure-development')->first();
    expect($service)->not->toBeNull();
    expect($service->hasMedia('image'))->toBeTrue();
    expect($service->getMedia('gallery')->count())->toBe(2);
    expect($service->image_url)->not->toBeEmpty();
    expect($service->featured)->toBeTrue();
    expect($service->is_published)->toBeTrue();

    // Verify activity log
    $log = ActivityLog::where('module', 'service')
        ->where('action', 'create')
        ->where('subject_id', $service->id)
        ->first();
    expect($log)->not->toBeNull();
    expect($log->description)->toContain('Civil Infrastructure Development');
});

test('superadmin can update a service, replace main image, and append gallery media', function () {
    Storage::fake('public');

    $initialImage = UploadedFile::fake()->image('mep_initial.jpg', 600, 400);
    $service = Service::create([
        'title' => 'MEP Mechanical Systems',
        'slug' => 'mep-mechanical-systems',
        'short_description' => 'HVAC and mechanical systems.',
        'sort_order' => 5,
        'featured' => false,
        'is_published' => true,
    ]);
    $service->addMedia($initialImage)->toMediaCollection('image');

    $replacementImage = UploadedFile::fake()->image('mep_replacement.png', 800, 600);
    $newGallery = UploadedFile::fake()->image('mep_ducts.jpg', 800, 600);

    $response = $this->actingAs($this->superadmin)
        ->put("/dashboard/services/{$service->id}", [
            'title' => 'MEP Mechanical & Plumbing Systems',
            'short_description' => 'Integrated HVAC and fire suppression.',
            'image' => $replacementImage,
            'gallery' => [$newGallery],
            'featured' => 1,
        ]);

    $response->assertRedirect('/dashboard/services');
    $response->assertSessionHas('success');

    $service->refresh();
    expect($service->title)->toBe('MEP Mechanical & Plumbing Systems');
    expect($service->featured)->toBeTrue();
    expect($service->getMedia('image')->count())->toBe(1);
    expect($service->getFirstMedia('image')->file_name)->toBe('mep_replacement.png');
    expect($service->getMedia('gallery')->count())->toBe(1);

    // Verify activity log
    $log = ActivityLog::where('module', 'service')
        ->where('action', 'update')
        ->where('subject_id', $service->id)
        ->first();
    expect($log)->not->toBeNull();
});

test('superadmin can toggle featured and published status via ajax', function () {
    $service = Service::first();

    // Toggle featured
    $response = $this->actingAs($this->superadmin)
        ->postJson("/dashboard/services/{$service->id}/toggle-status", [
            'field' => 'featured',
            'value' => 1,
        ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);

    expect($service->fresh()->featured)->toBeTrue();

    // Toggle is_published
    $responsePublish = $this->actingAs($this->superadmin)
        ->postJson("/dashboard/services/{$service->id}/toggle-status", [
            'field' => 'is_published',
            'value' => 0,
        ]);

    $responsePublish->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);

    expect($service->fresh()->is_published)->toBeFalse();
});

test('superadmin can delete individual gallery photo via ajax', function () {
    Storage::fake('public');

    $service = Service::first();
    $galleryFile = UploadedFile::fake()->image('gallery_sample.jpg', 600, 400);
    $media = $service->addMedia($galleryFile)->toMediaCollection('gallery');

    expect($service->getMedia('gallery')->contains('id', $media->id))->toBeTrue();

    $response = $this->actingAs($this->superadmin)
        ->deleteJson("/dashboard/services/{$service->id}/media/{$media->id}");

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Media file removed successfully',
        ]);

    $service->refresh();
    expect($service->getMedia('gallery')->contains('id', $media->id))->toBeFalse();
});

test('superadmin can delete a service and its media collections', function () {
    Storage::fake('public');

    $service = Service::create([
        'title' => 'Temporary Demolition Service',
        'slug' => 'temporary-demolition-service',
    ]);
    $service->addMedia(UploadedFile::fake()->image('demo.jpg'))->toMediaCollection('image');

    $serviceId = $service->id;

    $response = $this->actingAs($this->superadmin)
        ->delete("/dashboard/services/{$serviceId}");

    $response->assertRedirect('/dashboard/services');
    $response->assertSessionHas('success');

    expect(Service::find($serviceId))->toBeNull();

    $log = ActivityLog::where('module', 'service')
        ->where('action', 'delete')
        ->first();
    expect($log)->not->toBeNull();
    expect($log->description)->toContain('Temporary Demolition Service');
});

test('user without permissions cannot modify services', function () {
    $guestRole = Role::firstOrCreate(['name' => 'viewer', 'guard_name' => 'web']);
    $viewerUser = User::factory()->create();
    $viewerUser->assignRole($guestRole);

    // Cannot access create
    $this->actingAs($viewerUser)
        ->get('/dashboard/services/create')
        ->assertStatus(403);

    // Cannot store
    $this->actingAs($viewerUser)
        ->post('/dashboard/services', [
            'title' => 'Unauthorized Service',
        ])
        ->assertStatus(403);

    // Cannot edit
    $service = Service::first();
    $this->actingAs($viewerUser)
        ->get("/dashboard/services/{$service->id}/edit")
        ->assertStatus(403);

    // Cannot delete
    $this->actingAs($viewerUser)
        ->delete("/dashboard/services/{$service->id}")
        ->assertStatus(403);
});

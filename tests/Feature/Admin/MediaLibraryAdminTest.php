<?php

use App\Models\ActivityLog;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->artisan('db:seed');
    Storage::fake('public');

    $this->superadmin = User::role('superadmin')->first();
    $this->unauthorizedUser = User::factory()->create();
});

test('authenticated authorized user can access media library index view', function () {
    $response = $this->actingAs($this->superadmin)->get('/dashboard/media');

    $response->assertStatus(200);
    $response->assertSee('Media Library');
    $response->assertSee('Upload Media');
});

test('unauthenticated user is redirected from media library', function () {
    $response = $this->get('/dashboard/media');

    $response->assertRedirect('/login');
});

test('unauthorized user without media permissions cannot access media library', function () {
    $this->actingAs($this->unauthorizedUser)
        ->get('/dashboard/media')
        ->assertStatus(403);
});

test('media datatables ajax endpoint returns structured columns', function () {
    $file = UploadedFile::fake()->image('scaffold_blueprint.jpg', 800, 600);
    $this->superadmin->addMedia($file)
        ->withCustomProperties(['title' => 'Scaffold Blueprint', 'uploaded_by' => $this->superadmin->id])
        ->toMediaCollection('library');

    $response = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/media?draw=1&start=0&length=10');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data' => [
                '*' => [
                    'id',
                    'preview',
                    'file_info',
                    'collection_badge',
                    'mime_badge',
                    'readable_size',
                    'uploader',
                    'created_at',
                    'action-btn',
                ]
            ]
        ]);
});

test('media can be filtered by collection, mime type, and search', function () {
    $imgFile = UploadedFile::fake()->image('crane_photo.png', 1200, 800);
    $pdfFile = UploadedFile::fake()->create('contract_spec.pdf', 500, 'application/pdf');

    $this->superadmin->addMedia($imgFile)
        ->withCustomProperties(['title' => 'Heavy Crane Asset', 'uploaded_by' => $this->superadmin->id])
        ->toMediaCollection('gallery');

    $this->superadmin->addMedia($pdfFile)
        ->withCustomProperties(['title' => 'Civil Contract Specification', 'uploaded_by' => $this->superadmin->id])
        ->toMediaCollection('documents');

    // 1. Filter by collection
    $responseGallery = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/media?draw=1&collection=gallery&start=0&length=10');
    $responseGallery->assertStatus(200);
    $dataGallery = $responseGallery->json('data');
    expect(count($dataGallery))->toBeGreaterThan(0);
    foreach ($dataGallery as $item) {
        expect($item['collection_name'])->toBe('gallery');
    }

    // 2. Filter by mime_type
    $responseImages = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/media?draw=1&mime_type=image&start=0&length=10');
    $responseImages->assertStatus(200);
    $dataImages = $responseImages->json('data');
    expect(count($dataImages))->toBeGreaterThan(0);
    foreach ($dataImages as $item) {
        expect($item['mime_type'])->toContain('image/');
    }

    // 3. Filter by search
    $responseSearch = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/media?draw=1&search=crane_photo&start=0&length=10');
    $responseSearch->assertStatus(200);
    $dataSearch = $responseSearch->json('data');
    expect(count($dataSearch))->toBe(1);
    expect($dataSearch[0]['file_name'])->toBe('crane_photo.png');
});

test('authorized user can upload single media file with custom metadata and activity logging', function () {
    $file = UploadedFile::fake()->image('foundation_beam.webp', 1920, 1080);

    $response = $this->actingAs($this->superadmin)
        ->postJson('/dashboard/media', [
            'file' => $file,
            'collection' => 'library',
            'title' => 'Reinforced Foundation Beam',
            'alt_text' => 'Close up shot of reinforced beam',
            'caption' => 'Phase 1 ground construction work',
        ]);

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
        ]);

    $mediaId = $response->json('data.id');
    $media = Media::findOrFail($mediaId);

    expect($media->collection_name)->toBe('library');
    expect($media->title)->toBe('Reinforced Foundation Beam');
    expect($media->alt_text)->toBe('Close up shot of reinforced beam');
    expect($media->caption)->toBe('Phase 1 ground construction work');
    expect($media->getCustomProperty('uploaded_by'))->toBe($this->superadmin->id);

    // Verify activity log
    $log = ActivityLog::where('module', 'media')
        ->where('action', 'upload')
        ->where('subject_id', $mediaId)
        ->first();

    expect($log)->not->toBeNull();
    expect($log->description)->toContain('foundation_beam.webp');
});

test('authorized user can upload multiple media files simultaneously', function () {
    $file1 = UploadedFile::fake()->image('site_drone_1.jpg');
    $file2 = UploadedFile::fake()->image('site_drone_2.jpg');

    $response = $this->actingAs($this->superadmin)
        ->postJson('/dashboard/media', [
            'files' => [$file1, $file2],
            'collection' => 'gallery',
        ]);

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'count' => 2,
        ]);

    expect(Media::where('collection_name', 'gallery')->count())->toBeGreaterThanOrEqual(2);
});

test('upload rejects invalid file types or oversized files', function () {
    $invalidFile = UploadedFile::fake()->create('malicious_script.exe', 100, 'application/x-msdownload');

    $response = $this->actingAs($this->superadmin)
        ->postJson('/dashboard/media', [
            'file' => $invalidFile,
        ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['file']);
});

test('authorized user can view media details via show endpoint', function () {
    $file = UploadedFile::fake()->image('tower_facade.png', 1024, 768);
    $media = $this->superadmin->addMedia($file)
        ->withCustomProperties([
            'title' => 'Tower Facade Glass',
            'alt_text' => 'Reflective glass panels on facade',
            'uploaded_by' => $this->superadmin->id,
        ])
        ->toMediaCollection('library');

    $response = $this->actingAs($this->superadmin)
        ->getJson("/dashboard/media/{$media->id}");

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => [
                'id' => $media->id,
                'file_name' => 'tower_facade.png',
                'title' => 'Tower Facade Glass',
                'alt_text' => 'Reflective glass panels on facade',
                'collection_name' => 'library',
            ]
        ]);
});

test('authorized user can update media metadata and log changes', function () {
    $file = UploadedFile::fake()->image('concrete_pour.jpg');
    $media = $this->superadmin->addMedia($file)
        ->withCustomProperties(['title' => 'Initial Title'])
        ->toMediaCollection('library');

    $response = $this->actingAs($this->superadmin)
        ->putJson("/dashboard/media/{$media->id}", [
            'title' => 'Updated Concrete Pouring Stage 3',
            'alt_text' => 'Workers pouring concrete onto slab',
            'caption' => 'High quality commercial grade mix',
        ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);

    $media->refresh();
    expect($media->title)->toBe('Updated Concrete Pouring Stage 3');
    expect($media->alt_text)->toBe('Workers pouring concrete onto slab');
    expect($media->caption)->toBe('High quality commercial grade mix');

    // Verify activity log
    $log = ActivityLog::where('module', 'media')
        ->where('action', 'update')
        ->where('subject_id', $media->id)
        ->latest('id')
        ->first();

    expect($log)->not->toBeNull();
    expect($log->description)->toContain('Updated metadata for media');
});

test('authorized user can delete media and log activity', function () {
    $file = UploadedFile::fake()->image('temp_discard.jpg');
    $media = $this->superadmin->addMedia($file)->toMediaCollection('library');
    $mediaId = $media->id;

    $response = $this->actingAs($this->superadmin)
        ->deleteJson("/dashboard/media/{$mediaId}");

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);

    expect(Media::find($mediaId))->toBeNull();

    // Verify activity log
    $log = ActivityLog::where('module', 'media')
        ->where('action', 'delete')
        ->latest('id')
        ->first();

    expect($log)->not->toBeNull();
    expect($log->description)->toContain('Deleted media file');
});

test('unauthorized user cannot upload, edit, or delete media', function () {
    $file = UploadedFile::fake()->image('secret.png');
    $media = $this->superadmin->addMedia($file)->toMediaCollection('library');

    // 1. Upload attempt
    $this->actingAs($this->unauthorizedUser)
        ->postJson('/dashboard/media', [
            'file' => UploadedFile::fake()->image('unauth.png'),
        ])
        ->assertStatus(403);

    // 2. Edit attempt
    $this->actingAs($this->unauthorizedUser)
        ->putJson("/dashboard/media/{$media->id}", [
            'title' => 'Unauthorized Hack',
        ])
        ->assertStatus(403);

    // 3. Delete attempt
    $this->actingAs($this->unauthorizedUser)
        ->deleteJson("/dashboard/media/{$media->id}")
        ->assertStatus(403);

    expect(Media::find($media->id))->not->toBeNull();
});

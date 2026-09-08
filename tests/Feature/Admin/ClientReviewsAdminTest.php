<?php

use App\Models\ActivityLog;
use App\Models\ClientReview;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->artisan('db:seed');
    Storage::fake('public');

    $this->superadmin = User::role('superadmin')->first();
    $this->unauthorizedUser = User::factory()->create();

    $this->project = Project::first() ?? Project::create([
        'title' => 'Metropolis Financial Center',
        'slug' => 'metropolis-financial-center',
        'location' => 'Financial District, City Center',
        'status' => 'completed',
        'created_by' => $this->superadmin->id,
    ]);
});

test('authorized user can render review index, create, edit, and show views', function () {
    // 1. Index
    $this->actingAs($this->superadmin)
        ->get('/dashboard/client-reviews')
        ->assertStatus(200)
        ->assertSee('Client Reviews &amp; Testimonials', false)
        ->assertSee('Add Review');

    // 2. Create
    $this->actingAs($this->superadmin)
        ->get('/dashboard/client-reviews/create')
        ->assertStatus(200)
        ->assertSee('New Client Review')
        ->assertSee('Client Testimonial / Feedback');

    // 3. Create dummy review
    $review = ClientReview::create([
        'client_name' => 'Jonathan Sterling',
        'designation' => 'Executive Vice President',
        'company_name' => 'Sterling Real Estate Group',
        'review' => 'Exceptional structural engineering and immaculate delivery schedule.',
        'rating' => 5,
        'project_id' => $this->project->id,
        'featured' => true,
        'is_published' => true,
        'sort_order' => 1,
        'created_by' => $this->superadmin->id,
    ]);

    // 4. Show
    $this->actingAs($this->superadmin)
        ->get("/dashboard/client-reviews/{$review->id}")
        ->assertStatus(200)
        ->assertSee('Jonathan Sterling')
        ->assertSee('Sterling Real Estate Group')
        ->assertSee('5.0 / 5.0 Rating');

    // 5. Edit
    $this->actingAs($this->superadmin)
        ->get("/dashboard/client-reviews/{$review->id}/edit")
        ->assertStatus(200)
        ->assertSee('Edit Client Review')
        ->assertSee('Jonathan Sterling');
});

test('unauthenticated user is redirected from review routes', function () {
    $this->get('/dashboard/client-reviews')->assertRedirect('/login');
    $this->get('/dashboard/client-reviews/create')->assertRedirect('/login');
});

test('unauthorized user without permissions cannot access client reviews', function () {
    $this->actingAs($this->unauthorizedUser)
        ->get('/dashboard/client-reviews')
        ->assertStatus(403);
});

test('client reviews datatables ajax endpoint returns formatted columns', function () {
    $review = ClientReview::create([
        'client_name' => 'Victoria Vance',
        'designation' => 'Principal Architect',
        'company_name' => 'Vance Design Studios',
        'review' => 'Flawless steel fabrication and seismic damping installation.',
        'rating' => 5,
        'is_published' => true,
        'created_by' => $this->superadmin->id,
    ]);

    $response = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/client-reviews?draw=1&start=0&length=10');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data' => [
                '*' => [
                    'id',
                    'avatar',
                    'client_details',
                    'review_snippet',
                    'rating_badge',
                    'featured_toggle',
                    'published_toggle',
                    'action-btn',
                ]
            ]
        ]);
});

test('client reviews index can be filtered by rating, visibility, and project', function () {
    $customProject = Project::create([
        'title' => 'Special Filter Project',
        'slug' => 'special-filter-project',
        'category' => 'Commercial',
        'location' => 'Sector 7, Uttara',
        'status' => 'ongoing',
        'created_by' => $this->superadmin->id,
    ]);

    $r1 = ClientReview::create([
        'client_name' => 'Elena Rostova Unique',
        'review' => 'Top tier industrial safety compliance.',
        'rating' => 2,
        'project_id' => $customProject->id,
        'is_published' => true,
        'featured' => true,
        'created_by' => $this->superadmin->id,
    ]);

    $r2 = ClientReview::create([
        'client_name' => 'Marcus Brody Unique',
        'review' => 'Draft review awaiting verification.',
        'rating' => 1,
        'project_id' => null,
        'is_published' => false,
        'featured' => false,
        'created_by' => $this->superadmin->id,
    ]);

    // 1. Filter by rating
    $resRating = $this->actingAs($this->superadmin)
        ->getJson("/dashboard/client-reviews?draw=1&rating=2&start=0&length=10");
    $dataRating = $resRating->json('data');
    expect(count($dataRating))->toBe(1);

    // 2. Filter by visibility (draft)
    $resDraft = $this->actingAs($this->superadmin)
        ->getJson("/dashboard/client-reviews?draw=1&status=0&start=0&length=10");
    expect(count($resDraft->json('data')))->toBeGreaterThanOrEqual(1);

    // 3. Filter by project
    $resProject = $this->actingAs($this->superadmin)
        ->getJson("/dashboard/client-reviews?draw=1&project_id={$customProject->id}&start=0&length=10");
    expect(count($resProject->json('data')))->toBe(1);
});

test('authorized user can store a client review with photo and activity log', function () {
    $photo = UploadedFile::fake()->image('client_avatar.jpg', 400, 400);

    $response = $this->actingAs($this->superadmin)
        ->post('/dashboard/client-reviews', [
            'client_name' => 'Arthur Pendelton',
            'designation' => 'Chief Infrastructure Director',
            'company_name' => 'Apex Transit Authority',
            'review' => 'Superb project management and precision foundation engineering throughout the multi-stage rollout.',
            'rating' => 5,
            'project_id' => $this->project->id,
            'is_published' => '1',
            'featured' => '1',
            'sort_order' => 2,
            'client_photo' => $photo,
        ]);

    $response->assertRedirect(route('client-reviews.index'));

    $review = ClientReview::where('client_name', 'Arthur Pendelton')->first();
    expect($review)->not->toBeNull();
    expect($review->company_name)->toBe('Apex Transit Authority');
    expect($review->rating)->toBe(5);
    expect($review->hasMedia('client_photo'))->toBeTrue();

    // Verify activity log
    $log = ActivityLog::where('module', 'client-review')
        ->where('action', 'create')
        ->where('subject_id', $review->id)
        ->first();

    expect($log)->not->toBeNull();
});

test('storing client review validates rating range and required fields', function () {
    // 1. Rating out of bounds (> 5)
    $res1 = $this->actingAs($this->superadmin)
        ->postJson('/dashboard/client-reviews', [
            'client_name' => 'Invalid Rating User',
            'review' => 'Some review text here',
            'rating' => 6,
        ]);
    $res1->assertStatus(422)->assertJsonValidationErrors(['rating']);

    // 2. Rating less than 1
    $res2 = $this->actingAs($this->superadmin)
        ->postJson('/dashboard/client-reviews', [
            'client_name' => 'Zero Rating User',
            'review' => 'Some review text here',
            'rating' => 0,
        ]);
    $res2->assertStatus(422)->assertJsonValidationErrors(['rating']);

    // 3. Missing required client_name & review
    $res3 = $this->actingAs($this->superadmin)
        ->postJson('/dashboard/client-reviews', [
            'rating' => 5,
        ]);
    $res3->assertStatus(422)->assertJsonValidationErrors(['client_name', 'review']);
});

test('authorized user can update a client review and replace photo', function () {
    $review = ClientReview::create([
        'client_name' => 'Original Reviewer Name',
        'designation' => 'Project Lead',
        'company_name' => 'Original Firm',
        'review' => 'Initial preliminary feedback.',
        'rating' => 4,
        'is_published' => true,
        'created_by' => $this->superadmin->id,
    ]);

    $newPhoto = UploadedFile::fake()->image('updated_avatar.png', 500, 500);

    $response = $this->actingAs($this->superadmin)
        ->put("/dashboard/client-reviews/{$review->id}", [
            'client_name' => 'Updated Reviewer Name',
            'designation' => 'Director of Construction',
            'company_name' => 'Global Logistics Hub',
            'review' => 'Updated comprehensive testimonial on seismic testing and quality.',
            'rating' => 5,
            'is_published' => '1',
            'featured' => '1',
            'client_photo' => $newPhoto,
        ]);

    $response->assertRedirect(route('client-reviews.index'));

    $review->refresh();
    expect($review->client_name)->toBe('Updated Reviewer Name');
    expect($review->rating)->toBe(5);
    expect($review->hasMedia('client_photo'))->toBeTrue();

    $log = ActivityLog::where('module', 'client-review')
        ->where('action', 'update')
        ->where('subject_id', $review->id)
        ->first();

    expect($log)->not->toBeNull();
});

test('authorized user can toggle review visibility and featured state via ajax', function () {
    $review = ClientReview::create([
        'client_name' => 'Toggle Test Reviewer',
        'review' => 'Testimonial for AJAX toggles test.',
        'rating' => 5,
        'is_published' => true,
        'featured' => false,
        'created_by' => $this->superadmin->id,
    ]);

    // 1. Toggle visibility
    $resStatus = $this->actingAs($this->superadmin)
        ->postJson("/dashboard/client-reviews/{$review->id}/toggle-status", [
            'field' => 'is_published',
            'value' => false,
        ]);
    $resStatus->assertStatus(200)->assertJson(['success' => true]);
    $review->refresh();
    expect($review->is_published)->toBeFalse();

    // 2. Toggle featured
    $resFeatured = $this->actingAs($this->superadmin)
        ->postJson("/dashboard/client-reviews/{$review->id}/toggle-status", [
            'field' => 'featured',
            'value' => true,
        ]);
    $resFeatured->assertStatus(200)->assertJson(['success' => true]);
    $review->refresh();
    expect($review->featured)->toBeTrue();
});

test('authorized user can delete review and media is cleaned up', function () {
    $review = ClientReview::create([
        'client_name' => 'Deletable Client',
        'review' => 'Review to be deleted completely.',
        'rating' => 5,
        'created_by' => $this->superadmin->id,
    ]);

    $response = $this->actingAs($this->superadmin)
        ->deleteJson("/dashboard/client-reviews/{$review->id}");

    $response->assertStatus(200)
        ->assertJson(['success' => true]);

    expect(ClientReview::find($review->id))->toBeNull();

    $log = ActivityLog::where('module', 'client-review')
        ->where('action', 'delete')
        ->first();

    expect($log)->not->toBeNull();
});

test('unauthorized user cannot delete client review', function () {
    $review = ClientReview::create([
        'client_name' => 'Protected Client',
        'review' => 'Should not be deleted by unauthorized user.',
        'rating' => 5,
        'created_by' => $this->superadmin->id,
    ]);

    $this->actingAs($this->unauthorizedUser)
        ->deleteJson("/dashboard/client-reviews/{$review->id}")
        ->assertStatus(403);

    expect(ClientReview::find($review->id))->not->toBeNull();
});

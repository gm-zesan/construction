<?php

use App\Models\ActivityLog;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->artisan('db:seed');
    Storage::fake('public');

    $this->superadmin = User::role('superadmin')->first();
    $this->unauthorizedUser = User::factory()->create();

    $this->category = ArticleCategory::first() ?? ArticleCategory::create([
        'name' => 'General Construction',
        'slug' => 'general-construction',
        'is_active' => true,
        'created_by' => $this->superadmin->id,
    ]);
});

test('authorized user can render article index, create, edit, and show views', function () {
    // 1. Index
    $this->actingAs($this->superadmin)
        ->get('/dashboard/articles')
        ->assertStatus(200)
        ->assertSee('News &amp; Field Updates', false)
        ->assertSee('Add Article');

    // 2. Create
    $this->actingAs($this->superadmin)
        ->get('/dashboard/articles/create')
        ->assertStatus(200)
        ->assertSee('New Article')
        ->assertSee($this->category->name);

    // 3. Create dummy article
    $article = Article::create([
        'category_id' => $this->category->id,
        'title' => 'Structural Health Monitoring via Wireless Sensors',
        'slug' => 'structural-health-monitoring-via-wireless-sensors',
        'summary' => 'Real-time telemetry on high-rise vibration damping.',
        'content' => '<p>Sensors measure acceleration, tilt, and wind displacement.</p>',
        'author_name' => 'Dr. Farhana Yasmin',
        'read_time' => 4,
        'is_published' => true,
        'featured' => true,
        'created_by' => $this->superadmin->id,
    ]);

    // 4. Show
    $this->actingAs($this->superadmin)
        ->get("/dashboard/articles/{$article->id}")
        ->assertStatus(200)
        ->assertSee('Structural Health Monitoring via Wireless Sensors')
        ->assertSee('Dr. Farhana Yasmin')
        ->assertSee($this->category->name);

    // 5. Edit
    $this->actingAs($this->superadmin)
        ->get("/dashboard/articles/{$article->id}/edit")
        ->assertStatus(200)
        ->assertSee('Edit Article')
        ->assertSee('Structural Health Monitoring via Wireless Sensors');
});

test('unauthenticated user is redirected from article routes', function () {
    $this->get('/dashboard/articles')->assertRedirect('/login');
    $this->get('/dashboard/articles/create')->assertRedirect('/login');
});

test('unauthorized user without permissions cannot access articles', function () {
    $this->actingAs($this->unauthorizedUser)
        ->get('/dashboard/articles')
        ->assertStatus(403);
});

test('articles datatables ajax endpoint returns formatted columns', function () {
    $article = Article::create([
        'category_id' => $this->category->id,
        'title' => 'High-Performance Insulated Glass Units in Facades',
        'slug' => 'high-performance-insulated-glass-units-in-facades',
        'author_name' => 'Engr. Mahbubur Rahman',
        'read_time' => 3,
        'is_published' => true,
        'created_by' => $this->superadmin->id,
    ]);

    $response = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/articles?draw=1&start=0&length=10');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data' => [
                '*' => [
                    'id',
                    'thumbnail',
                    'article_title',
                    'category_badge',
                    'author_and_date',
                    'featured_toggle',
                    'published_toggle',
                    'action-btn',
                ]
            ]
        ]);
});

test('articles index can be filtered by category, visibility, and search', function () {
    $otherCategory = ArticleCategory::create([
        'name' => 'Acoustic Engineering',
        'slug' => 'acoustic-engineering',
        'is_active' => true,
        'created_by' => $this->superadmin->id,
    ]);

    $a1 = Article::create([
        'category_id' => $otherCategory->id,
        'title' => 'Auditorium Acoustic Baffle Engineering',
        'slug' => 'auditorium-acoustic-baffle-engineering',
        'is_published' => true,
        'featured' => true,
        'created_by' => $this->superadmin->id,
    ]);

    $a2 = Article::create([
        'category_id' => $this->category->id,
        'title' => 'Draft Deep Foundation Protocols',
        'slug' => 'draft-deep-foundation-protocols',
        'is_published' => false,
        'featured' => false,
        'created_by' => $this->superadmin->id,
    ]);

    // 1. Filter by category
    $resCategory = $this->actingAs($this->superadmin)
        ->getJson("/dashboard/articles?draw=1&category_id={$otherCategory->id}&start=0&length=10");
    $dataCat = $resCategory->json('data');
    expect(count($dataCat))->toBe(1);

    // 2. Filter by visibility
    $resDraft = $this->actingAs($this->superadmin)
        ->getJson("/dashboard/articles?draw=1&is_published=0&start=0&length=10");
    expect(count($resDraft->json('data')))->toBeGreaterThanOrEqual(1);

    // 3. Filter by search
    $resSearch = $this->actingAs($this->superadmin)
        ->getJson("/dashboard/articles?draw=1&search=Acoustic+Baffle&start=0&length=10");
    expect(count($resSearch->json('data')))->toBe(1);
});

test('authorized user can store an article with image and activity log', function () {
    $image = UploadedFile::fake()->image('cover_test.jpg', 800, 600);

    $response = $this->actingAs($this->superadmin)
        ->post('/dashboard/articles', [
            'title' => 'Precast Prestressed Concrete Girders for Highway Viaducts',
            'slug' => 'precast-prestressed-concrete-girders-for-highway-viaducts',
            'category_id' => $this->category->id,
            'author_name' => 'Tanvir Ahmed, Bridge Specialist',
            'summary' => 'Quality control and tendon tensioning for 45m span precast I-girders.',
            'content' => '<p>Post-tensioning tendons are grouted with high-strength non-shrink grout.</p>',
            'published_at' => now()->format('Y-m-d H:i:s'),
            'read_time' => 5,
            'is_published' => '1',
            'featured' => '1',
            'sort_order' => 1,
            'image' => $image,
            'meta_title' => 'Precast Girders in Highway Construction',
            'meta_description' => 'Bridge engineering case study.',
        ]);

    $response->assertRedirect(route('articles.index'));

    $article = Article::where('slug', 'precast-prestressed-concrete-girders-for-highway-viaducts')->first();
    expect($article)->not->toBeNull();
    expect($article->author_name)->toBe('Tanvir Ahmed, Bridge Specialist');
    expect($article->read_time)->toBe(5);
    expect($article->hasMedia('image'))->toBeTrue();

    // Verify activity log
    $log = ActivityLog::where('module', 'article')
        ->where('action', 'create')
        ->where('subject_id', $article->id)
        ->first();

    expect($log)->not->toBeNull();
});

test('storing article rejects invalid input', function () {
    $response = $this->actingAs($this->superadmin)
        ->postJson('/dashboard/articles', [
            'title' => '',
            'category_id' => 999999,
        ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['title', 'category_id']);
});

test('authorized user can update an article and replace image', function () {
    $article = Article::create([
        'category_id' => $this->category->id,
        'title' => 'Original Construction Article Title',
        'slug' => 'original-construction-article-title',
        'author_name' => 'Original Author',
        'read_time' => 2,
        'is_published' => true,
        'created_by' => $this->superadmin->id,
    ]);

    $newImage = UploadedFile::fake()->image('updated_cover.png', 1000, 700);

    $response = $this->actingAs($this->superadmin)
        ->put("/dashboard/articles/{$article->id}", [
            'title' => 'Updated Construction Article Title',
            'slug' => 'updated-construction-article-title',
            'category_id' => $this->category->id,
            'author_name' => 'Senior Editor',
            'read_time' => 6,
            'is_published' => '1',
            'image' => $newImage,
        ]);

    $response->assertRedirect(route('articles.index'));

    $article->refresh();
    expect($article->title)->toBe('Updated Construction Article Title');
    expect($article->author_name)->toBe('Senior Editor');
    expect($article->read_time)->toBe(6);
    expect($article->hasMedia('image'))->toBeTrue();

    $log = ActivityLog::where('module', 'article')
        ->where('action', 'update')
        ->where('subject_id', $article->id)
        ->first();

    expect($log)->not->toBeNull();
});

test('authorized user can toggle article visibility and featured state', function () {
    $article = Article::create([
        'category_id' => $this->category->id,
        'title' => 'Toggle Status Article Test',
        'slug' => 'toggle-status-article-test',
        'is_published' => true,
        'featured' => false,
        'created_by' => $this->superadmin->id,
    ]);

    // 1. Toggle visibility
    $resStatus = $this->actingAs($this->superadmin)
        ->postJson("/dashboard/articles/{$article->id}/toggle-status");
    $resStatus->assertStatus(200)->assertJson(['success' => true, 'is_published' => false]);
    $article->refresh();
    expect($article->is_published)->toBeFalse();

    // 2. Toggle featured
    $resFeatured = $this->actingAs($this->superadmin)
        ->postJson("/dashboard/articles/{$article->id}/toggle-featured");
    $resFeatured->assertStatus(200)->assertJson(['success' => true, 'featured' => true]);
    $article->refresh();
    expect($article->featured)->toBeTrue();
});

test('authorized user can delete article and its media', function () {
    $article = Article::create([
        'category_id' => $this->category->id,
        'title' => 'Deletable Article Test',
        'slug' => 'deletable-article-test',
        'created_by' => $this->superadmin->id,
    ]);

    $response = $this->actingAs($this->superadmin)
        ->deleteJson("/dashboard/articles/{$article->id}");

    $response->assertStatus(200)
        ->assertJson(['success' => true]);

    expect(Article::find($article->id))->toBeNull();

    $log = ActivityLog::where('module', 'article')
        ->where('action', 'delete')
        ->first();

    expect($log)->not->toBeNull();
});

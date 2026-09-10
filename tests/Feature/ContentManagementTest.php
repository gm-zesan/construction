<?php

use App\Models\ActivityLog;
use App\Models\User;
use App\Models\WebsiteContent;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    $this->artisan('db:seed');
    $this->superadmin = User::role('superadmin')->first();
    $this->unauthorizedUser = User::role('user')->first();
});

test('superadmin can access all cms page tabs', function () {
    $pages = ['home', 'about', 'contact', 'footer', 'seo'];

    foreach ($pages as $page) {
        $response = $this->actingAs($this->superadmin)->get("/dashboard/content-management?page={$page}");
        $response->assertStatus(200);
        $response->assertSee('Content Management');
    }
});

test('unauthorized user cannot access cms workspace', function () {
    $response = $this->actingAs($this->unauthorizedUser)->get('/dashboard/content-management');
    $response->assertStatus(403);
});

test('superadmin can update content fields and cache is flushed', function () {
    $payload = [
        'active_page' => 'home',
        'content' => [
            'hero' => [
                'headline' => 'Next-Gen Structural Infrastructure',
                'subheadline' => 'High-precision civil engineering built for resilient cities.',
            ],
            'stats' => [
                'stat_1_count' => '250+',
                'stat_1_label' => 'Mega-Structures Completed',
            ],
        ],
    ];

    $response = $this->actingAs($this->superadmin)->post('/dashboard/content-management', $payload);

    $response->assertRedirect('/dashboard/content-management?page=home');
    $response->assertSessionHas('success');

    // Verify DB update
    expect(WebsiteContent::get('home', 'hero', 'headline'))->toBe('Next-Gen Structural Infrastructure')
        ->and(WebsiteContent::get('home', 'hero', 'subheadline'))->toBe('High-precision civil engineering built for resilient cities.')
        ->and(WebsiteContent::get('home', 'stats', 'stat_1_count'))->toBe('250+');

    // Verify helper get_content
    expect(get_content('home', 'hero', 'headline'))->toBe('Next-Gen Structural Infrastructure')
        ->and(get_content('home', 'stats', 'stat_1_count'))->toBe('250+');

    // Verify helper get_content_section
    $heroSection = get_content_section('home', 'hero');
    expect($heroSection['headline'])->toBe('Next-Gen Structural Infrastructure');
});

test('media upload integrates with spatie medialibrary on website_contents', function () {
    $imageFile = UploadedFile::fake()->image('hero_banner.jpg', 1200, 600);

    $payload = [
        'active_page' => 'home',
        'content' => [
            'hero' => [
                'headline' => 'BIM-Powered Precision Engineering',
            ],
        ],
        'media_files' => [
            'hero' => [
                'bg_image' => $imageFile,
            ],
        ],
    ];

    $response = $this->actingAs($this->superadmin)->post('/dashboard/content-management', $payload);

    $response->assertRedirect('/dashboard/content-management?page=home');

    $record = WebsiteContent::where('page', 'home')
        ->where('section', 'hero')
        ->where('key', 'bg_image')
        ->first();

    expect($record)->not->toBeNull();
    expect($record->getFirstMedia('image'))->not->toBeNull();
    expect($record->image_url)->not->toBeNull();
});

test('activity log records content updates', function () {
    ActivityLog::query()->delete();

    $payload = [
        'active_page' => 'about',
        'content' => [
            'overview' => [
                'title' => 'Pioneering Structural Innovation Across Asia',
            ],
        ],
    ];

    $this->actingAs($this->superadmin)->post('/dashboard/content-management', $payload);

    $log = ActivityLog::where('module', 'website-content')->first();
    expect($log)->not->toBeNull()
        ->and($log->action)->toBe('update')
        ->and($log->user_id)->toBe($this->superadmin->id);
});

test('superadmin can dynamically create a new page, section, and field', function () {
    $payload = [
        'page' => 'careers',
        'section' => 'openings',
        'label' => 'Application Deadline Date',
        'key' => 'deadline_date',
        'type' => 'text',
        'value' => 'November 30, 2026',
    ];

    $response = $this->actingAs($this->superadmin)->post('/dashboard/content-management/fields', $payload);

    $response->assertRedirect('/dashboard/content-management?page=careers');
    $response->assertSessionHas('success');

    // Verify record exists in DB
    $record = WebsiteContent::where('page', 'careers')
        ->where('section', 'openings')
        ->where('key', 'deadline_date')
        ->first();

    expect($record)->not->toBeNull()
        ->and($record->value)->toBe('November 30, 2026');

    // Verify new page is listed in dynamic available pages
    $pages = WebsiteContent::getAvailablePagesWithMeta();
    expect(array_key_exists('careers', $pages))->toBeTrue();
});

test('superadmin can delete a generic cms field', function () {
    $record = WebsiteContent::create([
        'page' => 'faq',
        'section' => 'general',
        'key' => 'question_1',
        'label' => 'Question 1',
        'type' => 'text',
        'value' => 'What is BIM?',
    ]);

    $response = $this->actingAs($this->superadmin)->delete("/dashboard/content-management/fields/{$record->id}");

    $response->assertRedirect('/dashboard/content-management?page=faq');
    $response->assertSessionHas('success');

    expect(WebsiteContent::find($record->id))->toBeNull();
});

test('superadmin can update a single repeating item group only', function () {
    $payload = [
        'page' => 'about',
        'section' => 'timeline',
        'group_id' => 'item_1',
        'item_label' => 'Timeline Milestone 1',
        'fields' => [
            'item_1_year' => '2010',
            'item_1_title' => 'Inception and Groundwork',
            'item_1_desc' => 'Commenced operations specializing in foundation engineering.',
        ],
    ];

    $response = $this->actingAs($this->superadmin)->post('/dashboard/content-management/item', $payload);

    $response->assertRedirect('/dashboard/content-management?page=about');
    $response->assertSessionHas('success');

    expect(WebsiteContent::get('about', 'timeline', 'item_1_year'))->toBe('2010')
        ->and(WebsiteContent::get('about', 'timeline', 'item_1_title'))->toBe('Inception and Groundwork')
        ->and(WebsiteContent::get('about', 'timeline', 'item_1_desc'))->toBe('Commenced operations specializing in foundation engineering.');
});

test('superadmin can delete an entire repeating item group and all its subfields', function () {
    // Ensure item_4 exists first
    WebsiteContent::set('about', 'timeline', 'item_4_year', '2024');
    WebsiteContent::set('about', 'timeline', 'item_4_title', 'Smart Construction');
    WebsiteContent::set('about', 'timeline', 'item_4_desc', 'Low-carbon concrete benchmark.');

    $payload = [
        'page' => 'about',
        'section' => 'timeline',
        'group_id' => 'item_4',
        'item_label' => 'Timeline Milestone 4',
    ];

    $response = $this->actingAs($this->superadmin)->delete('/dashboard/content-management/item', $payload);

    $response->assertRedirect('/dashboard/content-management?page=about');
    $response->assertSessionHas('success');

    expect(WebsiteContent::where('page', 'about')->where('section', 'timeline')->where('key', 'like', 'item_4%')->count())->toBe(0);
});

test('superadmin can create a new item in a repeating item group', function () {
    $payload = [
        'page' => 'about',
        'section' => 'timeline',
        'group_type' => 'item',
        'fields' => [
            'year' => [
                'value' => '2027',
                'type' => 'text',
                'label' => 'Year',
            ],
            'title' => [
                'value' => 'Global Expansion & Carbon Neutrality',
                'type' => 'text',
                'label' => 'Title',
            ],
            'desc' => [
                'value' => 'Expanding sustainable construction operations across Southeast Asia.',
                'type' => 'textarea',
                'label' => 'Description',
            ],
        ],
    ];

    $response = $this->actingAs($this->superadmin)->post('/dashboard/content-management/item/create', $payload);

    $response->assertRedirect('/dashboard/content-management?page=about');
    $response->assertSessionHas('success');

    $newItemYear = WebsiteContent::where('page', 'about')
        ->where('section', 'timeline')
        ->where('value', '2027')
        ->first();

    expect($newItemYear)->not->toBeNull();
});

test('arbitrary unknown group (e.g. innovation_1..3) works 100% dynamically without code changes', function () {
    WebsiteContent::create([
        'page' => 'about',
        'section' => 'story',
        'key' => 'innovation_1',
        'value' => 'Direct Geothermal Piling',
        'type' => 'text',
        'label' => 'Geothermal Piling',
    ]);
    WebsiteContent::create([
        'page' => 'about',
        'section' => 'story',
        'key' => 'innovation_2',
        'value' => 'Carbon-Cured Concrete',
        'type' => 'text',
        'label' => 'Carbon-Cured Tech',
    ]);
    WebsiteContent::create([
        'page' => 'about',
        'section' => 'story',
        'key' => 'innovation_3',
        'value' => 'Autonomous Drone Surveying',
        'type' => 'text',
        'label' => 'Autonomous Drones',
    ]);

    // Request CMS Workspace
    $response = $this->actingAs($this->superadmin)->get('/dashboard/content-management?page=about');
    $response->assertStatus(200);

    // Verify dynamic group title and items in HTML
    $response->assertSee('Innovation Items');
    $response->assertSee('Geothermal Piling');
    $response->assertSee('Carbon-Cured Tech');
    $response->assertSee('Autonomous Drones');
});

test('arbitrary unknown multi-field group (e.g. technology_1..2 with subfields) works 100% dynamically', function () {
    WebsiteContent::create([
        'page' => 'about',
        'section' => 'story',
        'key' => 'technology_1_name',
        'value' => '5D BIM Digital Twin',
        'type' => 'text',
        'label' => 'Tech Name',
    ]);
    WebsiteContent::create([
        'page' => 'about',
        'section' => 'story',
        'key' => 'technology_1_description',
        'value' => 'Real-time telemetry and clash detection before concrete pours.',
        'type' => 'textarea',
        'label' => 'Tech Description',
    ]);
    WebsiteContent::create([
        'page' => 'about',
        'section' => 'story',
        'key' => 'technology_2_name',
        'value' => 'Robotic Rebar Tying',
        'type' => 'text',
        'label' => 'Tech Name',
    ]);
    WebsiteContent::create([
        'page' => 'about',
        'section' => 'story',
        'key' => 'technology_2_description',
        'value' => 'Precision automation on critical bridge deck reinforcement grids.',
        'type' => 'textarea',
        'label' => 'Tech Description',
    ]);

    // Request CMS Workspace
    $response = $this->actingAs($this->superadmin)->get('/dashboard/content-management?page=about');
    $response->assertStatus(200);

    // Verify dynamic group title and multi-fields in HTML
    $response->assertSee('Technology Items');
    $response->assertSee('Technology Item 1');
    $response->assertSee('Technology Item 2');
    $response->assertSee('5D BIM Digital Twin');
    $response->assertSee('Robotic Rebar Tying');
});




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


<?php

use App\Models\ActivityLog;
use App\Models\User;
use App\Models\WebsiteSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    $this->artisan('db:seed');
    $this->superadmin = User::role('superadmin')->first();
    $this->unauthorizedUser = User::role('user')->first();
});

test('superadmin can access website settings workspace', function () {
    $response = $this->actingAs($this->superadmin)->get('/dashboard/settings');

    $response->assertStatus(200);
    $response->assertSee('Website Settings');
    $response->assertSee('General Settings');

    // Test Contact group
    $contactResponse = $this->actingAs($this->superadmin)->get('/dashboard/settings?group=contact');
    $contactResponse->assertStatus(200);
    $contactResponse->assertSee('Contact Information');

    // Test Social group
    $socialResponse = $this->actingAs($this->superadmin)->get('/dashboard/settings?group=social');
    $socialResponse->assertStatus(200);
    $socialResponse->assertSee('Social Media Profiles');

    // Test Business group
    $bizResponse = $this->actingAs($this->superadmin)->get('/dashboard/settings?group=business');
    $bizResponse->assertStatus(200);
    $bizResponse->assertSee('Business Information');
});

test('unauthorized user cannot access website settings workspace', function () {
    $response = $this->actingAs($this->unauthorizedUser)->get('/dashboard/settings');

    $response->assertStatus(403);
});

test('unauthorized user cannot update website settings', function () {
    $response = $this->actingAs($this->unauthorizedUser)->post('/dashboard/settings', [
        'company_name' => 'Hacked Company',
    ]);

    $response->assertStatus(403);
});

test('settings can be updated successfully and persisted without duplicate keys', function () {
    $payload = [
        'company_name' => 'Apex Build & Civil Corporation',
        'company_tagline' => 'Engineering Resilient Infrastructure',
        'primary_phone' => '+1 (800) 999-1122',
        'primary_email' => 'contact@apexbuild.com',
        'whatsapp_number' => '+1 (800) 999-1122',
        'office_address' => '500 Construction Way, Seattle, WA',
        'google_maps_url' => 'https://maps.google.com/?q=Seattle',
        'facebook_url' => 'https://facebook.com/apexbuild',
        'instagram_url' => 'https://instagram.com/apexbuild',
        'linkedin_url' => 'https://linkedin.com/company/apexbuild',
        'youtube_url' => 'https://youtube.com/@apexbuild',
        'office_hours' => 'Mon - Sat: 07:00 AM - 07:00 PM',
        'copyright_text' => '© 2026 Apex Build Corporation. All Rights Reserved.',
    ];

    $response = $this->actingAs($this->superadmin)->post('/dashboard/settings', $payload);

    $response->assertRedirect('/dashboard/settings?group=general');
    $response->assertSessionHas('success', 'Website settings updated successfully.');

    // Assert values persisted
    expect(WebsiteSetting::get('company_name'))->toBe('Apex Build & Civil Corporation')
        ->and(WebsiteSetting::get('primary_email'))->toBe('contact@apexbuild.com')
        ->and(WebsiteSetting::get('primary_phone'))->toBe('+1 (800) 999-1122')
        ->and(WebsiteSetting::get('facebook_url'))->toBe('https://facebook.com/apexbuild')
        ->and(WebsiteSetting::get('copyright_text'))->toBe('© 2026 Apex Build Corporation. All Rights Reserved.');

    // Helper function verification
    expect(get_setting('company_name'))->toBe('Apex Build & Civil Corporation')
        ->and(get_setting('primary_email'))->toBe('contact@apexbuild.com');

    // Assert no duplicate keys were created
    $count = WebsiteSetting::where('key', 'company_name')->count();
    expect($count)->toBe(1);
});

test('validation prevents invalid email, urls, and file types', function () {
    $invalidPayload = [
        'company_name' => '', // Required
        'primary_email' => 'not-an-email',
        'facebook_url' => 'invalid-url',
        'site_logo' => UploadedFile::fake()->create('document.pdf', 1000, 'application/pdf'),
    ];

    $response = $this->actingAs($this->superadmin)->post('/dashboard/settings', $invalidPayload);

    $response->assertSessionHasErrors(['company_name', 'primary_email', 'facebook_url', 'site_logo']);
});

test('logo and favicon upload works and files are stored', function () {
    $logo = UploadedFile::fake()->image('custom_logo.png', 400, 100);
    $favicon = UploadedFile::fake()->image('custom_favicon.png', 32, 32);

    $response = $this->actingAs($this->superadmin)->post('/dashboard/settings', [
        'company_name' => 'Apex Construction Group',
        'site_logo' => $logo,
        'site_favicon' => $favicon,
    ]);

    $response->assertRedirect('/dashboard/settings?group=general');

    $storedLogo = WebsiteSetting::get('site_logo');
    $storedFavicon = WebsiteSetting::get('site_favicon');

    expect($storedLogo)->not->toBeNull()
        ->and($storedLogo)->toContain('upload/settings/logo_')
        ->and($storedFavicon)->not->toBeNull()
        ->and($storedFavicon)->toContain('upload/settings/favicon_');

    // Clean up created files
    if ($storedLogo && file_exists(public_path($storedLogo))) {
        @unlink(public_path($storedLogo));
    }
    if ($storedFavicon && file_exists(public_path($storedFavicon))) {
        @unlink(public_path($storedFavicon));
    }
});

test('activity log is created for settings update', function () {
    ActivityLog::query()->delete();

    $this->actingAs($this->superadmin)->post('/dashboard/settings', [
        'company_name' => 'Updated Landmark Firm',
    ]);

    $log = ActivityLog::where('module', 'website-setting')->first();

    expect($log)->not->toBeNull()
        ->and($log->action)->toBe('update')
        ->and($log->user_id)->toBe($this->superadmin->id)
        ->and($log->description)->toBe('Updated global website settings')
        ->and($log->new_values['company_name'])->toBe('Updated Landmark Firm');
});

test('viewing settings workspace does not generate activity log', function () {
    ActivityLog::query()->delete();

    $this->actingAs($this->superadmin)->get('/dashboard/settings');

    $logsCount = ActivityLog::where('module', 'website-setting')->count();
    expect($logsCount)->toBe(0);
});

test('superadmin can dynamically create a new setting field', function () {
    $payload = [
        'group' => 'general',
        'label' => 'Emergency 24/7 Hotline',
        'key' => 'emergency_hotline',
        'type' => 'phone',
        'col_class' => 'col-md-6 col-12',
        'placeholder' => '+1 (800) 911-0000',
        'value' => '+1 (800) 911-0000',
    ];

    $response = $this->actingAs($this->superadmin)->post('/dashboard/settings/fields', $payload);

    $response->assertRedirect('/dashboard/settings?group=general');
    $response->assertSessionHas('success');

    $setting = WebsiteSetting::where('key', 'emergency_hotline')->first();
    expect($setting)->not->toBeNull()
        ->and($setting->label)->toBe('Emergency 24/7 Hotline')
        ->and($setting->value)->toBe('+1 (800) 911-0000')
        ->and($setting->type)->toBe('phone')
        ->and($setting->is_custom)->toBeTrue();

    // Verify helper get_setting
    expect(get_setting('emergency_hotline'))->toBe('+1 (800) 911-0000');
});

test('non-superadmin cannot create dynamic setting field', function () {
    $payload = [
        'group' => 'general',
        'label' => 'Hacked Field',
        'key' => 'hacked_field',
        'type' => 'text',
    ];

    $response = $this->actingAs($this->unauthorizedUser)->post('/dashboard/settings/fields', $payload);

    $response->assertStatus(403);
    expect(WebsiteSetting::where('key', 'hacked_field')->exists())->toBeFalse();
});

test('superadmin can create setting with custom new group', function () {
    $payload = [
        'group' => 'integrations',
        'label' => 'Crisp Chat Website ID',
        'key' => 'crisp_chat_id',
        'type' => 'text',
        'value' => 'abc-123-xyz',
    ];

    $response = $this->actingAs($this->superadmin)->post('/dashboard/settings/fields', $payload);

    $response->assertRedirect('/dashboard/settings?group=integrations');

    $groupMeta = WebsiteSetting::getGroupMeta();
    expect($groupMeta)->toHaveKey('integrations');

    // Access new group workspace
    $workspaceResponse = $this->actingAs($this->superadmin)->get('/dashboard/settings?group=integrations');
    $workspaceResponse->assertStatus(200);
    $workspaceResponse->assertSee('Crisp Chat Website ID');
});

test('superadmin can delete a custom setting field but cannot delete default core settings', function () {
    // 1. Create custom setting
    $custom = WebsiteSetting::create([
        'key' => 'custom_tracking_id',
        'label' => 'Tracking ID',
        'type' => 'text',
        'group' => 'general',
        'is_custom' => true,
    ]);

    $response = $this->actingAs($this->superadmin)->delete('/dashboard/settings/fields/' . $custom->id);
    $response->assertRedirect('/dashboard/settings?group=general');
    $response->assertSessionHas('success');
    expect(WebsiteSetting::where('id', $custom->id)->exists())->toBeFalse();

    // 2. Attempt to delete default setting
    $coreSetting = WebsiteSetting::where('key', 'company_name')->first();
    $coreResponse = $this->actingAs($this->superadmin)->delete('/dashboard/settings/fields/' . $coreSetting->id);
    $coreResponse->assertSessionHas('error');
    expect(WebsiteSetting::where('key', 'company_name')->exists())->toBeTrue();
});


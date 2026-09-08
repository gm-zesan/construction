<?php

use App\Models\ActivityLog;
use App\Models\User;

beforeEach(function () {
    $this->artisan('db:seed');
    $this->superadmin = User::role('superadmin')->first();
    $this->unauthorizedUser = User::factory()->create();
});

test('authenticated authorized user can access activity logs index view', function () {
    $response = $this->actingAs($this->superadmin)->get('/dashboard/activity-logs');

    $response->assertStatus(200);
    $response->assertSee('Activity Logs');
});

test('unauthenticated user is redirected from activity logs index', function () {
    $response = $this->get('/dashboard/activity-logs');

    $response->assertRedirect('/login');
});

test('unauthorized user without permission cannot access activity logs index or show', function () {
    $this->actingAs($this->unauthorizedUser)
        ->get('/dashboard/activity-logs')
        ->assertStatus(403);

    $log = ActivityLog::first();
    if ($log) {
        $this->actingAs($this->unauthorizedUser)
            ->get("/dashboard/activity-logs/{$log->id}")
            ->assertStatus(403);
    }
});

test('activity logs datatables ajax endpoint returns structured data and columns', function () {
    // Ensure we have at least one test log
    ActivityLog::create([
        'user_id' => $this->superadmin->id,
        'action' => 'update',
        'module' => 'project',
        'description' => 'Updated project test details',
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0 TestBrowser',
        'created_at' => now(),
    ]);

    $response = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/activity-logs?draw=1&start=0&length=10');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data' => [
                '*' => [
                    'id',
                    'user',
                    'action_badge',
                    'module_badge',
                    'description_text',
                    'ip_address',
                    'timestamp',
                    'action-btn',
                ]
            ]
        ]);
});

test('activity logs can be filtered by module, action, and user', function () {
    $userA = $this->superadmin;
    $userB = User::factory()->create();

    ActivityLog::create([
        'user_id' => $userA->id,
        'action' => 'create',
        'module' => 'service',
        'description' => 'Created Architecture Design service',
        'ip_address' => '127.0.0.1',
        'created_at' => now(),
    ]);

    ActivityLog::create([
        'user_id' => $userB->id,
        'action' => 'delete',
        'module' => 'project',
        'description' => 'Deleted old project record',
        'ip_address' => '192.168.1.1',
        'created_at' => now(),
    ]);

    // 1. Filter by module
    $responseModule = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/activity-logs?draw=1&module=service&start=0&length=10');
    $responseModule->assertStatus(200);
    $dataModule = $responseModule->json('data');
    expect(count($dataModule))->toBeGreaterThan(0);
    foreach ($dataModule as $row) {
        expect($row['module'])->toBe('service');
    }

    // 2. Filter by action
    $responseAction = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/activity-logs?draw=1&action=delete&start=0&length=10');
    $responseAction->assertStatus(200);
    $dataAction = $responseAction->json('data');
    expect(count($dataAction))->toBeGreaterThan(0);
    foreach ($dataAction as $row) {
        expect($row['action'])->toBe('delete');
    }

    // 3. Filter by user_id
    $responseUser = $this->actingAs($this->superadmin)
        ->getJson("/dashboard/activity-logs?draw=1&user_id={$userB->id}&start=0&length=10");
    $responseUser->assertStatus(200);
    $dataUser = $responseUser->json('data');
    expect(count($dataUser))->toBe(1);
    expect($dataUser[0]['user_id'])->toBe($userB->id);
});

test('authorized user can view activity log details with formatted values', function () {
    $log = ActivityLog::create([
        'user_id' => $this->superadmin->id,
        'action' => 'update',
        'module' => 'project',
        'description' => 'Updated Commercial Plaza Project',
        'subject_type' => 'App\Models\Project',
        'subject_id' => 1,
        'old_values' => ['title' => 'Old Title', 'status' => 'planning'],
        'new_values' => ['title' => 'New Title', 'status' => 'in_progress'],
        'ip_address' => '10.0.0.5',
        'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
        'created_at' => now(),
    ]);

    $response = $this->actingAs($this->superadmin)->get("/dashboard/activity-logs/{$log->id}");

    $response->assertStatus(200);
    $response->assertSee('Activity Audit Details');
    $response->assertSee('Updated Commercial Plaza Project');
    $response->assertSee('10.0.0.5');
    $response->assertSee('Old Title');
    $response->assertSee('New Title');
    $response->assertSee($this->superadmin->name);
});

test('viewing activity log details does not create duplicate activity logs', function () {
    $log = ActivityLog::create([
        'user_id' => $this->superadmin->id,
        'action' => 'login',
        'module' => 'auth',
        'description' => 'User logged in',
        'created_at' => now(),
    ]);

    $initialCount = ActivityLog::count();

    $this->actingAs($this->superadmin)->get("/dashboard/activity-logs/{$log->id}")->assertStatus(200);

    expect(ActivityLog::count())->toBe($initialCount);
});

test('activity logs remain read-only audit records without delete routes', function () {
    $log = ActivityLog::first();
    if (!$log) {
        $log = ActivityLog::create([
            'user_id' => $this->superadmin->id,
            'action' => 'login',
            'module' => 'auth',
            'description' => 'Test log',
            'created_at' => now(),
        ]);
    }

    $response = $this->actingAs($this->superadmin)->delete("/dashboard/activity-logs/{$log->id}");

    // Delete route does not exist and should return 405 Method Not Allowed
    $response->assertStatus(405);
});

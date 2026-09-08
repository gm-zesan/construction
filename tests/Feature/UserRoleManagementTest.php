<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    // Seed permissions & roles
    $this->artisan('db:seed');
});

it('allows superadmin to view users list', function () {
    $superadmin = User::role('superadmin')->first();

    $response = $this->actingAs($superadmin)->get('/dashboard/users');

    $response->assertStatus(200);
    $response->assertSee('User');
});

it('allows superadmin to view roles management', function () {
    $superadmin = User::role('superadmin')->first();

    $response = $this->actingAs($superadmin)->get('/dashboard/role');

    $response->assertStatus(200);
    $response->assertSee('Role');
});


it('allows superadmin to create, edit, update, and delete a user', function () {
    $superadmin = User::role('superadmin')->first();

    // 1. Create form
    $this->actingAs($superadmin)->get('/dashboard/user/create')->assertStatus(200);

    // 2. Store user
    $response = $this->actingAs($superadmin)->post('/dashboard/user/store', [
        'name' => 'John Builder',
        'email' => 'john.builder@example.com',
        'phone_no' => '+8801711223344',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);
    $response->assertRedirect('/dashboard/users');
    $createdUser = User::where('email', 'john.builder@example.com')->first();
    expect($createdUser)->not->toBeNull();

    // 3. Edit form
    $this->actingAs($superadmin)->get('/dashboard/user/edit/' . $createdUser->id)->assertStatus(200);

    // 4. Update user
    $updateResponse = $this->actingAs($superadmin)->post('/dashboard/user/update/' . $createdUser->id, [
        'name' => 'John Senior Builder',
        'email' => 'john.builder@example.com',
        'phone_no' => '+8801711223344',
    ]);
    $updateResponse->assertRedirect('/dashboard/users');
    expect($createdUser->fresh()->name)->toBe('John Senior Builder');

    // 5. Delete user
    $deleteResponse = $this->actingAs($superadmin)->get('/dashboard/user/delete/' . $createdUser->id);
    $deleteResponse->assertRedirect('/dashboard/users');
    expect(User::where('email', 'john.builder@example.com')->first())->toBeNull();
});

it('allows superadmin to create, edit, update, and delete a custom role', function () {
    $superadmin = User::role('superadmin')->first();
    $permId = Permission::first()->id;

    // 1. Create form
    $this->actingAs($superadmin)->get('/dashboard/role/create')->assertStatus(200);

    // 2. Store role
    $response = $this->actingAs($superadmin)->post('/dashboard/role/store', [
        'name' => 'site-engineer',
        'description' => 'Field engineer with site permissions',
        'permission' => [$permId],
    ]);
    $response->assertRedirect('/dashboard/role');
    $role = Role::where('name', 'site-engineer')->first();
    expect($role)->not->toBeNull();

    // 3. Edit form
    $this->actingAs($superadmin)->get('/dashboard/role/edit/' . $role->id)->assertStatus(200);

    // 4. Update role
    $updateResponse = $this->actingAs($superadmin)->post('/dashboard/role/update/' . $role->id, [
        'name' => 'lead-site-engineer',
        'description' => 'Updated lead field engineer',
        'permission' => [$permId],
    ]);
    $updateResponse->assertRedirect('/dashboard/role');
    expect($role->fresh()->name)->toBe('lead-site-engineer');

    // 5. Delete role
    $deleteResponse = $this->actingAs($superadmin)->get('/dashboard/role/delete/' . $role->id);
    $deleteResponse->assertRedirect('/dashboard/role');
    expect(Role::where('name', 'lead-site-engineer')->first())->toBeNull();
});

it('allows superadmin to assign a role to a user', function () {
    $superadmin = User::role('superadmin')->first();
    $worker = User::create([
        'name' => 'Worker User',
        'email' => 'worker@example.com',
        'password' => bcrypt('password123'),
        'phone_no' => '+8801999887766',
    ]);
    $worker->assignRole('user');

    $response = $this->actingAs($superadmin)->post('/dashboard/user/assign-role', [
        'email' => 'worker@example.com',
        'role' => 'admin',
    ]);

    $response->assertSessionHasNoErrors();
    expect($worker->fresh()->hasRole('admin'))->toBeTrue();
    expect($worker->fresh()->hasRole('user'))->toBeFalse();
});

it('handles ckeditor upload without file gracefully', function () {
    $superadmin = User::role('superadmin')->first();

    $response = $this->actingAs($superadmin)->postJson('/ckeditor/upload');

    $response->assertStatus(400);
});

it('serves datatables ajax response for users and roles', function () {
    $superadmin = User::role('superadmin')->first();

    // Users DataTables AJAX
    $usersAjax = $this->actingAs($superadmin)
        ->getJson('/dashboard/users', ['X-Requested-With' => 'XMLHttpRequest']);
    $usersAjax->assertStatus(200);
    $usersAjax->assertJsonStructure(['data']);

    // Roles DataTables AJAX
    $rolesAjax = $this->actingAs($superadmin)
        ->getJson('/dashboard/role', ['X-Requested-With' => 'XMLHttpRequest']);
    $rolesAjax->assertStatus(200);
    $rolesAjax->assertJsonStructure(['data']);
});

it('allows superadmin to create user with specific role and update that role', function () {
    $superadmin = User::role('superadmin')->first();

    $response = $this->actingAs($superadmin)->post('/dashboard/user/store', [
        'name' => 'Project Specialist',
        'email' => 'specialist@example.com',
        'phone_no' => '+8801700998877',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'project-manager',
    ]);
    $response->assertRedirect('/dashboard/users');

    $specialist = User::where('email', 'specialist@example.com')->first();
    expect($specialist)->not->toBeNull();
    expect($specialist->hasRole('project-manager'))->toBeTrue();

    // Update role to admin
    $updateResponse = $this->actingAs($superadmin)->post('/dashboard/user/update/' . $specialist->id, [
        'name' => 'Project Specialist Updated',
        'email' => 'specialist@example.com',
        'phone_no' => '+8801700998877',
        'role' => 'admin',
    ]);
    $updateResponse->assertRedirect('/dashboard/users');
    expect($specialist->fresh()->hasRole('admin'))->toBeTrue();
});

it('verifies DataTables responses include badge and action data', function () {
    $superadmin = User::role('superadmin')->first();

    $usersAjax = $this->actingAs($superadmin)
        ->getJson('/dashboard/users', ['X-Requested-With' => 'XMLHttpRequest']);
    $usersAjax->assertStatus(200);
    $data = $usersAjax->json('data');
    expect(count($data))->toBeGreaterThan(0);
    expect($data[0])->toHaveKeys(['id', 'name', 'email', 'role', 'action-btn']);

    $rolesAjax = $this->actingAs($superadmin)
        ->getJson('/dashboard/role', ['X-Requested-With' => 'XMLHttpRequest']);
    $rolesAjax->assertStatus(200);
    $roleData = $rolesAjax->json('data');
    expect(count($roleData))->toBeGreaterThan(0);
    expect($roleData[0])->toHaveKeys(['id', 'name', 'display_name', 'users_count', 'action-btn']);
});



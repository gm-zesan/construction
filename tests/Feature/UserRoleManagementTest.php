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

it('allows superadmin to view assign role page', function () {
    $superadmin = User::role('superadmin')->first();

    $response = $this->actingAs($superadmin)->get('/dashboard/assign-role');

    $response->assertStatus(200);
    $response->assertSee('Assign Role');
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

    $response = $this->actingAs($superadmin)->post('/dashboard/assign-role/store', [
        'email' => 'worker@example.com',
        'role' => 'admin',
    ]);

    $response->assertSessionHasNoErrors();
    expect($worker->fresh()->hasRole('admin'))->toBeTrue();
    expect($worker->fresh()->hasRole('user'))->toBeFalse();
});

it('allows authenticated user to view ckeditor studio page', function () {
    $superadmin = User::role('superadmin')->first();

    $response = $this->actingAs($superadmin)->get('/ckeditor');

    $response->assertStatus(200);
    $response->assertSee('CKEditor');
    $response->assertSee('editor_demo');
});

it('serves datatables ajax response for users, roles, and assign-role', function () {
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

    // Assign Role DataTables AJAX
    $assignRoleAjax = $this->actingAs($superadmin)
        ->getJson('/dashboard/assign-role', ['X-Requested-With' => 'XMLHttpRequest']);
    $assignRoleAjax->assertStatus(200);
    $assignRoleAjax->assertJsonStructure(['data']);
});

it('handles ckeditor upload gracefully', function () {
    $superadmin = User::role('superadmin')->first();
    \Illuminate\Support\Facades\Storage::fake('public');

    $file = \Illuminate\Http\UploadedFile::fake()->image('diagram.png');

    $response = $this->actingAs($superadmin)->post('/ckeditor/upload', [
        'upload' => $file,
        'CKEditorFuncNum' => '1',
    ]);

    $response->assertStatus(200);
    $response->assertSee('window.parent.CKEDITOR.tools.callFunction');
});



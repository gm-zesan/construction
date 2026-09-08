<?php

use App\Models\User;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    $this->artisan('db:seed');

    $this->superadmin = User::role('superadmin')->first();
    $this->unauthorizedUser = User::factory()->create();
});

test('authorized user can render permissions management directory', function () {
    $this->actingAs($this->superadmin)
        ->get('/dashboard/permissions')
        ->assertStatus(200)
        ->assertSee('Permissions Directory')
        ->assertSee('New Permission');
});

test('unauthenticated user is redirected from permissions routes', function () {
    $this->get('/dashboard/permissions')->assertRedirect('/login');
});

test('unauthorized user without permissions cannot access permissions directory', function () {
    $this->actingAs($this->unauthorizedUser)
        ->get('/dashboard/permissions')
        ->assertStatus(403);
});

test('permissions datatables ajax endpoint returns formatted columns', function () {
    $response = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/permissions?draw=1&start=0&length=10');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'display_name',
                    'module',
                    'module_badge',
                    'code_badge',
                    'action-btn',
                ]
            ]
        ]);
});

test('authorized user can store a dynamic permission via AJAX with auto-generated slug', function () {
    $response = $this->actingAs($this->superadmin)
        ->postJson('/dashboard/permissions', [
            'module' => 'finance',
            'display_name' => 'Export Financial Ledger',
            'name' => '',
        ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Permission created successfully!',
            'data' => [
                'name' => 'finance-export-financial-ledger',
                'display_name' => 'Export Financial Ledger',
                'module' => 'finance',
                'module_title' => 'Finance',
            ]
        ]);

    $this->assertDatabaseHas('permissions', [
        'name' => 'finance-export-financial-ledger',
        'display_name' => 'Export Financial Ledger',
        'module' => 'finance',
    ]);
});

test('authorized user can store a permission with explicit custom name slug', function () {
    $response = $this->actingAs($this->superadmin)
        ->postJson('/dashboard/permissions', [
            'module' => 'inventory',
            'display_name' => 'Restock Materials Alert',
            'name' => 'inventory-restock-alert',
        ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => [
                'name' => 'inventory-restock-alert',
            ]
        ]);

    $this->assertDatabaseHas('permissions', [
        'name' => 'inventory-restock-alert',
    ]);
});

test('authorized user can update an existing permission', function () {
    $permission = Permission::create([
        'name' => 'custom-temp-perm',
        'display_name' => 'Temp Permission',
        'module' => 'custom',
        'guard_name' => 'web',
    ]);

    $response = $this->actingAs($this->superadmin)
        ->putJson("/dashboard/permissions/{$permission->id}", [
            'module' => 'custom-updated',
            'display_name' => 'Temp Permission Updated',
            'name' => 'custom-temp-perm-updated',
        ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Permission updated successfully!',
        ]);

    $this->assertDatabaseHas('permissions', [
        'id' => $permission->id,
        'name' => 'custom-temp-perm-updated',
        'display_name' => 'Temp Permission Updated',
        'module' => 'custom-updated',
    ]);
});

test('authorized user can delete a dynamic permission', function () {
    $permission = Permission::create([
        'name' => 'delete-me-perm',
        'display_name' => 'Delete Me',
        'module' => 'temporary',
        'guard_name' => 'web',
    ]);

    $response = $this->actingAs($this->superadmin)
        ->deleteJson("/dashboard/permissions/{$permission->id}");

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Permission deleted successfully!',
        ]);

    $this->assertDatabaseMissing('permissions', [
        'id' => $permission->id,
    ]);
});

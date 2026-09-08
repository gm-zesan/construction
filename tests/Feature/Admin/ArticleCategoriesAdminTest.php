<?php

use App\Models\ActivityLog;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;

beforeEach(function () {
    $this->artisan('db:seed');

    $this->superadmin = User::role('superadmin')->first();
    $this->unauthorizedUser = User::factory()->create();
});

test('authorized user can render single page article category management view', function () {
    $this->actingAs($this->superadmin)
        ->get('/dashboard/article-categories')
        ->assertStatus(200)
        ->assertSee('Article Categories')
        ->assertSee('Add New Category')
        ->assertSee('Save Category');
});

test('unauthenticated user is redirected from article category routes', function () {
    $this->get('/dashboard/article-categories')->assertRedirect('/login');
});

test('unauthorized user without permissions cannot access article categories', function () {
    $this->actingAs($this->unauthorizedUser)
        ->get('/dashboard/article-categories')
        ->assertStatus(403);
});

test('article categories datatables ajax endpoint returns formatted columns', function () {
    $response = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/article-categories?draw=1&start=0&length=10');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data' => [
                '*' => [
                    'id',
                    'category_name',
                    'description_text',
                    'articles_count_badge',
                    'action-btn',
                ]
            ]
        ]);
});

test('authorized user can store a new article category with auto-generated slug and activity log', function () {
    $response = $this->actingAs($this->superadmin)
        ->postJson('/dashboard/article-categories', [
            'name' => 'Renewable Infrastructure Systems',
            'description' => 'Solar and wind turbine civil construction updates',
        ]);

    $response->assertStatus(200)
        ->assertJson(['success' => true]);

    $cat = ArticleCategory::where('slug', 'renewable-infrastructure-systems')->first();
    expect($cat)->not->toBeNull();
    expect($cat->name)->toBe('Renewable Infrastructure Systems');
    expect($cat->slug)->toBe('renewable-infrastructure-systems');
    expect($cat->description)->toBe('Solar and wind turbine civil construction updates');

    // Verify activity log
    $log = ActivityLog::where('module', 'article_category')
        ->where('action', 'create')
        ->where('subject_id', $cat->id)
        ->first();

    expect($log)->not->toBeNull();
});

test('storing category rejects empty name', function () {
    $response = $this->actingAs($this->superadmin)
        ->postJson('/dashboard/article-categories', [
            'name' => '',
        ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['name']);
});

test('authorized user can update article category via ajax and log activity', function () {
    $category = ArticleCategory::create([
        'name' => 'Prefabricated Modular',
        'slug' => 'prefabricated-modular',
        'created_by' => $this->superadmin->id,
    ]);

    $response = $this->actingAs($this->superadmin)
        ->putJson("/dashboard/article-categories/{$category->id}", [
            'name' => 'Offsite Prefabricated Modular Tech',
            'description' => 'Factory assembled volumetric modules.',
        ]);

    $response->assertStatus(200)
        ->assertJson(['success' => true]);

    $category->refresh();
    expect($category->name)->toBe('Offsite Prefabricated Modular Tech');
    expect($category->description)->toBe('Factory assembled volumetric modules.');

    $log = ActivityLog::where('module', 'article_category')
        ->where('action', 'update')
        ->where('subject_id', $category->id)
        ->first();

    expect($log)->not->toBeNull();
});

test('cannot delete category with assigned articles', function () {
    $category = ArticleCategory::create([
        'name' => 'Protected Category',
        'slug' => 'protected-category',
        'created_by' => $this->superadmin->id,
    ]);

    Article::create([
        'category_id' => $category->id,
        'title' => 'Assigned Article',
        'slug' => 'assigned-article',
        'is_published' => true,
        'created_by' => $this->superadmin->id,
    ]);

    $response = $this->actingAs($this->superadmin)
        ->deleteJson("/dashboard/article-categories/{$category->id}");

    $response->assertStatus(422)
        ->assertJson(['success' => false]);

    expect(ArticleCategory::find($category->id))->not->toBeNull();
});

test('authorized user can delete unused category', function () {
    $category = ArticleCategory::create([
        'name' => 'Deletable Category',
        'slug' => 'deletable-category',
        'created_by' => $this->superadmin->id,
    ]);

    $response = $this->actingAs($this->superadmin)
        ->deleteJson("/dashboard/article-categories/{$category->id}");

    $response->assertStatus(200)
        ->assertJson(['success' => true]);

    expect(ArticleCategory::find($category->id))->toBeNull();
});

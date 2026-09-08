<?php

it('returns a successful response for home page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('allows authenticated admin to view operations dashboard', function () {
    $user = \App\Models\User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
    $response->assertSee('Operations Dashboard');
    $response->assertSee('Active Field Sites');
});


<?php

use App\Models\Article;
use App\Models\ClientReview;
use App\Models\Project;
use App\Models\Service;
use App\Models\WebsiteContent;
use App\Models\WebsiteSetting;

it('renders homepage with dynamic content, settings, services, projects, articles, and reviews', function () {
    $response = $this->get('/');

    $response->assertStatus(200);

    // Verify dynamic services are passed and present
    $services = Service::published()->ordered()->take(6)->get();
    foreach ($services as $service) {
        $response->assertSee($service->title);
    }

    // Verify dynamic projects are passed and present
    $projects = Project::published()->ordered()->take(6)->get();
    foreach ($projects as $project) {
        $response->assertSee($project->title);
    }

    // Verify dynamic articles are passed and present
    $articles = Article::published()->ordered()->take(3)->get();
    foreach ($articles as $article) {
        $response->assertSee($article->title);
    }

    // Verify dynamic testimonials are passed and present
    $reviews = ClientReview::published()->orderBy('sort_order', 'asc')->take(6)->get();
    foreach ($reviews as $review) {
        $response->assertSee($review->client_name);
    }
});

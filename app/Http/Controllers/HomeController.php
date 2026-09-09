<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ClientReview;
use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the dynamic website homepage.
     */
    public function index(): View
    {
        $services = Service::published()
            ->ordered()
            ->take(6)
            ->get();

        $projects = Project::published()
            ->with('media')
            ->ordered()
            ->take(6)
            ->get();

        $articles = Article::published()
            ->with(['category', 'media'])
            ->ordered()
            ->take(3)
            ->get();

        $testimonials = ClientReview::published()
            ->with(['media', 'project'])
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        return view('home', compact('services', 'projects', 'articles', 'testimonials'));
    }
}

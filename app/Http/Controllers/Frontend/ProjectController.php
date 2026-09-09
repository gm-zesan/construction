<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display the public projects portfolio showcase.
     */
    public function index(Request $request): View
    {
        $selectedCategory = $request->query('category');

        $query = Project::with(['media'])
            ->published()
            ->ordered();

        if ($selectedCategory && strtolower($selectedCategory) !== 'all') {
            $query->where('category', $selectedCategory);
        }

        $projects = $query->get();

        // Flagship featured project for the scroll-pinned spotlight
        $flagshipQuery = Project::with(['media', 'milestones'])
            ->published()
            ->featured()
            ->ordered();

        if ($selectedCategory && strtolower($selectedCategory) !== 'all') {
            $flagshipQuery->where('category', $selectedCategory);
        }

        $flagshipProject = $flagshipQuery->first() ?? $projects->first();

        // Distinct categories available in published projects
        $categories = Project::published()
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category')
            ->values()
            ->all();

        $companyName = WebsiteSetting::get('company_name', 'COMPANY NAME');
        $title = "Projects & Engineering Portfolio | {$companyName}";

        return view('frontend.projects.index', compact('projects', 'flagshipProject', 'categories', 'selectedCategory', 'title'));
    }

    /**
     * Display a specific project case study and technical specifications.
     */
    public function show(string $slug): View
    {
        $project = Project::with(['media', 'milestones' => function ($q) {
            $q->published()->ordered();
        }])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Related projects in same category
        $relatedProjects = Project::with('media')
            ->published()
            ->where('id', '!=', $project->id)
            ->where('category', $project->category)
            ->ordered()
            ->take(3)
            ->get();

        // If not enough in same category, backfill with other published projects
        if ($relatedProjects->count() < 3) {
            $needed = 3 - $relatedProjects->count();
            $existingIds = $relatedProjects->pluck('id')->push($project->id)->all();
            $additional = Project::with('media')
                ->published()
                ->whereNotIn('id', $existingIds)
                ->ordered()
                ->take($needed)
                ->get();
            $relatedProjects = $relatedProjects->concat($additional);
        }

        $companyName = WebsiteSetting::get('company_name', 'COMPANY NAME');
        $title = "{$project->title} | Case Study | {$companyName}";

        return view('frontend.projects.show', compact('project', 'relatedProjects', 'title'));
    }
}

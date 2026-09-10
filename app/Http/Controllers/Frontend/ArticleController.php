<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display the public News & Articles editorial archive with featured slider & 2-column sidebar layout.
     */
    public function index(Request $request): View
    {
        $selectedCategorySlug = $request->query('category');
        $searchQuery = $request->query('search');

        // 1. Featured Articles Slider (all published featured articles, or latest 4 if none)
        $featuredArticles = Article::with(['category', 'media'])
            ->published()
            ->featured()
            ->ordered()
            ->get();

        if ($featuredArticles->isEmpty()) {
            $featuredArticles = Article::with(['category', 'media'])
                ->published()
                ->ordered()
                ->take(4)
                ->get();
        }

        // 2. Main Articles Query for the left column
        $query = Article::with(['category', 'media'])
            ->published()
            ->ordered();

        // Optional category filter
        if ($selectedCategorySlug && strtolower($selectedCategorySlug) !== 'all') {
            $query->whereHas('category', function ($q) use ($selectedCategorySlug) {
                $q->where('slug', $selectedCategorySlug);
            });
        }

        // Optional search query
        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                    ->orWhere('summary', 'like', "%{$searchQuery}%")
                    ->orWhere('content', 'like', "%{$searchQuery}%");
            });
        }

        $articles = $query->paginate(6)->withQueryString();

        // 3. Right Sidebar: Categories with published count
        $categories = ArticleCategory::whereHas('articles', function ($q) {
            $q->published();
        })
            ->withCount(['articles' => function ($q) {
                $q->published();
            }])
            ->ordered()
            ->get();

        // 4. Right Sidebar: Recent Blogs List
        $recentArticles = Article::with(['category', 'media'])
            ->published()
            ->ordered()
            ->take(5)
            ->get();

        $companyName = WebsiteSetting::get('company_name', 'COMPANY NAME');
        $title = "News, Field Reports & Engineering Articles | {$companyName}";

        return theme_view('articles.index', compact(
            'articles',
            'featuredArticles',
            'categories',
            'recentArticles',
            'selectedCategorySlug',
            'searchQuery',
            'title'
        ));
    }

    /**
     * Display a single article deep-dive case study.
     */
    public function show(string $slug): View
    {
        $article = Article::with(['category', 'media', 'creator'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views count safely without touching timestamps
        $article->timestamps = false;
        $article->increment('views_count');
        $article->timestamps = true;

        // Related articles in the same category
        $relatedArticles = Article::with(['category', 'media'])
            ->published()
            ->where('id', '!=', $article->id)
            ->when($article->category_id, function ($q) use ($article) {
                $q->where('category_id', $article->category_id);
            })
            ->ordered()
            ->take(3)
            ->get();

        // If not enough related in same category, backfill with other published articles
        if ($relatedArticles->count() < 3) {
            $needed = 3 - $relatedArticles->count();
            $existingIds = $relatedArticles->pluck('id')->push($article->id)->all();
            $additional = Article::with(['category', 'media'])
                ->published()
                ->whereNotIn('id', $existingIds)
                ->ordered()
                ->take($needed)
                ->get();
            $relatedArticles = $relatedArticles->concat($additional);
        }

        $companyName = WebsiteSetting::get('company_name', 'COMPANY NAME');
        $title = "{$article->title} | Insights | {$companyName}";

        return theme_view('articles.show', compact('article', 'relatedArticles', 'title'));
    }
}

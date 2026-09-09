<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:article-list|blog-list|article-create|blog-create|article-edit|blog-edit|article-delete|blog-delete', only: ['index', 'show']),
            new Middleware('permission:article-create|blog-create', only: ['create', 'store']),
            new Middleware('permission:article-edit|blog-edit', only: ['edit', 'update', 'toggleStatus', 'toggleFeatured']),
            new Middleware('permission:article-delete|blog-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of articles.
     */
    public function index(Request $request): JsonResponse|View
    {
        $query = Article::with(['category', 'media'])->select('articles.*')->ordered();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('is_published')) {
            $query->where('is_published', (bool) $request->is_published);
        }

        if ($request->filled('featured')) {
            $query->where('featured', (bool) $request->featured);
        }

        $rawSearch = $request->input('search');
        $searchTerm = is_array($rawSearch) ? ($rawSearch['value'] ?? '') : $rawSearch;
        if (!empty($searchTerm)) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('summary', 'like', "%{$searchTerm}%")
                    ->orWhere('author_name', 'like', "%{$searchTerm}%")
                    ->orWhereHas('category', function ($cq) use ($searchTerm) {
                        $cq->where('name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        if ($request->ajax() || $request->wantsJson() || $request->has('draw')) {
            if ($request->has('draw')) {
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->filter(function ($q) {
                        // Handled in query above
                    }, true)
                    ->addColumn('thumbnail', function (Article $row) {
                        $imgUrl = $row->image_url;
                        return '<div class="rounded overflow-hidden d-inline-flex align-items-center justify-content-center bg-light" style="width: 52px; height: 44px; border: 1px solid #e2e8f0; flex-shrink: 0;">
                            <img src="' . e($imgUrl) . '" alt="' . e($row->title) . '" class="w-100 h-100 object-fit-cover" onerror="this.onerror=null;this.src=\'' . asset('admin/assets/images/default.jpg') . '\';">
                        </div>';
                    })
                    ->addColumn('article_title', function (Article $row) {
                        return '<div class="d-flex flex-column text-truncate" style="max-width: 280px;">
                            <span class="fw-bold text-dark text-truncate text-decoration-none" style="font-size: 13.5px;">' . e($row->title) . '</span>
                            <span class="text-muted text-truncate" style="font-size: 11px;">Slug: ' . e($row->slug) . '</span>
                        </div>';
                    })
                    ->addColumn('category_badge', function (Article $row) {
                        if (!$row->category) {
                            return '<span class="text-muted">—</span>';
                        }
                        return '<span class="badge" style="background-color: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; font-size: 11.5px; padding: 4px 8px; font-weight: 600;">
                            <i class="ri-price-tag-3-line me-1 text-primary"></i>' . e($row->category->name) . '
                        </span>';
                    })
                    ->addColumn('author_and_date', function (Article $row) {
                        $author = $row->author_name ?: 'Editorial Team';
                        $dateStr = $row->published_at ? $row->published_at->format('M d, Y') : 'Unscheduled';
                        return '<div class="d-flex flex-column">
                            <span class="fw-semibold text-dark text-truncate" style="font-size: 12px; max-width: 140px;">' . e($author) . '</span>
                            <span class="text-muted" style="font-size: 10.5px;">' . e($dateStr) . ' • ' . $row->read_time . 'm</span>
                        </div>';
                    })
                    ->addColumn('featured_toggle', function (Article $row) {
                        $checked = $row->featured ? 'checked' : '';
                        $disabled = Auth::user()?->can('article-edit') || Auth::user()?->can('blog-edit') ? '' : 'disabled';
                        return '<div class="form-check form-switch d-inline-block">
                            <input class="form-check-input featured-toggle" type="checkbox" ' . $checked . ' ' . $disabled . ' data-id="' . $row->id . '" style="cursor: pointer;">
                        </div>';
                    })
                    ->addColumn('published_toggle', function (Article $row) {
                        $checked = $row->is_published ? 'checked' : '';
                        $disabled = Auth::user()?->can('article-edit') || Auth::user()?->can('blog-edit') ? '' : 'disabled';
                        return '<div class="form-check form-switch d-inline-block">
                            <input class="form-check-input status-toggle" type="checkbox" ' . $checked . ' ' . $disabled . ' data-id="' . $row->id . '" style="cursor: pointer;">
                        </div>';
                    })
                    ->addColumn('action-btn', function (Article $row) {
                        $canEdit = Auth::user()?->can('article-edit') || Auth::user()?->can('blog-edit');
                        $canDelete = Auth::user()?->can('article-delete') || Auth::user()?->can('blog-delete');

                        return [
                            'id' => $row->id,
                            'title' => $row->title,
                            'show_url' => route('articles.show', $row->id),
                            'edit_url' => route('articles.edit', $row->id),
                            'can_edit' => $canEdit,
                            'can_delete' => $canDelete,
                        ];
                    })
                    ->rawColumns(['thumbnail', 'article_title', 'category_badge', 'author_and_date', 'featured_toggle', 'published_toggle', 'action-btn'])
                    ->make(true);
            }

            return response()->json([
                'success' => true,
                'data' => $query->paginate(25),
            ]);
        }

        $categories = ArticleCategory::ordered()->get(['id', 'name']);
        $totalCount = Article::count();
        $publishedCount = Article::where('is_published', true)->count();
        $featuredCount = Article::where('featured', true)->count();
        $totalViews = Article::sum('views_count');

        return view('admin.articles.index', compact(
            'categories',
            'totalCount',
            'publishedCount',
            'featuredCount',
            'totalViews'
        ));
    }

    /**
     * Show form for creating a new article.
     */
    public function create(): View
    {
        $categories = ArticleCategory::ordered()->get();
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created article.
     */
    public function store(StoreArticleRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        $data['is_published'] = $request->has('is_published');
        $data['featured'] = $request->has('featured');
        $data['sort_order'] = $request->input('sort_order', 0);
        $data['read_time'] = $request->input('read_time', 3);

        if (empty($data['published_at']) && $data['is_published']) {
            $data['published_at'] = now();
        }

        $article = Article::create($data);

        // Main cover image upload
        if ($request->hasFile('image')) {
            $article->addMediaFromRequest('image')->toMediaCollection('image');
        }

        // Gallery uploads if any
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $article->addMedia($file)->toMediaCollection('gallery');
            }
        }

        ActivityLogger::log(
            action: 'create',
            module: 'article',
            description: 'Created article "' . $article->title . '"',
            subject: $article,
            newValues: [
                'title' => $article->title,
                'slug' => $article->slug,
                'category_id' => $article->category_id,
                'author_name' => $article->author_name,
                'is_published' => $article->is_published,
                'featured' => $article->featured,
            ]
        );

        return redirect()->route('articles.index')->with('success', 'Article published successfully.');
    }

    /**
     * Display the specified article.
     */
    public function show(int $id): View|JsonResponse
    {
        $article = Article::with(['category', 'creator', 'updater', 'media'])->findOrFail($id);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $article,
            ]);
        }

        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show form for editing article.
     */
    public function edit(int $id): View
    {
        $article = Article::with(['category', 'media'])->findOrFail($id);
        $categories = ArticleCategory::ordered()->get();

        return view('admin.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update specified article.
     */
    public function update(UpdateArticleRequest $request, int $id): RedirectResponse
    {
        $article = Article::findOrFail($id);
        $oldValues = [
            'title' => $article->title,
            'slug' => $article->slug,
            'category_id' => $article->category_id,
            'is_published' => $article->is_published,
            'featured' => $article->featured,
        ];

        $data = $request->validated();
        $data['updated_by'] = Auth::id();
        $data['is_published'] = $request->has('is_published');
        $data['featured'] = $request->has('featured');
        $data['sort_order'] = $request->input('sort_order', 0);
        $data['read_time'] = $request->input('read_time', 3);

        $article->update($data);

        // Replace main image if provided
        if ($request->hasFile('image')) {
            $article->clearMediaCollection('image');
            $article->addMediaFromRequest('image')->toMediaCollection('image');
        }

        // Append gallery photos if provided
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $article->addMedia($file)->toMediaCollection('gallery');
            }
        }

        ActivityLogger::log(
            action: 'update',
            module: 'article',
            description: 'Updated article "' . $article->title . '"',
            subject: $article,
            oldValues: $oldValues,
            newValues: [
                'title' => $article->title,
                'slug' => $article->slug,
                'category_id' => $article->category_id,
                'is_published' => $article->is_published,
                'featured' => $article->featured,
            ]
        );

        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }

    /**
     * Fast toggle status (Visibility).
     */
    public function toggleStatus(Request $request, int $id): JsonResponse
    {
        $article = Article::findOrFail($id);
        $article->is_published = !$article->is_published;
        $article->updated_by = Auth::id();
        $article->save();

        ActivityLogger::log(
            action: 'status_change',
            module: 'article',
            description: 'Changed article "' . $article->title . '" visibility to ' . ($article->is_published ? 'published' : 'draft'),
            subject: $article
        );

        return response()->json([
            'success' => true,
            'message' => 'Article visibility updated successfully.',
            'is_published' => $article->is_published,
        ]);
    }

    /**
     * Fast toggle featured status.
     */
    public function toggleFeatured(Request $request, int $id): JsonResponse
    {
        $article = Article::findOrFail($id);
        $article->featured = !$article->featured;
        $article->updated_by = Auth::id();
        $article->save();

        ActivityLogger::log(
            action: 'status_change',
            module: 'article',
            description: 'Changed article "' . $article->title . '" featured state to ' . ($article->featured ? 'featured' : 'standard'),
            subject: $article
        );

        return response()->json([
            'success' => true,
            'message' => 'Article featured status updated successfully.',
            'featured' => $article->featured,
        ]);
    }

    /**
     * Delete article.
     */
    public function destroy(int $id): JsonResponse|RedirectResponse
    {
        $article = Article::findOrFail($id);
        $title = $article->title;

        $article->clearMediaCollection('image');
        $article->clearMediaCollection('gallery');
        $article->delete();

        ActivityLogger::log(
            action: 'delete',
            module: 'article',
            description: 'Deleted article "' . $title . '"'
        );

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Article deleted successfully.',
            ]);
        }

        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }
}

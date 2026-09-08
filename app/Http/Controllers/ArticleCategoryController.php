<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleCategoryRequest;
use App\Http\Requests\UpdateArticleCategoryRequest;
use App\Models\ArticleCategory;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ArticleCategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:article-category-list|blog-list|article-category-create|blog-create|article-category-edit|blog-edit|article-category-delete|blog-delete', only: ['index']),
            new Middleware('permission:article-category-create|blog-create', only: ['create', 'store']),
            new Middleware('permission:article-category-edit|blog-edit', only: ['edit', 'update']),
            new Middleware('permission:article-category-delete|blog-delete', only: ['destroy']),
        ];
    }

    /**
     * Display the single-page management view or DataTables JSON.
     */
    public function index(Request $request): JsonResponse|View
    {
        $query = ArticleCategory::withCount('articles')->ordered();

        $rawSearch = $request->input('search');
        $searchTerm = is_array($rawSearch) ? ($rawSearch['value'] ?? '') : $rawSearch;
        if (!empty($searchTerm)) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('slug', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->ajax() || $request->wantsJson() || $request->has('draw')) {
            if ($request->has('draw')) {
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('category_name', function (ArticleCategory $row) {
                        return '<div class="d-flex flex-column">
                            <span class="fw-bold text-dark" style="font-size: 13.5px;">' . e($row->name) . '</span>
                            <span class="text-muted" style="font-size: 11.5px;">Slug: <code class="text-primary" style="font-size: 11px;">' . e($row->slug) . '</code></span>
                        </div>';
                    })
                    ->addColumn('description_text', function (ArticleCategory $row) {
                        if (!$row->description) {
                            return '<span class="text-muted" style="font-size: 12px;">—</span>';
                        }
                        return '<span class="text-muted" style="font-size: 12.5px; line-height: 1.4;" title="' . e($row->description) . '">' . e(Str::limit($row->description, 80)) . '</span>';
                    })
                    ->addColumn('articles_count_badge', function (ArticleCategory $row) {
                        $count = $row->articles_count ?? 0;
                        return '<span class="badge" style="background-color: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; font-size: 11.5px; padding: 4px 8px; font-weight: 600; border-radius: 6px;">
                            <i class="ri-article-line me-1 text-primary"></i>' . $count . ' ' . ($count === 1 ? 'Article' : 'Articles') . '
                        </span>';
                    })
                    ->addColumn('action-btn', function (ArticleCategory $row) {
                        $canEdit = Auth::user()?->can('article-category-edit') || Auth::user()?->can('blog-edit');
                        $canDelete = Auth::user()?->can('article-category-delete') || Auth::user()?->can('blog-delete');

                        return [
                            'id' => $row->id,
                            'name' => $row->name,
                            'slug' => $row->slug,
                            'description' => $row->description ?? '',
                            'can_edit' => $canEdit,
                            'can_delete' => $canDelete,
                            'articles_count' => $row->articles_count ?? 0,
                        ];
                    })
                    ->rawColumns(['category_name', 'description_text', 'articles_count_badge', 'action-btn'])
                    ->make(true);
            }

            return response()->json([
                'success' => true,
                'data' => $query->paginate(25),
            ]);
        }

        $totalCount = ArticleCategory::count();

        return view('admin.article-categories.index', compact('totalCount'));
    }

    /**
     * Redirect to index or return JSON.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('article-categories.index');
    }

    /**
     * Store newly created category.
     */
    public function store(StoreArticleCategoryRequest $request): JsonResponse|RedirectResponse
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        $category = ArticleCategory::create($data);

        ActivityLogger::log(
            action: 'create',
            module: 'article_category',
            description: 'Created article category "' . $category->name . '"',
            subject: $category,
            newValues: [
                'name' => $category->name,
                'slug' => $category->slug,
            ]
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Article category created successfully.',
                'data' => $category,
            ]);
        }

        return redirect()->route('article-categories.index')->with('success', 'Article category created successfully.');
    }

    /**
     * Show category details (returns JSON for AJAX edit or redirects).
     */
    public function show(int $id): JsonResponse|RedirectResponse
    {
        $category = ArticleCategory::withCount('articles')->findOrFail($id);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $category,
            ]);
        }

        return redirect()->route('article-categories.index');
    }

    /**
     * Edit category (returns JSON for single-page form population or redirects).
     */
    public function edit(int $id): JsonResponse|RedirectResponse
    {
        $category = ArticleCategory::findOrFail($id);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $category,
            ]);
        }

        return redirect()->route('article-categories.index');
    }

    /**
     * Update specified category.
     */
    public function update(UpdateArticleCategoryRequest $request, int $id): JsonResponse|RedirectResponse
    {
        $category = ArticleCategory::findOrFail($id);
        $oldValues = [
            'name' => $category->name,
            'slug' => $category->slug,
            'description' => $category->description,
        ];

        $data = $request->validated();
        $data['updated_by'] = Auth::id();

        $category->update($data);

        ActivityLogger::log(
            action: 'update',
            module: 'article_category',
            description: 'Updated article category "' . $category->name . '"',
            subject: $category,
            oldValues: $oldValues,
            newValues: [
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
            ]
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Article category updated successfully.',
                'data' => $category,
            ]);
        }

        return redirect()->route('article-categories.index')->with('success', 'Article category updated successfully.');
    }

    /**
     * Delete category.
     */
    public function destroy(int $id): JsonResponse|RedirectResponse
    {
        $category = ArticleCategory::withCount('articles')->findOrFail($id);

        if ($category->articles_count > 0) {
            $msg = 'Cannot delete category because it has ' . $category->articles_count . ' associated article(s). Reassign them first.';
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return redirect()->route('article-categories.index')->with('error', $msg);
        }

        $name = $category->name;
        $category->delete();

        ActivityLogger::log(
            action: 'delete',
            module: 'article_category',
            description: 'Deleted article category "' . $name . '"'
        );

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Article category deleted successfully.',
            ]);
        }

        return redirect()->route('article-categories.index')->with('success', 'Article category deleted successfully.');
    }
}

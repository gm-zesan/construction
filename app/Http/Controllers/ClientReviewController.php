<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientReviewRequest;
use App\Http\Requests\UpdateClientReviewRequest;
use App\Models\ClientReview;
use App\Models\Project;
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

class ClientReviewController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:client-review-list|client-review-create|client-review-edit|client-review-delete', only: ['index', 'show']),
            new Middleware('permission:client-review-create', only: ['create', 'store']),
            new Middleware('permission:client-review-edit', only: ['edit', 'update', 'toggleStatus']),
            new Middleware('permission:client-review-delete', only: ['destroy']),
        ];
    }

    /**
     * Display listing of client reviews.
     */
    public function index(Request $request): JsonResponse|View
    {
        if ($request->ajax() || $request->wantsJson()) {
            $query = ClientReview::with(['project', 'creator', 'updater', 'media'])->select('client_reviews.*');

            if ($request->filled('status')) {
                $query->where('is_published', (bool) $request->status);
            }

            if ($request->filled('featured')) {
                $query->where('featured', (bool) $request->featured);
            }

            if ($request->filled('rating')) {
                $query->where('rating', (int) $request->rating);
            }

            if ($request->filled('project_id')) {
                $query->where('project_id', (int) $request->project_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('avatar', function (ClientReview $row) {
                    $photoUrl = $row->client_photo_url;
                    $initials = strtoupper(substr($row->client_name, 0, 2));

                    if ($photoUrl) {
                        return '<div class="rounded-circle overflow-hidden d-inline-flex align-items-center justify-content-center" style="width: 42px; height: 42px; border: 2px solid #e2e8f0; background: #f8fafc;">
                            <img src="' . e($photoUrl) . '" alt="' . e($row->client_name) . '" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>';
                    }

                    return '<div class="rounded-circle d-inline-flex align-items-center justify-content-center text-primary fw-bold" style="width: 42px; height: 42px; background: #eff6ff; border: 1px solid #bfdbfe; font-size: 13px;">' .
                        e($initials) .
                        '</div>';
                })
                ->addColumn('client_details', function (ClientReview $row) {
                    $sub = [];
                    if ($row->designation) $sub[] = $row->designation;
                    if ($row->company_name) $sub[] = $row->company_name;
                    $subText = !empty($sub) ? implode(', ', $sub) : 'Client';

                    return '<div class="d-flex flex-column text-truncate" style="max-width: 220px;">
                        <span class="fw-bold text-dark text-truncate" style="font-size: 13.5px;">' . e($row->client_name) . '</span>
                        <span class="text-muted text-truncate" style="font-size: 11.5px;">' . e($subText) . '</span>
                    </div>';
                })
                ->addColumn('review_snippet', function (ClientReview $row) {
                    $truncated = Str::limit($row->review, 90);
                    return '<div class="text-secondary" style="font-size: 12.5px; line-height: 1.4; max-width: 320px;" title="' . e($row->review) . '">
                        <i class="ri-double-quotes-l text-muted me-1"></i>' . e($truncated) . '
                    </div>';
                })
                ->addColumn('rating_badge', function (ClientReview $row) {
                    $stars = '';
                    for ($i = 1; $i <= 5; $i++) {
                        $stars .= $i <= $row->rating
                            ? '<i class="ri-star-fill text-warning" style="font-size: 12px;"></i>'
                            : '<i class="ri-star-line text-muted" style="font-size: 12px; opacity: 0.4;"></i>';
                    }

                    return '<div class="d-inline-flex align-items-center gap-1">
                        <div class="d-flex">' . $stars . '</div>
                        <span class="badge bg-light text-dark border ms-1" style="font-size: 11px; font-weight: 700;">' . $row->rating . '.0</span>
                    </div>';
                })
                ->addColumn('featured_toggle', function (ClientReview $row) {
                    $checked = $row->featured ? 'checked' : '';
                    return '<div class="form-check form-switch m-0 d-flex justify-content-center">
                        <input class="form-check-input featured-toggle toggle-review-feature" type="checkbox" role="switch" data-id="' . $row->id . '" ' . $checked . '>
                    </div>';
                })
                ->addColumn('published_toggle', function (ClientReview $row) {
                    $checked = $row->is_published ? 'checked' : '';
                    return '<div class="form-check form-switch m-0 d-flex justify-content-center">
                        <input class="form-check-input status-toggle toggle-review-publish" type="checkbox" role="switch" data-id="' . $row->id . '" ' . $checked . '>
                    </div>';
                })
                ->addColumn('created_at_formatted', function (ClientReview $row) {
                    return '<div class="d-flex flex-column" style="font-size: 12px;">
                        <span class="text-dark fw-semibold">' . $row->created_at->format('M d, Y') . '</span>
                        <span class="text-muted" style="font-size: 11px;">' . $row->created_at->diffForHumans() . '</span>
                    </div>';
                })
                ->addColumn('action-btn', function (ClientReview $row) {
                    $user = Auth::user();
                    return [
                        'id' => $row->id,
                        'client_name' => $row->client_name,
                        'show_url' => route('client-reviews.show', $row->id),
                        'edit_url' => route('client-reviews.edit', $row->id),
                        'delete_url' => route('client-reviews.destroy', $row->id),
                        'can_edit' => $user && ($user->can('client-review-edit') || $user->hasRole('superadmin')),
                        'can_delete' => $user && ($user->can('client-review-delete') || $user->hasRole('superadmin')),
                    ];
                })
                ->rawColumns(['avatar', 'client_details', 'review_snippet', 'rating_badge', 'featured_toggle', 'published_toggle', 'created_at_formatted'])
                ->make(true);
        }

        $stats = [
            'total' => ClientReview::count(),
            'published' => ClientReview::where('is_published', true)->count(),
            'featured' => ClientReview::where('featured', true)->count(),
            'avg_rating' => round((float) ClientReview::avg('rating') ?: 5.0, 1),
        ];

        $projects = Project::orderBy('title')->get(['id', 'title']);

        return view('admin.client-reviews.index', compact('stats', 'projects'));
    }

    /**
     * Show form for creating a new client review.
     */
    public function create(): View
    {
        $projects = Project::orderBy('title')->get(['id', 'title']);
        return view('admin.client-reviews.create', compact('projects'));
    }

    /**
     * Store newly created client review in storage.
     */
    public function store(StoreClientReviewRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['is_published'] = $request->boolean('is_published', true);
        $validated['featured'] = $request->boolean('featured', false);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        $review = ClientReview::create($validated);

        if ($request->hasFile('client_photo')) {
            $review->addMediaFromRequest('client_photo')
                ->toMediaCollection('client_photo');
        }

        ActivityLogger::log(
            'create',
            'client-review',
            "Created testimonial from client '{$review->client_name}' ({$review->rating}★)",
            $review,
            null,
            $review->toArray()
        );

        return redirect()
            ->route('client-reviews.index')
            ->with('success', 'Client review created successfully!');
    }

    /**
     * Display specified client review.
     */
    public function show(string|int $id): View
    {
        $review = ClientReview::with(['project', 'creator', 'updater', 'media'])->findOrFail($id);
        return view('admin.client-reviews.show', compact('review'));
    }

    /**
     * Show form for editing the client review.
     */
    public function edit(string|int $id): View
    {
        $review = ClientReview::with(['project', 'media'])->findOrFail($id);
        $projects = Project::orderBy('title')->get(['id', 'title']);
        return view('admin.client-reviews.edit', compact('review', 'projects'));
    }

    /**
     * Update specified client review in storage.
     */
    public function update(UpdateClientReviewRequest $request, string|int $id): RedirectResponse
    {
        $review = ClientReview::findOrFail($id);
        $oldValues = $review->toArray();

        $validated = $request->validated();
        $validated['is_published'] = $request->boolean('is_published', false);
        $validated['featured'] = $request->boolean('featured', false);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['updated_by'] = Auth::id();

        $review->update($validated);

        if ($request->hasFile('client_photo')) {
            $review->clearMediaCollection('client_photo');
            $review->addMediaFromRequest('client_photo')
                ->toMediaCollection('client_photo');
        }

        ActivityLogger::log(
            'update',
            'client-review',
            "Updated review testimonial for client '{$review->client_name}'",
            $review,
            $oldValues,
            $review->fresh()->toArray()
        );

        return redirect()
            ->route('client-reviews.index')
            ->with('success', 'Client review updated successfully!');
    }

    /**
     * Toggle featured or published status via AJAX.
     */
    public function toggleStatus(Request $request, string|int $id): JsonResponse
    {
        $request->validate([
            'field' => 'required|in:featured,is_published,status',
            'value' => 'required|boolean',
        ]);

        $review = ClientReview::findOrFail($id);
        $field = $request->input('field') === 'status' ? 'is_published' : $request->input('field');
        $oldValue = $review->{$field};
        $newValue = (bool) $request->input('value');

        $review->{$field} = $newValue;
        $review->updated_by = Auth::id();
        $review->save();

        ActivityLogger::log(
            'update',
            'client-review',
            "Toggled {$field} to " . ($newValue ? 'enabled' : 'disabled') . " for client '{$review->client_name}'",
            $review,
            [$field => $oldValue],
            [$field => $newValue]
        );

        return response()->json([
            'success' => true,
            'message' => ucfirst(str_replace('_', ' ', $field)) . ' updated successfully',
            'data' => [
                'id' => $review->id,
                'field' => $field,
                'value' => $newValue,
            ],
        ]);
    }

    /**
     * Remove specified client review from storage.
     */
    public function destroy(Request $request, string|int $id): JsonResponse|RedirectResponse
    {
        $review = ClientReview::findOrFail($id);
        $clientName = $review->client_name;
        $oldValues = $review->toArray();

        // Clear Spatie MediaLibrary collection
        $review->clearMediaCollection('client_photo');
        $review->delete();

        ActivityLogger::log(
            'delete',
            'client-review',
            "Deleted testimonial for client '{$clientName}'",
            null,
            $oldValues,
            null
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Client review from '{$clientName}' deleted successfully.",
            ]);
        }

        return redirect()
            ->route('client-reviews.index')
            ->with('success', "Client review from '{$clientName}' deleted successfully.");
    }
}

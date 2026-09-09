<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
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

class ServiceController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:service-list|service-create|service-edit|service-delete', only: ['index', 'show']),
            new Middleware('permission:service-create', only: ['create', 'store']),
            new Middleware('permission:service-edit', only: ['edit', 'update', 'toggleStatus', 'deleteMedia']),
            new Middleware('permission:service-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of services.
     */
    public function index(Request $request): JsonResponse|View
    {
        if ($request->ajax() || $request->wantsJson()) {
            $query = Service::with(['creator', 'updater', 'media'])->select('services.*');

            if ($request->filled('status')) {
                $query->where('is_published', (bool) $request->status);
            }

            if ($request->filled('featured')) {
                $query->where('featured', (bool) $request->featured);
            }

            if ($request->has('draw')) {
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('thumbnail', function ($row) {
                        $imageUrl = $row->image_url;
                        $defaultImage = asset('admin/assets/images/default.jpg');
                        return '<div class="service-thumb-box" style="width: 54px; height: 38px; border-radius: 6px; overflow: hidden; background: #e2e8f0; border: 1px solid #cbd5e1; display: inline-flex; align-items: center; justify-content: center;">
                            <img src="' . e($imageUrl) . '" alt="' . e($row->title) . '" onerror="this.onerror=null;this.src=\'' . e($defaultImage) . '\';" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>';
                    })
                    ->addColumn('title_details', function ($row) {
                        $iconHtml = $row->icon ? '<i class="' . e($row->icon) . ' me-1 text-primary" style="font-size: 13px;"></i>' : '';
                        return '<div class="d-flex flex-column">
                            <div class="d-flex align-items-center">
                                ' . $iconHtml . '
                                <span class="fw-bold text-dark" style="font-size: 13.5px;">' . e($row->title) . '</span>
                            </div>
                            <span class="text-muted" style="font-size: 11px;">Slug: ' . e($row->slug) . '</span>
                        </div>';
                    })
                    ->addColumn('short_description_text', function ($row) {
                        return '<span class="text-muted" style="font-size: 12px;">' . e(Str::limit($row->short_description ?? '—', 70)) . '</span>';
                    })
                    ->addColumn('sort_order_badge', function ($row) {
                        return '<span class="badge" style="background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; font-size: 11.5px; padding: 4px 8px; border-radius: 4px; font-weight: 600;">' . (int) $row->sort_order . '</span>';
                    })
                    ->addColumn('featured_toggle', function ($row) {
                        $checked = $row->featured ? 'checked' : '';
                        return '<div class="form-check form-switch m-0 d-flex justify-content-center">
                            <input class="form-check-input featured-toggle toggle-service-feature" type="checkbox" role="switch" data-id="' . $row->id . '" ' . $checked . '>
                        </div>';
                    })
                    ->addColumn('published_toggle', function ($row) {
                        $checked = $row->is_published ? 'checked' : '';
                        return '<div class="form-check form-switch m-0 d-flex justify-content-center">
                            <input class="form-check-input status-toggle toggle-service-publish" type="checkbox" role="switch" data-id="' . $row->id . '" ' . $checked . '>
                        </div>';
                    })
                    ->addColumn('action-btn', function ($row) {
                        $auth = Auth::user();
                        return [
                            'id' => $row->id,
                            'title' => $row->title,
                            'can_edit' => $auth ? ($auth->hasRole('superadmin') || $auth->can('service-edit')) : true,
                            'can_delete' => $auth ? ($auth->hasRole('superadmin') || $auth->can('service-delete')) : true,
                        ];
                    })
                    ->rawColumns(['thumbnail', 'title_details', 'short_description_text', 'sort_order_badge', 'featured_toggle', 'published_toggle', 'action-btn'])
                    ->make(true);
            }

            return response()->json([
                'success' => true,
                'data' => $query->ordered()->paginate(20),
            ]);
        }

        return view('admin.services.index');
    }

    /**
     * Show form for creating a new service.
     */
    public function create(): View
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created service.
     */
    public function store(StoreServiceRequest $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();

        if (empty($validated['slug'])) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;
            while (Service::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }
            $validated['slug'] = $slug;
        }

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        // Strip file inputs from model fillable array
        $serviceData = collect($validated)->except(['image', 'gallery'])->toArray();
        $service = Service::create($serviceData);

        $cleanName = function (string $fileName): string {
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $name = pathinfo($fileName, PATHINFO_FILENAME);
            $clean = preg_replace('/[^\w\-]/u', '-', $name);
            $clean = preg_replace('/-+/', '-', $clean);
            $clean = trim($clean, '-');
            return ($clean ?: 'file-' . time()) . ($ext ? '.' . strtolower($ext) : '');
        };

        // Attach Media through Spatie
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $service->addMedia($request->file('image'))
                ->sanitizingFileName($cleanName)
                ->toMediaCollection('image');
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                if ($file && $file->isValid()) {
                    $service->addMedia($file)
                        ->sanitizingFileName($cleanName)
                        ->toMediaCollection('gallery');
                }
            }
        }

        ActivityLogger::log(
            action: 'create',
            module: 'service',
            description: 'Created service "' . $service->title . '"',
            subject: $service,
            newValues: $service->only(['title', 'slug', 'featured', 'is_published', 'sort_order'])
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Service created successfully',
                'data' => $service,
            ], 201);
        }

        return redirect()->route('services.index')->with('success', 'Service created successfully');
    }

    /**
     * Display the specified service.
     */
    public function show(Request $request, int $id): JsonResponse|View
    {
        $service = Service::with(['creator', 'updater', 'media', 'enquiries'])->findOrFail($id);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $service,
            ]);
        }

        return view('admin.services.show', compact('service'));
    }

    /**
     * Show form for editing the service.
     */
    public function edit(int $id): View
    {
        $service = Service::with(['media'])->findOrFail($id);

        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified service.
     */
    public function update(UpdateServiceRequest $request, int $id): JsonResponse|RedirectResponse
    {
        $service = Service::findOrFail($id);
        $oldValues = $service->only(['title', 'slug', 'featured', 'is_published', 'sort_order']);

        $validated = $request->validated();
        if (empty($validated['slug'])) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;
            while (Service::where('slug', $slug)->where('id', '!=', $service->id)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }
            $validated['slug'] = $slug;
        }
        $validated['updated_by'] = Auth::id();

        $serviceData = collect($validated)->except(['image', 'gallery'])->toArray();
        $service->update($serviceData);

        $cleanName = function (string $fileName): string {
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $name = pathinfo($fileName, PATHINFO_FILENAME);
            $clean = preg_replace('/[^\w\-]/u', '-', $name);
            $clean = preg_replace('/-+/', '-', $clean);
            $clean = trim($clean, '-');
            return ($clean ?: 'file-' . time()) . ($ext ? '.' . strtolower($ext) : '');
        };

        // Replace main image if new file provided
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $service->clearMediaCollection('image');
            $service->addMedia($request->file('image'))
                ->sanitizingFileName($cleanName)
                ->toMediaCollection('image');
        }

        // Append new gallery images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                if ($file && $file->isValid()) {
                    $service->addMedia($file)
                        ->sanitizingFileName($cleanName)
                        ->toMediaCollection('gallery');
                }
            }
        }

        ActivityLogger::log(
            action: 'update',
            module: 'service',
            description: 'Updated service "' . $service->title . '"',
            subject: $service,
            oldValues: $oldValues,
            newValues: $service->only(['title', 'slug', 'featured', 'is_published', 'sort_order'])
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Service updated successfully',
                'data' => $service,
            ]);
        }

        return redirect()->route('services.index')->with('success', 'Service updated successfully');
    }

    /**
     * AJAX quick toggle for featured or is_published.
     */
    public function toggleStatus(Request $request, int $id): JsonResponse
    {
        $service = Service::findOrFail($id);

        $field = $request->input('field');
        $value = $request->input('value');

        if (!in_array($field, ['featured', 'is_published'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid toggle field requested',
            ], 422);
        }

        $oldVal = $service->$field;
        $service->$field = (bool) $value;
        $service->updated_by = Auth::id();
        $service->save();

        ActivityLogger::log(
            action: 'status_change',
            module: 'service',
            description: 'Toggled ' . $field . ' to ' . ($value ? 'true' : 'false') . ' for service "' . $service->title . '"',
            subject: $service,
            oldValues: [$field => $oldVal],
            newValues: [$field => $service->$field]
        );

        return response()->json([
            'success' => true,
            'message' => ucfirst(str_replace('_', ' ', $field)) . ' updated successfully',
        ]);
    }

    /**
     * AJAX delete individual media file attached to service.
     */
    public function deleteMedia(int $id, int $mediaId): JsonResponse
    {
        $service = Service::findOrFail($id);
        $media = $service->media()->findOrFail($mediaId);

        $fileName = $media->file_name;
        $collection = $media->collection_name;

        $media->delete();

        ActivityLogger::log(
            action: 'delete_media',
            module: 'service',
            description: 'Deleted media "' . $fileName . '" from collection "' . $collection . '" on service "' . $service->title . '"',
            subject: $service,
            oldValues: ['media_id' => $mediaId, 'file_name' => $fileName, 'collection' => $collection]
        );

        return response()->json([
            'success' => true,
            'message' => 'Media file removed successfully',
        ]);
    }

    /**
     * Remove the specified service.
     */
    public function destroy(int $id): JsonResponse|RedirectResponse
    {
        $service = Service::findOrFail($id);
        $title = $service->title;
        $oldValues = $service->only(['title', 'slug', 'featured', 'is_published']);

        $service->clearMediaCollection('image');
        $service->clearMediaCollection('gallery');
        $service->delete();

        ActivityLogger::log(
            action: 'delete',
            module: 'service',
            description: 'Deleted service "' . $title . '"',
            oldValues: $oldValues
        );

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Service deleted successfully',
            ]);
        }

        return redirect()->route('services.index')->with('success', 'Service deleted successfully');
    }
}

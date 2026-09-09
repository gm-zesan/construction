<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
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

class ProjectController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:project-list|project-create|project-edit|project-delete', only: ['index', 'show']),
            new Middleware('permission:project-create', only: ['create', 'store']),
            new Middleware('permission:project-edit', only: ['edit', 'update', 'toggleStatus', 'deleteMedia']),
            new Middleware('permission:project-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of projects.
     */
    public function index(Request $request): JsonResponse|View
    {
        if ($request->ajax() || $request->wantsJson()) {
            $query = Project::with(['creator', 'updater', 'media'])->select('projects.*');

            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('featured')) {
                $query->where('featured', (bool) $request->featured);
            }

            if ($request->has('draw')) {
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('thumbnail', function ($row) {
                        $imageUrl = $row->main_image_url;
                        $defaultImage = asset('admin/assets/images/default.jpg');
                        return '<div class="project-thumb-box" style="width: 54px; height: 38px; border-radius: 6px; overflow: hidden; background: #e2e8f0; border: 1px solid #cbd5e1; display: inline-flex; align-items: center; justify-content: center;">
                            <img src="' . e($imageUrl) . '" alt="' . e($row->title) . '" onerror="this.onerror=null;this.src=\'' . e($defaultImage) . '\';" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>';
                    })
                    ->addColumn('title_details', function ($row) {
                        return '<div class="d-flex flex-column">
                            <span class="fw-bold text-dark" style="font-size: 13.5px;">' . e($row->title) . '</span>
                        </div>
                        <span class="text-muted" style="font-size: 11px;">Slug: ' . e($row->slug) . '</span>';
                    })
                    ->addColumn('client_location', function ($row) {
                        $client = $row->client_name ? e($row->client_name) : '<span class="text-muted">—</span>';
                        $location = $row->location ? '<span class="text-muted d-block" style="font-size: 11.5px;"><i class="ri-map-pin-line me-1"></i>' . e($row->location) . '</span>' : '';
                        return '<div><span class="fw-semibold" style="font-size: 12.5px;">' . $client . '</span>' . $location . '</div>';
                    })
                    ->addColumn('status_badge', function ($row) {
                        $status = $row->status instanceof ProjectStatus ? $row->status : ProjectStatus::tryFrom($row->status);
                        $badgeStyle = match ($status) {
                            ProjectStatus::COMPLETED => 'background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;',
                            ProjectStatus::ONGOING => 'background-color: #fff3ee; color: #f95716; border: 1px solid rgba(249, 87, 22, 0.3);',
                            ProjectStatus::UPCOMING => 'background-color: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;',
                            default => 'background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;',
                        };
                        $label = $status ? $status->label() : ucfirst($row->status);
                        return '<span class="badge" style="' . $badgeStyle . ' font-size: 11px; padding: 4px 8px; border-radius: 4px; font-weight: 600;">' . e($label) . '</span>';
                    })
                    ->addColumn('featured_toggle', function ($row) {
                        $checked = $row->featured ? 'checked' : '';
                        return '<div class="form-check form-switch m-0 d-flex justify-content-center">
                            <input class="form-check-input featured-toggle toggle-project-feature" type="checkbox" role="switch" data-id="' . $row->id . '" ' . $checked . '>
                        </div>';
                    })
                    ->addColumn('published_toggle', function ($row) {
                        $checked = $row->is_published ? 'checked' : '';
                        return '<div class="form-check form-switch m-0 d-flex justify-content-center">
                            <input class="form-check-input status-toggle toggle-project-publish" type="checkbox" role="switch" data-id="' . $row->id . '" ' . $checked . '>
                        </div>';
                    })
                    ->addColumn('action-btn', function ($row) {
                        $auth = Auth::user();
                        return [
                            'id' => $row->id,
                            'title' => $row->title,
                            'can_edit' => $auth ? ($auth->hasRole('superadmin') || $auth->can('project-edit')) : true,
                            'can_delete' => $auth ? ($auth->hasRole('superadmin') || $auth->can('project-delete')) : true,
                        ];
                    })
                    ->rawColumns(['thumbnail', 'title_details', 'client_location', 'status_badge', 'featured_toggle', 'published_toggle', 'action-btn'])
                    ->make(true);
            }

            return response()->json([
                'success' => true,
                'data' => $query->latest()->paginate(20),
            ]);
        }

        $categories = Project::distinct()->whereNotNull('category')->pluck('category')->toArray();
        if (empty($categories)) {
            $categories = ['Commercial', 'Residential', 'Industrial', 'Infrastructure', 'Institutional'];
        }

        $statuses = ProjectStatus::cases();

        return view('admin.projects.index', compact('categories', 'statuses'));
    }

    /**
     * Show form for creating a new project.
     */
    public function create(): View
    {
        $categories = Project::distinct()->whereNotNull('category')->pluck('category')->toArray();
        if (empty($categories)) {
            $categories = ['Commercial', 'Residential', 'Industrial', 'Infrastructure', 'Institutional'];
        }

        $statuses = ProjectStatus::cases();

        return view('admin.projects.create', compact('categories', 'statuses'));
    }

    /**
     * Store a newly created project.
     */
    public function store(StoreProjectRequest $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();

        if (empty($validated['slug'])) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;
            while (Project::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }
            $validated['slug'] = $slug;
        }

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        // Strip file inputs from model fillable array
        $projectData = collect($validated)->except(['main_image', 'gallery', 'documents'])->toArray();
        $project = Project::create($projectData);

        $cleanName = function (string $fileName): string {
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $name = pathinfo($fileName, PATHINFO_FILENAME);
            $clean = preg_replace('/[^\w\-]/u', '-', $name);
            $clean = preg_replace('/-+/', '-', $clean);
            $clean = trim($clean, '-');
            return ($clean ?: 'file-' . time()) . ($ext ? '.' . strtolower($ext) : '');
        };

        // Attach Media through Spatie
        if ($request->hasFile('main_image') && $request->file('main_image')->isValid()) {
            $project->addMedia($request->file('main_image'))
                ->sanitizingFileName($cleanName)
                ->toMediaCollection('main_image');
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                if ($file && $file->isValid()) {
                    $project->addMedia($file)
                        ->sanitizingFileName($cleanName)
                        ->toMediaCollection('gallery');
                }
            }
        }

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                if ($file && $file->isValid()) {
                    $project->addMedia($file)
                        ->sanitizingFileName($cleanName)
                        ->toMediaCollection('documents');
                }
            }
        }

        ActivityLogger::log(
            action: 'create',
            module: 'project',
            description: 'Created project "' . $project->title . '"',
            subject: $project,
            newValues: $project->only(['title', 'slug', 'category', 'status', 'featured', 'is_published'])
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Project created successfully',
                'data' => $project,
            ], 201);
        }

        return redirect()->route('projects.index')->with('success', 'Project created successfully');
    }

    /**
     * Display the specified project.
     */
    public function show(Request $request, int $id): JsonResponse|View
    {
        $project = Project::with(['creator', 'updater', 'media', 'enquiries'])->findOrFail($id);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $project,
            ]);
        }

        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show form for editing the project.
     */
    public function edit(int $id): View
    {
        $project = Project::with(['media'])->findOrFail($id);

        $categories = Project::distinct()->whereNotNull('category')->pluck('category')->toArray();
        if (empty($categories)) {
            $categories = ['Commercial', 'Residential', 'Industrial', 'Infrastructure', 'Institutional'];
        }

        $statuses = ProjectStatus::cases();

        return view('admin.projects.edit', compact('project', 'categories', 'statuses'));
    }

    /**
     * Update the specified project.
     */
    public function update(UpdateProjectRequest $request, int $id): JsonResponse|RedirectResponse
    {
        $project = Project::findOrFail($id);
        $oldValues = $project->only(['title', 'slug', 'category', 'status', 'featured', 'is_published']);

        $validated = $request->validated();
        if (empty($validated['slug'])) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;
            while (Project::where('slug', $slug)->where('id', '!=', $project->id)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }
            $validated['slug'] = $slug;
        }
        $validated['updated_by'] = Auth::id();

        $projectData = collect($validated)->except(['main_image', 'gallery', 'documents'])->toArray();
        $project->update($projectData);

        $cleanName = function (string $fileName): string {
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $name = pathinfo($fileName, PATHINFO_FILENAME);
            $clean = preg_replace('/[^\w\-]/u', '-', $name);
            $clean = preg_replace('/-+/', '-', $clean);
            $clean = trim($clean, '-');
            return ($clean ?: 'file-' . time()) . ($ext ? '.' . strtolower($ext) : '');
        };

        // Replace main image if new file provided
        if ($request->hasFile('main_image') && $request->file('main_image')->isValid()) {
            $project->clearMediaCollection('main_image');
            $project->addMedia($request->file('main_image'))
                ->sanitizingFileName($cleanName)
                ->toMediaCollection('main_image');
        }

        // Append new gallery images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                if ($file && $file->isValid()) {
                    $project->addMedia($file)
                        ->sanitizingFileName($cleanName)
                        ->toMediaCollection('gallery');
                }
            }
        }

        // Append new documents
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                if ($file && $file->isValid()) {
                    $project->addMedia($file)
                        ->sanitizingFileName($cleanName)
                        ->toMediaCollection('documents');
                }
            }
        }

        ActivityLogger::log(
            action: 'update',
            module: 'project',
            description: 'Updated project "' . $project->title . '"',
            subject: $project,
            oldValues: $oldValues,
            newValues: $project->only(['title', 'slug', 'category', 'status', 'featured', 'is_published'])
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Project updated successfully',
                'data' => $project,
            ]);
        }

        return redirect()->route('projects.index')->with('success', 'Project updated successfully');
    }

    /**
     * AJAX quick toggle for featured, is_published, or status.
     */
    public function toggleStatus(Request $request, int $id): JsonResponse
    {
        $project = Project::findOrFail($id);

        $field = $request->input('field');
        $value = $request->input('value');

        if (!in_array($field, ['featured', 'is_published', 'status'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid toggle field requested',
            ], 422);
        }

        $oldVal = $project->$field;
        $project->$field = $value;
        $project->updated_by = Auth::id();
        $project->save();

        ActivityLogger::log(
            action: 'status_change',
            module: 'project',
            description: 'Toggled ' . $field . ' for project "' . $project->title . '"',
            subject: $project,
            oldValues: [$field => $oldVal],
            newValues: [$field => $value]
        );

        return response()->json([
            'success' => true,
            'message' => ucfirst($field) . ' updated successfully',
            'data' => [
                'id' => $project->id,
                'field' => $field,
                'value' => $project->$field,
            ],
        ]);
    }

    /**
     * Delete an individual media item from project gallery or documents.
     */
    public function deleteMedia(int $projectId, int $mediaId): JsonResponse
    {
        $project = Project::findOrFail($projectId);
        $media = $project->media()->findOrFail($mediaId);

        $fileName = $media->file_name;
        $collection = $media->collection_name;

        $media->delete();

        ActivityLogger::log(
            action: 'delete',
            module: 'media',
            description: 'Removed ' . $collection . ' item "' . $fileName . '" from project "' . $project->title . '"',
            subject: $project,
            oldValues: ['media_id' => $mediaId, 'file_name' => $fileName, 'collection' => $collection]
        );

        return response()->json([
            'success' => true,
            'message' => 'Media item deleted successfully',
        ]);
    }

    /**
     * Remove the specified project.
     */
    public function destroy(int $id): JsonResponse|RedirectResponse
    {
        $project = Project::findOrFail($id);
        $title = $project->title;
        $oldValues = $project->only(['title', 'slug', 'category', 'status']);

        // Spatie handles media cleanup on delete, but explicit clear ensures disk sync
        $project->clearMediaCollection('gallery');
        $project->clearMediaCollection('main_image');
        $project->clearMediaCollection('documents');
        $project->delete();

        ActivityLogger::log(
            action: 'delete',
            module: 'project',
            description: 'Deleted project "' . $title . '"',
            oldValues: $oldValues
        );

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Project deleted successfully',
            ]);
        }

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully');
    }
}

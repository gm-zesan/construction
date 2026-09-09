<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MilestoneStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectMilestoneRequest;
use App\Http\Requests\UpdateProjectMilestoneRequest;
use App\Models\Project;
use App\Models\ProjectMilestone;
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

class ProjectMilestoneController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:milestone-list|milestone-create|milestone-edit|milestone-delete', only: ['index', 'show']),
            new Middleware('permission:milestone-create', only: ['create', 'store']),
            new Middleware('permission:milestone-edit', only: ['edit', 'update', 'toggleStatus']),
            new Middleware('permission:milestone-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the project milestones.
     */
    public function index(Request $request): JsonResponse|View
    {
        $query = ProjectMilestone::with(['project', 'media'])->select('project_milestones.*')->ordered();

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('is_published')) {
            $query->where('is_published', (bool) $request->is_published);
        }

        $rawSearch = $request->input('search');
        $searchTerm = is_array($rawSearch) ? ($rawSearch['value'] ?? '') : $rawSearch;
        if (!empty($searchTerm)) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%")
                    ->orWhereHas('project', function ($pq) use ($searchTerm) {
                        $pq->where('title', 'like', "%{$searchTerm}%");
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
                    ->addColumn('thumbnail', function (ProjectMilestone $row) {
                        $imgUrl = $row->image_url ?: ($row->project?->main_image_url ?: asset('admin/assets/images/default.jpg'));
                        return '<div class="rounded overflow-hidden d-inline-flex align-items-center justify-content-center bg-light" style="width: 48px; height: 48px; border: 1px solid #e2e8f0; flex-shrink: 0;">
                            <img src="' . e($imgUrl) . '" alt="' . e($row->title) . '" class="w-100 h-100 object-fit-cover">
                        </div>';
                    })
                    ->addColumn('milestone_title', function (ProjectMilestone $row) {
                        return '<div class="d-flex flex-column text-truncate" style="max-width: 280px;">
                            <span class="fw-bold text-dark text-truncate text-decoration-none" style="font-size: 13.5px;">' . e($row->title) . '</span>
                            <span class="text-muted text-truncate" style="font-size: 11px;">Slug: ' . e($row->slug) . '</span>
                        </div>';
                    })
                    ->addColumn('project_badge', function (ProjectMilestone $row) {
                        if (!$row->project) {
                            return '<span class="text-muted">—</span>';
                        }
                        return '<span class="badge text-decoration-none" style="background-color: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; font-size: 11.5px; padding: 4px 8px; font-weight: 600;">
                            <i class="ri-community-line me-1 text-primary"></i>' . e(Str::limit($row->project->title, 26)) . '
                        </span>';
                    })
                    ->addColumn('progress_bar', function (ProjectMilestone $row) {
                        $percent = $row->progress_percentage ?? 0;
                        $colorClass = $percent >= 100 ? 'bg-success' : ($percent >= 50 ? 'bg-primary' : 'bg-warning');

                        return '<div class="d-flex align-items-center gap-2" style="min-width: 120px;">
                            <div class="progress flex-grow-1" style="height: 6px; background-color: #e2e8f0;">
                                <div class="progress-bar ' . $colorClass . '" role="progressbar" style="width: ' . $percent . '%"></div>
                            </div>
                            <span class="fw-bold text-dark" style="font-size: 11.5px; width: 32px;">' . $percent . '%</span>
                        </div>';
                    })
                    ->addColumn('target_date_formatted', function (ProjectMilestone $row) {
                        return '<div class="d-flex flex-column">
                            <span class="fw-semibold text-dark" style="font-size: 12px;">' . $row->target_date->format('M d, Y') . '</span>
                            <span class="text-muted" style="font-size: 10.5px;">' . $row->target_date->diffForHumans() . '</span>
                        </div>';
                    })
                    ->addColumn('status_badge', function (ProjectMilestone $row) {
                        $status = $row->status instanceof MilestoneStatus ? $row->status : MilestoneStatus::tryFrom($row->status) ?? MilestoneStatus::PENDING;
                        return '<span class="badge" style="' . $status->badgeStyle() . ' font-size: 11.5px; padding: 4px 8px; border-radius: 4px; font-weight: 600;">' . e($status->label()) . '</span>';
                    })
                    ->addColumn('published_toggle', function (ProjectMilestone $row) {
                        $checked = $row->is_published ? 'checked' : '';
                        $disabled = Auth::user()?->can('milestone-edit') ? '' : 'disabled';
                        return '<div class="form-check form-switch d-inline-block">
                            <input class="form-check-input status-toggle" type="checkbox" ' . $checked . ' ' . $disabled . ' data-id="' . $row->id . '" style="cursor: pointer;">
                        </div>';
                    })
                    ->addColumn('action-btn', function (ProjectMilestone $row) {
                        $canEdit = Auth::user()?->can('milestone-edit') ?? false;
                        $canDelete = Auth::user()?->can('milestone-delete') ?? false;

                        return [
                            'id' => $row->id,
                            'title' => $row->title,
                            'show_url' => route('milestones.show', $row->id),
                            'edit_url' => route('milestones.edit', $row->id),
                            'can_edit' => $canEdit,
                            'can_delete' => $canDelete,
                        ];
                    })
                    ->rawColumns(['thumbnail', 'milestone_title', 'project_badge', 'progress_bar', 'target_date_formatted', 'status_badge', 'published_toggle', 'action-btn'])
                    ->make(true);
            }

            return response()->json([
                'success' => true,
                'data' => $query->paginate(25),
            ]);
        }

        $projects = Project::orderBy('title')->get(['id', 'title']);
        $statuses = MilestoneStatus::cases();
        $totalCount = ProjectMilestone::count();
        $completedCount = ProjectMilestone::where('status', MilestoneStatus::COMPLETED->value)->count();
        $inProgressCount = ProjectMilestone::where('status', MilestoneStatus::IN_PROGRESS->value)->count();
        $delayedCount = ProjectMilestone::where('status', MilestoneStatus::DELAYED->value)->count();

        return view('admin.milestones.index', compact(
            'projects',
            'statuses',
            'totalCount',
            'completedCount',
            'inProgressCount',
            'delayedCount'
        ));
    }

    /**
     * Show the form for creating a new milestone.
     */
    public function create(): View
    {
        $projects = Project::orderBy('title')->get(['id', 'title']);
        $statuses = MilestoneStatus::cases();

        return view('admin.milestones.create', compact('projects', 'statuses'));
    }

    /**
     * Store a newly created milestone in storage.
     */
    public function store(StoreProjectMilestoneRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        $data['is_published'] = $request->has('is_published');
        $data['progress_percentage'] = $request->input('progress_percentage', 0);
        $data['sort_order'] = $request->input('sort_order', 0);

        $milestone = ProjectMilestone::create($data);

        if ($request->hasFile('image')) {
            $milestone->addMediaFromRequest('image')->toMediaCollection('image');
        }

        ActivityLogger::log(
            action: 'create',
            module: 'milestone',
            description: 'Created milestone "' . $milestone->title . '" for project "' . ($milestone->project?->title ?? 'N/A') . '"',
            subject: $milestone,
            newValues: [
                'title' => $milestone->title,
                'project_id' => $milestone->project_id,
                'status' => $milestone->status?->value ?? $milestone->status,
                'target_date' => $milestone->target_date?->format('Y-m-d'),
                'progress_percentage' => $milestone->progress_percentage,
            ]
        );

        return redirect()->route('milestones.index')->with('success', 'Project milestone created successfully.');
    }

    /**
     * Display the specified milestone.
     */
    public function show(int $id): View|JsonResponse
    {
        $milestone = ProjectMilestone::with(['project', 'creator', 'updater', 'media'])->findOrFail($id);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $milestone,
            ]);
        }

        return view('admin.milestones.show', compact('milestone'));
    }

    /**
     * Show the form for editing the specified milestone.
     */
    public function edit(int $id): View
    {
        $milestone = ProjectMilestone::with(['project', 'media'])->findOrFail($id);
        $projects = Project::orderBy('title')->get(['id', 'title']);
        $statuses = MilestoneStatus::cases();

        return view('admin.milestones.edit', compact('milestone', 'projects', 'statuses'));
    }

    /**
     * Update the specified milestone in storage.
     */
    public function update(UpdateProjectMilestoneRequest $request, int $id): RedirectResponse
    {
        $milestone = ProjectMilestone::findOrFail($id);
        $oldValues = [
            'title' => $milestone->title,
            'status' => $milestone->status?->value ?? $milestone->status,
            'progress_percentage' => $milestone->progress_percentage,
            'target_date' => $milestone->target_date?->format('Y-m-d'),
        ];

        $data = $request->validated();
        $data['updated_by'] = Auth::id();
        $data['is_published'] = $request->has('is_published');
        $data['progress_percentage'] = $request->input('progress_percentage', 0);
        $data['sort_order'] = $request->input('sort_order', 0);

        $milestone->update($data);

        if ($request->hasFile('image')) {
            $milestone->clearMediaCollection('image');
            $milestone->addMediaFromRequest('image')->toMediaCollection('image');
        }

        ActivityLogger::log(
            action: 'update',
            module: 'milestone',
            description: 'Updated milestone "' . $milestone->title . '"',
            subject: $milestone,
            oldValues: $oldValues,
            newValues: [
                'title' => $milestone->title,
                'status' => $milestone->status?->value ?? $milestone->status,
                'progress_percentage' => $milestone->progress_percentage,
                'target_date' => $milestone->target_date?->format('Y-m-d'),
            ]
        );

        return redirect()->route('milestones.index')->with('success', 'Project milestone updated successfully.');
    }

    /**
     * Fast toggle status / publication endpoint.
     */
    public function toggleStatus(Request $request, int $id): JsonResponse
    {
        $milestone = ProjectMilestone::findOrFail($id);
        $milestone->is_published = !$milestone->is_published;
        $milestone->updated_by = Auth::id();
        $milestone->save();

        ActivityLogger::log(
            action: 'status_change',
            module: 'milestone',
            description: 'Changed milestone "' . $milestone->title . '" visibility to ' . ($milestone->is_published ? 'published' : 'draft'),
            subject: $milestone
        );

        return response()->json([
            'success' => true,
            'message' => 'Milestone visibility updated successfully.',
            'is_published' => $milestone->is_published,
        ]);
    }

    /**
     * Remove the specified milestone from storage.
     */
    public function destroy(int $id): JsonResponse|RedirectResponse
    {
        $milestone = ProjectMilestone::findOrFail($id);
        $title = $milestone->title;

        $milestone->clearMediaCollection('image');
        $milestone->delete();

        ActivityLogger::log(
            action: 'delete',
            module: 'milestone',
            description: 'Deleted milestone "' . $title . '"'
        );

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Milestone deleted successfully.',
            ]);
        }

        return redirect()->route('milestones.index')->with('success', 'Milestone deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamMemberRequest;
use App\Http\Requests\UpdateTeamMemberRequest;
use App\Models\TeamMember;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class TeamMemberController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:team-member-list|team-member-create|team-member-edit|team-member-delete', only: ['index', 'show']),
            new Middleware('permission:team-member-create', only: ['create', 'store']),
            new Middleware('permission:team-member-edit', only: ['edit', 'update', 'toggleStatus']),
            new Middleware('permission:team-member-delete', only: ['destroy']),
        ];
    }

    /**
     * Display listing of team members.
     */
    public function index(Request $request): JsonResponse|View
    {
        if ($request->ajax() || $request->wantsJson()) {
            $query = TeamMember::with(['creator', 'updater', 'media'])->select('team_members.*');

            if ($request->filled('status')) {
                $query->where('is_active', (bool) $request->status);
            }

            if ($request->filled('featured')) {
                $query->where('is_featured', (bool) $request->featured);
            }

            if ($request->filled('department')) {
                $query->where('department', $request->department);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('avatar', function (TeamMember $row) {
                    $photoUrl = $row->photo_url;
                    $initials = strtoupper(substr($row->name, 0, 2));

                    if ($photoUrl) {
                        return '<div class="rounded-circle overflow-hidden d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px; border: 2px solid #e2e8f0; background: #f8fafc;">
                            <img src="' . e($photoUrl) . '" alt="' . e($row->name) . '" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>';
                    }

                    return '<div class="rounded-circle d-inline-flex align-items-center justify-content-center text-primary fw-bold shadow-sm" style="width: 44px; height: 44px; background: #eff6ff; border: 1px solid #bfdbfe; font-size: 13px;">' .
                        e($initials) .
                        '</div>';
                })
                ->addColumn('member_details', function (TeamMember $row) {
                    $contact = [];
                    if ($row->email) $contact[] = '<span class="text-muted"><i class="ri-mail-line me-1"></i>' . e($row->email) . '</span>';
                    if ($row->phone) $contact[] = '<span class="text-muted"><i class="ri-phone-line me-1"></i>' . e($row->phone) . '</span>';
                    $contactInfo = !empty($contact) ? '<div class="mt-1 d-flex gap-2 flex-wrap" style="font-size: 11.5px;">' . implode('<span class="text-muted">·</span>', $contact) . '</div>' : '';

                    return '<div class="d-flex flex-column text-truncate" style="max-width: 260px;">
                        <span class="fw-bold text-dark text-truncate" style="font-size: 14px;">' . e($row->name) . '</span>
                        <span class="text-muted text-truncate" style="font-size: 12px; font-weight: 500;">' . e($row->designation) . '</span>
                        ' . $contactInfo . '
                    </div>';
                })
                ->addColumn('department_badge', function (TeamMember $row) {
                    if (!$row->department) {
                        return '<span class="text-muted fst-italic" style="font-size: 12px;">—</span>';
                    }
                    return '<span class="badge bg-light text-secondary border px-2.5 py-1.5" style="font-size: 11px; font-weight: 600;">
                        <i class="ri-building-line me-1 text-primary"></i>' . e($row->department) . '
                    </span>';
                })
                ->addColumn('social_links', function (TeamMember $row) {
                    $links = '';
                    if ($row->linkedin_url) {
                        $links .= '<a href="' . e($row->linkedin_url) . '" target="_blank" class="btn btn-sm btn-light border text-primary px-2 py-1" title="LinkedIn"><i class="ri-linkedin-fill"></i></a>';
                    }
                    if ($row->twitter_url) {
                        $links .= '<a href="' . e($row->twitter_url) . '" target="_blank" class="btn btn-sm btn-light border text-dark px-2 py-1" title="X / Twitter"><i class="ri-twitter-x-line"></i></a>';
                    }
                    if ($row->facebook_url) {
                        $links .= '<a href="' . e($row->facebook_url) . '" target="_blank" class="btn btn-sm btn-light border text-primary px-2 py-1" title="Facebook"><i class="ri-facebook-fill"></i></a>';
                    }
                    return !empty($links) ? '<div class="d-flex gap-1">' . $links . '</div>' : '<span class="text-muted fst-italic" style="font-size: 12px;">None</span>';
                })
                ->addColumn('status_toggle', function (TeamMember $row) {
                    $checked = $row->is_active ? 'checked' : '';
                    return '<div class="form-check form-switch m-0 d-flex justify-content-center">
                        <input class="form-check-input toggle-member-status" type="checkbox" role="switch" data-id="' . $row->id . '" ' . $checked . ' style="cursor: pointer;">
                    </div>';
                })
                ->addColumn('featured_toggle', function (TeamMember $row) {
                    $checked = $row->is_featured ? 'checked' : '';
                    return '<div class="form-check form-switch m-0 d-flex justify-content-center">
                        <input class="form-check-input toggle-member-featured" type="checkbox" role="switch" data-id="' . $row->id . '" ' . $checked . ' style="cursor: pointer;">
                    </div>';
                })
                ->addColumn('action-btn', function (TeamMember $row) {
                    $user = Auth::user();
                    return [
                        'id' => $row->id,
                        'name' => $row->name,
                        'show_url' => route('team-members.show', $row->id),
                        'edit_url' => route('team-members.edit', $row->id),
                        'delete_url' => route('team-members.destroy', $row->id),
                        'can_edit' => $user && ($user->can('team-member-edit') || $user->hasRole('superadmin')),
                        'can_delete' => $user && ($user->can('team-member-delete') || $user->hasRole('superadmin')),
                    ];
                })
                ->addColumn('action', function (TeamMember $row) {
                    $user = Auth::user();
                    $actions = '<div class="action-btn justify-content-center gap-1">';
                    $actions .= '<a href="' . route('team-members.show', $row->id) . '" class="btn btn-edit" title="View Profile" style="background-color: #f1f5f9; color: #334155;"><i class="ri-eye-line"></i></a>';

                    if ($user && ($user->can('team-member-edit') || $user->hasRole('superadmin'))) {
                        $actions .= '<a href="' . route('team-members.edit', $row->id) . '" class="btn btn-edit" title="Edit Profile"><i class="ri-edit-line"></i></a>';
                    }

                    if ($user && ($user->can('team-member-delete') || $user->hasRole('superadmin'))) {
                        $actions .= '<button type="button" class="btn btn-delete btn-delete-member" data-id="' . $row->id . '" data-name="' . e($row->name) . '" title="Delete Member"><i class="ri-delete-bin-2-line"></i></button>';
                    }

                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['avatar', 'member_details', 'department_badge', 'social_links', 'status_toggle', 'featured_toggle', 'action'])
                ->make(true);
        }

        $stats = [
            'total' => TeamMember::count(),
            'active' => TeamMember::active()->count(),
            'featured' => TeamMember::featured()->count(),
            'departments_count' => TeamMember::whereNotNull('department')->distinct('department')->count('department'),
        ];

        $departments = TeamMember::whereNotNull('department')->distinct()->pluck('department')->sort()->values();

        return view('admin.team-members.index', compact('stats', 'departments'));
    }

    /**
     * Show form for creating a new team member.
     */
    public function create(): View
    {
        $departments = TeamMember::whereNotNull('department')->distinct()->pluck('department')->sort()->values();
        $nextSortOrder = (TeamMember::max('sort_order') ?? 0) + 1;

        return view('admin.team-members.create', compact('departments', 'nextSortOrder'));
    }

    /**
     * Store a newly created team member.
     */
    public function store(StoreTeamMemberRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['sort_order'] = $validated['sort_order'] ?? ((TeamMember::max('sort_order') ?? 0) + 1);
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        $photo = $request->file('photo');
        unset($validated['photo']);

        $teamMember = TeamMember::create($validated);

        if ($photo && $photo->isValid()) {
            $teamMember->addMedia($photo)->toMediaCollection('photo');
        }

        ActivityLogger::log(
            'team_member_created',
            'team-member',
            "Created team member profile '{$teamMember->name}' ({$teamMember->designation})",
            $teamMember
        );

        return redirect()->route('team-members.index')->with('success', "Team member '{$teamMember->name}' created successfully.");
    }

    /**
     * Display specified team member profile.
     */
    public function show(int $id): View
    {
        $teamMember = TeamMember::with(['creator', 'updater', 'media'])->findOrFail($id);

        return view('admin.team-members.show', compact('teamMember'));
    }

    /**
     * Show form for editing team member.
     */
    public function edit(int $id): View
    {
        $teamMember = TeamMember::with(['media'])->findOrFail($id);
        $departments = TeamMember::whereNotNull('department')->distinct()->pluck('department')->sort()->values();

        return view('admin.team-members.edit', compact('teamMember', 'departments'));
    }

    /**
     * Update team member in database.
     */
    public function update(UpdateTeamMemberRequest $request, int $id): RedirectResponse
    {
        $teamMember = TeamMember::findOrFail($id);
        $validated = $request->validated();

        $validated['is_active'] = $request->boolean('is_active', false);
        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['updated_by'] = Auth::id();

        $photo = $request->file('photo');
        unset($validated['photo']);

        $teamMember->update($validated);

        if ($photo && $photo->isValid()) {
            $teamMember->clearMediaCollection('photo');
            $teamMember->addMedia($photo)->toMediaCollection('photo');
        }

        ActivityLogger::log(
            'team_member_updated',
            'team-member',
            "Updated team member profile '{$teamMember->name}'",
            $teamMember
        );

        return redirect()->route('team-members.index')->with('success', "Team member '{$teamMember->name}' updated successfully.");
    }

    /**
     * Delete team member from database.
     */
    public function destroy(int $id): JsonResponse
    {
        $teamMember = TeamMember::findOrFail($id);
        $name = $teamMember->name;

        $teamMember->clearMediaCollection('photo');
        $teamMember->delete();

        ActivityLogger::log(
            'team_member_deleted',
            'team-member',
            "Deleted team member profile '{$name}'"
        );

        return response()->json([
            'success' => true,
            'message' => "Team member '{$name}' deleted successfully.",
        ]);
    }

    /**
     * Toggle active or featured status via AJAX.
     */
    public function toggleStatus(Request $request, int $id): JsonResponse
    {
        $teamMember = TeamMember::findOrFail($id);
        $field = $request->input('field', $request->input('type', 'status'));

        if ($field === 'featured' || $field === 'is_featured') {
            if ($request->has('value')) {
                $teamMember->is_featured = (bool) $request->input('value');
            } else {
                $teamMember->is_featured = !$teamMember->is_featured;
            }
            $teamMember->updated_by = Auth::id();
            $teamMember->save();

            $statusText = $teamMember->is_featured ? 'featured' : 'standard';
            $message = "Team member '{$teamMember->name}' is now marked as {$statusText}.";
        } else {
            if ($request->has('value')) {
                $teamMember->is_active = (bool) $request->input('value');
            } else {
                $teamMember->is_active = !$teamMember->is_active;
            }
            $teamMember->updated_by = Auth::id();
            $teamMember->save();

            $statusText = $teamMember->is_active ? 'active' : 'inactive';
            $message = "Team member '{$teamMember->name}' is now {$statusText}.";
        }

        ActivityLogger::log(
            'team_member_status_toggled',
            'team-member',
            "Toggled {$field} status for '{$teamMember->name}' to '{$statusText}'",
            $teamMember
        );

        return response()->json([
            'success' => true,
            'message' => $message,
            'is_active' => $teamMember->is_active,
            'is_featured' => $teamMember->is_featured,
        ]);
    }
}

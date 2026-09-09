<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:activity-list|user-list|role-list', only: ['index', 'show']),
        ];
    }

    /**
     * Display a listing of activity logs.
     */
    public function index(Request $request): JsonResponse|View
    {
        if ($request->ajax() || $request->wantsJson()) {
            $query = ActivityLog::with(['user', 'subject'])->select('activity_logs.*');

            if ($request->filled('module')) {
                $query->where('module', $request->module);
            }

            if ($request->filled('action')) {
                $query->where('action', $request->action);
            }

            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            if ($request->has('draw')) {
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('user', function ($row) {
                        if ($row->user) {
                            $initials = strtoupper(substr($row->user->name, 0, 1));
                            $avatarColors = ['#f95716', '#4f46e5', '#0284c7', '#059669', '#d97706'];
                            $colorIndex = crc32($row->user->name) % count($avatarColors);
                            $bgColor = $avatarColors[abs($colorIndex)];

                            return '<div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0" style="width: 32px; height: 32px; font-size: 12px; background-color: ' . $bgColor . ';">
                                    ' . e($initials) . '
                                </div>
                                <div class="d-flex flex-column text-truncate">
                                    <span class="fw-bold text-dark text-truncate" style="font-size: 13px;">' . e($row->user->name) . '</span>
                                    <span class="text-muted text-truncate" style="font-size: 11px;">' . e($row->user->email) . '</span>
                                </div>
                            </div>';
                        }

                        return '<div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0" style="width: 32px; height: 32px; font-size: 12px; background-color: #64748b;">
                                S
                            </div>
                            <span class="text-muted fw-semibold" style="font-size: 12.5px;">System / Guest</span>
                        </div>';
                    })
                    ->addColumn('action_badge', function ($row) {
                        $action = strtolower($row->action);
                        $badgeStyles = [
                            'create' => 'background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;',
                            'update' => 'background-color: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;',
                            'delete' => 'background-color: #fee2e2; color: #dc2626; border: 1px solid #fca5a5;',
                            'status_change' => 'background-color: #fef3c7; color: #d97706; border: 1px solid #fde68a;',
                            'delete_media' => 'background-color: #fff1f2; color: #e11d48; border: 1px solid #fecdd3;',
                            'login' => 'background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;',
                            'logout' => 'background-color: #f8fafc; color: #475569; border: 1px solid #cbd5e1;',
                        ];

                        $style = $badgeStyles[$action] ?? 'background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;';
                        $label = ucwords(str_replace('_', ' ', $row->action));

                        return '<span class="badge" style="' . $style . ' font-size: 11px; padding: 4px 8px; border-radius: 4px; font-weight: 600;">' . e($label) . '</span>';
                    })
                    ->addColumn('module_badge', function ($row) {
                        $module = strtolower($row->module);
                        $moduleIcons = [
                            'project' => 'ri-community-line',
                            'service' => 'ri-hammer-line',
                            'enquiry' => 'ri-mail-line',
                            'media' => 'ri-image-line',
                            'user' => 'ri-user-3-line',
                            'role' => 'ri-shield-user-line',
                            'auth' => 'ri-lock-line',
                        ];

                        $icon = $moduleIcons[$module] ?? 'ri-file-list-line';
                        $label = ucfirst($row->module);

                        return '<span class="badge" style="background-color: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; font-size: 11.5px; padding: 4px 8px; border-radius: 4px; font-weight: 600;">
                            <i class="' . $icon . ' me-1 text-primary"></i>' . e($label) . '
                        </span>';
                    })
                    ->addColumn('description_text', function ($row) {
                        return '<span class="text-dark d-inline-block text-truncate" style="max-width: 380px; font-size: 13px;" title="' . e($row->description) . '">' . e($row->description) . '</span>';
                    })
                    ->addColumn('ip_address', function ($row) {
                        return '<code class="text-muted" style="font-size: 11.5px;">' . e($row->ip_address ?? '—') . '</code>';
                    })
                    ->addColumn('timestamp', function ($row) {
                        $date = $row->created_at;
                        if (!$date) {
                            return '—';
                        }
                        return '<div class="d-flex flex-column">
                            <span class="fw-semibold text-dark" style="font-size: 12px;">' . $date->format('M d, Y') . '</span>
                            <span class="text-muted" style="font-size: 10.5px;">' . $date->format('h:i A') . ' (' . $date->diffForHumans() . ')</span>
                        </div>';
                    })
                    ->addColumn('action-btn', function ($row) {
                        return [
                            'id' => $row->id,
                            'can_view' => true,
                        ];
                    })
                    ->rawColumns(['user', 'action_badge', 'module_badge', 'description_text', 'ip_address', 'timestamp', 'action-btn'])
                    ->make(true);
            }

            return response()->json([
                'success' => true,
                'data' => $query->recent()->paginate(25),
            ]);
        }

        $modules = ActivityLog::distinct()->whereNotNull('module')->pluck('module')->sort()->values();
        $actions = ActivityLog::distinct()->whereNotNull('action')->pluck('action')->sort()->values();
        $users = User::orderBy('name')->get(['id', 'name', 'email']);

        return view('admin.activity-logs.index', compact('modules', 'actions', 'users'));
    }

    /**
     * Display the specified activity log.
     */
    public function show(Request $request, int $id): JsonResponse|View
    {
        $log = ActivityLog::with(['user', 'subject'])->findOrFail($id);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $log,
            ]);
        }

        return view('admin.activity-logs.show', compact('log'));
    }
}

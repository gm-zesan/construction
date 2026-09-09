<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:role-list|role-create|role-edit|role-delete', only: ['index', 'store']),
            new Middleware('permission:role-create', only: ['create', 'store']),
            new Middleware('permission:role-edit', only: ['edit', 'update']),
            new Middleware('permission:role-delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $auth_user = Auth::user();
            if ($auth_user && $auth_user->hasRole('superadmin')) {
                $roles = Role::withCount('users')->select('roles.*');
            } else {
                $roles = Role::withCount('users')->where('name', '!=', 'superadmin')->select('roles.*');
            }

            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('display_name', function($row) {
                    $badgeStyle = match($row->name) {
                        'superadmin' => 'background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;',
                        'admin' => 'background-color: #fff3ee; color: #f95716; border: 1px solid rgba(249, 87, 22, 0.3);',
                        'project-manager' => 'background-color: #e0f2fe; color: #075985; border: 1px solid #7dd3fc;',
                        default => 'background-color: #f3e8ff; color: #6b21a8; border: 1px solid #d8b4fe;',
                    };
                    return '<div class="d-flex align-items-center gap-2">' .
                        '<span class="badge" style="' . $badgeStyle . ' font-size: 12px; padding: 4px 10px; border-radius: 4px; font-weight: 600;">' . e(ucwords(str_replace('-', ' ', $row->name))) . '</span>' .
                        '<span class="text-muted" style="font-size: 11.5px; font-family: monospace;">(' . e($row->name) . ')</span>' .
                        '</div>';
                })
                ->addColumn('users_count', function($row) {
                    return '<span class="badge bg-light text-dark border px-2 py-1" style="font-size: 11.5px; font-weight: 600;">' . $row->users_count . ' users</span>';
                })
                ->addColumn('action-btn', function($row) {
                    $auth_user = Auth::user();
                    return [
                        'id' => $row->id,
                        'name' => $row->name,
                        'role' => $auth_user && $auth_user->roles->first() ? $auth_user->roles->first()->name : null,
                        'is_superadmin' => $row->name === 'superadmin',
                        'can_delete' => $row->name !== 'superadmin' && ($auth_user && $auth_user->hasRole('superadmin')),
                        'can_edit' => $row->name !== 'superadmin' || ($auth_user && $auth_user->hasRole('superadmin')),
                    ];
                })
                ->rawColumns(['display_name', 'users_count', 'action-btn'])
                ->make(true);
        }

        $permission = Permission::all();
        $modules = Permission::select('module')->distinct()->get();
        return view('admin.roles.index', compact('permission', 'modules'));
    }

    public function create(): View
    {
        $permission = Permission::all();
        $modules = Permission::select('module')->distinct()->get();
        return view('admin.roles.create', compact('permission', 'modules'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array',
        ]);

        $role = Role::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'guard_name' => 'web',
        ]);

        $permissions = Permission::whereIn('id', $request->input('permission'))->get();
        $role->syncPermissions($permissions);

        return redirect()
            ->route('role.index')
            ->with('success', 'Role created successfully');
    }

    public function show($id): View
    {
        $role = Role::findOrFail($id);
        $rolePermissions = $role->permissions;

        return view('admin.roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id): View
    {
        $auth_user = Auth::user();
        $role = Role::findOrFail($id);

        if ($role->name === 'superadmin' && !$auth_user->hasRole('superadmin')) {
            return redirect()->route('role.index');
        }

        $permission = Permission::all();
        $modules = Permission::select('module')->distinct()->get();
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_id', $id)
            ->pluck('permission_id', 'permission_id')
            ->all();

        return view('admin.roles.edit', compact('role', 'permission', 'rolePermissions', 'modules'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permission' => 'required|array',
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->description = $request->input('description');
        $role->save();

        $permissions = Permission::whereIn('id', $request->input('permission'))->get();
        $role->syncPermissions($permissions);

        return redirect()->route('role.index')
            ->with('success', 'Role updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        if ($role->name === 'superadmin') {
            return redirect()->route('role.index')->with('error', 'Cannot delete superadmin role');
        }

        $role->delete();
        return redirect()->route('role.index')
            ->with('success', 'Role deleted successfully');
    }
}

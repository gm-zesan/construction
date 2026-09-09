<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:user-list|user-create|user-edit|user-delete', only: ['index', 'store']),
            new Middleware('permission:user-create', only: ['create', 'store']),
            new Middleware('permission:user-edit', only: ['edit', 'update']),
            new Middleware('permission:user-delete', only: ['delete']),
            new Middleware('permission:assignrole-create|role-create|role-edit|user-edit', only: ['assignRole']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $auth_user = Auth::user();
            if ($auth_user && $auth_user->hasRole('superadmin')) {
                $users = User::with('roles')->select('users.*');
            } else {
                $users = User::with('roles')
                    ->whereDoesntHave('roles', function ($query) {
                        return $query->where('name', 'superadmin');
                    })
                    ->where('id', '!=', $auth_user->id ?? 0)
                    ->select('users.*');
            }

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('role', function($row) {
                    $role = $row->roles->first();
                    if (!$role) {
                        return '<span class="badge" style="background-color: #f1f5f9; color: #64748b; font-size: 11px; padding: 4px 8px; border: 1px solid #cbd5e1; border-radius: 4px;">No Role</span>';
                    }
                    $badgeStyle = match($role->name) {
                        'superadmin' => 'background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;',
                        'admin' => 'background-color: #fff3ee; color: #f95716; border: 1px solid rgba(249, 87, 22, 0.3);',
                        'project-manager' => 'background-color: #e0f2fe; color: #075985; border: 1px solid #7dd3fc;',
                        default => 'background-color: #f3e8ff; color: #6b21a8; border: 1px solid #d8b4fe;',
                    };
                    return '<span class="badge" style="' . $badgeStyle . ' font-size: 11.5px; padding: 4px 10px; border-radius: 4px; font-weight: 600;">' . e(ucwords(str_replace('-', ' ', $role->name))) . '</span>';
                })
                ->addColumn('action-btn', function($row) {
                    $auth_user = Auth::user();
                    $isSuper = $row->hasRole('superadmin');
                    return [
                        'id' => $row->id,
                        'name' => $row->name,
                        'email' => $row->email,
                        'role' => $row->roles->first()?->name ?? '',
                        'can_delete' => !$isSuper && ($auth_user->id ?? null) !== $row->id,
                        'can_edit' => !$isSuper || (($auth_user->id ?? null) === $row->id),
                        'can_assign' => ($auth_user && ($auth_user->hasRole('superadmin') || $auth_user->can('assignrole-create'))),
                    ];
                })
                ->rawColumns(['role', 'action-btn'])
                ->make(true);
        }

        $auth_user = Auth::user();
        if ($auth_user && $auth_user->hasRole('superadmin')) {
            $roles = Role::pluck('name')->all();
        } else {
            $roles = Role::where('name', '!=', 'superadmin')->pluck('name')->all();
        }

        return view('admin.users.index', compact('roles'));
    }

    public function create()
    {
        $auth_user = Auth::user();
        if ($auth_user && $auth_user->hasRole('superadmin')) {
            $roles = Role::pluck('name')->all();
        } else {
            $roles = Role::where('name', '!=', 'superadmin')->pluck('name')->all();
        }

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:40',
            'email' => 'required|max:100|unique:users',
            'phone_no' => 'nullable|max:100|unique:users',
        ], [
            'name.required' => 'Your name is required',
            'name.max' => 'Your name should be less than 40 characters',
            'email.required' => 'Your email is required',
            'email.max' => 'Your email should be less than 100 characters',
            'email.unique' => 'Your email should be unique',
            'phone_no.unique' => 'Your mobile should be unique',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            ]);
            $image = $request->file('image');
            $destinationPath = 'upload/user-image/';
            if (!file_exists(public_path($destinationPath))) {
                mkdir(public_path($destinationPath), 0755, true);
            }
            $imageValue = $destinationPath . date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move(public_path($destinationPath), basename($imageValue));
            $data['image'] = $imageValue;
        }

        if (!empty($request->password)) {
            $request->validate([
                'password' => 'min:8|confirmed',
            ]);
            $data['password'] = bcrypt($request->password);
        } else {
            $data['password'] = bcrypt('password123');
        }

        $roleToAssign = $request->input('role', 'user');
        if (!Role::where('name', $roleToAssign)->exists()) {
            $roleToAssign = 'user';
        }

        $user = User::create($data);
        $user->assignRole($roleToAssign);

        return redirect()->route('users')->with('message', 'User created successfully');
    }

    public function edit($id)
    {
        $auth_user = Auth::user();
        $user = User::findOrFail($id);

        if ($user->hasRole('superadmin') && ($auth_user->id ?? null) != $user->id) {
            return redirect()->route('users');
        }

        if ($auth_user && $auth_user->hasRole('superadmin')) {
            $roles = Role::pluck('name')->all();
        } else {
            $roles = Role::where('name', '!=', 'superadmin')->pluck('name')->all();
        }

        $userRole = $user->roles->first()?->name ?? 'user';

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:40',
            'email' => 'required|max:100|unique:users,email,' . $id,
            'phone_no' => 'nullable|max:100|unique:users,phone_no,' . $id,
        ], [
            'name.required' => 'Your name is required',
            'name.max' => 'Your name should be less than 40 characters',
            'email.required' => 'Your email is required',
            'email.unique' => 'Your email should be unique',
            'phone_no.unique' => 'Your mobile should be unique',
        ]);

        $data = $request->all();
        $old_data = User::findOrFail($id);

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            ]);
            $image = $request->file('image');
            $destinationPath = 'upload/user-image/';
            if (!file_exists(public_path($destinationPath))) {
                mkdir(public_path($destinationPath), 0755, true);
            }
            $imageValue = $destinationPath . date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move(public_path($destinationPath), basename($imageValue));
            $data['image'] = $imageValue;

            if ($old_data->image && file_exists(public_path($old_data->image))) {
                @unlink(public_path($old_data->image));
            }
        }

        if (!empty($request->password)) {
            $request->validate([
                'password' => 'min:8|confirmed',
            ]);
            $data['password'] = bcrypt($request->password);
        } else {
            $data['password'] = $old_data->password;
        }

        if ($request->filled('role') && Role::where('name', $request->role)->exists()) {
            $old_data->syncRoles([$request->role]);
        }

        $old_data->update($data);
        return redirect()->route('users')->with('message', 'User updated successfully');
    }

    public function delete($id)
    {
        $old_data = User::findOrFail($id);
        if ($old_data->hasRole('superadmin')) {
            return redirect()->route('users')->with('error', 'Cannot delete superadmin');
        }

        if ($old_data->image && file_exists(public_path($old_data->image))) {
            @unlink(public_path($old_data->image));
        }

        $old_data->delete();
        return redirect()->route('users')->with('message', 'User deleted successfully');
    }

    public function assignRole(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::where('email', $request->email)->firstOrFail();
        $user->syncRoles([$request->role]);

        return back()->with('success', 'Role assigned successfully to ' . $user->name);
    }
}

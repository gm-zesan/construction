<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AssignRoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:assignrole-list|assignrole-create|role-list', only: ['index']),
            new Middleware('permission:assignrole-create|role-create|role-edit', only: ['assignRole']),
        ];
    }

    public function index(Request $request)
    {
        $auth_user = Auth::user();
        if ($auth_user && $auth_user->hasRole('superadmin')) {
            $users = User::all();
            $roles = Role::pluck('name')->all();
        } else {
            $users = User::whereHas('roles', function ($query) {
                return $query->where('name', '!=', 'superadmin');
            })->with('roles')->get();
            $roles = Role::where('name', '!=', 'superadmin')->pluck('name')->all();
        }

        if ($request->ajax()) {
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('role', function($row) {
                    if ($row->roles->first() == null) {
                        return '- - -';
                    }
                    return $row->roles->first()->name;
                })
                ->addColumn('action-btn', function($row) {
                    return [
                        'id' => $row->id,
                        'name' => $row->name,
                        'email' => $row->email,
                        'role' => $row->roles->first()->name ?? null,
                    ];
                })
                ->rawColumns(['action-btn'])
                ->make(true);
        }

        return view('admin.assign-role.index', ['roles' => $roles]);
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

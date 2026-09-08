<?php

namespace App\Http\Controllers;

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
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $auth_user = Auth::user();
            if ($auth_user && $auth_user->hasRole('superadmin')) {
                $users = User::all();
            } else {
                $users = User::whereHas('roles', function ($query) {
                    return $query->where('name', '!=', 'superadmin');
                })->where('id', '!=', $auth_user->id ?? 0)->get();
            }

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('action-btn', function($row) {
                    return $row->id;
                })
                ->rawColumns(['action-btn'])
                ->make(true);
        }

        return view('admin.users.index');
    }

    public function create()
    {
        return view('admin.users.create');
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

        $user = User::create($data);
        $user->assignRole('user');

        return redirect()->route('users')->with('message', 'User created successfully');
    }

    public function edit($id)
    {
        $auth_user = Auth::user();
        $user = User::findOrFail($id);

        if ($user->hasRole('superadmin') && ($auth_user->id ?? null) != $user->id) {
            return redirect()->route('users');
        }

        return view('admin.users.edit', [
            'user' => $user,
        ]);
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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:role-list|role-create|role-edit|role-delete', only: ['index', 'store', 'update', 'destroy']),
        ];
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax() || $request->wantsJson()) {
            $query = Permission::query();

            if ($request->filled('module')) {
                $query->where('module', $request->input('module'));
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('module_badge', function (Permission $row) {
                    $color = match($row->module) {
                        'project' => 'background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;',
                        'service' => 'background-color: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0;',
                        'blog' => 'background-color: #fff7ed; color: #c2410c; border: 1px solid #ffedd5;',
                        'media' => 'background-color: #fdf4ff; color: #a21caf; border: 1px solid #f5d0fe;',
                        'role', 'assign-role', 'user' => 'background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;',
                        default => 'background-color: #f8fafc; color: #475569; border: 1px solid #e2e8f0;',
                    };

                    return '<span class="badge" style="' . $color . ' font-size: 11.5px; font-weight: 600; padding: 4px 10px; border-radius: 4px;">' .
                        e(ucwords(str_replace(['-', '_'], ' ', $row->module))) .
                        '</span>';
                })
                ->addColumn('code_badge', function (Permission $row) {
                    return '<code class="px-2 py-1 bg-light text-dark rounded border" style="font-size: 12px; font-family: monospace;">' . e($row->name) . '</code>';
                })
                ->addColumn('action-btn', function (Permission $row) {
                    return [
                        'id' => $row->id,
                        'name' => $row->name,
                        'display_name' => $row->display_name,
                        'module' => $row->module,
                    ];
                })
                ->rawColumns(['module_badge', 'code_badge'])
                ->make(true);
        }

        $modules = Permission::select('module')->distinct()->orderBy('module')->pluck('module');
        return view('admin.permissions.index', compact('modules'));
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'module' => 'required|string|max:100',
            'display_name' => 'required|string|max:255',
            'name' => 'nullable|string|max:255|unique:permissions,name',
        ]);

        $name = !empty($validated['name'])
            ? Str::slug($validated['name'])
            : Str::slug($validated['module'] . '-' . $validated['display_name']);

        // Check uniqueness if generated
        $counter = 1;
        $originalName = $name;
        while (Permission::where('name', $name)->exists()) {
            $name = $originalName . '-' . $counter;
            $counter++;
        }

        $module = Str::slug($validated['module']);

        $permission = Permission::create([
            'name' => $name,
            'display_name' => $validated['display_name'],
            'module' => $module,
            'guard_name' => 'web',
        ]);

        // Clear Spatie Permission Cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Permission created successfully!',
                'data' => [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'display_name' => $permission->display_name,
                    'module' => $permission->module,
                    'module_title' => ucwords(str_replace(['-', '_'], ' ', $permission->module)),
                ],
            ]);
        }

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully!');
    }

    public function update(Request $request, $id): RedirectResponse|JsonResponse
    {
        $permission = Permission::findOrFail($id);

        $validated = $request->validate([
            'module' => 'required|string|max:100',
            'display_name' => 'required|string|max:255',
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
        ]);

        $permission->update([
            'name' => Str::slug($validated['name']),
            'display_name' => $validated['display_name'],
            'module' => Str::slug($validated['module']),
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Permission updated successfully!',
                'data' => $permission,
            ]);
        }

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully!');
    }

    public function destroy(Request $request, $id): RedirectResponse|JsonResponse
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Permission deleted successfully!',
            ]);
        }

        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:user-list|role-list', only: ['index', 'show']),
        ];
    }

    /**
     * Display a listing of activity logs.
     */
    public function index(Request $request): JsonResponse
    {
        $query = ActivityLog::with('user')->select('activity_logs.*');

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
                ->make(true);
        }

        return response()->json([
            'success' => true,
            'data' => $query->recent()->paginate(25),
        ]);
    }

    /**
     * Display the specified activity log.
     */
    public function show(int $id): JsonResponse
    {
        $log = ActivityLog::with(['user', 'subject'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $log,
        ]);
    }
}

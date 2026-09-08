<?php

namespace App\Http\Controllers;

use App\Enums\EnquiryStatus;
use App\Http\Requests\UpdateClientEnquiryRequest;
use App\Models\ClientEnquiry;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;

class ClientEnquiryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:contact-list', only: ['index', 'show', 'update']),
            new Middleware('permission:contact-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of enquiries.
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->ajax() || $request->wantsJson()) {
            $query = ClientEnquiry::with(['service', 'project'])->select('client_enquiries.*');

            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }

            if ($request->has('draw')) {
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->make(true);
            }

            return response()->json([
                'success' => true,
                'data' => $query->recent()->paginate(20),
            ]);
        }

        $enquiries = ClientEnquiry::with(['service', 'project'])->recent()->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $enquiries,
        ]);
    }

    /**
     * Display the specified enquiry and mark as read if newly opened.
     */
    public function show(int $id): JsonResponse
    {
        $enquiry = ClientEnquiry::with(['service', 'project'])->findOrFail($id);

        if ($enquiry->status === EnquiryStatus::NEW) {
            $enquiry->update(['status' => EnquiryStatus::READ]);

            ActivityLogger::log(
                action: 'status_change',
                module: 'enquiry',
                description: 'Enquiry from "' . $enquiry->name . '" marked as read',
                subject: $enquiry,
                oldValues: ['status' => 'new'],
                newValues: ['status' => 'read']
            );
        }

        return response()->json([
            'success' => true,
            'data' => $enquiry,
        ]);
    }

    /**
     * Update enquiry status and internal notes.
     */
    public function update(UpdateClientEnquiryRequest $request, int $id): JsonResponse|RedirectResponse
    {
        $enquiry = ClientEnquiry::findOrFail($id);
        $oldValues = [
            'status' => $enquiry->status instanceof EnquiryStatus ? $enquiry->status->value : $enquiry->status,
            'internal_notes' => $enquiry->internal_notes,
        ];

        $validated = $request->validated();
        $enquiry->update($validated);

        ActivityLogger::log(
            action: 'status_change',
            module: 'enquiry',
            description: 'Updated enquiry status/notes for "' . $enquiry->name . '"',
            subject: $enquiry,
            oldValues: $oldValues,
            newValues: [
                'status' => $enquiry->status instanceof EnquiryStatus ? $enquiry->status->value : $enquiry->status,
                'internal_notes' => $enquiry->internal_notes,
            ]
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Enquiry updated successfully',
                'data' => $enquiry,
            ]);
        }

        return redirect()->back()->with('success', 'Enquiry updated successfully');
    }

    /**
     * Remove the specified enquiry.
     */
    public function destroy(int $id): JsonResponse|RedirectResponse
    {
        $enquiry = ClientEnquiry::findOrFail($id);
        $name = $enquiry->name;
        $oldValues = [
            'name' => $enquiry->name,
            'email' => $enquiry->email,
            'status' => $enquiry->status instanceof EnquiryStatus ? $enquiry->status->value : $enquiry->status,
        ];

        $enquiry->delete();

        ActivityLogger::log(
            action: 'delete',
            module: 'enquiry',
            description: 'Deleted enquiry from "' . $name . '"',
            oldValues: $oldValues
        );

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Enquiry deleted successfully',
            ]);
        }

        return redirect()->back()->with('success', 'Enquiry deleted successfully');
    }
}

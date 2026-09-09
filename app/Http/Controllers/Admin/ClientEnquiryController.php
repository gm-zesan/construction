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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ClientEnquiryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:contact-list', only: ['index', 'show', 'update', 'updateStatus']),
            new Middleware('permission:contact-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of enquiries.
     */
    public function index(Request $request): JsonResponse|View
    {
        if ($request->ajax() || $request->wantsJson()) {
            $query = ClientEnquiry::with(['service', 'project'])->select('client_enquiries.*');

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->has('draw')) {
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('name', function ($row) {
                        $isUnread = ($row->status === EnquiryStatus::NEW || $row->status === 'new');
                        $unreadDot = $isUnread ? '<span class="badge bg-danger rounded-circle p-1 me-2" style="display:inline-block; width: 8px; height: 8px;" title="Unread"></span>' : '';
                        $fontWeight = $isUnread ? 'font-weight: 700;' : 'font-weight: 500;';
                        return '<div class="d-flex align-items-center">
                            ' . $unreadDot . '
                            <span class="text-dark" style="font-size: 13.5px; ' . $fontWeight . '">' . e($row->name) . '</span>
                        </div>';
                    })
                    ->addColumn('email', function ($row) {
                        return '<span style="font-size: 13px;">' . e($row->email) . '</span>';
                    })
                    ->addColumn('subject', function ($row) {
                        $isUnread = ($row->status === EnquiryStatus::NEW || $row->status === 'new');
                        $fontWeight = $isUnread ? 'font-weight: 700;' : 'font-weight: 500;';
                        return '<span class="text-dark d-inline-block text-truncate" style="max-width: 360px; font-size: 13px; ' . $fontWeight . '" title="' . e($row->subject) . '">' . e($row->subject) . '</span>';
                    })
                    ->addColumn('status_badge', function ($row) {
                        $status = $row->status instanceof EnquiryStatus ? $row->status : EnquiryStatus::tryFrom($row->status);
                        $badgeStyle = $status ? $status->badgeStyle() : 'background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;';
                        $label = $status ? ($status === EnquiryStatus::NEW ? 'Unread' : $status->label()) : ucfirst($row->status);

                        return '<span class="badge" style="' . $badgeStyle . ' font-size: 11.5px; padding: 4px 8px; border-radius: 4px; font-weight: 600;">' . e($label) . '</span>';
                    })
                    ->addColumn('action-btn', function ($row) {
                        $auth = Auth::user();
                        return [
                            'id' => $row->id,
                            'name' => $row->name,
                            'subject' => $row->subject,
                            'can_view' => true,
                            'can_delete' => $auth ? ($auth->hasRole('superadmin') || $auth->can('contact-delete')) : true,
                        ];
                    })
                    ->rawColumns(['name', 'email', 'phone', 'subject', 'status_badge', 'action-btn'])
                    ->make(true);
            }

            return response()->json([
                'success' => true,
                'data' => $query->recent()->paginate(20),
            ]);
        }

        $statuses = EnquiryStatus::cases();

        return view('admin.enquiries.index', compact('statuses'));
    }

    /**
     * Display the specified enquiry and mark as read if newly opened.
     */
    public function show(Request $request, int $id): JsonResponse|View
    {
        $enquiry = ClientEnquiry::with(['service', 'project'])->findOrFail($id);

        // Mark as read if currently new/unread
        if ($enquiry->status === EnquiryStatus::NEW || $enquiry->status === 'new') {
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

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $enquiry,
            ]);
        }

        $statuses = EnquiryStatus::cases();

        return view('admin.enquiries.show', compact('enquiry', 'statuses'));
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
            action: 'update',
            module: 'enquiry',
            description: 'Updated enquiry status/notes for "' . $enquiry->name . '"',
            subject: $enquiry,
            oldValues: $oldValues,
            newValues: [
                'status' => $enquiry->status instanceof EnquiryStatus ? $enquiry->status->value : $enquiry->status,
                'internal_notes' => $enquiry->internal_notes,
            ]
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Enquiry updated successfully',
                'data' => $enquiry,
            ]);
        }

        return redirect()->route('enquiries.show', $enquiry->id)->with('success', 'Enquiry updated successfully');
    }

    /**
     * Fast AJAX Status update.
     */
    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'status' => ['required', Rule::enum(EnquiryStatus::class)],
        ]);

        $enquiry = ClientEnquiry::findOrFail($id);
        $oldStatus = $enquiry->status instanceof EnquiryStatus ? $enquiry->status->value : $enquiry->status;
        $newStatus = $request->status instanceof EnquiryStatus ? $request->status->value : $request->status;

        if ($oldStatus !== $newStatus) {
            $enquiry->update(['status' => $newStatus]);

            ActivityLogger::log(
                action: 'status_change',
                module: 'enquiry',
                description: 'Changed enquiry status for "' . $enquiry->name . '" to ' . ucfirst($newStatus),
                subject: $enquiry,
                oldValues: ['status' => $oldStatus],
                newValues: ['status' => $newStatus]
            );
        }

        $enumStatus = $enquiry->status instanceof EnquiryStatus ? $enquiry->status : EnquiryStatus::tryFrom($enquiry->status);

        return response()->json([
            'success' => true,
            'message' => 'Status updated to ' . ($enumStatus ? ($enumStatus === EnquiryStatus::NEW ? 'Unread' : $enumStatus->label()) : ucfirst($enquiry->status)),
            'status' => $enumStatus ? $enumStatus->value : $enquiry->status,
            'badgeStyle' => $enumStatus ? $enumStatus->badgeStyle() : '',
        ]);
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

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Enquiry deleted successfully',
            ]);
        }

        return redirect()->route('enquiries.index')->with('success', 'Enquiry deleted successfully');
    }
}

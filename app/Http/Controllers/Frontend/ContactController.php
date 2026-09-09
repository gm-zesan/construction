<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\EnquiryStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePublicEnquiryRequest;
use App\Models\ClientEnquiry;
use App\Models\Project;
use App\Models\Service;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display the public Contact and Consultation page.
     */
    public function index(Request $request): View
    {
        // Fetch active services & projects for enquiry form select dropdowns
        $services = Service::where('is_published', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('title', 'asc')
            ->get(['id', 'title', 'slug']);

        $projects = Project::where('is_published', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('title', 'asc')
            ->get(['id', 'title', 'slug']);

        // Check if pre-selected service or project was passed via query params
        $selectedServiceId = $request->query('service_id');
        $selectedProjectId = $request->query('project_id');

        return view('frontend.contact', compact(
            'services',
            'projects',
            'selectedServiceId',
            'selectedProjectId'
        ));
    }

    /**
     * Handle public project / consultation enquiry submission.
     */
    public function store(StorePublicEnquiryRequest $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();

        // Ensure default status and timestamp
        $validated['status'] = EnquiryStatus::NEW;
        $validated['submitted_at'] = now();

        $enquiry = ClientEnquiry::create($validated);

        // Log public submission for audit trail
        ActivityLogger::log(
            action: 'create',
            module: 'enquiry',
            description: 'New public consultation enquiry from "' . $enquiry->name . '" (' . $enquiry->email . ')',
            subject: $enquiry,
            newValues: [
                'name' => $enquiry->name,
                'email' => $enquiry->email,
                'phone' => $enquiry->phone,
                'company' => $enquiry->company,
                'subject' => $enquiry->subject,
                'service_id' => $enquiry->service_id,
                'project_id' => $enquiry->project_id,
                'status' => 'new',
            ]
        );

        $successMessage = get_content(
            'contact',
            'form',
            'success_message',
            'Thank you for reaching out. Your project enquiry has been submitted to our estimating team. We will review your requirements and respond within 1 business day.'
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $successMessage,
                'data' => [
                    'id' => $enquiry->id,
                    'name' => $enquiry->name,
                ],
            ]);
        }

        return redirect()
            ->route('contact')
            ->with('success', $successMessage)
            ->with('enquiry_submitted', true);
    }
}

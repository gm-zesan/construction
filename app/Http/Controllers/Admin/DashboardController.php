<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EnquiryStatus;
use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ClientEnquiry;
use App\Models\ClientReview;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the administration dashboard.
     */
    public function index(): View
    {
        $stats = [
            'total_projects' => Project::count(),
            'ongoing_projects' => Project::where('status', ProjectStatus::ONGOING)->count(),
            'completed_projects' => Project::where('status', ProjectStatus::COMPLETED)->count(),
            'upcoming_projects' => Project::where('status', ProjectStatus::UPCOMING)->count(),
            'total_services' => Service::count(),
            'new_enquiries' => ClientEnquiry::where('status', EnquiryStatus::NEW)->count(),
            'total_articles' => Article::count(),
            'total_reviews' => ClientReview::count(),
        ];

        $recent_projects = Project::with(['media'])
            ->latest('id')
            ->take(5)
            ->get();

        $recent_enquiries = ClientEnquiry::with(['service'])
            ->latest('id')
            ->take(5)
            ->get();

        return view('admin.home.index', compact('stats', 'recent_projects', 'recent_enquiries'));
    }

    /**
     * Clear system cache via Ajax.
     */
    public function clearCache(Request $request): JsonResponse|RedirectResponse
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('config:clear');

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'System, configuration, and view cache cleared successfully!'
                ]);
            }

            return back()->with('success', 'System cache cleared successfully!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to clear cache: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to clear cache.');
        }
    }
}

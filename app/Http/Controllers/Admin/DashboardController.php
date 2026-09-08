<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the administration dashboard.
     */
    public function index()
    {
        $stats = [
            'total_projects' => 24,
            'active_sites' => 8,
            'completed_projects' => 16,
            'today_inquiries' => 5,
            'week_inquiries' => 19,
            'total_inquiries' => 142,
            'team_engineers' => 38,
            'safety_score' => 99.4,
        ];

        $recent_projects = [
            [
                'id' => 1,
                'name' => 'Metropolitan Skyway & Commercial Tower',
                'category' => 'Commercial High-Rise',
                'location' => 'Dhaka Financial District',
                'status' => 'in_progress',
                'progress' => 82,
                'budget' => '$45.2M',
                'updated' => '2 hours ago',
            ],
            [
                'id' => 2,
                'name' => 'Apex Industrial Logistics Hub',
                'category' => 'Heavy Structural Steel',
                'location' => 'Chittagong Economic Zone',
                'status' => 'approved',
                'progress' => 100,
                'budget' => '$28.6M',
                'updated' => 'Yesterday',
            ],
            [
                'id' => 3,
                'name' => 'Meridian Waterfront Civic Center',
                'category' => 'Architectural Concrete',
                'location' => 'North Bank Waterfront',
                'status' => 'verified',
                'progress' => 64,
                'budget' => '$36.0M',
                'updated' => '3 days ago',
            ],
            [
                'id' => 4,
                'name' => 'Crestview Multi-Tier Transit Terminal',
                'category' => 'Civic Infrastructure',
                'location' => 'Metropolitan Interchange',
                'status' => 'pending',
                'progress' => 35,
                'budget' => '$52.8M',
                'updated' => '5 days ago',
            ],
        ];

        $recent_inquiries = [
            [
                'name' => 'Aylani Rowyn',
                'company' => 'Aura Development Corp',
                'email' => 'aylani@auradev.com',
                'project_type' => 'Commercial High-Rise',
                'message' => 'Looking for structural engineering consultation and general contracting for a 32-story commercial project.',
                'date' => now()->subHours(3)->format('d M Y, h:i A'),
            ],
            [
                'name' => 'Elena Rostova',
                'company' => 'Vanguard Logistics',
                'email' => 'e.rostova@vanguardlog.com',
                'project_type' => 'Industrial Warehouse',
                'message' => 'Requesting proposal for heavy structural steel warehouse fitout and concrete foundation work.',
                'date' => now()->subHours(7)->format('d M Y, h:i A'),
            ],
            [
                'name' => 'David Sterling',
                'company' => 'Sterling Estates',
                'email' => 'david@sterlingestates.com',
                'project_type' => 'Adaptive Reuse & Renovation',
                'message' => 'Need full superintendent site management and architectural retrofit for historic property.',
                'date' => now()->subDay()->format('d M Y, h:i A'),
            ],
        ];

        return view('admin.home.index', compact('stats', 'recent_projects', 'recent_inquiries'));
    }

    /**
     * Clear system cache via Ajax.
     */
    public function clearCache(Request $request)
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('config:clear');

            if ($request->ajax()) {
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

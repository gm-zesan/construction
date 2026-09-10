<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends Controller
{
    /**
     * Display the comprehensive Team & Engineering Leadership directory.
     */
    public function index(Request $request): View
    {
        $department = $request->query('department');
        $search = $request->query('search');

        $query = TeamMember::with('media')
            ->active()
            ->ordered();

        if (!empty($department) && $department !== 'all') {
            $query->where('department', $department);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('designation', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhere('bio', 'like', "%{$search}%");
            });
        }

        $teamMembers = $query->get();

        $departments = TeamMember::active()
            ->whereNotNull('department')
            ->where('department', '!=', '')
            ->distinct()
            ->pluck('department')
            ->sort()
            ->values();

        $featuredLeaders = TeamMember::with('media')
            ->active()
            ->featured()
            ->ordered()
            ->take(3)
            ->get();

        $companyName = WebsiteSetting::get('company_name', 'COMPANY NAME');
        $title = "Our Engineering & Construction Leadership | {$companyName}";

        return theme_view('team.index', compact(
            'teamMembers',
            'departments',
            'featuredLeaders',
            'department',
            'search',
            'title'
        ));
    }

    /**
     * Display the detailed profile of an individual team member / engineer.
     */
    public function show(int $id): View
    {
        $member = TeamMember::with('media')
            ->active()
            ->findOrFail($id);

        $relatedMembers = TeamMember::with('media')
            ->active()
            ->where('id', '!=', $member->id)
            ->when($member->department, function ($q) use ($member) {
                $q->where('department', $member->department);
            })
            ->ordered()
            ->take(3)
            ->get();

        // If not enough in the same department, fill with other active members
        if ($relatedMembers->count() < 3) {
            $fallbackMembers = TeamMember::with('media')
                ->active()
                ->where('id', '!=', $member->id)
                ->whereNotIn('id', $relatedMembers->pluck('id'))
                ->ordered()
                ->take(3 - $relatedMembers->count())
                ->get();

            $relatedMembers = $relatedMembers->merge($fallbackMembers);
        }

        $companyName = WebsiteSetting::get('company_name', 'COMPANY NAME');
        $title = "{$member->name} — {$member->designation} | {$companyName}";

        return theme_view('team.show', compact('member', 'relatedMembers', 'title'));
    }
}

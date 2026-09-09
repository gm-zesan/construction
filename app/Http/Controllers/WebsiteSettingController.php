<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateWebsiteSettingsRequest;
use App\Models\WebsiteSetting;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class WebsiteSettingController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:website-setting-list|website-setting-edit', only: ['index']),
            new Middleware('permission:website-setting-edit', only: ['update']),
        ];
    }

    /**
     * Display the Website Settings Workspace.
     */
    public function index(Request $request): View
    {
        $activeGroup = $request->query('group', 'general');
        $allSettings = WebsiteSetting::all();
        $settings = $allSettings->pluck('value', 'key')->toArray();
        $groupedSettings = $allSettings->groupBy('group');
        $groupMeta = WebsiteSetting::getGroupMeta();

        return view('admin.settings.index', compact('settings', 'groupedSettings', 'groupMeta', 'activeGroup'));
    }

    /**
     * Update the global website settings.
     */
    public function update(UpdateWebsiteSettingsRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $oldSettings = WebsiteSetting::pluck('value', 'key')->toArray();

        // Handle Site Logo Upload / Removal
        if ($request->boolean('remove_logo')) {
            $currentLogo = WebsiteSetting::get('site_logo');
            if ($currentLogo && file_exists(public_path($currentLogo))) {
                @unlink(public_path($currentLogo));
            }
            $validated['site_logo'] = null;
        } elseif ($request->hasFile('site_logo')) {
            $logoFile = $request->file('site_logo');
            $destDir = 'upload/settings/';
            if (!file_exists(public_path($destDir))) {
                mkdir(public_path($destDir), 0755, true);
            }
            $logoPath = $destDir . 'logo_' . date('YmdHis') . '_' . uniqid() . '.' . $logoFile->getClientOriginalExtension();
            $logoFile->move(public_path($destDir), basename($logoPath));

            $currentLogo = WebsiteSetting::get('site_logo');
            if ($currentLogo && file_exists(public_path($currentLogo))) {
                @unlink(public_path($currentLogo));
            }
            $validated['site_logo'] = $logoPath;
        } else {
            unset($validated['site_logo']);
        }

        // Handle Site Favicon Upload / Removal
        if ($request->boolean('remove_favicon')) {
            $currentFavicon = WebsiteSetting::get('site_favicon');
            if ($currentFavicon && file_exists(public_path($currentFavicon))) {
                @unlink(public_path($currentFavicon));
            }
            $validated['site_favicon'] = null;
        } elseif ($request->hasFile('site_favicon')) {
            $favFile = $request->file('site_favicon');
            $destDir = 'upload/settings/';
            if (!file_exists(public_path($destDir))) {
                mkdir(public_path($destDir), 0755, true);
            }
            $favPath = $destDir . 'favicon_' . date('YmdHis') . '_' . uniqid() . '.' . $favFile->getClientOriginalExtension();
            $favFile->move(public_path($destDir), basename($favPath));

            $currentFavicon = WebsiteSetting::get('site_favicon');
            if ($currentFavicon && file_exists(public_path($currentFavicon))) {
                @unlink(public_path($currentFavicon));
            }
            $validated['site_favicon'] = $favPath;
        } else {
            unset($validated['site_favicon']);
        }

        unset($validated['remove_logo'], $validated['remove_favicon']);

        // Field definitions mapping to types and groups
        $fieldMeta = [
            'company_name' => ['type' => 'text', 'group' => 'general'],
            'company_tagline' => ['type' => 'text', 'group' => 'general'],
            'site_logo' => ['type' => 'image', 'group' => 'general'],
            'site_favicon' => ['type' => 'image', 'group' => 'general'],

            'primary_phone' => ['type' => 'phone', 'group' => 'contact'],
            'primary_email' => ['type' => 'email', 'group' => 'contact'],
            'whatsapp_number' => ['type' => 'phone', 'group' => 'contact'],
            'office_address' => ['type' => 'textarea', 'group' => 'contact'],
            'google_maps_url' => ['type' => 'url', 'group' => 'contact'],

            'facebook_url' => ['type' => 'url', 'group' => 'social'],
            'instagram_url' => ['type' => 'url', 'group' => 'social'],
            'linkedin_url' => ['type' => 'url', 'group' => 'social'],
            'youtube_url' => ['type' => 'url', 'group' => 'social'],

            'office_hours' => ['type' => 'text', 'group' => 'business'],
            'copyright_text' => ['type' => 'text', 'group' => 'business'],
        ];

        $updatedValues = [];

        foreach ($validated as $key => $value) {
            if (isset($fieldMeta[$key])) {
                WebsiteSetting::updateOrCreate(
                    ['key' => $key],
                    [
                        'value' => $value,
                        'type' => $fieldMeta[$key]['type'],
                        'group' => $fieldMeta[$key]['group'],
                    ]
                );
                $updatedValues[$key] = $value;
            }
        }

        // Flush cache
        Cache::forget(WebsiteSetting::CACHE_KEY);

        // Record Activity Log
        ActivityLogger::log(
            action: 'update',
            module: 'website-setting',
            description: 'Updated global website settings',
            subject: null,
            oldValues: array_intersect_key($oldSettings, $updatedValues),
            newValues: $updatedValues
        );

        $activeGroup = $request->input('active_group', 'general');

        return redirect()->route('settings.index', ['group' => $activeGroup])
            ->with('success', 'Website settings updated successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWebsiteSettingFieldRequest;
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
            new Middleware('permission:website-setting-create|role:superadmin', only: ['storeField']),
            new Middleware('permission:website-setting-delete|role:superadmin', only: ['destroyField']),
        ];
    }

    /**
     * Display the Website Settings Workspace.
     */
    public function index(Request $request): View
    {
        $activeGroup = $request->query('group', 'general');
        $allSettings = WebsiteSetting::orderBy('id')->get();
        $settings = $allSettings->pluck('value', 'key')->toArray();
        $groupedSettings = $allSettings->groupBy('group');
        $groupMeta = WebsiteSetting::getGroupMeta();

        return view('admin.settings.index', compact('settings', 'groupedSettings', 'groupMeta', 'activeGroup'));
    }

    /**
     * Update the global website settings (both default and dynamic custom fields).
     */
    public function update(UpdateWebsiteSettingsRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $oldSettings = WebsiteSetting::pluck('value', 'key')->toArray();
        $allDbSettings = WebsiteSetting::all()->keyBy('key');
        $updatedValues = [];

        // 1. Handle Core Site Logo Upload / Removal
        if ($request->boolean('remove_logo')) {
            $currentLogo = WebsiteSetting::get('site_logo');
            if ($currentLogo && file_exists(public_path($currentLogo))) {
                @unlink(public_path($currentLogo));
            }
            WebsiteSetting::where('key', 'site_logo')->update(['value' => null]);
            $updatedValues['site_logo'] = null;
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
            WebsiteSetting::where('key', 'site_logo')->update(['value' => $logoPath]);
            $updatedValues['site_logo'] = $logoPath;
        }

        // 2. Handle Core Site Favicon Upload / Removal
        if ($request->boolean('remove_favicon')) {
            $currentFavicon = WebsiteSetting::get('site_favicon');
            if ($currentFavicon && file_exists(public_path($currentFavicon))) {
                @unlink(public_path($currentFavicon));
            }
            WebsiteSetting::where('key', 'site_favicon')->update(['value' => null]);
            $updatedValues['site_favicon'] = null;
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
            WebsiteSetting::where('key', 'site_favicon')->update(['value' => $favPath]);
            $updatedValues['site_favicon'] = $favPath;
        }

        // 3. Process all other fields dynamically (both predefined and custom)
        foreach ($request->except(['_token', 'active_group', 'site_logo', 'site_favicon', 'remove_logo', 'remove_favicon']) as $key => $value) {
            if (str_starts_with($key, 'remove_')) {
                continue;
            }

            $settingItem = $allDbSettings->get($key);
            if ($settingItem) {
                if ($settingItem->type === 'image') {
                    if ($request->boolean('remove_' . $key)) {
                        if ($settingItem->value && file_exists(public_path($settingItem->value))) {
                            @unlink(public_path($settingItem->value));
                        }
                        $settingItem->update(['value' => null]);
                        $updatedValues[$key] = null;
                    } elseif ($request->hasFile($key)) {
                        $imgFile = $request->file($key);
                        $destDir = 'upload/settings/';
                        if (!file_exists(public_path($destDir))) {
                            mkdir(public_path($destDir), 0755, true);
                        }
                        $imgPath = $destDir . $key . '_' . date('YmdHis') . '_' . uniqid() . '.' . $imgFile->getClientOriginalExtension();
                        $imgFile->move(public_path($destDir), basename($imgPath));

                        if ($settingItem->value && file_exists(public_path($settingItem->value))) {
                            @unlink(public_path($settingItem->value));
                        }
                        $settingItem->update(['value' => $imgPath]);
                        $updatedValues[$key] = $imgPath;
                    }
                } else {
                    $settingItem->update(['value' => $value]);
                    $updatedValues[$key] = $value;
                }
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

    /**
     * Store a newly created dynamic website setting field (Superadmin only).
     */
    public function storeField(StoreWebsiteSettingFieldRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $setting = WebsiteSetting::create([
            'key' => $validated['key'],
            'label' => $validated['label'],
            'type' => $validated['type'],
            'group' => $validated['group'],
            'placeholder' => $validated['placeholder'] ?? null,
            'value' => $validated['value'] ?? null,
            'col_class' => $validated['col_class'] ?? 'col-md-6 col-12',
            'is_custom' => true,
        ]);

        ActivityLogger::log(
            action: 'create',
            module: 'website-setting',
            description: 'Created dynamic website setting field: ' . $setting->label . ' (' . $setting->key . ')',
            subject: $setting,
            oldValues: null,
            newValues: $setting->toArray()
        );

        return redirect()->route('settings.index', ['group' => $validated['group']])
            ->with('success', 'New setting field "' . $setting->label . '" created successfully.');
    }

    /**
     * Remove a dynamic custom setting field (Superadmin only).
     */
    public function destroyField(int $id): RedirectResponse
    {
        $setting = WebsiteSetting::findOrFail($id);

        if (!$setting->is_custom) {
            return redirect()->back()->with('error', 'Default core system settings cannot be deleted.');
        }

        $label = $setting->label;
        $group = $setting->group;
        $oldValues = $setting->toArray();

        if ($setting->type === 'image' && $setting->value && file_exists(public_path($setting->value))) {
            @unlink(public_path($setting->value));
        }

        $setting->delete();

        ActivityLogger::log(
            action: 'delete',
            module: 'website-setting',
            description: 'Deleted dynamic website setting field: ' . $label,
            subject: null,
            oldValues: $oldValues,
            newValues: null
        );

        return redirect()->route('settings.index', ['group' => $group])
            ->with('success', 'Custom setting field "' . $label . '" deleted successfully.');
    }
}

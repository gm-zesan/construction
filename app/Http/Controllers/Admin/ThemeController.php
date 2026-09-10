<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ThemeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:theme-list|theme-edit|theme-active', only: ['index']),
            new Middleware('permission:theme-active|theme-edit', only: ['activate']),
            new Middleware('permission:theme-create|role:superadmin', only: ['store', 'scan']),
            new Middleware('permission:theme-edit|role:superadmin', only: ['update']),
            new Middleware('permission:theme-delete|role:superadmin', only: ['destroy']),
        ];
    }

    /**
     * Display the Theme Management gallery.
     */
    public function index(): View
    {
        $themes = Theme::orderByDesc('is_active')
            ->orderBy('name')
            ->get();

        $activeTheme = Theme::getActiveTheme() ?? $themes->firstWhere('is_active', true);
        
        // Count total views available across themes
        $themeDirs = File::isDirectory(resource_path('views/themes')) 
            ? File::directories(resource_path('views/themes')) 
            : [];

        return view('admin.themes.index', compact('themes', 'activeTheme', 'themeDirs'));
    }

    /**
     * Activate a theme.
     */
    public function activate(Request $request, int $id): JsonResponse|RedirectResponse
    {
        $theme = Theme::findOrFail($id);
        $oldActiveTheme = Theme::getActiveTheme();

        Theme::activateTheme($theme->id);

        ActivityLogger::log(
            action: 'update',
            module: 'theme',
            description: "Activated theme '{$theme->name}' ({$theme->directory})",
            subject: $theme,
            oldValues: ['active_theme' => $oldActiveTheme?->slug],
            newValues: ['active_theme' => $theme->slug]
        );

        $message = "Theme '{$theme->name}' is now active on the public website!";

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'theme' => $theme,
            ]);
        }

        return redirect()->route('themes.index')->with('success', $message);
    }

    /**
     * Store a new custom theme.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'directory' => 'required|string|max:50|alpha_dash|unique:themes,directory',
            'description' => 'nullable|string|max:500',
            'author' => 'nullable|string|max:100',
            'version' => 'nullable|string|max:20',
            'preview_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        // Handle preview image upload
        if ($request->hasFile('preview_image')) {
            $imageName = 'theme_' . $validated['directory'] . '_' . time() . '.' . $request->file('preview_image')->getClientOriginalExtension();
            $request->file('preview_image')->move(public_path('images/themes'), $imageName);
            $validated['preview_image'] = 'images/themes/' . $imageName;
        }

        // Create theme view folder if it does not exist
        $targetPath = resource_path("views/themes/{$validated['directory']}");
        if (!File::exists($targetPath)) {
            File::makeDirectory($targetPath, 0755, true);
            // Create subdirectories
            File::makeDirectory("{$targetPath}/layouts", 0755, true);
            File::makeDirectory("{$targetPath}/partials", 0755, true);
        }

        $theme = Theme::create($validated);

        ActivityLogger::log(
            action: 'create',
            module: 'theme',
            description: "Created new theme '{$theme->name}'",
            subject: $theme,
            newValues: $theme->toArray()
        );

        return redirect()->route('themes.index')->with('success', "Theme '{$theme->name}' registered successfully!");
    }

    /**
     * Update theme details.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $theme = Theme::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'author' => 'nullable|string|max:100',
            'version' => 'nullable|string|max:20',
            'preview_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('preview_image')) {
            // Remove old custom preview image if exists
            if ($theme->preview_image && File::exists(public_path($theme->preview_image))) {
                File::delete(public_path($theme->preview_image));
            }

            $imageName = 'theme_' . $theme->directory . '_' . time() . '.' . $request->file('preview_image')->getClientOriginalExtension();
            $request->file('preview_image')->move(public_path('images/themes'), $imageName);
            $validated['preview_image'] = 'images/themes/' . $imageName;
        }

        $theme->update($validated);
        Theme::clearThemeCache();

        ActivityLogger::log(
            action: 'update',
            module: 'theme',
            description: "Updated metadata for theme '{$theme->name}'",
            subject: $theme,
            newValues: $validated
        );

        return redirect()->route('themes.index')->with('success', "Theme '{$theme->name}' updated successfully!");
    }

    /**
     * Delete an inactive custom theme.
     */
    public function destroy(int $id): RedirectResponse
    {
        $theme = Theme::findOrFail($id);

        if ($theme->is_active) {
            return redirect()->route('themes.index')->with('error', 'Cannot delete the currently active theme! Please activate another theme first.');
        }

        if ($theme->directory === 'default') {
            return redirect()->route('themes.index')->with('error', 'The default theme is protected and cannot be deleted.');
        }

        if ($theme->preview_image && File::exists(public_path($theme->preview_image))) {
            File::delete(public_path($theme->preview_image));
        }

        $themeName = $theme->name;
        $theme->delete();
        Theme::clearThemeCache();

        ActivityLogger::log(
            action: 'delete',
            module: 'theme',
            description: "Deleted theme '{$themeName}'",
            subject: null
        );

        return redirect()->route('themes.index')->with('success', "Theme '{$themeName}' was removed successfully.");
    }

    /**
     * Auto-scan filesystem for theme folders.
     */
    public function scan(): RedirectResponse
    {
        $baseThemesPath = resource_path('views/themes');
        if (!File::isDirectory($baseThemesPath)) {
            return redirect()->route('themes.index')->with('info', 'No themes directory found.');
        }

        $directories = File::directories($baseThemesPath);
        $added = 0;

        foreach ($directories as $dirPath) {
            $folderName = basename($dirPath);
            $exists = Theme::where('directory', $folderName)->exists();

            if (!$exists) {
                Theme::create([
                    'name' => ucwords(str_replace(['-', '_'], ' ', $folderName)),
                    'slug' => Str::slug($folderName),
                    'directory' => $folderName,
                    'description' => "Auto-discovered theme located in resources/views/themes/{$folderName}",
                    'version' => '1.0.0',
                    'is_active' => false,
                ]);
                $added++;
            }
        }

        Theme::clearThemeCache();

        return redirect()->route('themes.index')->with('success', "Scan complete. {$added} new themes registered.");
    }
}

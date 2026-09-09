<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateContentManagementRequest;
use App\Models\WebsiteContent;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ContentManagementController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:website-content-list|website-content-edit|website-content-create|website-content-delete', only: ['index']),
            new Middleware('permission:website-content-edit', only: ['update']),
            new Middleware('permission:website-content-create', only: ['storeField']),
            new Middleware('permission:website-content-delete', only: ['destroyField']),
        ];
    }

    /**
     * Display the Content Management Workspace for the selected page.
     */
    public function index(Request $request): View
    {
        $availablePages = WebsiteContent::getAvailablePagesWithMeta();
        $activePage = $request->query('page', array_key_first($availablePages) ?? 'home');

        if (!array_key_exists($activePage, $availablePages)) {
            $activePage = array_key_first($availablePages) ?? 'home';
        }

        $sectionsMeta = WebsiteContent::getPageSectionsWithMeta($activePage);
        $allRecords = WebsiteContent::with('media')
            ->where('page', $activePage)
            ->orderBy('id', 'asc')
            ->get();
        $contentRecords = [];

        foreach ($allRecords as $record) {
            $contentRecords[$record->section][$record->key] = $record;
        }

        return view('admin.content-management.index', compact('availablePages', 'activePage', 'sectionsMeta', 'contentRecords'));
    }

    /**
     * Update content and media for the selected page.
     */
    public function update(UpdateContentManagementRequest $request): RedirectResponse
    {
        $activePage = $request->input('active_page', 'home');
        $contentData = $request->input('content', []);
        $removeMedia = $request->input('remove_media', []);
        $oldContent = WebsiteContent::getPage($activePage);
        $updatedValues = [];

        // 1. Process Text / Value Inputs
        foreach ($contentData as $section => $keys) {
            if (!is_array($keys)) continue;

            foreach ($keys as $key => $value) {
                $record = WebsiteContent::firstOrNew([
                    'page' => $activePage,
                    'section' => $section,
                    'key' => $key,
                ]);

                if (!$record->exists) {
                    $record->type = 'text';
                    $record->label = ucwords(str_replace('_', ' ', $key));
                }

                if ($record->type !== 'image') {
                    $record->value = $value;
                    $record->save();
                    $updatedValues["{$section}.{$key}"] = $value;
                }
            }
        }

        // 2. Process Media Removal
        if (is_array($removeMedia)) {
            foreach ($removeMedia as $section => $keys) {
                if (!is_array($keys)) continue;

                foreach ($keys as $key => $shouldRemove) {
                    if ($shouldRemove === '1' || $shouldRemove === 1 || $shouldRemove === true) {
                        $record = WebsiteContent::where('page', $activePage)
                            ->where('section', $section)
                            ->where('key', $key)
                            ->first();

                        if ($record) {
                            $record->clearMediaCollection('image');
                            $record->value = null;
                            $record->save();
                            $updatedValues["{$section}.{$key}"] = null;
                        }
                    }
                }
            }
        }

        // 3. Process Spatie MediaLibrary File Uploads
        $mediaFiles = $request->allFiles()['media_files'] ?? $request->file('media_files', []);
        if (!empty($mediaFiles) && is_array($mediaFiles)) {
            foreach ($mediaFiles as $section => $keys) {
                if (!is_array($keys)) continue;

                foreach ($keys as $key => $file) {
                    if ($file && $file->isValid()) {
                        $record = WebsiteContent::updateOrCreate(
                            [
                                'page' => $activePage,
                                'section' => $section,
                                'key' => $key,
                            ],
                            [
                                'type' => 'image',
                                'label' => ucwords(str_replace('_', ' ', $key)),
                            ]
                        );

                        // Clear existing single file and attach new file to Spatie collection
                        $record->clearMediaCollection('image');
                        $mediaItem = $record->addMedia($file)->toMediaCollection('image');
                        $record->update(['value' => $mediaItem->getUrl()]);

                        $updatedValues["{$section}.{$key}"] = $record->value;
                    }
                }
            }
        }

        // 4. Invalidate Cache for this page
        WebsiteContent::clearPageCache($activePage);

        // 5. Activity Log
        ActivityLogger::log(
            action: 'update',
            module: 'website-content',
            description: "Updated content for page: {$activePage}",
            subject: null,
            oldValues: $oldContent,
            newValues: $updatedValues
        );

        return redirect()->route('content-management.index', ['page' => $activePage])
            ->with('success', ucfirst($activePage) . ' page content updated successfully.');
    }

    /**
     * Create a new generic CMS Page, Section, or Field dynamically.
     */
    public function storeField(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'page' => ['required', 'string', 'max:60'],
            'section' => ['required', 'string', 'max:60'],
            'label' => ['required', 'string', 'max:100'],
            'key' => ['nullable', 'string', 'max:80'],
            'type' => ['required', 'string', 'in:text,textarea,richtext,image,url,number,boolean'],
            'value' => ['nullable'],
        ]);

        $page = Str::slug($validated['page'], '_');
        $section = Str::slug($validated['section'], '_');
        $key = !empty($validated['key']) ? Str::slug($validated['key'], '_') : Str::slug($validated['label'], '_');

        $exists = WebsiteContent::where('page', $page)
            ->where('section', $section)
            ->where('key', $key)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', "Field with key '{$key}' already exists in section '{$section}' on page '{$page}'.");
        }

        $record = WebsiteContent::create([
            'page' => $page,
            'section' => $section,
            'key' => $key,
            'label' => $validated['label'],
            'type' => $validated['type'],
            'value' => $validated['value'] ?? null,
        ]);

        WebsiteContent::clearPageCache($page);

        ActivityLogger::log(
            action: 'create',
            module: 'website-content',
            description: "Created new content field '{$key}' in section '{$section}' on page '{$page}'",
            subject: $record,
            newValues: $record->toArray()
        );

        return redirect()->route('content-management.index', ['page' => $page])
            ->with('success', "New content field '{$record->label}' created successfully.");
    }

    /**
     * Delete a generic CMS field by ID.
     */
    public function destroyField(int $id): RedirectResponse
    {
        $record = WebsiteContent::findOrFail($id);
        $page = $record->page;
        $label = $record->label ?: $record->key;

        $record->clearMediaCollection('image');
        $record->delete();

        WebsiteContent::clearPageCache($page);

        ActivityLogger::log(
            action: 'delete',
            module: 'website-content',
            description: "Deleted content field '{$record->key}' from page '{$page}'",
            subject: null
        );

        return redirect()->route('content-management.index', ['page' => $page])
            ->with('success', "Content field '{$label}' deleted successfully.");
    }
}

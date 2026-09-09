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
            new Middleware('permission:website-content-edit', only: ['update', 'updateItem']),
            new Middleware('permission:website-content-create', only: ['storeField', 'storeGroupItem']),
            new Middleware('permission:website-content-delete', only: ['destroyField', 'destroyGroup']),
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
        $recordsBySection = $allRecords->groupBy('section');
        $sectionsData = [];

        foreach ($allRecords as $record) {
            $contentRecords[$record->section][$record->key] = $record;
        }

        foreach ($sectionsMeta as $secKey => $secMeta) {
            $secRecords = $recordsBySection->get($secKey, collect());
            $sectionsData[$secKey] = WebsiteContent::organizeSectionContent($secRecords, $secKey, $activePage);
        }

        return view('admin.content-management.index', compact('availablePages', 'activePage', 'sectionsMeta', 'contentRecords', 'sectionsData'));
    }

    /**
     * Update a single grouped item and its fields only.
     */
    public function updateItem(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'page' => ['required', 'string'],
            'section' => ['required', 'string'],
            'group_id' => ['required', 'string'],
            'item_label' => ['nullable', 'string'],
            'fields' => ['required', 'array'],
            'remove_media' => ['nullable', 'array'],
        ]);

        $page = $validated['page'];
        $section = $validated['section'];
        $groupId = $validated['group_id'];
        $fields = $validated['fields'];
        $itemLabel = $validated['item_label'] ?: ucwords(str_replace('_', ' ', $groupId));
        $removeMedia = $request->input('remove_media', []);
        $updatedValues = [];

        // 1. Process Text / Value fields
        foreach ($fields as $key => $value) {
            $record = WebsiteContent::firstOrNew([
                'page' => $page,
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
                $updatedValues[$key] = $value;
            }
        }

        // 2. Process Media Removal
        if (is_array($removeMedia)) {
            foreach ($removeMedia as $key => $shouldRemove) {
                if ($shouldRemove === '1' || $shouldRemove === 1 || $shouldRemove === true) {
                    $record = WebsiteContent::where('page', $page)
                        ->where('section', $section)
                        ->where('key', $key)
                        ->first();

                    if ($record) {
                        $record->clearMediaCollection('image');
                        $record->value = null;
                        $record->save();
                        $updatedValues[$key] = null;
                    }
                }
            }
        }

        // 3. Process Media File Uploads
        $mediaFiles = $request->allFiles()['media_files'] ?? $request->file('media_files', []);
        if (!empty($mediaFiles) && is_array($mediaFiles)) {
            foreach ($mediaFiles as $key => $file) {
                if ($file && $file->isValid()) {
                    $record = WebsiteContent::updateOrCreate(
                        [
                            'page' => $page,
                            'section' => $section,
                            'key' => $key,
                        ],
                        [
                            'type' => 'image',
                            'label' => ucwords(str_replace('_', ' ', $key)),
                        ]
                    );

                    $record->clearMediaCollection('image');
                    $mediaItem = $record->addMedia($file)->toMediaCollection('image');
                    $record->update(['value' => $mediaItem->getUrl()]);
                    $updatedValues[$key] = $record->value;
                }
            }
        }

        WebsiteContent::clearPageCache($page);

        ActivityLogger::log(
            action: 'update',
            module: 'website-content',
            description: "Updated {$itemLabel} in {$section} on page: {$page}",
            subject: null,
            newValues: $updatedValues
        );

        return redirect()->route('content-management.index', ['page' => $page])
            ->with('success', "{$itemLabel} updated successfully.");
    }

    /**
     * Delete an entire repeating item group and all its sub-fields.
     */
    public function destroyGroup(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'page' => ['required', 'string'],
            'section' => ['required', 'string'],
            'group_id' => ['required', 'string'],
            'item_label' => ['nullable', 'string'],
        ]);

        $page = $validated['page'];
        $section = $validated['section'];
        $groupId = $validated['group_id'];
        $itemLabel = $validated['item_label'] ?: ucwords(str_replace('_', ' ', $groupId));

        $records = WebsiteContent::where('page', $page)
            ->where('section', $section)
            ->where(function ($query) use ($groupId) {
                $query->where('key', $groupId)
                      ->orWhere('key', 'like', "{$groupId}_%")
                      ->orWhere('key', 'like', "{$groupId}");
            })
            ->get();

        foreach ($records as $record) {
            $record->clearMediaCollection('image');
            $record->delete();
        }

        WebsiteContent::clearPageCache($page);

        ActivityLogger::log(
            action: 'delete',
            module: 'website-content',
            description: "Deleted {$itemLabel} ({$groupId}) from {$section} on page: {$page}",
            subject: null
        );

        return redirect()->route('content-management.index', ['page' => $page])
            ->with('success', "{$itemLabel} deleted successfully.");
    }

    /**
     * Dynamically add a new repeating item to a section.
     */
    public function storeGroupItem(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'page' => ['required', 'string'],
            'section' => ['required', 'string'],
            'group_type' => ['required', 'string'],
            'fields' => ['required', 'array'],
        ]);

        $page = $validated['page'];
        $section = $validated['section'];
        $groupType = $validated['group_type'];
        $fields = $validated['fields'];

        // Determine the next index in a database-agnostic manner
        $existingKeys = WebsiteContent::where('page', $page)
            ->where('section', $section)
            ->pluck('key');

        $maxIndex = 0;
        foreach ($existingKeys as $k) {
            if (preg_match('/^' . preg_quote($groupType, '/') . '_(\d+)/', $k, $m)) {
                $maxIndex = max($maxIndex, (int)$m[1]);
            }
        }
        $nextIndex = $maxIndex + 1;
        $groupId = "{$groupType}_{$nextIndex}";
        $itemLabel = WebsiteContent::getItemDisplayName($groupType, $nextIndex, $section);

        $createdValues = [];
        foreach ($fields as $subKey => $data) {
            $value = is_array($data) ? ($data['value'] ?? '') : $data;
            $type = is_array($data) ? ($data['type'] ?? 'text') : 'text';
            $label = is_array($data) ? ($data['label'] ?? null) : null;

            $fullKey = !empty($subKey) && $subKey !== '__self__' ? "{$groupId}_{$subKey}" : $groupId;
            $fieldLabel = $label ?: ucwords(str_replace('_', ' ', !empty($subKey) && $subKey !== '__self__' ? $subKey : $groupType)) . " {$nextIndex}";

            $record = WebsiteContent::updateOrCreate(
                [
                    'page' => $page,
                    'section' => $section,
                    'key' => $fullKey,
                ],
                [
                    'label' => $fieldLabel,
                    'type' => $type,
                    'value' => $value,
                ]
            );

            $createdValues[$fullKey] = $value;
        }

        WebsiteContent::clearPageCache($page);

        ActivityLogger::log(
            action: 'create',
            module: 'website-content',
            description: "Created new {$itemLabel} in {$section} on page: {$page}",
            subject: null,
            newValues: $createdValues
        );

        return redirect()->route('content-management.index', ['page' => $page])
            ->with('success', "New {$itemLabel} created successfully.");
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Models\Media;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class MediaController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:media-list|media-create|media-edit|media-delete', only: ['index', 'show']),
            new Middleware('permission:media-create', only: ['store']),
            new Middleware('permission:media-edit', only: ['update']),
            new Middleware('permission:media-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of media.
     */
    public function index(Request $request): JsonResponse|View
    {
        $query = Media::with(['model', 'uploader'])->select('media.*')->latest('id');

        if ($request->filled('collection')) {
            $query->where('collection_name', $request->collection);
        }

        if ($request->filled('mime_type')) {
            if ($request->mime_type === 'image') {
                $query->where('mime_type', 'like', 'image/%');
            } elseif ($request->mime_type === 'document' || $request->mime_type === 'pdf') {
                $query->where(function ($q) {
                    $q->where('mime_type', 'like', 'application/%')
                        ->orWhere('mime_type', 'like', 'text/%');
                });
            } else {
                $query->where('mime_type', 'like', $request->mime_type . '%');
            }
        }

        if ($request->filled('uploaded_by')) {
            $query->where('custom_properties->uploaded_by', $request->uploaded_by);
        }

        $rawSearch = $request->input('search');
        $searchTerm = is_array($rawSearch) ? ($rawSearch['value'] ?? '') : $rawSearch;
        if (!empty($searchTerm)) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('file_name', 'like', "%{$searchTerm}%")
                    ->orWhere('collection_name', 'like', "%{$searchTerm}%")
                    ->orWhere('custom_properties->title', 'like', "%{$searchTerm}%")
                    ->orWhere('custom_properties->alt_text', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->ajax() || $request->wantsJson() || $request->has('draw')) {
            if ($request->has('draw')) {
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->filter(function ($q) {
                        // Handled in query above
                    }, true)
                    ->addColumn('preview', function (Media $media) {
                        $url = $media->getUrl();
                        if ($media->isImage()) {
                            return '<div class="d-flex align-items-center justify-content-center bg-light rounded overflow-hidden" style="width: 48px; height: 48px; border: 1px solid #e2e8f0; flex-shrink: 0;">
                                <img src="' . e($url) . '" alt="' . e($media->alt_text ?? $media->file_name) . '" class="object-fit-cover w-100 h-100" style="cursor: pointer;" onclick="openMediaPreview(' . $media->id . ')">
                            </div>';
                        }

                        $icon = 'ri-file-text-line';
                        $iconColor = '#64748b';
                        if (str_contains($media->mime_type ?? '', 'pdf')) {
                            $icon = 'ri-file-pdf-2-line';
                            $iconColor = '#dc2626';
                        }

                        return '<div class="d-flex align-items-center justify-content-center bg-light rounded" style="width: 48px; height: 48px; border: 1px solid #e2e8f0; color: ' . $iconColor . '; font-size: 24px; flex-shrink: 0; cursor: pointer;" onclick="openMediaPreview(' . $media->id . ')">
                            <i class="' . $icon . '"></i>
                        </div>';
                    })
                    ->addColumn('file_info', function (Media $media) {
                        $title = $media->title ?: $media->name;
                        $dimensions = $media->dimensions ? ' • <span class="text-muted">' . e($media->dimensions) . '</span>' : '';

                        return '<div class="d-flex flex-column text-truncate" style="max-width: 280px;">
                            <span class="fw-bold text-dark text-truncate" style="font-size: 13px;" title="' . e($media->file_name) . '">' . e($media->file_name) . '</span>
                            <span class="text-muted text-truncate" style="font-size: 11.5px;">' . e($title) . $dimensions . '</span>
                        </div>';
                    })
                    ->addColumn('collection_badge', function (Media $media) {
                        $collectionColors = [
                            'library' => 'background-color: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;',
                            'main_image' => 'background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;',
                            'gallery' => 'background-color: #fdf4ff; color: #86198f; border: 1px solid #f5d0fe;',
                            'documents' => 'background-color: #fff7ed; color: #9a3412; border: 1px solid #fed7aa;',
                            'image' => 'background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;',
                        ];
                        $style = $collectionColors[$media->collection_name] ?? 'background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;';
                        $label = ucwords(str_replace('_', ' ', $media->collection_name));

                        return '<span class="badge" style="' . $style . ' font-size: 11px; padding: 4px 8px; border-radius: 4px; font-weight: 600;">' . e($label) . '</span>';
                    })
                    ->addColumn('mime_badge', function (Media $media) {
                        $mime = $media->mime_type ?? 'unknown';
                        $shortMime = strtoupper(explode('/', $mime)[1] ?? $mime);
                        return '<span class="badge bg-light text-secondary border" style="font-size: 10.5px; padding: 3px 6px; font-family: monospace;">' . e($shortMime) . '</span>';
                    })
                    ->addColumn('readable_size', fn(Media $media) => '<span class="text-muted fw-semibold" style="font-size: 12px;">' . e($media->readable_size) . '</span>')
                    ->addColumn('uploader', function (Media $media) {
                        $uploaderId = $media->getCustomProperty('uploaded_by');
                        $uploader = $uploaderId ? User::find($uploaderId) : null;

                        if ($uploader) {
                            $initials = strtoupper(substr($uploader->name, 0, 1));
                            $avatarColors = ['#f95716', '#4f46e5', '#0284c7', '#059669', '#d97706'];
                            $colorIndex = crc32($uploader->name) % count($avatarColors);
                            $bgColor = $avatarColors[abs($colorIndex)];

                            return '<div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0" style="width: 26px; height: 26px; font-size: 11px; background-color: ' . $bgColor . ';">
                                    ' . e($initials) . '
                                </div>
                                <span class="text-dark fw-semibold text-truncate" style="font-size: 12.5px; max-width: 120px;">' . e($uploader->name) . '</span>
                            </div>';
                        }

                        return '<span class="text-muted" style="font-size: 12px;">System</span>';
                    })
                    ->addColumn('created_at', function (Media $media) {
                        return '<div class="d-flex flex-column">
                            <span class="fw-semibold text-dark" style="font-size: 12px;">' . ($media->created_at ? $media->created_at->format('M d, Y') : '—') . '</span>
                            <span class="text-muted" style="font-size: 10.5px;">' . ($media->created_at ? $media->created_at->format('h:i A') : '') . '</span>
                        </div>';
                    })
                    ->addColumn('action-btn', function (Media $media) {
                        return [
                            'id' => $media->id,
                            'url' => $media->getUrl(),
                            'file_name' => $media->file_name,
                            'can_edit' => Auth::user()?->can('media-edit') ?? false,
                            'can_delete' => Auth::user()?->can('media-delete') ?? false,
                        ];
                    })
                    ->rawColumns(['preview', 'file_info', 'collection_badge', 'mime_badge', 'readable_size', 'uploader', 'created_at', 'action-btn'])
                    ->make(true);
            }

            return response()->json([
                'success' => true,
                'data' => $query->paginate(24),
            ]);
        }

        $collections = Media::distinct()->whereNotNull('collection_name')->pluck('collection_name')->sort()->values();
        $uploaders = User::orderBy('name')->get(['id', 'name', 'email']);
        $totalCount = Media::count();
        $totalSizeBytes = Media::sum('size');
        $imageCount = Media::where('mime_type', 'like', 'image/%')->count();
        $docCount = Media::where('mime_type', 'not like', 'image/%')->count();

        return view('admin.media.index', compact(
            'collections',
            'uploaders',
            'totalCount',
            'totalSizeBytes',
            'imageCount',
            'docCount'
        ));
    }

    /**
     * Store newly uploaded media.
     */
    public function store(StoreMediaRequest $request): JsonResponse|RedirectResponse
    {
        $user = Auth::user();
        $collection = $request->input('collection', 'library');

        // Determine target model to attach media to
        if ($request->filled('model_type') && $request->filled('model_id')) {
            $modelClass = $request->input('model_type');
            $targetModel = $modelClass::findOrFail($request->input('model_id'));
        } else {
            $targetModel = $user;
        }

        $uploadedMedia = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $customProperties = [
                    'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    'alt_text' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    'caption' => null,
                    'uploaded_by' => $user?->id,
                ];

                $media = $targetModel->addMedia($file)
                    ->withCustomProperties($customProperties)
                    ->toMediaCollection($collection);

                $uploadedMedia[] = $media;

                ActivityLogger::log(
                    action: 'upload',
                    module: 'media',
                    description: 'Uploaded media file "' . $media->file_name . '" (' . $media->readable_size . ')',
                    subject: $media,
                    newValues: [
                        'file_name' => $media->file_name,
                        'mime_type' => $media->mime_type,
                        'size' => $media->size,
                        'collection' => $media->collection_name,
                    ]
                );
            }
        } elseif ($request->hasFile('file')) {
            $file = $request->file('file');
            $customProperties = [
                'title' => $request->input('title', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)),
                'alt_text' => $request->input('alt_text', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)),
                'caption' => $request->input('caption'),
                'uploaded_by' => $user?->id,
            ];

            $media = $targetModel->addMediaFromRequest('file')
                ->withCustomProperties($customProperties)
                ->toMediaCollection($collection);

            $uploadedMedia[] = $media;

            ActivityLogger::log(
                action: 'upload',
                module: 'media',
                description: 'Uploaded media file "' . $media->file_name . '" (' . $media->readable_size . ')',
                subject: $media,
                newValues: [
                    'file_name' => $media->file_name,
                    'mime_type' => $media->mime_type,
                    'size' => $media->size,
                    'collection' => $media->collection_name,
                ]
            );
        }

        if ($request->wantsJson() || $request->ajax()) {
            $lastMedia = end($uploadedMedia) ?: null;

            return response()->json([
                'success' => true,
                'message' => count($uploadedMedia) > 1
                    ? count($uploadedMedia) . ' files uploaded successfully'
                    : 'File uploaded successfully',
                'data' => $lastMedia ? [
                    'id' => $lastMedia->id,
                    'name' => $lastMedia->name,
                    'file_name' => $lastMedia->file_name,
                    'url' => $lastMedia->getUrl(),
                    'readable_size' => $lastMedia->readable_size,
                    'mime_type' => $lastMedia->mime_type,
                    'is_image' => $lastMedia->isImage(),
                ] : null,
                'count' => count($uploadedMedia),
            ], 201);
        }

        return redirect()->back()->with('success', 'File(s) uploaded successfully');
    }

    /**
     * Display the specified media item.
     */
    public function show(int $id): JsonResponse
    {
        $media = Media::with('model')->findOrFail($id);
        $uploaderId = $media->getCustomProperty('uploaded_by');
        $uploader = $uploaderId ? User::find($uploaderId) : null;

        return response()->json([
            'success' => true,
            'data' => array_merge($media->toArray(), [
                'url' => $media->getUrl(),
                'readable_size' => $media->readable_size,
                'is_image' => $media->isImage(),
                'dimensions' => $media->dimensions,
                'title' => $media->title,
                'alt_text' => $media->alt_text,
                'caption' => $media->caption,
                'uploader' => $uploader ? [
                    'id' => $uploader->id,
                    'name' => $uploader->name,
                    'email' => $uploader->email,
                ] : null,
                'formatted_created_at' => $media->created_at ? $media->created_at->format('M d, Y \a\t h:i A') : '—',
            ]),
        ]);
    }

    /**
     * Update media metadata (title, alt_text, caption).
     */
    public function update(UpdateMediaRequest $request, int $id): JsonResponse|RedirectResponse
    {
        $media = Media::findOrFail($id);
        $oldValues = [
            'title' => $media->title,
            'alt_text' => $media->alt_text,
            'caption' => $media->caption,
        ];

        if ($request->has('title')) {
            $media->setCustomProperty('title', $request->input('title'));
        }
        if ($request->has('alt_text')) {
            $media->setCustomProperty('alt_text', $request->input('alt_text'));
        }
        if ($request->has('caption')) {
            $media->setCustomProperty('caption', $request->input('caption'));
        }

        $media->save();

        ActivityLogger::log(
            action: 'update',
            module: 'media',
            description: 'Updated metadata for media "' . $media->file_name . '"',
            subject: $media,
            oldValues: $oldValues,
            newValues: [
                'title' => $media->title,
                'alt_text' => $media->alt_text,
                'caption' => $media->caption,
            ]
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Media metadata updated successfully',
                'data' => array_merge($media->toArray(), [
                    'title' => $media->title,
                    'alt_text' => $media->alt_text,
                    'caption' => $media->caption,
                ]),
            ]);
        }

        return redirect()->back()->with('success', 'Media metadata updated successfully');
    }

    /**
     * Remove the specified media item from storage.
     */
    public function destroy(int $id): JsonResponse|RedirectResponse
    {
        $media = Media::findOrFail($id);
        $fileName = $media->file_name;

        $media->delete();

        ActivityLogger::log(
            action: 'delete',
            module: 'media',
            description: 'Deleted media file "' . $fileName . '"'
        );

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Media file deleted successfully',
            ]);
        }

        return redirect()->back()->with('success', 'Media file deleted successfully');
    }
}

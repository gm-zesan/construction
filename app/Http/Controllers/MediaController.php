<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Models\Media;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
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
    public function index(Request $request): JsonResponse
    {
        $query = Media::with('model')->latest('id');

        if ($request->filled('collection')) {
            $query->where('collection_name', $request->collection);
        }

        if ($request->filled('mime_type')) {
            $query->where('mime_type', 'like', $request->mime_type . '%');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('file_name', 'like', "%{$search}%");
            });
        }

        if ($request->has('draw')) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('url', fn(Media $media) => $media->getUrl())
                ->addColumn('readable_size', fn(Media $media) => $media->readable_size)
                ->addColumn('is_image', fn(Media $media) => $media->isImage())
                ->make(true);
        }

        return response()->json([
            'success' => true,
            'data' => $query->paginate(24),
        ]);
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

        $customProperties = [
            'title' => $request->input('title', $request->file('file')->getClientOriginalName()),
            'alt_text' => $request->input('alt_text'),
            'caption' => $request->input('caption'),
            'uploaded_by' => $user->id,
        ];

        $media = $targetModel->addMediaFromRequest('file')
            ->withCustomProperties($customProperties)
            ->toMediaCollection($collection);

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

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'data' => [
                    'id' => $media->id,
                    'name' => $media->name,
                    'file_name' => $media->file_name,
                    'url' => $media->getUrl(),
                    'readable_size' => $media->readable_size,
                    'mime_type' => $media->mime_type,
                    'is_image' => $media->isImage(),
                ],
            ], 201);
        }

        return redirect()->back()->with('success', 'File uploaded successfully');
    }

    /**
     * Display the specified media item.
     */
    public function show(int $id): JsonResponse
    {
        $media = Media::with('model')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => array_merge($media->toArray(), [
                'url' => $media->getUrl(),
                'readable_size' => $media->readable_size,
                'is_image' => $media->isImage(),
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

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Media metadata updated successfully',
                'data' => $media,
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

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Media file deleted successfully',
            ]);
        }

        return redirect()->back()->with('success', 'Media file deleted successfully');
    }
}

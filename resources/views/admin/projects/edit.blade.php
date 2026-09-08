@extends('admin.app')
@section('title')
    Edit Project - {{ $project->title }}
@endsection

@push('custom-style')
    <style>
        /* Interactive Uploader & Gallery Styles */
        .dropzone-box {
            border: 2px dashed #cbd5e1;
            border-radius: 10px;
            background-color: #f8fafc;
            padding: 22px 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s ease;
            position: relative;
        }

        .dropzone-box:hover,
        .dropzone-box.dragover {
            border-color: #f95716;
            background-color: #fff7ed;
            transform: translateY(-1px);
        }

        .dropzone-box.dragover {
            box-shadow: 0 0 0 4px rgba(249, 87, 22, 0.15);
        }

        .dropzone-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-color: rgba(249, 87, 22, 0.1);
            color: #f95716;
            font-size: 24px;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s ease;
        }

        .dropzone-box:hover .dropzone-icon {
            transform: scale(1.08);
        }

        .preview-card {
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.04);
            position: relative;
            transition: all 0.2s ease;
        }

        .preview-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .preview-thumb {
            width: 100%;
            height: 110px;
            object-fit: cover;
            display: block;
            background-color: #f1f5f9;
        }

        .preview-info {
            padding: 6px 8px;
            background: #ffffff;
        }

        .preview-filename {
            font-size: 11px;
            font-weight: 600;
            color: #1e293b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }

        .preview-filesize {
            font-size: 10px;
            color: #64748b;
        }

        .preview-remove-btn {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: rgba(239, 68, 68, 0.9);
            color: #ffffff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: all 0.2s ease;
            z-index: 5;
        }

        .preview-remove-btn:hover {
            background: #dc2626;
            transform: scale(1.15);
        }

        .badge-cover-type {
            position: absolute;
            bottom: 8px;
            left: 8px;
            font-size: 10.5px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 4px;
            background: rgba(17, 26, 58, 0.85);
            color: #ffffff;
            backdrop-filter: blur(4px);
        }

        .gallery-overlay-btn {
            width: 26px;
            height: 26px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            border: none;
            color: #ffffff;
            text-decoration: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <form id="projectEditForm" action="{{ route('projects.update', $project->id) }}" method="POST"
            enctype="multipart/form-data" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="row">
                {{-- Main Project Details --}}
                <div class="col-lg-8 col-12">
                    <div class="card table-card mb-4">
                        <div class="card-header table-header">
                            <div class="title-with-breadcrumb">
                                <div class="table-title">Edit Project: {{ $project->title }}</div>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                                    </ol>
                                </nav>
                            </div>
                            <a href="{{ route('projects.index') }}" class="add-new">
                                <i class="ri-list-check me-1"></i> Project List
                            </a>
                        </div>
                        <div class="card-body custom-form">
                            <div class="row g-3">
                                {{-- Project Title --}}
                                <div class="col-md-8 col-12">
                                    <label for="title" class="form-label custom-label">Project Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control custom-input @error('title') is-invalid @enderror" name="title"
                                        id="title" value="{{ old('title', $project->title) }}" required>
                                    @error('title')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Slug --}}
                                <div class="col-md-4 col-12">
                                    <label for="slug" class="form-label custom-label">Slug (URL Identifier)</label>
                                    <input type="text" class="form-control custom-input @error('slug') is-invalid @enderror"
                                        name="slug" id="slug" value="{{ old('slug', $project->slug) }}">
                                    <div class="text-muted mt-1" style="font-size: 11px;">Leave empty to re-generate from
                                        title</div>
                                    @error('slug')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Category & Status --}}
                                <div class="col-md-6 col-12">
                                    <label for="category" class="form-label custom-label">Category / Sector <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select custom-input @error('category') is-invalid @enderror"
                                        name="category" id="category" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}" {{ old('category', $project->category) == $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-12">
                                    <label for="status" class="form-label custom-label">Project Status <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select custom-input @error('status') is-invalid @enderror"
                                        name="status" id="status" required>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->value }}" {{ old('status', $project->status instanceof \App\Enums\ProjectStatus ? $project->status->value : $project->status) == $status->value ? 'selected' : '' }}>
                                                {{ $status->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Client & Site Location --}}
                                <div class="col-md-6 col-12">
                                    <label for="client_name" class="form-label custom-label">Client / Stakeholder</label>
                                    <input type="text"
                                        class="form-control custom-input @error('client_name') is-invalid @enderror"
                                        name="client_name" id="client_name"
                                        value="{{ old('client_name', $project->client_name) }}">
                                    @error('client_name')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-12">
                                    <label for="location" class="form-label custom-label">Site Location</label>
                                    <input type="text"
                                        class="form-control custom-input @error('location') is-invalid @enderror"
                                        name="location" id="location" value="{{ old('location', $project->location) }}">
                                    @error('location')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Timeline Dates --}}
                                <div class="col-md-6 col-12">
                                    <label for="start_date" class="form-label custom-label">Commencement Date</label>
                                    <input type="date"
                                        class="form-control custom-input @error('start_date') is-invalid @enderror"
                                        name="start_date" id="start_date"
                                        value="{{ old('start_date', $project->start_date ? $project->start_date->format('Y-m-d') : '') }}">
                                    @error('start_date')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-12">
                                    <label for="completion_date" class="form-label custom-label">Completion / Delivery
                                        Date</label>
                                    <input type="date"
                                        class="form-control custom-input @error('completion_date') is-invalid @enderror"
                                        name="completion_date" id="completion_date"
                                        value="{{ old('completion_date', $project->completion_date ? $project->completion_date->format('Y-m-d') : '') }}">
                                    @error('completion_date')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Short Description --}}
                                <div class="col-12">
                                    <label for="short_description" class="form-label custom-label">Executive Summary /
                                        Brief</label>
                                    <textarea
                                        class="form-control custom-input @error('short_description') is-invalid @enderror"
                                        name="short_description" id="short_description" rows="3"
                                        style="resize: none;">{{ old('short_description', $project->short_description) }}</textarea>
                                    @error('short_description')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Full Description with CKEditor --}}
                                <div class="col-12">
                                    <label for="description" class="form-label custom-label">Detailed Case Study &amp; Scope
                                        of Work</label>
                                    <textarea class="form-control custom-input" name="description" id="description"
                                        rows="10">{{ old('description', $project->description) }}</textarea>
                                    @error('description')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Search Engine Optimization (SEO) --}}
                    <div class="card table-card mb-4">
                        <div class="card-header table-header">
                            <div class="table-title">SEO &amp; Discoverability</div>
                        </div>
                        <div class="card-body custom-form">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="meta_title" class="form-label custom-label">Meta Title</label>
                                    <input type="text"
                                        class="form-control custom-input @error('meta_title') is-invalid @enderror"
                                        name="meta_title" id="meta_title"
                                        value="{{ old('meta_title', $project->meta_title) }}">
                                    @error('meta_title')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="meta_description" class="form-label custom-label">Meta Description</label>
                                    <textarea
                                        class="form-control custom-input @error('meta_description') is-invalid @enderror"
                                        name="meta_description" id="meta_description" rows="2"
                                        style="resize: none;">{{ old('meta_description', $project->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Media, Actions, Interactive Gallery Manager --}}
                <div class="col-lg-4 col-12">
                    <div class="row g-3">
                        {{-- Save / Publish Actions --}}
                        <div class="col-12">
                            <div class="card table-card">
                                <div class="card-header table-header">
                                    <div class="table-title">Publish Actions</div>
                                </div>
                                <div class="card-body custom-form">
                                    <div class="d-flex flex-column gap-3 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_published"
                                                id="is_published" value="1" {{ old('is_published', $project->is_published) ? 'checked' : '' }} style="cursor: pointer;">
                                            <label class="form-check-label fw-semibold" for="is_published"
                                                style="font-size: 13.5px; cursor: pointer;">
                                                Visible on Website
                                            </label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="featured" id="featured"
                                                value="1" {{ old('featured', $project->featured) ? 'checked' : '' }}
                                                style="cursor: pointer;">
                                            <label class="form-check-label fw-semibold" for="featured"
                                                style="font-size: 13.5px; cursor: pointer;">
                                                Feature on Homepage
                                            </label>
                                        </div>
                                        <div>
                                            <label for="sort_order" class="form-label custom-label mb-1">Display Priority
                                                Order</label>
                                            <input type="number" class="form-control custom-input" name="sort_order"
                                                id="sort_order" value="{{ old('sort_order', $project->sort_order) }}"
                                                min="0">
                                            <div class="text-muted" style="font-size: 11px;">Lower numbers appear first
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <button type="submit" class="btn submit-button w-100">
                                                <i class="ri-save-line me-1"></i> Update
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('projects.index') }}" class="btn leave-button w-100">
                                                Cancel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Main Cover Image --}}
                        <div class="col-12">
                            <div class="card table-card">
                                <div class="card-header table-header">
                                    <div class="table-title">Main Cover Image</div>
                                </div>
                                <div class="card-body custom-form">
                                    {{-- Hidden file input --}}
                                    <input type="file" id="main_image" name="main_image" class="d-none"
                                        accept="image/png,image/jpeg,image/webp,image/jpg">

                                    {{-- Interactive Dropzone with In-Dropzone Preview --}}
                                    <div id="main_image_dropzone" class="dropzone-box">
                                        <div id="main_image_empty"
                                            class="{{ $project->hasMedia('main_image') || $project->hasMedia('gallery') ? 'd-none' : '' }}">
                                            <div class="dropzone-icon">
                                                <i class="ri-image-add-line"></i>
                                            </div>
                                            <p class="fw-bold text-dark mb-1" style="font-size: 13.5px;">Drag &amp; drop
                                                cover photo</p>
                                            <span class="text-muted d-block mb-3" style="font-size: 11.5px;">PNG, JPG, WebP
                                                up to 5MB (16:9 ratio recommended)</span>
                                            <button type="button" class="btn btn-sm upload-btn px-3 mx-auto"
                                                onclick="$('#main_image').click();">
                                                <i class="ri-upload-2-line me-1"></i> Browse Photo
                                            </button>
                                        </div>

                                        {{-- Staged / Active Preview Box --}}
                                        <div id="main_image_preview_box"
                                            class="{{ $project->hasMedia('main_image') || $project->hasMedia('gallery') ? '' : 'd-none' }}">
                                            <div class="position-relative rounded overflow-hidden mb-2"
                                                style="height: 180px; background: #000;">
                                                <img id="main_image_img" src="{{ $project->main_image_url }}"
                                                    alt="{{ $project->title }}"
                                                    onerror="this.onerror=null;this.src='{{ asset('admin/assets/images/default.jpg') }}';"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                                <span class="badge-cover-type" id="main_image_badge">
                                                    @if($project->hasMedia('main_image'))
                                                        <i class="ri-check-line me-1 text-success"></i> Current Active Cover
                                                    @elseif($project->hasMedia('gallery'))
                                                        <i class="ri-gallery-line me-1 text-info"></i> From Gallery (Auto)
                                                    @else
                                                        <i class="ri-image-line me-1"></i> Primary Cover
                                                    @endif
                                                </span>
                                                <button type="button" class="preview-remove-btn d-none"
                                                    id="btn_cancel_cover_replace" title="Cancel replacement">
                                                    <i class="ri-close-line"></i>
                                                </button>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between px-1">
                                                <div class="text-start text-truncate me-2">
                                                    <span id="main_image_name"
                                                        class="fw-semibold text-dark d-block text-truncate"
                                                        style="font-size: 12px;">
                                                        {{ $project->getFirstMedia('main_image')?->file_name ?? $project->title }}
                                                    </span>
                                                    <span id="main_image_size" class="text-muted"
                                                        style="font-size: 11px;">Active cover image</span>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-secondary px-2"
                                                    style="font-size: 11.5px; height: 28px;"
                                                    onclick="$('#main_image').click();">
                                                    Change
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @error('main_image')
                                        <div class="error_msg mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Interactive Gallery Manager --}}
                        <div class="col-12">
                            <div class="card table-card">
                                <div class="card-header table-header d-flex justify-content-between align-items-center">
                                    <div class="table-title">Gallery Manager</div>
                                    <span class="badge bg-primary" id="gallery_count_badge" style="font-size: 11px;">
                                        {{ $project->getMedia('gallery')->count() }} Photos
                                    </span>
                                </div>
                                <div class="card-body custom-form">
                                    {{-- 1. Existing Gallery Photos --}}
                                    <h6 class="fw-bold text-dark mb-2" style="font-size: 12.5px;">Current Gallery Photos
                                    </h6>
                                    <div class="row g-2 mb-3" id="existing_gallery_grid">
                                        @forelse($project->getMedia('gallery') as $media)
                                            @php
                                                $mediaUrl = $media->getUrl();
                                                if (\Illuminate\Support\Str::startsWith($mediaUrl, ['http://', 'https://'])) {
                                                    $mediaUrl = parse_url($mediaUrl, PHP_URL_PATH) ?: $mediaUrl;
                                                }
                                            @endphp
                                            <div class="col-6 col-sm-4 media-item-card" id="media_item_{{ $media->id }}">
                                                <div class="position-relative rounded overflow-hidden border"
                                                    style="height: 95px; background: #000;">
                                                    <img src="{{ $mediaUrl }}" alt="{{ $media->name }}"
                                                        onerror="this.onerror=null;this.src='{{ asset('admin/assets/images/default.jpg') }}';"
                                                        style="width: 100%; height: 100%; object-fit: cover;">

                                                    <div class="position-absolute top-0 end-0 p-1 d-flex gap-1"
                                                        style="z-index: 5;">
                                                        <a href="{{ $mediaUrl }}" target="_blank"
                                                            class="gallery-overlay-btn bg-dark bg-opacity-75"
                                                            title="View full image">
                                                            <i class="ri-zoom-in-line"></i>
                                                        </a>
                                                        <button type="button"
                                                            class="gallery-overlay-btn bg-danger delete-media-btn"
                                                            data-project-id="{{ $project->id }}"
                                                            data-media-id="{{ $media->id }}" title="Delete photo permanently">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </div>
                                                    <div class="position-absolute bottom-0 start-0 end-0 px-1 py-1"
                                                        style="background: rgba(0,0,0,0.65); backdrop-filter: blur(2px);">
                                                        <span class="text-white text-truncate d-block"
                                                            style="font-size: 10px;">{{ $media->file_name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12 text-center text-muted py-3" id="empty_gallery_text"
                                                style="font-size: 12px; background: #f8fafc; border-radius: 6px;">
                                                <i class="ri-image-line d-block mb-1 text-secondary"
                                                    style="font-size: 24px;"></i>
                                                No gallery photos uploaded yet.
                                            </div>
                                        @endforelse
                                    </div>

                                    {{-- 2. Add New Photos Dropzone --}}
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 12.5px;">Add New Photos</h6>
                                    <input type="file" id="gallery_input" name="gallery[]" class="d-none"
                                        accept="image/png,image/jpeg,image/webp,image/jpg" multiple>

                                    <div id="gallery_dropzone" class="dropzone-box mb-3">
                                        <div class="dropzone-icon"
                                            style="background-color: rgba(79, 70, 229, 0.1); color: #4f46e5;">
                                            <i class="ri-gallery-upload-line"></i>
                                        </div>
                                        <p class="fw-bold text-dark mb-1" style="font-size: 13px;">Drag &amp; drop more
                                            gallery photos</p>
                                        <span class="text-muted d-block mb-2" style="font-size: 11px;">Hold Ctrl/Cmd to
                                            select multiple</span>
                                        <button type="button" class="btn btn-sm upload-btn px-3 mx-auto"
                                            style="background-color: #eef2ff; border-color: #6366f1; color: #4f46e5;"
                                            onclick="$('#gallery_input').click();">
                                            <i class="ri-add-circle-line me-1"></i> Browse Photos
                                        </button>
                                    </div>

                                    {{-- Staging Preview for Newly Selected Gallery Photos --}}
                                    <div id="staged_gallery_grid" class="row g-2"></div>
                                    @error('gallery.*')
                                        <div class="error_msg mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Technical Documents Manager --}}
                        <div class="col-12">
                            <div class="card table-card">
                                <div class="card-header table-header d-flex justify-content-between align-items-center">
                                    <div class="table-title">Project Documents</div>
                                    <span class="badge bg-secondary" id="doc_count_badge" style="font-size: 11px;">
                                        {{ $project->getMedia('documents')->count() }} Files
                                    </span>
                                </div>
                                <div class="card-body custom-form">
                                    {{-- Existing Documents --}}
                                    @if($project->getMedia('documents')->isNotEmpty())
                                        <ul class="list-group list-group-flush mb-3" id="existing_documents_list"
                                            style="border-radius: 6px; overflow: hidden;">
                                            @foreach($project->getMedia('documents') as $doc)
                                                @php
                                                    $docUrl = $doc->getUrl();
                                                    if (\Illuminate\Support\Str::startsWith($docUrl, ['http://', 'https://'])) {
                                                        $docUrl = parse_url($docUrl, PHP_URL_PATH) ?: $docUrl;
                                                    }
                                                @endphp
                                                <li class="list-group-item d-flex justify-content-between align-items-center px-2 py-2"
                                                    id="media_item_{{ $doc->id }}" style="font-size: 12px; background: #f8fafc;">
                                                    <div class="d-flex align-items-center text-truncate me-2">
                                                        <i class="ri-file-pdf-line text-danger me-2" style="font-size: 18px;"></i>
                                                        <a href="{{ $docUrl }}" target="_blank"
                                                            class="text-dark fw-semibold text-truncate text-decoration-none">
                                                            {{ $doc->file_name }}
                                                        </a>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="text-muted"
                                                            style="font-size: 11px;">{{ $doc->readable_size }}</span>
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger p-0 delete-media-btn"
                                                            data-project-id="{{ $project->id }}" data-media-id="{{ $doc->id }}"
                                                            style="width: 24px; height: 24px; line-height: 1;" title="Delete file">
                                                            <i class="ri-delete-bin-line" style="font-size: 12px;"></i>
                                                        </button>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    {{-- Add Documents --}}
                                    <label class="form-label custom-label mb-1" style="font-size: 12px;">Upload Additional
                                        Documents</label>
                                    <input type="file" id="documents_input" name="documents[]"
                                        class="form-control custom-input mb-1" multiple
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.txt">
                                    <span class="text-muted d-block" style="font-size: 11px;">PDF, DOC, DOCX, XLS up to
                                        10MB</span>
                                    <div id="documents_preview_list" class="mt-2"></div>
                                    @error('documents.*')
                                        <div class="error_msg mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('custom-script')
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Initialize CKEditor
            if (typeof CKEDITOR !== 'undefined' && document.getElementById('description')) {
                CKEDITOR.replace('description', {
                    filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                    filebrowserUploadMethod: 'form',
                    height: 300
                });
            }

            // ==========================================
            // 1. MAIN COVER IMAGE REPLACE & DRAG/DROP
            // ==========================================
            var $mainDropzone = $('#main_image_dropzone');
            var $mainInput = $('#main_image');

            $mainDropzone.on('click', function (e) {
                if (!$(e.target).closest('button').length && !$(e.target).is('button')) {
                    $mainInput.click();
                }
            });

            $mainDropzone.on('dragover dragenter', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $mainDropzone.addClass('dragover');
            });

            $mainDropzone.on('dragleave dragend drop', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $mainDropzone.removeClass('dragover');
            });

            $mainDropzone.on('drop', function (e) {
                var files = e.originalEvent.dataTransfer.files;
                if (files && files.length > 0) {
                    var file = files[0];
                    if (!file.type.match('image.*')) {
                        toastr.error('Please select an image file (PNG, JPG, WebP)');
                        return;
                    }
                    if (file.size > 5 * 1024 * 1024) {
                        toastr.error('Cover image must not exceed 5MB');
                        return;
                    }

                    var dt = new DataTransfer();
                    dt.items.add(file);
                    $mainInput[0].files = dt.files;
                    renderCoverReplacement(file);
                }
            });

            $mainInput.on('change', function () {
                if (this.files && this.files[0]) {
                    var file = this.files[0];
                    if (file.size > 5 * 1024 * 1024) {
                        toastr.error('Cover image must not exceed 5MB');
                        this.value = '';
                        return;
                    }
                    renderCoverReplacement(file);
                }
            });

            var originalCoverSrc = "{{ $project->main_image_url }}";
            var originalCoverName = $('#main_image_name').text();

            function renderCoverReplacement(file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#main_image_img').attr('src', e.target.result);
                    $('#main_image_name').text(file.name);
                    $('#main_image_size').text(formatBytes(file.size));
                    $('#main_image_badge').html('<i class="ri-refresh-line me-1 text-warning"></i> Staged Replacement');
                    $('#btn_cancel_cover_replace').removeClass('d-none');
                    $('#main_image_empty').addClass('d-none');
                    $('#main_image_preview_box').removeClass('d-none');
                    toastr.info('New cover selected. Click "Update" to save changes.');
                };
                reader.readAsDataURL(file);
            }

            $('#btn_cancel_cover_replace').on('click', function (e) {
                e.stopPropagation();
                $mainInput.val('');
                $('#main_image_img').attr('src', originalCoverSrc);
                $('#main_image_name').text(originalCoverName);
                $('#main_image_size').text('Active cover image');
                $('#main_image_badge').html('@if($project->hasMedia('main_image'))<i class="ri-check-line me-1 text-success"></i> Current Active Cover @elseif($project->hasMedia('gallery'))<i class="ri-gallery-line me-1 text-info"></i> From Gallery (Auto) @else<i class="ri-image-line me-1"></i> Primary Cover @endif');
                $(this).addClass('d-none');
            });

            // ==========================================
            // 2. MULTI-GALLERY DRAG & DROP & STAGING
            // ==========================================
            var $galleryDropzone = $('#gallery_dropzone');
            var $galleryInput = $('#gallery_input');
            var galleryDataTransfer = new DataTransfer();

            $galleryDropzone.on('click', function (e) {
                if (!$(e.target).closest('button').length && !$(e.target).is('button')) {
                    $galleryInput.click();
                }
            });

            $galleryDropzone.on('dragover dragenter', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $galleryDropzone.addClass('dragover');
            });

            $galleryDropzone.on('dragleave dragend drop', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $galleryDropzone.removeClass('dragover');
            });

            $galleryDropzone.on('drop', function (e) {
                var files = e.originalEvent.dataTransfer.files;
                if (files && files.length > 0) {
                    appendGalleryFiles(files);
                }
            });

            $galleryInput.on('change', function () {
                if (this.files && this.files.length > 0) {
                    appendGalleryFiles(this.files);
                }
            });

            function appendGalleryFiles(files) {
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    if (!file.type.match('image.*')) {
                        toastr.warning(file.name + ' is not an image file');
                        continue;
                    }
                    if (file.size > 5 * 1024 * 1024) {
                        toastr.warning(file.name + ' exceeds 5MB limit');
                        continue;
                    }
                    galleryDataTransfer.items.add(file);
                }
                $galleryInput[0].files = galleryDataTransfer.files;
                renderStagedGallery();
            }

            function renderStagedGallery() {
                var $grid = $('#staged_gallery_grid');
                $grid.empty();
                var files = galleryDataTransfer.files;

                if (files.length === 0) {
                    return;
                }

                Array.from(files).forEach(function (file, index) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var cardHtml = '<div class="col-6 col-md-4" id="staged_gallery_' + index + '">' +
                            '<div class="preview-card" style="border-color: #f95716;">' +
                            '<button type="button" class="preview-remove-btn remove-staged-gallery" data-index="' + index + '" title="Remove from upload queue">' +
                            '<i class="ri-close-line"></i>' +
                            '</button>' +
                            '<img src="' + e.target.result + '" class="preview-thumb" alt="' + file.name + '">' +
                            '<div class="preview-info">' +
                            '<span class="preview-filename">' + file.name + '</span>' +
                            '<span class="preview-filesize text-warning fw-semibold">New (' + formatBytes(file.size) + ')</span>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                        $grid.append(cardHtml);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Remove single file from Gallery DataTransfer queue
            $(document).on('click', '.remove-staged-gallery', function (e) {
                e.stopPropagation();
                var removeIndex = parseInt($(this).data('index'), 10);
                var newDt = new DataTransfer();
                Array.from(galleryDataTransfer.files).forEach(function (file, idx) {
                    if (idx !== removeIndex) {
                        newDt.items.add(file);
                    }
                });
                galleryDataTransfer = newDt;
                $galleryInput[0].files = galleryDataTransfer.files;
                renderStagedGallery();
            });

            // ==========================================
            // 3. AJAX DELETE FOR EXISTING GALLERY/DOCS
            // ==========================================
            $(document).on('click', '.delete-media-btn', function (e) {
                e.preventDefault();
                var projectId = $(this).data('project-id');
                var mediaId = $(this).data('media-id');
                var $itemContainer = $('#media_item_' + mediaId);

                if (!confirm('Are you sure you want to permanently remove this media file?')) {
                    return;
                }

                $.ajax({
                    url: "{{ url('/dashboard/projects') }}/" + projectId + "/media/" + mediaId,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        if (res.success) {
                            toastr.success(res.message || 'Media file deleted');
                            $itemContainer.fadeOut(300, function () {
                                $(this).remove();
                                // Update count
                                var currentCount = $('#existing_gallery_grid .media-item-card').length;
                                $('#gallery_count_badge').text(currentCount + ' Photos');
                                if (currentCount === 0) {
                                    $('#existing_gallery_grid').html('<div class="col-12 text-center text-muted py-3" style="font-size: 12px; background: #f8fafc; border-radius: 6px;"><i class="ri-image-line d-block mb-1 text-secondary" style="font-size: 24px;"></i> No gallery photos uploaded yet.</div>');
                                }
                            });
                        } else {
                            toastr.error('Could not delete media file');
                        }
                    },
                    error: function () {
                        toastr.error('Network error while deleting media file');
                    }
                });
            });

            // ==========================================
            // 4. DOCUMENTS PREVIEW
            // ==========================================
            $('#documents_input').on('change', function () {
                var $list = $('#documents_preview_list');
                $list.empty();
                if (this.files && this.files.length > 0) {
                    var html = '<ul class="list-group list-group-flush" style="border-radius: 6px; overflow: hidden;">';
                    Array.from(this.files).forEach(function (file) {
                        html += '<li class="list-group-item d-flex justify-content-between align-items-center py-2 px-2" style="font-size: 12px; background: #fff3ee; border-color: rgba(249, 87, 22, 0.2);">' +
                            '<div class="text-truncate me-2">' +
                            '<i class="ri-file-add-line text-warning me-1"></i> ' +
                            '<strong>' + file.name + '</strong>' +
                            '</div>' +
                            '<span class="badge bg-warning text-dark">' + formatBytes(file.size) + '</span>' +
                            '</li>';
                    });
                    html += '</ul>';
                    $list.append(html);
                }
            });

            function formatBytes(bytes, decimals = 1) {
                if (!+bytes) return '0 Bytes';
                const k = 1024;
                const dm = decimals < 0 ? 0 : decimals;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`;
            }
        });
    </script>
@endpush
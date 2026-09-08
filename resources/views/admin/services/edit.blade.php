@extends('admin.app')
@section('title')
    Edit Service
@endsection

@push('custom-style')
    <style>
        /* Interactive Uploader Styles */
        .dropzone-box {
            border: 2px dashed #cbd5e1;
            border-radius: 10px;
            background-color: #f8fafc;
            padding: 24px 16px;
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
            width: 52px;
            height: 52px;
            line-height: 52px;
            border-radius: 50%;
            background-color: rgba(249, 87, 22, 0.1);
            color: #f95716;
            font-size: 26px;
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
            height: 120px;
            object-fit: cover;
            display: block;
            background-color: #f1f5f9;
        }

        .preview-info {
            padding: 8px 10px;
            background: #ffffff;
        }

        .preview-filename {
            font-size: 11.5px;
            font-weight: 600;
            color: #1e293b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }

        .preview-filesize {
            font-size: 10.5px;
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

        .icon-preview-box {
            width: 42px;
            height: 42px;
            border-radius: 6px;
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #f95716;
            transition: all 0.2s ease;
        }

        .icon-suggestion-pill {
            cursor: pointer;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 4px;
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .icon-suggestion-pill:hover {
            background: #fff3ee;
            border-color: #f95716;
            color: #f95716;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <form id="serviceEditForm" action="{{ route('services.update', $service->id) }}" method="POST"
            enctype="multipart/form-data" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="row">
                {{-- Main Service Details --}}
                <div class="col-lg-8 col-12">
                    <div class="card table-card mb-4">
                        <div class="card-header table-header">
                            <div class="title-with-breadcrumb">
                                <div class="table-title">Edit Service: {{ $service->title }}</div>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                                    </ol>
                                </nav>
                            </div>
                            <a href="{{ route('services.index') }}" class="add-new">
                                <i class="ri-list-check me-1"></i> Services List
                            </a>
                        </div>
                        <div class="card-body custom-form">
                            <div class="row g-3">
                                {{-- Service Title --}}
                                <div class="col-md-7 col-12">
                                    <label for="title" class="form-label custom-label">Service Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control custom-input @error('title') is-invalid @enderror" name="title"
                                        id="title" value="{{ old('title', $service->title) }}" required>
                                    @error('title')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Slug --}}
                                <div class="col-md-5 col-12">
                                    <label for="slug" class="form-label custom-label">URL Slug</label>
                                    <input type="text" class="form-control custom-input @error('slug') is-invalid @enderror"
                                        name="slug" id="slug" value="{{ old('slug', $service->slug) }}">
                                    <small class="text-muted" style="font-size: 11px;">Unique URL identifier</small>
                                    @error('slug')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Icon Class with Live Preview --}}
                                <div class="col-12">
                                    <label for="icon" class="form-label custom-label">Icon Class (RemixIcon or
                                        FontAwesome)</label>
                                    <div class="input-group align-items-start">
                                        <div class="input-group-text p-0 bg-transparent border-0 me-2">
                                            <div class="icon-preview-box" id="icon_preview_container">
                                                <i class="{{ $service->icon ?: 'ri-hammer-line' }}"
                                                    id="icon_preview_element"></i>
                                            </div>
                                        </div>
                                        <input type="text"
                                            class="form-control custom-input @error('icon') is-invalid @enderror"
                                            name="icon" id="icon" value="{{ old('icon', $service->icon) }}"
                                            placeholder="e.g. ri-building-2-line, ri-tools-line">
                                    </div>
                                    <div class="d-flex flex-wrap gap-1 mt-2 align-items-center">
                                        <span class="text-muted" style="font-size: 11px;">Quick suggestions:</span>
                                        <span class="icon-suggestion-pill" data-icon="ri-building-2-line"><i
                                                class="ri-building-2-line"></i> Commercial</span>
                                        <span class="icon-suggestion-pill" data-icon="ri-home-4-line"><i
                                                class="ri-home-4-line"></i> Residential</span>
                                        <span class="icon-suggestion-pill" data-icon="ri-tools-line"><i
                                                class="ri-tools-line"></i> Contracting</span>
                                        <span class="icon-suggestion-pill" data-icon="ri-draft-line"><i
                                                class="ri-draft-line"></i> Architectural</span>
                                        <span class="icon-suggestion-pill" data-icon="ri-road-map-line"><i
                                                class="ri-road-map-line"></i> Civil</span>
                                        <span class="icon-suggestion-pill" data-icon="ri-shield-check-line"><i
                                                class="ri-shield-check-line"></i> Quality</span>
                                    </div>
                                    @error('icon')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Short Description --}}
                                <div class="col-12">
                                    <label for="short_description" class="form-label custom-label">Short Summary</label>
                                    <textarea
                                        class="form-control custom-input @error('short_description') is-invalid @enderror"
                                        name="short_description" id="short_description"
                                        rows="3">{{ old('short_description', $service->short_description) }}</textarea>
                                    @error('short_description')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Full Description / Features with CKEditor --}}
                                <div class="col-12">
                                    <label for="description" class="form-label custom-label">Comprehensive Service Details
                                        &amp; Scope</label>
                                    <textarea class="form-control custom-input @error('description') is-invalid @enderror"
                                        name="description" id="description"
                                        rows="10">{{ old('description', $service->description) }}</textarea>
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
                            <div class="table-title">Search Engine Optimization (SEO)</div>
                        </div>
                        <div class="card-body custom-form">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="meta_title" class="form-label custom-label">SEO Meta Title</label>
                                    <input type="text"
                                        class="form-control custom-input @error('meta_title') is-invalid @enderror"
                                        name="meta_title" id="meta_title"
                                        value="{{ old('meta_title', $service->meta_title) }}">
                                    @error('meta_title')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="meta_description" class="form-label custom-label">SEO Meta
                                        Description</label>
                                    <textarea
                                        class="form-control custom-input @error('meta_description') is-invalid @enderror"
                                        name="meta_description" id="meta_description"
                                        rows="3">{{ old('meta_description', $service->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Controls & Media Uploaders --}}
                <div class="col-lg-4 col-12">
                    <div class="row g-4">
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
                                                id="is_published" value="1" {{ old('is_published', $service->is_published) ? 'checked' : '' }} style="cursor: pointer;">
                                            <label class="form-check-label fw-semibold" for="is_published"
                                                style="font-size: 13.5px; cursor: pointer;">
                                                Visible on Website
                                            </label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="featured" id="featured"
                                                value="1" {{ old('featured', $service->featured) ? 'checked' : '' }}
                                                style="cursor: pointer;">
                                            <label class="form-check-label fw-semibold" for="featured"
                                                style="font-size: 13.5px; cursor: pointer;">
                                                Feature on Homepage
                                            </label>
                                        </div>
                                        <div>
                                            <label for="sort_order" class="form-label custom-label mb-1">Display Priority
                                                Order</label>
                                            <input type="number" class="form-control custom-input @error('sort_order') is-invalid @enderror" name="sort_order"
                                                id="sort_order" value="{{ old('sort_order', $service->sort_order) }}"
                                                min="0">
                                            <div class="text-muted" style="font-size: 11px;">Lower numbers appear first
                                                (e.g. 0, 1, 2)
                                            </div>
                                            @error('sort_order')
                                                <div class="error_msg">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <button type="submit" class="btn submit-button w-100">
                                                <i class="ri-save-line me-1"></i> Update
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('services.index') }}" class="btn leave-button w-100">
                                                Cancel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Primary Service Image --}}
                        <div class="col-12">
                            <div class="card table-card">
                                <div class="card-header table-header">
                                    <div class="table-title">Main Service Image</div>
                                </div>
                                <div class="card-body custom-form">
                                    {{-- Hidden native file input --}}
                                    <input type="file" id="image" name="image" class="d-none"
                                        accept="image/png,image/jpeg,image/webp,image/jpg">

                                    {{-- Current Active Image Display --}}
                                    <div id="current_image_card"
                                        class="position-relative rounded overflow-hidden mb-3 border"
                                        style="height: 180px; background: #000;">
                                        <img id="current_image_img" src="{{ $service->image_url }}"
                                            alt="{{ $service->title }}"
                                            onerror="this.onerror=null;this.src='{{ asset('admin/assets/images/default.jpg') }}';"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                        @if($service->hasMedia('image'))
                                            <span class="badge-cover-type" style="background: rgba(16, 185, 129, 0.9);">
                                                <i class="ri-check-line me-1"></i> Current Active Image
                                            </span>
                                        @elseif($service->hasMedia('gallery'))
                                            <span class="badge-cover-type" style="background: rgba(59, 130, 246, 0.9);">
                                                <i class="ri-gallery-line me-1"></i> From Gallery (Auto)
                                            </span>
                                        @else
                                            <span class="badge-cover-type" style="background: rgba(100, 116, 139, 0.9);">
                                                <i class="ri-image-line me-1"></i> Default Placeholder
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Staged Replacement Preview (Hidden initially) --}}
                                    <div id="staged_image_card"
                                        class="position-relative rounded overflow-hidden mb-3 border d-none"
                                        style="height: 180px; background: #000; border-color: #f95716 !important;">
                                        <img id="staged_image_img" src="" alt="Replacement preview"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                        <span class="badge-cover-type" style="background: rgba(249, 87, 22, 0.95);">
                                            <i class="ri-refresh-line me-1"></i> Ready to Replace on Save
                                        </span>
                                        <button type="button" class="preview-remove-btn" id="btn_cancel_image_replace"
                                            title="Cancel replacement">
                                            <i class="ri-close-line"></i>
                                        </button>
                                    </div>

                                    {{-- Replace Dropzone --}}
                                    <div id="main_image_dropzone" class="dropzone-box">
                                        <div class="dropzone-icon">
                                            <i class="ri-image-edit-line"></i>
                                        </div>
                                        <p class="fw-bold text-dark mb-1" style="font-size: 13px;">Click or drag to replace
                                            image</p>
                                        <span class="text-muted d-block mb-2" style="font-size: 11px;">PNG, JPG, WebP up to
                                            5MB</span>
                                        <button type="button" class="btn btn-sm upload-btn px-3 mx-auto"
                                            onclick="$('#image').click();">
                                            <i class="ri-upload-cloud-line me-1"></i> Select New Image
                                        </button>
                                    </div>
                                    @error('image')
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
                                        {{ $service->getMedia('gallery')->count() }} Photos
                                    </span>
                                </div>
                                <div class="card-body custom-form">
                                    {{-- 1. Existing Gallery Photos --}}
                                    <h6 class="fw-bold text-dark mb-2" style="font-size: 12.5px;">Current Gallery Photos
                                    </h6>
                                    <div class="row g-2 mb-3" id="existing_gallery_grid">
                                        @forelse($service->getMedia('gallery') as $media)
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
                                                            data-service-id="{{ $service->id }}"
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

                                    {{-- 3. Staging Preview for Newly Selected Gallery Photos --}}
                                    <div id="staged_gallery_grid" class="row g-2"></div>
                                    @error('gallery.*')
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

@push('custom-scripts')
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function () {
            // 1. Live Icon Preview & Suggestion Pills
            $('#icon').on('input', function () {
                var iconClass = $(this).val().trim() || 'ri-hammer-line';
                $('#icon_preview_element').attr('class', iconClass);
            });

            $('.icon-suggestion-pill').on('click', function () {
                var selectedIcon = $(this).data('icon');
                $('#icon').val(selectedIcon).trigger('input');
            });

            // 2. Initialize CKEditor
            if (typeof CKEDITOR !== 'undefined' && document.getElementById('description')) {
                CKEDITOR.replace('description', {
                    filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                    filebrowserUploadMethod: 'form',
                    height: 300
                });
            }

            // ==========================================
            // 3. MAIN SERVICE IMAGE REPLACE & DRAG/DROP
            // ==========================================
            var $mainDropzone = $('#main_image_dropzone');
            var $mainInput = $('#image');

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
                        toastr.error('Image must not exceed 5MB');
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
                        toastr.error('Image must not exceed 5MB');
                        this.value = '';
                        return;
                    }
                    renderCoverReplacement(file);
                }
            });

            function renderCoverReplacement(file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#staged_image_img').attr('src', e.target.result);
                    $('#current_image_card').addClass('d-none');
                    $('#staged_image_card').removeClass('d-none');
                    toastr.info('New image selected. Click "Update Service" to save changes.');
                };
                reader.readAsDataURL(file);
            }

            $('#btn_cancel_image_replace').on('click', function (e) {
                e.stopPropagation();
                $mainInput.val('');
                $('#staged_image_img').attr('src', '');
                $('#staged_image_card').addClass('d-none');
                $('#current_image_card').removeClass('d-none');
            });

            // ==========================================
            // 4. MULTI-GALLERY DRAG & DROP & STAGING
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
            // 5. AJAX DELETE FOR EXISTING GALLERY
            // ==========================================
            $(document).on('click', '.delete-media-btn', function (e) {
                e.preventDefault();
                var serviceId = $(this).data('service-id');
                var mediaId = $(this).data('media-id');
                var $itemContainer = $('#media_item_' + mediaId);

                if (!confirm('Are you sure you want to permanently remove this media file?')) {
                    return;
                }

                $.ajax({
                    url: "{{ url('/dashboard/services') }}/" + serviceId + "/media/" + mediaId,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        if (res.success) {
                            toastr.success(res.message || 'Media file deleted');
                            $itemContainer.fadeOut(300, function () {
                                $(this).remove();
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
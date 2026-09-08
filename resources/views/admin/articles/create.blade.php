@extends('admin.app')
@section('title')
    New Article
@endsection

@push('custom-style')
    <style>
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

        .upload-btn {
            background-color: #f95716;
            border-color: #f95716;
            color: #ffffff;
            font-weight: 600;
            font-size: 13px;
            border-radius: 6px;
            transition: all 0.15s ease;
        }

        .upload-btn:hover {
            background-color: #ea580c;
            color: #ffffff;
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
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <form id="articleCreateForm" action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- Left Column: Main Article Details --}}
                <div class="col-lg-8 col-12">
                    <div class="card table-card mb-4">
                        <div class="card-header table-header">
                            <div class="title-with-breadcrumb">
                                <div class="table-title">New Article</div>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">News &
                                                Articles</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                                    </ol>
                                </nav>
                            </div>
                            <a href="{{ route('articles.index') }}" class="add-new">
                                <i class="ri-list-check me-1"></i> Articles List
                            </a>
                        </div>
                        <div class="card-body custom-form p-4">
                            <div class="row g-3">
                                {{-- Article Title --}}
                                <div class="col-md-7 col-12">
                                    <label for="title" class="form-label custom-label">Article Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control custom-input @error('title') is-invalid @enderror" name="title"
                                        id="title" value="{{ old('title') }}"
                                        placeholder="e.g. Advancements in Mass Timber & Seismic Damping" required>
                                    @error('title')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Slug --}}
                                <div class="col-md-5 col-12">
                                    <label for="slug" class="form-label custom-label">URL Slug</label>
                                    <input type="text" class="form-control custom-input @error('slug') is-invalid @enderror"
                                        name="slug" id="slug" value="{{ old('slug') }}"
                                        placeholder="Auto-generated if empty">
                                    @error('slug')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Category & Author & Read Time --}}
                                <div class="col-md-5 col-12">
                                    <label for="category_id" class="form-label custom-label">Category</label>
                                    <select class="form-select custom-input @error('category_id') is-invalid @enderror"
                                        name="category_id" id="category_id">
                                        <option value="">Select Category (None)</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 col-12">
                                    <label for="author_name" class="form-label custom-label">Author Name</label>
                                    <input type="text"
                                        class="form-control custom-input @error('author_name') is-invalid @enderror"
                                        name="author_name" id="author_name"
                                        value="{{ old('author_name', Auth::user()?->name ?? 'Editorial Team') }}"
                                        placeholder="e.g. Lead Engineer, Project Ops">
                                    @error('author_name')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 col-12">
                                    <label for="read_time" class="form-label custom-label">Read Time (Mins)</label>
                                    <input type="number"
                                        class="form-control custom-input @error('read_time') is-invalid @enderror"
                                        name="read_time" id="read_time" value="{{ old('read_time', 3) }}" min="1" max="120">
                                    @error('read_time')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Excerpt / Short Summary --}}
                                <div class="col-12">
                                    <label for="summary" class="form-label custom-label">Excerpt / Short Summary</label>
                                    <textarea class="form-control custom-input @error('summary') is-invalid @enderror"
                                        name="summary" id="summary" rows="3"
                                        placeholder="Brief 1-2 sentence overview shown on homepage cards and search snippets...">{{ old('summary') }}</textarea>
                                    @error('summary')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Full Content (CKEditor) --}}
                                <div class="col-12">
                                    <label for="editor" class="form-label custom-label">Full Article Content</label>
                                    <textarea class="form-control custom-input @error('content') is-invalid @enderror"
                                        name="content" id="editor" rows="12">{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Search Engine Optimization (SEO) --}}
                    <div class="card table-card mb-4">
                        <div class="card-header table-header">
                            <div class="table-title">SEO &amp; Search Metadata</div>
                        </div>
                        <div class="card-body custom-form p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="meta_title" class="form-label custom-label">Meta Title</label>
                                    <input type="text" class="form-control custom-input" name="meta_title" id="meta_title"
                                        value="{{ old('meta_title') }}" placeholder="Custom page title for search engines">
                                </div>
                                <div class="col-12">
                                    <label for="meta_description" class="form-label custom-label">Meta Description</label>
                                    <textarea class="form-control custom-input" name="meta_description"
                                        id="meta_description" rows="2"
                                        placeholder="Search result snippet (recommended under 160 characters)">{{ old('meta_description') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label for="meta_keywords" class="form-label custom-label">Meta Keywords</label>
                                    <input type="text" class="form-control custom-input" name="meta_keywords"
                                        id="meta_keywords" value="{{ old('meta_keywords') }}"
                                        placeholder="e.g. construction technology, mass timber, seismic safety">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Controls, Actions & Cover Photo --}}
                <div class="col-lg-4 col-12">
                    <div class="row g-3">
                        {{-- Publish Actions --}}
                        <div class="col-12">
                            <div class="card table-card">
                                <div class="card-header table-header">
                                    <div class="table-title">Publish Actions</div>
                                </div>
                                <div class="card-body custom-form p-4">
                                    <div class="d-flex flex-column gap-3 mb-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_published"
                                                id="is_published" value="1" {{ old('is_published', '1') ? 'checked' : '' }}
                                                style="cursor: pointer;">
                                            <label class="form-check-label fw-semibold" for="is_published"
                                                style="font-size: 13.5px; cursor: pointer;">
                                                Visible on Website
                                            </label>
                                        </div>

                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="featured" id="featured"
                                                value="1" {{ old('featured') ? 'checked' : '' }} style="cursor: pointer;">
                                            <label class="form-check-label fw-semibold" for="featured"
                                                style="font-size: 13.5px; cursor: pointer;">
                                                Feature on Homepage
                                            </label>
                                        </div>

                                        <div>
                                            <label for="published_at" class="form-label custom-label mb-1">Publication
                                                Date</label>
                                            <input type="datetime-local" class="form-control custom-input"
                                                name="published_at" id="published_at"
                                                value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                                            <div class="text-muted" style="font-size: 11px;">Default is current timestamp
                                            </div>
                                        </div>

                                        <div>
                                            <label for="sort_order" class="form-label custom-label mb-1">Display Priority
                                                Order</label>
                                            <input type="number" class="form-control custom-input" name="sort_order"
                                                id="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                            <div class="text-muted" style="font-size: 11px;">Lower numbers appear first
                                                (e.g. 0, 1, 2)</div>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <button type="submit" class="btn submit-button w-100">
                                                <i class="ri-check-line me-1"></i> Publish
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('articles.index') }}" class="btn leave-button w-100">
                                                Cancel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Cover Image Dropzone --}}
                        <div class="col-12">
                            <div class="card table-card">
                                <div class="card-header table-header">
                                    <div class="table-title">Featured Cover Photo</div>
                                </div>
                                <div class="card-body custom-form p-3">
                                    <input type="file" id="image" name="image" class="d-none"
                                        accept="image/png,image/jpeg,image/webp,image/jpg">

                                    <div id="image_dropzone" class="dropzone-box">
                                        <div id="image_empty">
                                            <div class="dropzone-icon">
                                                <i class="ri-image-add-line"></i>
                                            </div>
                                            <p class="fw-bold text-dark mb-1" style="font-size: 13px;">Drop cover photo here
                                            </p>
                                            <span class="text-muted d-block mb-3" style="font-size: 11.5px;">PNG, JPG, WebP
                                                up to 10MB</span>
                                            <button type="button" class="btn btn-sm upload-btn px-3 mx-auto"
                                                onclick="$('#image').click();">
                                                <i class="ri-upload-2-line me-1"></i> Browse Photo
                                            </button>
                                        </div>

                                        {{-- Staged Preview Box --}}
                                        <div id="image_preview_box" class="d-none">
                                            <div class="position-relative rounded overflow-hidden mb-2"
                                                style="height: 160px; background: #000;">
                                                <img id="image_preview_img" src="" alt="Cover preview"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                                <button type="button" class="preview-remove-btn" id="btn_remove_image"
                                                    title="Remove selected image">
                                                    <i class="ri-close-line"></i>
                                                </button>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between px-1">
                                                <div class="text-start text-truncate me-2">
                                                    <span id="image_preview_name"
                                                        class="fw-semibold text-dark d-block text-truncate"
                                                        style="font-size: 12px;"></span>
                                                    <span id="image_preview_size" class="text-muted"
                                                        style="font-size: 11px;"></span>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-secondary px-2"
                                                    style="font-size: 11.5px; height: 28px;" onclick="$('#image').click();">
                                                    Change
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @error('image')
                                        <div class="text-danger mt-2" style="font-size: 12px;">{{ $message }}</div>
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
    <script type="text/javascript">
        $(document).ready(function () {
            // Auto Slug
            $('#title').on('input', function () {
                var titleVal = $(this).val();
                var slugVal = titleVal.toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .trim()
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                $('#slug').val(slugVal);
            });

            // Initialize CKEditor
            if (typeof CKEDITOR !== 'undefined' && document.getElementById('editor')) {
                CKEDITOR.replace('editor', {
                    filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                    filebrowserUploadMethod: 'form',
                    height: 350
                });
            }

            // Image Dropzone Handling
            var $imageInput = $('#image');
            var $dropzone = $('#image_dropzone');

            function formatBytes(bytes) {
                if (bytes === 0) return '0 B';
                var k = 1024;
                var sizes = ['B', 'KB', 'MB', 'GB'];
                var i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            $dropzone.on('click', function (e) {
                if (!$(e.target).closest('button').length && !$(e.target).is('button')) {
                    $imageInput.click();
                }
            });

            $dropzone.on('dragover dragenter', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $dropzone.addClass('dragover');
            });

            $dropzone.on('dragleave drop', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $dropzone.removeClass('dragover');
            });

            $dropzone.on('drop', function (e) {
                var files = e.originalEvent.dataTransfer.files;
                if (files && files.length > 0) {
                    $imageInput[0].files = files;
                    renderPreview(files[0]);
                }
            });

            $imageInput.on('change', function () {
                if (this.files && this.files[0]) {
                    renderPreview(this.files[0]);
                }
            });

            function renderPreview(file) {
                if (file.size > 10 * 1024 * 1024) {
                    toastr.warning('Photo exceeds 10MB limit', 'File Too Large');
                    $imageInput.val('');
                    return;
                }
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image_preview_img').attr('src', e.target.result);
                    $('#image_preview_name').text(file.name);
                    $('#image_preview_size').text(formatBytes(file.size));
                    $('#image_empty').addClass('d-none');
                    $('#image_preview_box').removeClass('d-none');
                };
                reader.readAsDataURL(file);
            }

            $('#btn_remove_image').on('click', function (e) {
                e.stopPropagation();
                $imageInput.val('');
                $('#image_preview_img').attr('src', '');
                $('#image_preview_box').addClass('d-none');
                $('#image_empty').removeClass('d-none');
            });
        });
    </script>
@endpush
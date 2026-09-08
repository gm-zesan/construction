@extends('admin.app')
@section('title')
    Edit Article: {{ $article->title }}
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
        <form id="articleEditForm" action="{{ route('articles.update', $article->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                {{-- Left Column: Main Article Details --}}
                <div class="col-lg-8 col-12">
                    <div class="card table-card mb-4">
                        <div class="card-header table-header">
                            <div class="title-with-breadcrumb">
                                <div class="table-title">Edit Article</div>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">News &
                                                Articles</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('articles.show', $article->id) }}" class="add-new"
                                    style="background-color: #f1f5f9; color: #334155;">
                                    <i class="ri-eye-line me-1"></i> Preview
                                </a>
                                <a href="{{ route('articles.index') }}" class="add-new">
                                    <i class="ri-list-check me-1"></i> Articles List
                                </a>
                            </div>
                        </div>
                        <div class="card-body custom-form p-4">
                            <div class="row g-3">
                                {{-- Article Title --}}
                                <div class="col-md-7 col-12">
                                    <label for="title" class="form-label custom-label">Article Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control custom-input @error('title') is-invalid @enderror" name="title"
                                        id="title" value="{{ old('title', $article->title) }}" required>
                                    @error('title')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Slug --}}
                                <div class="col-md-5 col-12">
                                    <label for="slug" class="form-label custom-label">URL Slug</label>
                                    <input type="text" class="form-control custom-input @error('slug') is-invalid @enderror"
                                        name="slug" id="slug" value="{{ old('slug', $article->slug) }}">
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
                                            <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
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
                                        value="{{ old('author_name', $article->author_name) }}">
                                    @error('author_name')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 col-12">
                                    <label for="read_time" class="form-label custom-label">Read Time (Mins)</label>
                                    <input type="number"
                                        class="form-control custom-input @error('read_time') is-invalid @enderror"
                                        name="read_time" id="read_time" value="{{ old('read_time', $article->read_time) }}"
                                        min="1" max="120">
                                    @error('read_time')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Excerpt / Short Summary --}}
                                <div class="col-12">
                                    <label for="summary" class="form-label custom-label">Excerpt / Short Summary</label>
                                    <textarea class="form-control custom-input @error('summary') is-invalid @enderror"
                                        name="summary" id="summary"
                                        rows="3">{{ old('summary', $article->summary) }}</textarea>
                                    @error('summary')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Full Content (CKEditor) --}}
                                <div class="col-12">
                                    <label for="editor" class="form-label custom-label">Full Article Content</label>
                                    <textarea class="form-control custom-input @error('content') is-invalid @enderror"
                                        name="content" id="editor"
                                        rows="12">{{ old('content', $article->content) }}</textarea>
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
                                        value="{{ old('meta_title', $article->meta_title) }}">
                                </div>
                                <div class="col-12">
                                    <label for="meta_description" class="form-label custom-label">Meta Description</label>
                                    <textarea class="form-control custom-input" name="meta_description"
                                        id="meta_description"
                                        rows="2">{{ old('meta_description', $article->meta_description) }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label for="meta_keywords" class="form-label custom-label">Meta Keywords</label>
                                    <input type="text" class="form-control custom-input" name="meta_keywords"
                                        id="meta_keywords" value="{{ old('meta_keywords', $article->meta_keywords) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Controls, Actions & Cover Photo --}}
                <div class="col-lg-4 col-12">
                    <div class="row g-4">
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
                                                id="is_published" value="1" {{ old('is_published', $article->is_published) ? 'checked' : '' }} style="cursor: pointer;">
                                            <label class="form-check-label fw-semibold" for="is_published"
                                                style="font-size: 13.5px; cursor: pointer;">
                                                Visible on Website
                                            </label>
                                        </div>

                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="featured" id="featured"
                                                value="1" {{ old('featured', $article->featured) ? 'checked' : '' }}
                                                style="cursor: pointer;">
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
                                                value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}">
                                        </div>

                                        <div>
                                            <label for="sort_order" class="form-label custom-label mb-1">Display Priority
                                                Order</label>
                                            <input type="number" class="form-control custom-input" name="sort_order"
                                                id="sort_order" value="{{ old('sort_order', $article->sort_order) }}"
                                                min="0">
                                            <div class="text-muted" style="font-size: 11px;">Lower numbers appear first
                                                (e.g. 0, 1, 2)</div>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <button type="submit" class="btn submit-button w-100">
                                                <i class="ri-check-line me-1"></i> Update
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

                        {{-- Cover Image Dropzone with Current/Staged Preview --}}
                        <div class="col-12">
                            <div class="card table-card">
                                <div class="card-header table-header">
                                    <div class="table-title">Featured Cover Photo</div>
                                </div>
                                <div class="card-body custom-form p-3">
                                    <input type="file" id="image" name="image" class="d-none"
                                        accept="image/png,image/jpeg,image/webp,image/jpg">

                                    <div id="image_dropzone" class="dropzone-box">
                                        <div id="image_empty" class="{{ $article->hasMedia('image') ? 'd-none' : '' }}">
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

                                        {{-- Staged / Current Preview Box --}}
                                        <div id="image_preview_box"
                                            class="{{ $article->hasMedia('image') ? '' : 'd-none' }}">
                                            <div class="position-relative rounded overflow-hidden mb-2"
                                                style="height: 160px; background: #000;">
                                                <img id="image_preview_img" src="{{ $article->image_url }}"
                                                    alt="{{ $article->title }}"
                                                    onerror="this.onerror=null;this.src='{{ asset('admin/assets/images/default.jpg') }}';"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                                <span class="badge-cover-type" id="image_badge"
                                                    style="position: absolute; top: 8px; left: 8px; font-size: 10.5px; padding: 3px 7px; background: rgba(0,0,0,0.65); color: #fff; border-radius: 4px; backdrop-filter: blur(4px);">
                                                    <i class="ri-check-line me-1 text-success"></i> Current Cover
                                                </span>
                                                <button type="button"
                                                    class="preview-remove-btn {{ $article->hasMedia('image') ? 'd-none' : '' }}"
                                                    id="btn_remove_image" title="Cancel selected image">
                                                    <i class="ri-close-line"></i>
                                                </button>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between px-1">
                                                <div class="text-start text-truncate me-2">
                                                    <span id="image_preview_name"
                                                        class="fw-semibold text-dark d-block text-truncate"
                                                        style="font-size: 12px;">{{ $article->getFirstMedia('image')?->file_name ?? $article->title }}</span>
                                                    <span id="image_preview_size" class="text-muted"
                                                        style="font-size: 11px;">{{ $article->getFirstMedia('image')?->readable_size ?? 'Active cover image' }}</span>
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
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // Initialize CKEditor
            if (document.querySelector('#editor')) {
                ClassicEditor
                    .create(document.querySelector('#editor'), {
                        ckfinder: {
                            uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}"
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            // Image Dropzone Handling
            var $imageInput = $('#image');
            var $dropzone = $('#image_dropzone');
            var originalPhotoSrc = "{{ $article->image_url }}";
            var originalPhotoName = "{{ $article->getFirstMedia('image')?->file_name ?? $article->title }}";
            var originalPhotoSize = "{{ $article->getFirstMedia('image')?->readable_size ?? 'Active cover image' }}";
            var hasOriginalImage = {{ $article->hasMedia('image') ? 'true' : 'false' }};

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
                    $('#image_badge').html('<i class="ri-refresh-line me-1 text-warning"></i> Staged Replacement');
                    $('#btn_remove_image').removeClass('d-none');
                    $('#image_empty').addClass('d-none');
                    $('#image_preview_box').removeClass('d-none');
                    toastr.info('New cover photo selected. Click "Update" to save.');
                };
                reader.readAsDataURL(file);
            }

            $('#btn_remove_image').on('click', function (e) {
                e.stopPropagation();
                $imageInput.val('');
                if (hasOriginalImage) {
                    $('#image_preview_img').attr('src', originalPhotoSrc);
                    $('#image_preview_name').text(originalPhotoName);
                    $('#image_preview_size').text(originalPhotoSize);
                    $('#image_badge').html('<i class="ri-check-line me-1 text-success"></i> Current Cover');
                    $(this).addClass('d-none');
                } else {
                    $('#image_preview_img').attr('src', '');
                    $('#image_preview_box').addClass('d-none');
                    $('#image_empty').removeClass('d-none');
                }
            });
        });
    </script>
@endpush
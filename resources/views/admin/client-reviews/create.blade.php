@extends('admin.app')
@section('title')
    New Client Review
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

        .star-rating-picker {
            display: inline-flex;
            gap: 6px;
            padding: 8px 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
        }

        .star-rating-picker .star-item {
            font-size: 24px;
            color: #cbd5e1;
            cursor: pointer;
            transition: transform 0.15s ease, color 0.15s ease;
        }

        .star-rating-picker .star-item:hover {
            transform: scale(1.15);
        }

        .star-rating-picker .star-item.active {
            color: #f59e0b;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <form id="reviewCreateForm" action="{{ route('client-reviews.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- Left Column: Review & Client Details --}}
                <div class="col-lg-8 col-12">
                    <div class="card table-card mb-4">
                        <div class="card-header table-header">
                            <div class="title-with-breadcrumb">
                                <div class="table-title">New Client Review</div>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('client-reviews.index') }}">Client Reviews</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                                    </ol>
                                </nav>
                            </div>
                            <a href="{{ route('client-reviews.index') }}" class="add-new">
                                <i class="ri-list-check me-1"></i> Reviews List
                            </a>
                        </div>
                        <div class="card-body custom-form p-4">
                            <div class="row g-3">
                                {{-- Client Name --}}
                                <div class="col-md-6 col-12">
                                    <label for="client_name" class="form-label custom-label">Client Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control custom-input @error('client_name') is-invalid @enderror" name="client_name" id="client_name" value="{{ old('client_name') }}" placeholder="e.g. Marcus Vance" required>
                                    @error('client_name')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Designation / Position --}}
                                <div class="col-md-6 col-12">
                                    <label for="designation" class="form-label custom-label">Designation / Role</label>
                                    <input type="text" class="form-control custom-input @error('designation') is-invalid @enderror" name="designation" id="designation" value="{{ old('designation') }}" placeholder="e.g. Chief Operations Officer, Senior Project Architect">
                                    @error('designation')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Company Name --}}
                                <div class="col-md-6 col-12">
                                    <label for="company_name" class="form-label custom-label">Company Name</label>
                                    <input type="text" class="form-control custom-input @error('company_name') is-invalid @enderror" name="company_name" id="company_name" value="{{ old('company_name') }}" placeholder="e.g. Vantage Tower Holdings">
                                    @error('company_name')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Related Project --}}
                                <div class="col-md-6 col-12">
                                    <label for="project_id" class="form-label custom-label">Associated Project</label>
                                    <select class="form-select custom-input @error('project_id') is-invalid @enderror" name="project_id" id="project_id">
                                        <option value="">General Testimonial (No specific project)</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Rating (1 to 5) --}}
                                <div class="col-12">
                                    <label class="form-label custom-label d-block">Client Rating <span class="text-danger">*</span></label>
                                    <input type="hidden" name="rating" id="rating_input" value="{{ old('rating', '5') }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="star-rating-picker" id="star_rating_picker">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="ri-star-fill star-item {{ old('rating', 5) >= $i ? 'active' : '' }}" data-value="{{ $i }}" title="{{ $i }} Star{{ $i > 1 ? 's' : '' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="badge bg-light text-dark border px-3 py-2" id="rating_display_badge" style="font-size: 13px; font-weight: 700;">
                                            <span id="rating_text">{{ old('rating', 5) }}</span>.0 / 5.0 Rating
                                        </span>
                                    </div>
                                    @error('rating')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Testimonial / Review Content --}}
                                <div class="col-12">
                                    <label for="review" class="form-label custom-label">Client Testimonial / Feedback <span class="text-danger">*</span></label>
                                    <textarea class="form-control custom-input @error('review') is-invalid @enderror" name="review" id="review" rows="6" placeholder="Provide client feedback regarding workmanship, project safety, timeliness, structural integrity, communication..." required>{{ old('review') }}</textarea>
                                    @error('review')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Controls & Client Photo --}}
                <div class="col-lg-4 col-12">
                    <div class="row g-4">
                        {{-- Publish Actions --}}
                        <div class="col-12">
                            <div class="card table-card">
                                <div class="card-header table-header">
                                    <div class="table-title">Review Settings</div>
                                </div>
                                <div class="card-body custom-form p-4">
                                    <div class="d-flex flex-column gap-3 mb-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', '1') ? 'checked' : '' }} style="cursor: pointer;">
                                            <label class="form-check-label fw-semibold" for="is_published" style="font-size: 13.5px; cursor: pointer;">
                                                Visible on Website
                                            </label>
                                        </div>

                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1" {{ old('featured') ? 'checked' : '' }} style="cursor: pointer;">
                                            <label class="form-check-label fw-semibold" for="featured" style="font-size: 13.5px; cursor: pointer;">
                                                Feature on Homepage
                                            </label>
                                        </div>

                                        <div>
                                            <label for="sort_order" class="form-label custom-label mb-1">Display Priority Order</label>
                                            <input type="number" class="form-control custom-input" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                            <div class="text-muted" style="font-size: 11px;">Lower numbers appear first (e.g. 0, 1, 2)</div>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <button type="submit" class="btn submit-button w-100">
                                                <i class="ri-check-line me-1"></i> Save Review
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('client-reviews.index') }}" class="btn leave-button w-100">
                                                Cancel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Client Photo Dropzone --}}
                        <div class="col-12">
                            <div class="card table-card">
                                <div class="card-header table-header">
                                    <div class="table-title">Client Photo / Avatar</div>
                                </div>
                                <div class="card-body custom-form p-3">
                                    <input type="file" id="client_photo" name="client_photo" class="d-none" accept="image/png,image/jpeg,image/webp,image/jpg">

                                    <div id="photo_dropzone" class="dropzone-box">
                                        <div id="photo_empty">
                                            <div class="dropzone-icon">
                                                <i class="ri-user-smile-line"></i>
                                            </div>
                                            <p class="fw-bold text-dark mb-1" style="font-size: 13px;">Drop client photo here</p>
                                            <span class="text-muted d-block mb-3" style="font-size: 11.5px;">PNG, JPG, WebP up to 10MB</span>
                                            <button type="button" class="btn btn-sm upload-btn px-3 mx-auto" onclick="$('#client_photo').click();">
                                                <i class="ri-upload-2-line me-1"></i> Browse Photo
                                            </button>
                                        </div>

                                        {{-- Staged Preview Box --}}
                                        <div id="photo_preview_box" class="d-none">
                                            <div class="position-relative rounded-circle overflow-hidden mx-auto mb-2 border" style="width: 120px; height: 120px; background: #f8fafc;">
                                                <img id="photo_preview_img" src="" alt="Client preview" style="width: 100%; height: 100%; object-fit: cover;">
                                                <button type="button" class="preview-remove-btn" id="btn_remove_photo" title="Remove selected image">
                                                    <i class="ri-close-line"></i>
                                                </button>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between px-1">
                                                <div class="text-start text-truncate me-2">
                                                    <span id="photo_preview_name" class="fw-semibold text-dark d-block text-truncate" style="font-size: 12px;"></span>
                                                    <span id="photo_preview_size" class="text-muted" style="font-size: 11px;"></span>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-secondary px-2" style="font-size: 11.5px; height: 28px;" onclick="$('#client_photo').click();">
                                                    Change
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @error('client_photo')
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
    <script type="text/javascript">
        $(document).ready(function () {
            // Star rating picker
            var $ratingInput = $('#rating_input');
            var $starItems = $('.star-item');
            var $ratingText = $('#rating_text');

            $starItems.on('mouseenter', function () {
                var hoverVal = parseInt($(this).data('value'));
                highlightStars(hoverVal);
            });

            $('#star_rating_picker').on('mouseleave', function () {
                var currentVal = parseInt($ratingInput.val()) || 5;
                highlightStars(currentVal);
            });

            $starItems.on('click', function () {
                var selectedVal = parseInt($(this).data('value'));
                $ratingInput.val(selectedVal);
                $ratingText.text(selectedVal);
                highlightStars(selectedVal);
            });

            function highlightStars(val) {
                $starItems.each(function () {
                    var itemVal = parseInt($(this).data('value'));
                    if (itemVal <= val) {
                        $(this).addClass('active');
                    } else {
                        $(this).removeClass('active');
                    }
                });
            }

            // Image Dropzone Handling
            var $photoInput = $('#client_photo');
            var $dropzone = $('#photo_dropzone');

            function formatBytes(bytes) {
                if (bytes === 0) return '0 B';
                var k = 1024;
                var sizes = ['B', 'KB', 'MB', 'GB'];
                var i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            $dropzone.on('click', function (e) {
                if (!$(e.target).closest('button').length && !$(e.target).is('button')) {
                    $photoInput.click();
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
                    $photoInput[0].files = files;
                    renderPreview(files[0]);
                }
            });

            $photoInput.on('change', function () {
                if (this.files && this.files[0]) {
                    renderPreview(this.files[0]);
                }
            });

            function renderPreview(file) {
                if (file.size > 10 * 1024 * 1024) {
                    toastr.warning('Photo exceeds 10MB limit', 'File Too Large');
                    $photoInput.val('');
                    return;
                }
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#photo_preview_img').attr('src', e.target.result);
                    $('#photo_preview_name').text(file.name);
                    $('#photo_preview_size').text(formatBytes(file.size));
                    $('#photo_empty').addClass('d-none');
                    $('#photo_preview_box').removeClass('d-none');
                };
                reader.readAsDataURL(file);
            }

            $('#btn_remove_photo').on('click', function (e) {
                e.stopPropagation();
                $photoInput.val('');
                $('#photo_preview_img').attr('src', '');
                $('#photo_preview_box').addClass('d-none');
                $('#photo_empty').removeClass('d-none');
            });
        });
    </script>
@endpush

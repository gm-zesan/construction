@extends('admin.app')
@section('title', 'Edit Team Member: ' . $teamMember->name)

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
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <form id="teamMemberEditForm" action="{{ route('team-members.update', $teamMember->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="row">
                {{-- Left Column: Core Member Details --}}
                <div class="col-lg-8 col-12">
                    <div class="card table-card mb-4">
                        <div class="card-header table-header">
                            <div class="title-with-breadcrumb">
                                <div class="table-title">Edit Team Member</div>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('team-members.index') }}">Team Members</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Edit #{{ $teamMember->id }}</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('team-members.show', $teamMember->id) }}" class="add-new"
                                    style="background-color: #f1f5f9; color: #334155;">
                                    <i class="ri-eye-line me-1"></i> Preview
                                </a>
                                <a href="{{ route('team-members.index') }}" class="add-new">
                                    <i class="ri-list-check me-1"></i> Team Members
                                </a>
                            </div>
                        </div>
                        <div class="card-body custom-form p-4">
                            <div class="row g-3">
                                {{-- Full Name --}}
                                <div class="col-md-6 col-12">
                                    <label for="name" class="form-label custom-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control custom-input @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ old('name', $teamMember->name) }}" required>
                                    @error('name')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Designation / Role --}}
                                <div class="col-md-6 col-12">
                                    <label for="designation" class="form-label custom-label">Designation / Role <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control custom-input @error('designation') is-invalid @enderror"
                                        name="designation" id="designation" value="{{ old('designation', $teamMember->designation) }}" required>
                                    @error('designation')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Department --}}
                                <div class="col-md-6 col-12">
                                    <label for="department" class="form-label custom-label">Department / Discipline</label>
                                    <input type="text" list="departmentList" class="form-control custom-input @error('department') is-invalid @enderror"
                                        name="department" id="department" value="{{ old('department', $teamMember->department) }}" placeholder="e.g. Architecture & Planning, Structural">
                                    <datalist id="departmentList">
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept }}">
                                        @endforeach
                                    </datalist>
                                    @error('department')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email Address --}}
                                <div class="col-md-6 col-12">
                                    <label for="email" class="form-label custom-label">Email Address</label>
                                    <input type="email" class="form-control custom-input @error('email') is-invalid @enderror"
                                        name="email" id="email" value="{{ old('email', $teamMember->email) }}" placeholder="name@company.com">
                                    @error('email')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Phone Number --}}
                                <div class="col-md-6 col-12">
                                    <label for="phone" class="form-label custom-label">Phone Number</label>
                                    <input type="text" class="form-control custom-input @error('phone') is-invalid @enderror"
                                        name="phone" id="phone" value="{{ old('phone', $teamMember->phone) }}" placeholder="+1 (555) 000-0000">
                                    @error('phone')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- LinkedIn Profile --}}
                                <div class="col-md-6 col-12">
                                    <label for="linkedin_url" class="form-label custom-label">LinkedIn Profile URL</label>
                                    <input type="url" class="form-control custom-input @error('linkedin_url') is-invalid @enderror"
                                        name="linkedin_url" id="linkedin_url" value="{{ old('linkedin_url', $teamMember->linkedin_url) }}" placeholder="https://linkedin.com/in/username">
                                    @error('linkedin_url')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Twitter / X URL --}}
                                <div class="col-md-6 col-12">
                                    <label for="twitter_url" class="form-label custom-label">X / Twitter URL</label>
                                    <input type="url" class="form-control custom-input @error('twitter_url') is-invalid @enderror"
                                        name="twitter_url" id="twitter_url" value="{{ old('twitter_url', $teamMember->twitter_url) }}" placeholder="https://x.com/username">
                                    @error('twitter_url')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Facebook URL --}}
                                <div class="col-md-6 col-12">
                                    <label for="facebook_url" class="form-label custom-label">Facebook Profile URL</label>
                                    <input type="url" class="form-control custom-input @error('facebook_url') is-invalid @enderror"
                                        name="facebook_url" id="facebook_url" value="{{ old('facebook_url', $teamMember->facebook_url) }}" placeholder="https://facebook.com/username">
                                    @error('facebook_url')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Professional Bio / Overview --}}
                                <div class="col-12">
                                    <label for="bio" class="form-label custom-label">Professional Overview / Bio</label>
                                    <textarea class="form-control custom-input @error('bio') is-invalid @enderror"
                                        name="bio" id="bio" rows="5">{{ old('bio', $teamMember->bio) }}</textarea>
                                    @error('bio')
                                        <div class="error_msg">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Controls & Photo Upload --}}
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
                                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                                value="1" {{ old('is_active', $teamMember->is_active) ? 'checked' : '' }} style="cursor: pointer;">
                                            <label class="form-check-label fw-semibold" for="is_active" style="font-size: 13.5px; cursor: pointer;">
                                                Visible on Website
                                            </label>
                                        </div>

                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured"
                                                value="1" {{ old('is_featured', $teamMember->is_featured) ? 'checked' : '' }} style="cursor: pointer;">
                                            <label class="form-check-label fw-semibold" for="is_featured" style="font-size: 13.5px; cursor: pointer;">
                                                Feature on Leadership Carousel
                                            </label>
                                        </div>

                                        <div>
                                            <label for="sort_order" class="form-label custom-label mb-1">Display Priority Order</label>
                                            <input type="number" class="form-control custom-input @error('sort_order') is-invalid @enderror"
                                                name="sort_order" id="sort_order" value="{{ old('sort_order', $teamMember->sort_order) }}" min="0">
                                            <div class="text-muted" style="font-size: 11px;">Lower numbers appear first (e.g. 0, 1, 2)</div>
                                            @error('sort_order')
                                                <div class="error_msg">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <button type="submit" class="btn submit-button w-100">
                                                <i class="ri-check-line me-1"></i> Update
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('team-members.index') }}" class="btn leave-button w-100">
                                                Cancel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Portrait Photo Dropzone with Current/Staged Preview --}}
                        <div class="col-12">
                            <div class="card table-card">
                                <div class="card-header table-header">
                                    <div class="table-title">Portrait Photo</div>
                                </div>
                                <div class="card-body custom-form p-3">
                                    <input type="file" id="photo" name="photo" class="d-none" accept="image/png,image/jpeg,image/webp,image/jpg">

                                    <div id="photo_dropzone" class="dropzone-box">
                                        <div id="photo_empty" class="{{ $teamMember->hasMedia('photo') ? 'd-none' : '' }}">
                                            <div class="dropzone-icon">
                                                <i class="ri-user-add-line"></i>
                                            </div>
                                            <p class="fw-bold text-dark mb-1" style="font-size: 13px;">Drop member photo here</p>
                                            <span class="text-muted d-block mb-3" style="font-size: 11.5px;">PNG, JPG, WebP up to 5MB (600×700px recommended)</span>
                                            <button type="button" class="btn btn-sm upload-btn px-3 mx-auto" onclick="$('#photo').click();">
                                                <i class="ri-upload-2-line me-1"></i> Browse Photo
                                            </button>
                                        </div>

                                        {{-- Staged / Current Preview Box --}}
                                        <div id="photo_preview_box" class="{{ $teamMember->hasMedia('photo') ? '' : 'd-none' }}">
                                            <div class="position-relative rounded overflow-hidden mx-auto mb-2 border shadow-sm" style="width: 140px; height: 165px; background: #f8fafc;">
                                                <img id="photo_preview_img" src="{{ $teamMember->photo_url ?? '' }}" alt="{{ $teamMember->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                <button type="button" class="preview-remove-btn {{ $teamMember->hasMedia('photo') ? 'd-none' : '' }}" id="btn_remove_photo" title="Cancel selected photo">
                                                    <i class="ri-close-line"></i>
                                                </button>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between px-1">
                                                <div class="text-start text-truncate me-2">
                                                    <span id="photo_preview_name" class="fw-semibold text-dark d-block text-truncate" style="font-size: 12px;">{{ $teamMember->getFirstMedia('photo')?->file_name ?? $teamMember->name }}</span>
                                                    <span id="photo_preview_size" class="text-muted" style="font-size: 11px;">{{ $teamMember->getFirstMedia('photo')?->readable_size ?? 'Active photo' }}</span>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-secondary px-2" style="font-size: 11.5px; height: 28px;" onclick="$('#photo').click();">
                                                    Change
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @error('photo')
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
    <script type="text/javascript">
        $(document).ready(function() {
            var $photoInput = $('#photo');
            var $dropzone = $('#photo_dropzone');
            var originalPhotoSrc = "{{ $teamMember->photo_url ?? '' }}";
            var originalPhotoName = "{{ $teamMember->getFirstMedia('photo')?->file_name ?? $teamMember->name }}";
            var originalPhotoSize = "{{ $teamMember->getFirstMedia('photo')?->readable_size ?? 'Active photo' }}";
            var hasOriginalPhoto = {{ $teamMember->hasMedia('photo') ? 'true' : 'false' }};

            function formatBytes(bytes) {
                if (bytes === 0) return '0 B';
                var k = 1024;
                var sizes = ['B', 'KB', 'MB', 'GB'];
                var i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            $dropzone.on('click', function(e) {
                if (!$(e.target).closest('button').length && !$(e.target).is('button')) {
                    $photoInput.click();
                }
            });

            $dropzone.on('dragover dragenter', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $dropzone.addClass('dragover');
            });

            $dropzone.on('dragleave drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $dropzone.removeClass('dragover');
            });

            $dropzone.on('drop', function(e) {
                var files = e.originalEvent.dataTransfer.files;
                if (files && files.length > 0) {
                    $photoInput[0].files = files;
                    renderPreview(files[0]);
                }
            });

            $photoInput.on('change', function() {
                if (this.files && this.files[0]) {
                    renderPreview(this.files[0]);
                }
            });

            function renderPreview(file) {
                if (!file.type.match('image.*')) {
                    toastr.warning('Please select a valid image file (JPG, PNG, WebP)', 'Invalid File Type');
                    $photoInput.val('');
                    return;
                }
                if (file.size > 5 * 1024 * 1024) {
                    toastr.warning('Photo exceeds 5MB limit', 'File Too Large');
                    $photoInput.val('');
                    return;
                }
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#photo_preview_img').attr('src', e.target.result);
                    $('#photo_preview_name').text(file.name);
                    $('#photo_preview_size').text(formatBytes(file.size));
                    $('#btn_remove_photo').removeClass('d-none');
                    $('#photo_empty').addClass('d-none');
                    $('#photo_preview_box').removeClass('d-none');
                    toastr.info('New photo selected. Click "Update Member" to save.');
                };
                reader.readAsDataURL(file);
            }

            $('#btn_remove_photo').on('click', function(e) {
                e.stopPropagation();
                $photoInput.val('');
                if (hasOriginalPhoto) {
                    $('#photo_preview_img').attr('src', originalPhotoSrc);
                    $('#photo_preview_name').text(originalPhotoName);
                    $('#photo_preview_size').text(originalPhotoSize);
                    $(this).addClass('d-none');
                } else {
                    $('#photo_preview_img').attr('src', '');
                    $('#photo_preview_box').addClass('d-none');
                    $('#photo_empty').removeClass('d-none');
                }
            });
        });
    </script>
@endpush

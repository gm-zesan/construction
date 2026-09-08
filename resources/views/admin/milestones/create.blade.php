@extends('admin.app')
@section('title')
    Create Project Milestone
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
    .dropzone-box:hover, .dropzone-box.dragover {
        border-color: #f95716;
        background-color: #fff7ed;
        transform: translateY(-1px);
    }
    .dropzone-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: rgba(249, 87, 22, 0.1);
        color: #f95716;
        font-size: 26px;
        margin: 0 auto 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .upload-btn {
        background-color: #f95716;
        border-color: #f95716;
        color: #ffffff;
        font-weight: 600;
        font-size: 13px;
        border-radius: 6px;
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
        <form id="milestoneCreateForm" action="{{ route('milestones.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- Main Form Details --}}
                <div class="col-lg-8 col-12">
                    <div class="card table-card mb-4">
                        <div class="card-header table-header">
                            <div class="title-with-breadcrumb">
                                <div class="table-title">New Project Milestone</div>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('milestones.index') }}">Milestones</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                                    </ol>
                                </nav>
                            </div>
                            <a href="{{ route('milestones.index') }}" class="add-new">
                                <i class="ri-list-check me-1"></i> Milestone List
                            </a>
                        </div>
                        <div class="card-body custom-form p-4">
                            <div class="row g-3">
                                {{-- Project Selection --}}
                                <div class="col-md-12">
                                    <label for="project_id" class="form-label custom-label">Associated Construction Project <span class="text-danger">*</span></label>
                                    <select class="form-select custom-input @error('project_id') is-invalid @enderror" name="project_id" id="project_id" required>
                                        <option value="">Select a construction project...</option>
                                        @foreach($projects as $p)
                                            <option value="{{ $p->id }}" {{ old('project_id') == $p->id ? 'selected' : '' }}>
                                                {{ $p->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Milestone Title --}}
                                <div class="col-md-12">
                                    <label for="title" class="form-label custom-label">Milestone Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control custom-input @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title') }}" placeholder="e.g. Structural Steel Superstructure Complete" required>
                                    @error('title')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Target Date & Completion Date --}}
                                <div class="col-md-6">
                                    <label for="target_date" class="form-label custom-label">Target Completion Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control custom-input @error('target_date') is-invalid @enderror" name="target_date" id="target_date" value="{{ old('target_date', date('Y-m-d')) }}" required>
                                    @error('target_date')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="completion_date" class="form-label custom-label">Actual Completion Date (Optional)</label>
                                    <input type="date" class="form-control custom-input @error('completion_date') is-invalid @enderror" name="completion_date" id="completion_date" value="{{ old('completion_date') }}">
                                    @error('completion_date')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Progress Percentage --}}
                                <div class="col-md-12">
                                    <label for="progress_percentage" class="form-label custom-label d-flex justify-content-between">
                                        <span>Milestone Execution Progress</span>
                                        <span class="fw-bold text-primary" id="progressValBadge">{{ old('progress_percentage', 0) }}%</span>
                                    </label>
                                    <input type="range" class="form-range" name="progress_percentage" id="progress_percentage" min="0" max="100" step="5" value="{{ old('progress_percentage', 0) }}" oninput="$('#progressValBadge').text(this.value + '%');">
                                </div>

                                {{-- Description --}}
                                <div class="col-12">
                                    <label for="description" class="form-label custom-label">Phase Description &amp; Scope of Inspection</label>
                                    <textarea class="form-control custom-input @error('description') is-invalid @enderror" name="description" id="description" rows="4" placeholder="Detailed summary of work completed for this milestone...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Status, Verification Image, & Actions --}}
                <div class="col-lg-4 col-12">
                    <div class="row g-4">
                        {{-- Save / Publish Actions Card --}}
                        <div class="col-12">
                            <div class="card table-card">
                                <div class="card-header table-header">
                                    <div class="table-title">Milestone Status &amp; Save</div>
                                </div>
                                <div class="card-body custom-form p-3">
                                    <div class="d-flex flex-column gap-3 mb-3">
                                        <div>
                                            <label for="status" class="form-label custom-label mb-1">Current Status <span class="text-danger">*</span></label>
                                            <select class="form-select custom-input" name="status" id="status" required>
                                                @foreach($statuses as $st)
                                                    <option value="{{ $st->value }}" {{ old('status', 'pending') == $st->value ? 'selected' : '' }}>
                                                        {{ $st->label() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', 1) ? 'checked' : '' }} style="cursor: pointer;">
                                            <label class="form-check-label fw-semibold" for="is_published" style="font-size: 13px; cursor: pointer;">
                                                Visible on Project Timeline
                                            </label>
                                        </div>

                                        <div>
                                            <label for="sort_order" class="form-label custom-label mb-1">Sequence Order</label>
                                            <input type="number" class="form-control custom-input" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                            <div class="text-muted" style="font-size: 11px;">Lower numbers appear first (e.g. 0, 1, 2)</div>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <button type="submit" class="btn submit-button w-100">
                                                <i class="ri-check-line me-1"></i> Save
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('milestones.index') }}" class="btn leave-button w-100">
                                                Cancel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Site Verification Photo --}}
                        <div class="col-12">
                            <div class="card table-card">
                                <div class="card-header table-header">
                                    <div class="table-title">Site Verification Photo</div>
                                </div>
                                <div class="card-body custom-form p-3">
                                    <input type="file" id="image" name="image" class="d-none" accept="image/png,image/jpeg,image/webp,image/jpg">

                                    <div id="image_dropzone" class="dropzone-box">
                                        <div id="image_empty">
                                            <div class="dropzone-icon">
                                                <i class="ri-image-add-line"></i>
                                            </div>
                                            <p class="fw-bold text-dark mb-1" style="font-size: 13px;">Drop site photo here</p>
                                            <span class="text-muted d-block mb-3" style="font-size: 11.5px;">PNG, JPG up to 10MB</span>
                                            <button type="button" class="btn btn-sm upload-btn px-3 mx-auto" onclick="$('#image').click();">
                                                <i class="ri-upload-2-line me-1"></i> Browse Photo
                                            </button>
                                        </div>

                                        {{-- Staged Preview Box --}}
                                        <div id="image_preview_box" class="d-none">
                                            <div class="position-relative rounded overflow-hidden mb-2" style="height: 160px; background: #000;">
                                                <img id="image_preview_img" src="" alt="Verification preview" style="width: 100%; height: 100%; object-fit: cover;">
                                                <button type="button" class="preview-remove-btn" id="btn_remove_image" title="Remove selected image">
                                                    <i class="ri-close-line"></i>
                                                </button>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between px-1">
                                                <div class="text-start text-truncate me-2">
                                                    <span id="image_preview_name" class="fw-semibold text-dark d-block text-truncate" style="font-size: 12px;"></span>
                                                    <span id="image_preview_size" class="text-muted" style="font-size: 11px;"></span>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-secondary px-2" style="font-size: 11.5px; height: 28px;" onclick="$('#image').click();">
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

@push('custom-scripts')
    <script type="text/javascript">
        $(document).ready(function () {
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
                if (!$(e.target).closest('button').length) {
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

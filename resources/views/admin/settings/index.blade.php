@extends('admin.app')

@php
    $currentGroupMeta = $groupMeta[$activeGroup] ?? [
        'title' => ucwords(str_replace('_', ' ', $activeGroup)),
        'icon' => 'ri-settings-4-line text-primary'
    ];
@endphp

@section('title')
    {{ $currentGroupMeta['title'] }} - Website Settings
@endsection

@push('custom-style')
    <style>
        .dropzone-box {
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            background-color: #f8fafc;
            padding: 20px 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .dropzone-box:hover,
        .dropzone-box.dragover {
            border-color: #f95716;
            background-color: #fff7ed;
        }

        .dropzone-icon {
            width: 44px;
            height: 44px;
            line-height: 44px;
            border-radius: 50%;
            background-color: rgba(249, 87, 22, 0.1);
            color: #f95716;
            font-size: 22px;
            margin: 0 auto 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .settings-section-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #ffffff;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }

        .settings-section-header {
            padding: 14px 20px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .settings-section-body {
            padding: 20px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <div class="row g-3">
            <div class="col-12">
                <div class="card table-card mb-4">
                    <div class="card-header table-header d-flex justify-content-between align-items-center">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">{{ $currentGroupMeta['title'] }}</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item">Website Settings</li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $currentGroupMeta['title'] }}</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('home') }}" target="_blank" class="add-new">
                                <i class="ri-external-link-line me-1"></i> View Live Site
                            </a>
                        </div>
                    </div>

                    <div class="card-body custom-form">
                        <form id="websiteSettingsForm" action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="active_group" value="{{ $activeGroup }}">

                            @php
                                $imageFieldKeys = [];
                                $settingsInActiveGroup = $groupedSettings[$activeGroup] ?? [];
                            @endphp

                            <div class="settings-section-card" id="section-{{ $activeGroup }}">
                                <div class="settings-section-header">
                                    <i class="{{ $currentGroupMeta['icon'] ?? 'ri-settings-4-line text-primary' }}" style="font-size: 18px;"></i> {{ $currentGroupMeta['title'] }}
                                </div>
                                <div class="settings-section-body">
                                    <div class="row g-3">
                                        @forelse($settingsInActiveGroup as $setting)
                                            @php
                                                $val = old($setting->key, $setting->value ?? '');
                                                $isRequired = $setting->key === 'company_name';
                                                $colClass = $setting->col_class;
                                            @endphp

                                            <div class="{{ $colClass }}">
                                                <label for="{{ $setting->key }}" class="form-label custom-label">
                                                    {{ $setting->label }}
                                                    @if($isRequired)
                                                        <span class="text-danger">*</span>
                                                    @endif
                                                </label>

                                                {{-- 1. Image Type Field --}}
                                                @if($setting->type === 'image')
                                                    @php
                                                        $imageFieldKeys[] = $setting->key;
                                                        $hasValue = !empty($setting->value);
                                                    @endphp

                                                    <input type="file" id="{{ $setting->key }}_input" name="{{ $setting->key }}" class="d-none dynamic-image-input" data-key="{{ $setting->key }}" accept="image/png,image/jpeg,image/webp,image/svg+xml,image/x-icon">
                                                    <input type="hidden" name="remove_{{ $setting->key }}" id="remove_{{ $setting->key }}_input" value="0">

                                                    <div id="{{ $setting->key }}_dropzone" class="dropzone-box" data-key="{{ $setting->key }}">
                                                        <div id="{{ $setting->key }}_empty" class="{{ $hasValue ? 'd-none' : '' }}">
                                                            <div class="dropzone-icon">
                                                                <i class="ri-image-add-line"></i>
                                                            </div>
                                                            <div class="fw-semibold text-dark mt-1" style="font-size: 13px;">Upload {{ $setting->label }}</div>
                                                            <div class="text-muted" style="font-size: 11.5px;">PNG, SVG, JPG, WebP, ICO up to 5MB</div>
                                                        </div>

                                                        <div id="{{ $setting->key }}_preview" class="{{ !$hasValue ? 'd-none' : '' }}">
                                                            <div class="position-relative d-inline-block rounded overflow-hidden border p-2 mb-2 bg-white" style="max-height: 100px;">
                                                                <img id="{{ $setting->key }}_img" src="{{ $hasValue ? asset($setting->value) : '' }}" alt="{{ $setting->label }}" style="max-height: 80px; max-width: 100%; object-fit: contain;">
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 dynamic-change-btn" data-key="{{ $setting->key }}" style="font-size: 11.5px;">
                                                                    <i class="ri-refresh-line me-1"></i> Change
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 dynamic-remove-btn" data-key="{{ $setting->key }}" style="font-size: 11.5px;">
                                                                    <i class="ri-delete-bin-line me-1"></i> Remove
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                {{-- 2. Textarea Type Field --}}
                                                @elseif($setting->type === 'textarea')
                                                    <textarea class="form-control custom-input @error($setting->key) is-invalid @enderror"
                                                        id="{{ $setting->key }}" name="{{ $setting->key }}" rows="2" placeholder="{{ $setting->placeholder }}">{{ $val }}</textarea>

                                                {{-- 3. Email Type Field --}}
                                                @elseif($setting->type === 'email')
                                                    <input type="email" class="form-control custom-input @error($setting->key) is-invalid @enderror"
                                                        id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ $val }}" placeholder="{{ $setting->placeholder }}" {{ $isRequired ? 'required' : '' }}>

                                                {{-- 4. URL Type Field --}}
                                                @elseif($setting->type === 'url')
                                                    <input type="url" class="form-control custom-input @error($setting->key) is-invalid @enderror"
                                                        id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ $val }}" placeholder="{{ $setting->placeholder }}" {{ $isRequired ? 'required' : '' }}>

                                                {{-- 5. Text / Phone / Default Field --}}
                                                @else
                                                    <input type="text" class="form-control custom-input @error($setting->key) is-invalid @enderror"
                                                        id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ $val }}" placeholder="{{ $setting->placeholder }}" {{ $isRequired ? 'required' : '' }}>
                                                @endif

                                                @error($setting->key)
                                                    <div class="error_msg">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <div class="alert alert-light border text-center py-4 text-muted mb-0">
                                                    No settings defined for this group.
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="row mt-4 pt-3 border-top">
                                <div class="col-12 d-flex align-items-center">
                                    <button type="submit" class="btn submit-button me-2" id="btn_save_settings">
                                        <i class="ri-check-line me-1"></i> Save {{ $currentGroupMeta['title'] }}
                                    </button>
                                    <a href="{{ route('dashboard') }}" class="btn leave-button">
                                        <i class="ri-arrow-left-line me-1"></i> Dashboard
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dynamic Image Uploaders Handler
            const imageKeys = @json($imageFieldKeys);

            imageKeys.forEach(key => {
                setupDynamicUploader(key);
            });

            function setupDynamicUploader(key) {
                const dropzone = document.getElementById(`${key}_dropzone`);
                const input = document.getElementById(`${key}_input`);
                const emptyState = document.getElementById(`${key}_empty`);
                const previewState = document.getElementById(`${key}_preview`);
                const previewImg = document.getElementById(`${key}_img`);
                const removeInput = document.getElementById(`remove_${key}_input`);
                const changeBtn = previewState ? previewState.querySelector('.dynamic-change-btn') : null;
                const removeBtn = previewState ? previewState.querySelector('.dynamic-remove-btn') : null;

                if (!dropzone || !input) return;

                dropzone.addEventListener('click', function (e) {
                    if (e.target.closest('button')) return;
                    input.click();
                });

                if (changeBtn) {
                    changeBtn.addEventListener('click', function (e) {
                        e.stopPropagation();
                        input.click();
                    });
                }

                input.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        previewFile(this.files[0], {
                            previewImg,
                            emptyState,
                            previewState,
                            removeInput
                        });
                    }
                });

                dropzone.addEventListener('dragover', function (e) {
                    e.preventDefault();
                    this.classList.add('dragover');
                });

                dropzone.addEventListener('dragleave', function (e) {
                    e.preventDefault();
                    this.classList.remove('dragover');
                });

                dropzone.addEventListener('drop', function (e) {
                    e.preventDefault();
                    this.classList.remove('dragover');
                    if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                        input.files = e.dataTransfer.files;
                        previewFile(e.dataTransfer.files[0], {
                            previewImg,
                            emptyState,
                            previewState,
                            removeInput
                        });
                    }
                });

                if (removeBtn) {
                    removeBtn.addEventListener('click', function (e) {
                        e.stopPropagation();
                        input.value = '';
                        if (previewImg) previewImg.src = '';
                        if (emptyState) emptyState.classList.remove('d-none');
                        if (previewState) previewState.classList.add('d-none');
                        if (removeInput) removeInput.value = '1';
                    });
                }
            }

            function previewFile(file, cfg) {
                if (!file.type.match('image.*') && !file.name.endsWith('.ico')) {
                    if (typeof toastr !== 'undefined') toastr.error('Please select a valid image file');
                    return;
                }
                const reader = new FileReader();
                reader.onload = function (e) {
                    if (cfg.previewImg) cfg.previewImg.src = e.target.result;
                    if (cfg.emptyState) cfg.emptyState.classList.add('d-none');
                    if (cfg.previewState) cfg.previewState.classList.remove('d-none');
                    if (cfg.removeInput) cfg.removeInput.value = '0';
                    if (typeof toastr !== 'undefined') toastr.success('Image selected: ' + file.name);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush

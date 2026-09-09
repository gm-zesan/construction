@extends('admin.app')

@php
    $currentGroupMeta = $groupMeta[$activeGroup] ?? [
        'title' => ucwords(str_replace(['_', '-'], ' ', $activeGroup)),
        'icon' => 'ri-settings-4-line text-primary'
    ];
    $isSuperadmin = Auth::check() && (Auth::user()->hasRole('superadmin') || Auth::user()->can('website-setting-create'));
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
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
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
                    <div class="card-header table-header d-flex justify-content-between align-items-center flex-wrap gap-2">
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
                            @if($isSuperadmin)
                                <button type="button" class="add-new" data-bs-toggle="modal" data-bs-target="#createSettingFieldModal">
                                    <i class="ri-add-line me-1"></i> Add Dynamic Field
                                </button>
                            @endif
                            <a href="{{ route('home') }}" target="_blank" class="add-new" style="background-color: #ffffff; color: #475569; border: 1px solid #cbd5e1;">
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
                                <div class="settings-section-header justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="{{ $currentGroupMeta['icon'] ?? 'ri-settings-4-line text-primary' }}" style="font-size: 18px;"></i>
                                        <span>{{ $currentGroupMeta['title'] }}</span>
                                    </div>
                                    <span class="badge bg-light text-dark border" style="font-size: 11px;">
                                        {{ count($settingsInActiveGroup) }} Fields
                                    </span>
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
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <label for="{{ $setting->key }}" class="form-label custom-label mb-0">
                                                        {{ $setting->label }}
                                                        @if($isRequired)
                                                            <span class="text-danger">*</span>
                                                        @endif
                                                        @if($setting->is_custom)
                                                            <span class="badge bg-light text-primary border ms-1" style="font-size: 10px;">Custom</span>
                                                        @endif
                                                    </label>

                                                    @if($setting->is_custom && $isSuperadmin)
                                                        <button type="button" class="btn btn-link text-danger p-0 delete-field-btn" data-id="{{ $setting->id }}" data-name="{{ $setting->label }}" title="Delete custom field" style="font-size: 13px; text-decoration: none;">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    @endif
                                                </div>

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

                                                {{-- 5. Number Type Field --}}
                                                @elseif($setting->type === 'number')
                                                    <input type="number" step="any" class="form-control custom-input @error($setting->key) is-invalid @enderror"
                                                        id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ $val }}" placeholder="{{ $setting->placeholder }}" {{ $isRequired ? 'required' : '' }}>

                                                {{-- 6. Text / Phone / Default Field --}}
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

    {{-- Superadmin Dynamic Setting Field Creation Modal --}}
    @if($isSuperadmin)
        <div class="modal fade" id="createSettingFieldModal" tabindex="-1" aria-labelledby="createSettingFieldModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0"
                                style="width: 32px; height: 32px; background-color: #f95716;">
                                <i class="ri-settings-4-line" style="font-size: 18px;"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold text-dark mb-0" id="createSettingFieldModalLabel"
                                    style="font-size: 15.5px;">
                                    Create Dynamic Website Setting
                                </h5>
                                <span class="text-muted" style="font-size: 11.5px;">Add custom configuration fields to the website settings repository</span>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <form action="{{ route('settings.fields.store') }}" method="POST">
                            @csrf
                            <div class="row g-3 mb-3">
                                {{-- Target Group Selection --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Target Group <span class="text-danger">*</span></label>
                                    <select name="group" id="field_group_select" class="form-select custom-input" style="height: 38px; font-size: 13px;" required>
                                        @foreach($groupMeta as $gKey => $gMeta)
                                            <option value="{{ $gKey }}" {{ $activeGroup === $gKey ? 'selected' : '' }}>
                                                {{ $gMeta['title'] }} ({{ $gKey }})
                                            </option>
                                        @endforeach
                                        <option value="__new__">+ Create New Group...</option>
                                    </select>
                                </div>

                                {{-- Custom Group Name (if new group selected) --}}
                                <div class="col-md-6 d-none" id="custom_group_wrapper">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">New Group Name <span class="text-danger">*</span></label>
                                    <input type="text" id="custom_group_input" class="form-control custom-input" placeholder="e.g. Integrations or Analytics" style="height: 38px; font-size: 13px;">
                                </div>

                                {{-- Field Label --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Field Label / Title <span class="text-danger">*</span></label>
                                    <input type="text" id="field_label" name="label" class="form-control custom-input" placeholder="e.g. Emergency Hotline Number" required style="height: 38px; font-size: 13px;">
                                </div>

                                {{-- Field Key (auto-generated snake_case) --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Setting Key (Identifier) <span class="text-danger">*</span></label>
                                    <input type="text" id="field_key" name="key" class="form-control custom-input" placeholder="e.g. emergency_hotline" required style="height: 38px; font-size: 13px;">
                                    <div class="text-muted mt-1" style="font-size: 11px;">Code accessor: <code>get_setting('key')</code></div>
                                </div>

                                {{-- Field Input Type --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Field Type <span class="text-danger">*</span></label>
                                    <select id="field_type" name="type" class="form-select custom-input" style="height: 38px; font-size: 13px;" required>
                                        <option value="text">Text (Single Line)</option>
                                        <option value="textarea">Textarea (Multi-line)</option>
                                        <option value="email">Email Address</option>
                                        <option value="phone">Phone Number</option>
                                        <option value="url">URL / Web Link</option>
                                        <option value="image">Image File Upload</option>
                                        <option value="number">Numeric Value</option>
                                    </select>
                                </div>

                                {{-- Column Grid Size --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Grid Width Class</label>
                                    <select id="field_col_class" name="col_class" class="form-select custom-input" style="height: 38px; font-size: 13px;">
                                        <option value="col-md-6 col-12">Half Width (col-md-6)</option>
                                        <option value="col-12">Full Width (col-12)</option>
                                        <option value="col-md-4 col-12">One Third (col-md-4)</option>
                                        <option value="col-md-8 col-12">Two Thirds (col-md-8)</option>
                                    </select>
                                </div>

                                {{-- Placeholder Helper --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Placeholder Text (Optional)</label>
                                    <input type="text" id="field_placeholder" name="placeholder" class="form-control custom-input" placeholder="e.g. Enter phone number..." style="height: 38px; font-size: 13px;">
                                </div>

                                {{-- Initial / Default Value --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Initial Default Value (Optional)</label>
                                    <input type="text" id="field_value" name="value" class="form-control custom-input" placeholder="Optional initial value" style="height: 38px; font-size: 13px;">
                                </div>
                            </div>

                            {{-- Modal Action Buttons matching uploadMediaModal --}}
                            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                                <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal"
                                    style="height: 36px; font-weight: 600;">Cancel</button>
                                <button type="submit" class="btn btn-primary btn-sm px-4"
                                    style="height: 36px; font-weight: 600; background-color: #f95716; border-color: #f95716;">
                                    <i class="ri-check-line me-1"></i> Save Setting Field
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hidden Delete Field Form --}}
        <form id="deleteSettingFieldForm" action="" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    @endif
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

            // Modal Dynamic Key Generation from Label
            const labelInput = document.getElementById('field_label');
            const keyInput = document.getElementById('field_key');
            let manualKeyEdit = false;

            if (keyInput) {
                keyInput.addEventListener('input', function () {
                    manualKeyEdit = true;
                });
            }

            if (labelInput && keyInput) {
                labelInput.addEventListener('input', function () {
                    if (!manualKeyEdit) {
                        const slug = this.value
                            .toLowerCase()
                            .replace(/[^a-z0-9]+/g, '_')
                            .replace(/^_+|_+$/g, '');
                        keyInput.value = slug;
                    }
                });
            }

            // Custom Group Input Toggle
            const groupSelect = document.getElementById('field_group_select');
            const customGroupWrapper = document.getElementById('custom_group_wrapper');
            const customGroupInput = document.getElementById('custom_group_input');

            if (groupSelect && customGroupWrapper && customGroupInput) {
                groupSelect.addEventListener('change', function () {
                    if (this.value === '__new__') {
                        customGroupWrapper.classList.remove('d-none');
                        customGroupInput.setAttribute('required', 'required');
                        customGroupInput.name = 'group';
                        groupSelect.name = '';
                    } else {
                        customGroupWrapper.classList.add('d-none');
                        customGroupInput.removeAttribute('required');
                        customGroupInput.name = '';
                        groupSelect.name = 'group';
                    }
                });
            }

            // Delete Custom Field Handler
            const deleteButtons = document.querySelectorAll('.delete-field-btn');
            const deleteForm = document.getElementById('deleteSettingFieldForm');

            deleteButtons.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const fieldId = this.getAttribute('data-id');
                    const fieldName = this.getAttribute('data-name');

                    if (confirm(`Are you sure you want to delete the custom field "${fieldName}"? This will permanently remove its value.`)) {
                        deleteForm.action = `/dashboard/settings/fields/${fieldId}`;
                        deleteForm.submit();
                    }
                });
            });

            // Auto-trigger Create Group Modal if requested from sidebar
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('create_group')) {
                const modalEl = document.getElementById('createSettingFieldModal');
                if (modalEl) {
                    if (groupSelect && customGroupWrapper && customGroupInput) {
                        groupSelect.value = '__new__';
                        customGroupWrapper.classList.remove('d-none');
                        customGroupInput.setAttribute('required', 'required');
                        customGroupInput.name = 'group';
                        groupSelect.name = '';
                    }
                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        const modal = new bootstrap.Modal(modalEl);
                        modal.show();
                    }
                }
            }
        });
    </script>
@endpush

@extends('admin.app')
@section('title', 'Create Role')

@push('custom-style')
<style>
    .permission-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        transition: all 0.2s ease-in-out;
    }
    .permission-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px -2px rgba(15, 23, 42, 0.06);
    }
    .permission-card .card-head {
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }
    .permission-card .form-check-input {
        width: 17px;
        height: 17px;
        border-radius: 4px !important;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        margin-top: 0.15em;
    }
    .permission-card .form-check-input:checked {
        background-color: #2563eb;
        border-color: #2563eb;
    }
    .permission-card .form-check-label {
        font-size: 13px;
        color: #334155;
        cursor: pointer;
        user-select: none;
        transition: color 0.15s ease;
    }
    .permission-card .form-check:hover .form-check-label {
        color: #0f172a;
    }
    .permission-count {
        font-size: 11.5px;
        font-weight: 600;
        color: #94a3b8;
        font-family: monospace;
    }
    .permission-count.has-selected {
        color: #2563eb;
    }
    .permission-count.all-selected {
        color: #10b981;
    }
</style>
@endpush

@section('content')
<div class="container-fluid my-3">
    <form action="{{ route('role.store') }}" method="POST" id="createRoleForm">
        @csrf

        {{-- Role Header & Basic Details Card --}}
        <div class="card table-card mb-4 border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-header table-header d-flex align-items-center justify-content-between p-3" style="border-bottom: 1px solid #f1f5f9;">
                <div class="title-with-breadcrumb">
                    <div class="table-title fw-bold" style="font-size: 16px; color: #0f172a;">Create New Role</div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0" style="font-size: 12px;">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('role.index') }}" class="text-decoration-none">Roles</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Role</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-outline-secondary px-3" style="height: 36px; border-radius: 6px; font-weight: 600;">
                        <i class="ri-key-2-line me-1"></i> Permissions
                    </a>
                    <a href="{{ route('role.index') }}" class="btn btn-sm btn-outline-secondary px-3" style="height: 36px; border-radius: 6px; font-weight: 600;">
                        <i class="ri-list-ordered-2 me-1"></i> Role List
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6 col-12">
                        <label class="form-label fw-semibold text-dark" style="font-size: 13px;">Role Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control custom-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="e.g. Editor, Project Manager, Support Lead" required style="height: 40px; font-size: 13.5px;">
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="form-label fw-semibold text-dark" style="font-size: 13px;">Role Description</label>
                        <input type="text" class="form-control custom-input @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" placeholder="Optional description of role responsibilities..." style="height: 40px; font-size: 13.5px;">
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Permissions Card --}}
        <div class="card table-card mb-4 border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-header table-header d-flex flex-wrap align-items-center justify-content-between p-3 gap-2" style="border-bottom: 1px solid #f1f5f9;">
                <div>
                    <div class="table-title fw-bold" style="font-size: 15px; color: #0f172a;">Role Permissions</div>
                    <div class="text-muted" style="font-size: 12px;">Assign granular module privileges and capabilities for this role.</div>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 12px; font-weight: 600;">
                        <span id="global_selected_count" class="text-primary fw-bold">0</span> / <span id="global_total_count">{{ $permission->count() }}</span> Total Selected
                    </span>
                    <button type="button" id="btn_select_all" class="btn btn-sm btn-outline-primary px-3" style="height: 32px; font-size: 12px; font-weight: 600; border-radius: 6px;">
                        <i class="ri-checkbox-multiple-line me-1"></i> Select All
                    </button>
                    <button type="button" id="btn_deselect_all" class="btn btn-sm btn-outline-secondary px-3" style="height: 32px; font-size: 12px; font-weight: 600; border-radius: 6px;">
                        <i class="ri-checkbox-blank-line me-1"></i> Deselect All
                    </button>
                    <button type="button" class="btn btn-sm btn-primary px-3" data-bs-toggle="modal" data-bs-target="#quickAddPermissionModal" style="height: 32px; font-size: 12px; font-weight: 600; border-radius: 6px; background-color: #f95716; border-color: #f95716;">
                        <i class="ri-add-line me-1"></i> Add Permission
                    </button>
                </div>
            </div>

            <div class="card-body p-4 bg-light bg-opacity-25">
                @error('permission')
                    <div class="alert alert-danger py-2 mb-3" style="font-size: 13px;">
                        <i class="ri-error-warning-line me-1"></i> Please select at least one permission.
                    </div>
                @enderror

                {{-- Permissions Grid (4-columns) --}}
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-3" id="permissions_grid_row">
                    @foreach ($modules as $module)
                        @php
                            $modulePermissions = $permission->where('module', $module->module);
                            $moduleSlug = \Illuminate\Support\Str::slug($module->module);
                            $moduleTitle = ucwords(str_replace(['-', '_'], ' ', $module->module));
                        @endphp
                        <div class="col">
                            <div class="permission-card h-100 p-3" data-card-module="{{ $module->module }}">
                                {{-- Module Card Header --}}
                                <div class="card-head d-flex align-items-center justify-content-between">
                                    <div class="form-check mb-0 d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input module-checkbox" id="mod-check-{{ $moduleSlug }}" data-module="{{ $module->module }}">
                                        <label class="form-check-label fw-bold text-dark ms-2" for="mod-check-{{ $moduleSlug }}" style="font-size: 13.5px;">
                                            {{ $moduleTitle }}
                                        </label>
                                    </div>
                                    <span class="permission-count" data-module-count="{{ $module->module }}">
                                        0/{{ $modulePermissions->count() }}
                                    </span>
                                </div>

                                {{-- Module Permission Items --}}
                                <div class="permission-list d-flex flex-column gap-2 mt-1">
                                    @foreach ($modulePermissions as $value)
                                        <div class="form-check mb-0 d-flex align-items-center">
                                            <input type="checkbox" name="permission[]" class="form-check-input permission-checkbox" id="check-{{ $value->id }}" value="{{ $value->id }}" data-module="{{ $module->module }}" {{ (is_array(old('permission')) && in_array($value->id, old('permission'))) ? 'checked' : '' }}>
                                            <label class="form-check-label ms-2" for="check-{{ $value->id }}">
                                                {{ $value->display_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Form Footer Actions --}}
            <div class="card-footer bg-white p-3 d-flex align-items-center justify-content-end gap-2" style="border-top: 1px solid #f1f5f9;">
                <a href="{{ route('role.index') }}" class="btn btn-outline-secondary px-4" style="height: 38px; border-radius: 6px; font-weight: 600; font-size: 13px;">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary submit-button px-4" style="height: 38px; border-radius: 6px; font-weight: 600; font-size: 13px; background-color: #f95716; border-color: #f95716;">
                    <i class="ri-save-line me-1"></i> Save Role
                    <span class="ms-1 spinner-border spinner-border-sm d-none" role="status"></span>
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Quick Add Permission Modal --}}
<div class="modal fade" id="quickAddPermissionModal" tabindex="-1" aria-labelledby="quickAddPermissionTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 10px;">
            <div class="modal-header" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 14px 20px;">
                <h5 class="modal-title fw-bold text-dark" id="quickAddPermissionTitle" style="font-size: 15px;">
                    <i class="ri-key-2-line text-primary me-1"></i> Create Dynamic Permission
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quickAddPermissionForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark" style="font-size: 13px;">Module / Group <span class="text-danger">*</span></label>
                        <input type="text" id="quick_perm_module" name="module" list="quick_modules_list" class="form-control custom-input" placeholder="e.g. project, service, blog, finance" required style="height: 38px; font-size: 13px;">
                        <datalist id="quick_modules_list">
                            @foreach ($modules as $mod)
                                <option value="{{ $mod->module }}">{{ ucwords(str_replace(['-', '_'], ' ', $mod->module)) }}</option>
                            @endforeach
                        </datalist>
                        <div class="text-muted mt-1" style="font-size: 11.5px;">Pick an existing module or type a new module name.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark" style="font-size: 13px;">Display Name <span class="text-danger">*</span></label>
                        <input type="text" id="quick_perm_display_name" name="display_name" class="form-control custom-input" placeholder="e.g. Export Reports, Print Invoices" required style="height: 38px; font-size: 13px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark" style="font-size: 13px;">Permission Key / Code</label>
                        <input type="text" id="quick_perm_name" name="name" class="form-control custom-input" placeholder="Auto-generated if left empty" style="height: 38px; font-size: 13px;">
                    </div>
                </div>

                <div class="modal-footer" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 12px 20px;">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3" data-bs-dismiss="modal" style="height: 36px; border-radius: 6px; font-size: 13px;">Cancel</button>
                    <button type="submit" id="btn_save_quick_permission" class="btn btn-sm btn-primary px-4" style="height: 36px; border-radius: 6px; font-size: 13px; font-weight: 600; background-color: #f95716; border-color: #f95716;">
                        <i class="ri-add-line me-1"></i> Add to Form
                        <span class="spinner-border spinner-border-sm d-none ms-1" role="status"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
    $(document).ready(function () {
        // Update single module card counter and checkbox state
        function updateModuleCard($card) {
            var $perms = $card.find('.permission-checkbox');
            var total = $perms.length;
            var checked = $perms.filter(':checked').length;

            var $countSpan = $card.find('.permission-count');
            $countSpan.text(checked + '/' + total);

            if (checked === total && total > 0) {
                $countSpan.removeClass('has-selected').addClass('all-selected');
                $card.find('.module-checkbox').prop('checked', true);
            } else if (checked > 0) {
                $countSpan.removeClass('all-selected').addClass('has-selected');
                $card.find('.module-checkbox').prop('checked', false);
            } else {
                $countSpan.removeClass('has-selected all-selected');
                $card.find('.module-checkbox').prop('checked', false);
            }
        }

        // Update overall total selected counter
        function updateGlobalCount() {
            var totalChecked = $('.permission-checkbox:checked').length;
            var totalAvailable = $('.permission-checkbox').length;
            $('#global_selected_count').text(totalChecked);
            $('#global_total_count').text(totalAvailable);
        }

        // Initialize all module cards on page load
        $('.permission-card').each(function () {
            updateModuleCard($(this));
        });
        updateGlobalCount();

        // Module Checkbox Click (Toggle All in Module)
        $(document).on('change', '.module-checkbox', function () {
            var isChecked = $(this).is(':checked');
            var $card = $(this).closest('.permission-card');
            $card.find('.permission-checkbox').prop('checked', isChecked);
            updateModuleCard($card);
            updateGlobalCount();
        });

        // Individual Permission Checkbox Click
        $(document).on('change', '.permission-checkbox', function () {
            var $card = $(this).closest('.permission-card');
            updateModuleCard($card);
            updateGlobalCount();
        });

        // Global Select All Button
        $('#btn_select_all').on('click', function () {
            $('.permission-checkbox').prop('checked', true);
            $('.permission-card').each(function () {
                updateModuleCard($(this));
            });
            updateGlobalCount();
        });

        // Global Deselect All Button
        $('#btn_deselect_all').on('click', function () {
            $('.permission-checkbox').prop('checked', false);
            $('.permission-card').each(function () {
                updateModuleCard($(this));
            });
            updateGlobalCount();
        });

        // Auto-slugify in Quick Add modal
        $('#quick_perm_display_name, #quick_perm_module').on('input', function () {
            var mod = $('#quick_perm_module').val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            var disp = $('#quick_perm_display_name').val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            if (mod && disp) {
                $('#quick_perm_name').val(mod + '-' + disp);
            } else if (disp) {
                $('#quick_perm_name').val(disp);
            }
        });

        // Quick Add Permission Form Submit via AJAX
        $('#quickAddPermissionForm').on('submit', function (e) {
            e.preventDefault();
            var $btn = $('#btn_save_quick_permission');
            $btn.prop('disabled', true);
            $btn.find('.spinner-border').removeClass('d-none');

            $.ajax({
                url: "{{ route('permissions.store') }}",
                type: 'POST',
                data: $(this).serialize(),
                success: function (res) {
                    if (res.success && res.data) {
                        var perm = res.data;
                        var moduleSlug = perm.module.toLowerCase().replace(/[^a-z0-9]+/g, '-');
                        var $card = $('.permission-card[data-card-module="' + perm.module + '"]');

                        if ($card.length) {
                            var itemHtml = '<div class="form-check mb-0 d-flex align-items-center">' +
                                '<input type="checkbox" name="permission[]" class="form-check-input permission-checkbox" id="check-' + perm.id + '" value="' + perm.id + '" data-module="' + perm.module + '" checked>' +
                                '<label class="form-check-label ms-2" for="check-' + perm.id + '">' + perm.display_name + '</label>' +
                                '</div>';
                            $card.find('.permission-list').append(itemHtml);
                        } else {
                            var cardHtml = '<div class="col">' +
                                '<div class="permission-card h-100 p-3" data-card-module="' + perm.module + '">' +
                                    '<div class="card-head d-flex align-items-center justify-content-between">' +
                                        '<div class="form-check mb-0 d-flex align-items-center">' +
                                            '<input type="checkbox" class="form-check-input module-checkbox" id="mod-check-' + moduleSlug + '" data-module="' + perm.module + '" checked>' +
                                            '<label class="form-check-label fw-bold text-dark ms-2" for="mod-check-' + moduleSlug + '" style="font-size: 13.5px;">' + perm.module_title + '</label>' +
                                        '</div>' +
                                        '<span class="permission-count all-selected" data-module-count="' + perm.module + '">1/1</span>' +
                                    '</div>' +
                                    '<div class="permission-list d-flex flex-column gap-2 mt-1">' +
                                        '<div class="form-check mb-0 d-flex align-items-center">' +
                                            '<input type="checkbox" name="permission[]" class="form-check-input permission-checkbox" id="check-' + perm.id + '" value="' + perm.id + '" data-module="' + perm.module + '" checked>' +
                                            '<label class="form-check-label ms-2" for="check-' + perm.id + '">' + perm.display_name + '</label>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';
                            $('#permissions_grid_row').append(cardHtml);
                            $card = $('.permission-card[data-card-module="' + perm.module + '"]');
                        }

                        if ($('#quick_modules_list option[value="' + perm.module + '"]').length === 0) {
                            $('#quick_modules_list').append('<option value="' + perm.module + '">' + perm.module_title + '</option>');
                        }

                        updateModuleCard($card);
                        updateGlobalCount();
                        $('#quickAddPermissionModal').modal('hide');
                        $('#quickAddPermissionForm')[0].reset();
                        toastr.success('Permission "' + perm.display_name + '" created and selected!');
                    }
                },
                error: function (xhr) {
                    var errorMsg = 'Failed to create permission.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var firstErr = Object.values(xhr.responseJSON.errors)[0];
                        if (Array.isArray(firstErr)) errorMsg = firstErr[0];
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    toastr.error(errorMsg);
                },
                complete: function () {
                    $btn.prop('disabled', false);
                    $btn.find('.spinner-border').addClass('d-none');
                }
            });
        });

        // Submit Button Loading state
        $('#createRoleForm').on('submit', function () {
            var $btn = $(this).find('.submit-button');
            $btn.prop('disabled', true);
            $btn.find('.spinner-border').removeClass('d-none');
        });
    });
</script>
@endpush

@extends('admin.app')
@section('title', 'Permissions Management')

@section('content')
<div class="container-fluid my-3">
    <div class="row">
        <div class="col-12">
            <div class="card table-card border-0 shadow-sm" style="border-radius: 10px;">
                {{-- Header --}}
                <div class="card-header table-header d-flex flex-wrap align-items-center justify-content-between p-3 gap-2" style="border-bottom: 1px solid #f1f5f9;">
                    <div class="title-with-breadcrumb">
                        <div class="table-title fw-bold" style="font-size: 16px; color: #0f172a;">Permissions Directory</div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0" style="font-size: 12px;">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('role.index') }}" class="text-decoration-none">Roles & Permissions</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('role.index') }}" class="btn btn-sm btn-outline-secondary px-3" style="height: 36px; border-radius: 6px; font-weight: 600;">
                            <i class="ri-shield-user-line me-1"></i> Roles List
                        </a>
                        <button type="button" class="btn btn-sm btn-primary px-3" id="btn_open_create_modal" style="height: 36px; border-radius: 6px; font-weight: 600; background-color: #f95716; border-color: #f95716;">
                            <i class="ri-add-line me-1"></i> New Permission
                        </button>
                    </div>
                </div>

                {{-- Filter Bar --}}
                <div class="p-3" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4 col-sm-6">
                            <label class="form-label mb-1 text-muted" style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Filter by Module</label>
                            <select id="filter_module" class="form-select form-select-sm custom-input" style="height: 36px; font-size: 13px;">
                                <option value="">All Modules</option>
                                @foreach ($modules as $mod)
                                    <option value="{{ $mod }}">{{ ucwords(str_replace(['-', '_'], ' ', $mod)) }} ({{ $mod }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6 d-flex align-items-end">
                            <button type="button" id="btn_reset_filters" class="btn btn-sm btn-outline-secondary w-100" style="height: 36px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                                <i class="ri-refresh-line me-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="card-body p-3">
                    <table class="table dataTable w-100" id="permissions-table" style="min-width: 700px;">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 50px;" class="text-center">SL</th>
                                <th scope="col">Display Name / Action Title</th>
                                <th scope="col" style="width: 200px;">Permission Key</th>
                                <th scope="col" style="width: 170px;">Module Group</th>
                                <th scope="col" style="width: 100px;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Create / Edit Permission Modal --}}
<div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="permissionModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 10px;">
            <div class="modal-header" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 14px 20px;">
                <h5 class="modal-title fw-bold text-dark" id="permissionModalTitle" style="font-size: 15px;">
                    <i class="ri-key-2-line text-primary me-1"></i> <span id="modal_mode_title">Create New Permission</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="permissionForm">
                @csrf
                <input type="hidden" id="permission_id" name="permission_id">
                <input type="hidden" id="form_method" name="_method" value="POST">

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark" style="font-size: 13px;">Module / Group <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" id="perm_module" name="module" list="modulesList" class="form-control custom-input" placeholder="e.g. project, service, blog, finance" required style="height: 38px; font-size: 13px;">
                            <datalist id="modulesList">
                                @foreach ($modules as $mod)
                                    <option value="{{ $mod }}">{{ ucwords(str_replace(['-', '_'], ' ', $mod)) }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="text-muted mt-1" style="font-size: 11.5px;">Choose an existing module or type a new module name.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark" style="font-size: 13px;">Display Name <span class="text-danger">*</span></label>
                        <input type="text" id="perm_display_name" name="display_name" class="form-control custom-input" placeholder="e.g. Export Projects, Approve Content" required style="height: 38px; font-size: 13px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark" style="font-size: 13px;">Permission Key / Code (Slug)</label>
                        <input type="text" id="perm_name" name="name" class="form-control custom-input" placeholder="Auto-generated if left empty (e.g. project-export)" style="height: 38px; font-size: 13px;">
                        <div class="text-muted mt-1" style="font-size: 11.5px;">Identifier used in middleware / permissions checking (e.g. project-create).</div>
                    </div>
                </div>

                <div class="modal-footer" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 12px 20px;">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3" data-bs-dismiss="modal" style="height: 36px; border-radius: 6px; font-size: 13px;">Cancel</button>
                    <button type="submit" id="btn_save_permission" class="btn btn-sm btn-primary px-4" style="height: 36px; border-radius: 6px; font-size: 13px; font-weight: 600; background-color: #f95716; border-color: #f95716;">
                        <i class="ri-save-line me-1"></i> <span id="modal_submit_text">Save Permission</span>
                        <span class="spinner-border spinner-border-sm d-none ms-1" role="status"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow" style="border-radius: 10px;">
            <div class="modal-body text-center p-4">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px; background-color: #fee2e2; color: #dc2626;">
                    <i class="ri-delete-bin-line" style="font-size: 24px;"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1" style="font-size: 15px;">Delete Permission?</h5>
                <p class="text-muted mb-3" style="font-size: 12.5px;">Are you sure you want to remove <strong id="delete_perm_label" class="text-dark"></strong>?</p>
                <input type="hidden" id="delete_perm_id">

                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3" data-bs-dismiss="modal" style="height: 34px; border-radius: 6px; font-size: 12.5px;">Cancel</button>
                    <button type="button" id="confirmDeletePermBtn" class="btn btn-sm btn-danger px-3" style="height: 34px; border-radius: 6px; font-size: 12.5px; font-weight: 600; background-color: #dc2626; border-color: #dc2626;">
                        <i class="ri-delete-bin-line me-1"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
    $(document).ready(function () {
        var listUrl = "{{ route('permissions.index') }}";
        var storeUrl = "{{ route('permissions.store') }}";

        var table = $('#permissions-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            lengthMenu: [10, 25, 50, 100],
            ajax: {
                url: listUrl,
                data: function (d) {
                    d.module = $('#filter_module').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center align-middle' },
                { data: 'display_name', name: 'display_name', orderable: true, searchable: true, className: 'align-middle fw-semibold text-dark' },
                { data: 'code_badge', name: 'name', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'module_badge', name: 'module', orderable: true, searchable: true, className: 'align-middle' },
                {
                    data: 'action-btn',
                    orderable: false,
                    searchable: false,
                    className: 'text-center align-middle',
                    render: function (data) {
                        var id = data.id;
                        var name = (data.name || '').replace(/"/g, '&quot;');
                        var display = (data.display_name || '').replace(/"/g, '&quot;');
                        var module = (data.module || '').replace(/"/g, '&quot;');

                        return '<div class="action-btn justify-content-center">' +
                            '<button type="button" class="btn btn-edit btn-edit-perm" data-id="' + id + '" data-name="' + name + '" data-display="' + display + '" data-module="' + module + '" title="Edit Permission"><i class="ri-edit-line"></i></button>' +
                            '<button type="button" class="btn btn-delete btn-delete-perm ms-1" data-id="' + id + '" data-name="' + display + '" title="Delete Permission"><i class="ri-delete-bin-2-line"></i></button>' +
                            '</div>';
                    }
                }
            ],
            order: [[3, 'asc']]
        });

        // Filter handlers
        $('#filter_module').on('change', function () {
            table.draw();
        });

        $('#btn_reset_filters').on('click', function () {
            $('#filter_module').val('');
            table.draw();
        });

        // Open Create Modal
        $('#btn_open_create_modal').on('click', function () {
            $('#permissionForm')[0].reset();
            $('#permission_id').val('');
            $('#form_method').val('POST');
            $('#modal_mode_title').text('Create New Permission');
            $('#modal_submit_text').text('Save Permission');
            $('#permissionModal').modal('show');
        });

        // Open Edit Modal
        $(document).on('click', '.btn-edit-perm', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var display = $(this).data('display');
            var module = $(this).data('module');

            $('#permission_id').val(id);
            $('#form_method').val('PUT');
            $('#perm_module').val(module);
            $('#perm_display_name').val(display);
            $('#perm_name').val(name);

            $('#modal_mode_title').text('Edit Permission: ' + display);
            $('#modal_submit_text').text('Update Permission');
            $('#permissionModal').modal('show');
        });

        // Auto-slugify code on typing display name if creating
        $('#perm_display_name, #perm_module').on('input', function () {
            if (!$('#permission_id').val()) {
                var mod = $('#perm_module').val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
                var disp = $('#perm_display_name').val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
                if (mod && disp) {
                    $('#perm_name').val(mod + '-' + disp);
                } else if (disp) {
                    $('#perm_name').val(disp);
                }
            }
        });

        // Submit Form via AJAX
        $('#permissionForm').on('submit', function (e) {
            e.preventDefault();
            var id = $('#permission_id').val();
            var method = $('#form_method').val();
            var url = id ? ("{{ url('/dashboard/permissions') }}/" + id) : storeUrl;

            var $btn = $('#btn_save_permission');
            $btn.prop('disabled', true);
            $btn.find('.spinner-border').removeClass('d-none');

            $.ajax({
                url: url,
                type: 'POST',
                data: $(this).serialize(),
                success: function (res) {
                    $('#permissionModal').modal('hide');
                    toastr.success(res.message || 'Permission saved successfully');
                    table.draw();
                },
                error: function (xhr) {
                    var errorMsg = 'Failed to save permission.';
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

        // Delete Modal Handler
        $(document).on('click', '.btn-delete-perm', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            $('#delete_perm_id').val(id);
            $('#delete_perm_label').text(name);
            $('#deletePermissionModal').modal('show');
        });

        $('#confirmDeletePermBtn').on('click', function () {
            var id = $('#delete_perm_id').val();
            var $btn = $(this);
            $btn.prop('disabled', true);

            $.ajax({
                url: "{{ url('/dashboard/permissions') }}/" + id,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    $('#deletePermissionModal').modal('hide');
                    toastr.success(res.message || 'Permission deleted successfully');
                    table.draw();
                },
                error: function () {
                    toastr.error('Failed to delete permission.');
                },
                complete: function () {
                    $btn.prop('disabled', false);
                }
            });
        });
    });
</script>
@endpush

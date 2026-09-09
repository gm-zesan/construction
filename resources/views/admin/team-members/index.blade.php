@extends('admin.app')
@section('title', 'Team Members & Leadership')

@push('custom-style')
    <style>
        .stat-badge-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .stat-badge-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-12">
                {{-- Quick Metrics Row --}}
                <div class="row g-3 mb-3">
                    <div class="col-xl-3 col-sm-6">
                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background-color: #eff6ff; color: #2563eb;">
                                <i class="ri-team-line"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Total Members</div>
                                <div class="fw-bold text-dark" style="font-size: 18px;">{{ $stats['total'] }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6">
                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background-color: #ecfdf5; color: #059669;">
                                <i class="ri-checkbox-circle-line"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Active Live</div>
                                <div class="fw-bold text-dark" style="font-size: 18px;">{{ $stats['active'] }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6">
                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background-color: #fff7ed; color: #ea580c;">
                                <i class="ri-star-line"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Featured Leadership</div>
                                <div class="fw-bold text-dark" style="font-size: 18px;">{{ $stats['featured'] }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6">
                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background-color: #f5f3ff; color: #7c3aed;">
                                <i class="ri-building-line"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Departments</div>
                                <div class="fw-bold text-dark" style="font-size: 18px;">{{ $stats['departments_count'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Main Team Members Table Card --}}
                <div class="card table-card">
                    {{-- Card Header --}}
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Leadership &amp; Team Members</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Team Members</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            @canany(['team-member-create'])
                                <a href="{{ route('team-members.create') }}" class="add-new">
                                    Add Member <i class="ms-1 ri-add-line"></i>
                                </a>
                            @endcanany
                        </div>
                    </div>

                    {{-- Dynamic Filter Bar --}}
                    <div class="card-body border-bottom" style="background-color: #f8fafc; padding: 14px 20px;">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Department</label>
                                <select id="filter_department" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Departments</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept }}">{{ $dept }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Publish Status</label>
                                <select id="filter_status" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Statuses</option>
                                    <option value="1">Active Only</option>
                                    <option value="0">Inactive Only</option>
                                </select>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Featured</label>
                                <select id="filter_featured" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Members</option>
                                    <option value="1">Featured Only</option>
                                    <option value="0">Standard Only</option>
                                </select>
                            </div>

                            <div class="col-md-3 col-sm-6 d-flex align-items-end">
                                <button type="button" id="btn_reset_filters" class="btn btn-sm btn-outline-secondary w-100"
                                    style="height: 36px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                                    <i class="ri-refresh-line me-1"></i> Reset Filters
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Data Table Body --}}
                    <div class="card-body" style="padding: 20px;">
                        <table class="table dataTable w-100" id="team-members-table" style="min-width: 850px;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 45px;">SL</th>
                                    <th scope="col" style="width: 60px;" class="text-center">Photo</th>
                                    <th scope="col">Member &amp; Role</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Social Links</th>
                                    <th scope="col" style="width: 85px;" class="text-center">Featured</th>
                                    <th scope="col" style="width: 85px;" class="text-center">Status</th>
                                    <th scope="col" style="width: 100px;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    @canany(['team-member-delete'])
        <div class="modal fade" id="deleteMemberModal" tabindex="-1" aria-labelledby="deleteMemberModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-0 shadow" style="border-radius: 10px; overflow: hidden;">
                    <div class="modal-body text-center p-4">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 56px; height: 56px; background-color: #fee2e2; color: #dc2626;">
                            <i class="ri-delete-bin-line" style="font-size: 28px;"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1" style="font-size: 16px;">Delete Team Member?</h5>
                        <p class="text-muted mb-2" style="font-size: 13px;">
                            Are you sure you want to delete profile of <strong id="delete_member_name" class="text-dark"></strong>?
                        </p>
                        <p class="text-muted mb-0" style="font-size: 12px;">
                            This action cannot be undone. Portrait photo will be permanently removed.
                        </p>
                        <input type="hidden" id="delete_member_id">
                    </div>
                    <div class="modal-footer" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 12px 20px;">
                        <button type="button" class="btn btn-sm btn-outline-secondary px-3" data-bs-dismiss="modal"
                            style="font-size: 13px; height: 36px; border-radius: 6px;">Cancel</button>
                        <button type="button" id="confirmDeleteMemberBtn" class="btn btn-sm btn-danger px-4"
                            style="font-size: 13px; height: 36px; border-radius: 6px; font-weight: 600; background-color: #dc2626; border-color: #dc2626;">
                            <i class="ri-delete-bin-line me-1"></i> Delete Permanently
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endcanany
@endsection

@push('custom-script')
    <script type="text/javascript">
        $(document).ready(function() {
            var listUrl = "{{ route('team-members.index') }}";

            var table = $('#team-members-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 20,
                lengthMenu: [10, 20, 50, 100],
                order: [[2, 'asc']],
                ajax: {
                    url: listUrl,
                    data: function(d) {
                        d.status = $('#filter_status').val();
                        d.featured = $('#filter_featured').val();
                        d.department = $('#filter_department').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'avatar', name: 'avatar', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'member_details', name: 'name', orderable: true, searchable: true },
                    { data: 'department_badge', name: 'department', orderable: true, searchable: true },
                    { data: 'social_links', name: 'linkedin_url', orderable: false, searchable: false },
                    { data: 'featured_toggle', name: 'is_featured', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'status_toggle', name: 'is_active', orderable: false, searchable: false, className: 'text-center' },
                    {
                        data: 'action-btn',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            var id = data.id;
                            var name = (data.name || '').replace(/"/g, '&quot;');
                            var showUrl = data.show_url;
                            var editUrl = data.edit_url;
                            var canEdit = data.can_edit;
                            var canDelete = data.can_delete;

                            var html = '<div class="action-btn justify-content-center gap-1">';
                            html += '<a href="' + showUrl + '" class="btn btn-edit" title="View Profile" style="background-color: #f1f5f9; color: #334155;"><i class="ri-eye-line"></i></a>';
                            if (canEdit) {
                                html += '<a href="' + editUrl + '" class="btn btn-edit" title="Edit Profile"><i class="ri-edit-line"></i></a>';
                            }
                            if (canDelete) {
                                html += '<button type="button" class="btn btn-delete btn-delete-member" data-id="' + id + '" data-name="' + name + '" title="Delete Member"><i class="ri-delete-bin-2-line"></i></button>';
                            }
                            html += '</div>';

                            return html;
                        }
                    }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search members by name, role, department...",
                    processing: '<div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading members...'
                }
            });

            // Trigger filters
            $('#filter_status, #filter_featured, #filter_department').on('change', function() {
                table.draw();
            });

            $('#btn_reset_filters').on('click', function() {
                $('#filter_status').val('');
                $('#filter_featured').val('');
                $('#filter_department').val('');
                table.draw();
            });

            // Toggle Featured Switch
            $(document).on('change', '.toggle-member-featured', function() {
                var memberId = $(this).data('id');
                var isChecked = $(this).is(':checked') ? 1 : 0;
                var $switch = $(this);

                $.ajax({
                    url: "{{ url('/dashboard/team-members') }}/" + memberId + "/toggle-status",
                    type: 'POST',
                    data: {
                        field: 'featured',
                        value: isChecked,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.success) {
                            toastr.success(res.message || 'Featured status updated');
                        } else {
                            toastr.error('Failed to update featured status');
                            $switch.prop('checked', !isChecked);
                        }
                    },
                    error: function() {
                        toastr.error('Network error updating featured status');
                        $switch.prop('checked', !isChecked);
                    }
                });
            });

            // Toggle Status Switch
            $(document).on('change', '.toggle-member-status', function() {
                var memberId = $(this).data('id');
                var isChecked = $(this).is(':checked') ? 1 : 0;
                var $switch = $(this);

                $.ajax({
                    url: "{{ url('/dashboard/team-members') }}/" + memberId + "/toggle-status",
                    type: 'POST',
                    data: {
                        field: 'is_active',
                        value: isChecked,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.success) {
                            toastr.success(res.message || 'Publish status updated');
                        } else {
                            toastr.error('Failed to update publish status');
                            $switch.prop('checked', !isChecked);
                        }
                    },
                    error: function() {
                        toastr.error('Network error updating publish status');
                        $switch.prop('checked', !isChecked);
                    }
                });
            });

            // Delete Member Modal Handler
            $(document).on('click', '.btn-delete-member', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                $('#delete_member_id').val(id);
                $('#delete_member_name').text(name);
                $('#deleteMemberModal').modal('show');
            });

            $('#confirmDeleteMemberBtn').on('click', function() {
                var id = $('#delete_member_id').val();
                var $btn = $(this);
                $btn.prop('disabled', true);

                $.ajax({
                    url: "{{ url('/dashboard/team-members') }}/" + id,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        $('#deleteMemberModal').modal('hide');
                        toastr.success(res.message || 'Team member deleted successfully');
                        table.draw(false);
                    },
                    error: function(xhr) {
                        var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Failed to delete member';
                        toastr.error(msg);
                    },
                    complete: function() {
                        $btn.prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endpush

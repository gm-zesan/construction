@extends('admin.app')
@section('title')
    Project Milestones
@endsection

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
                                <i class="ri-flag-2-line"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Total Milestones</div>
                                <div class="fw-bold text-dark" style="font-size: 18px;">{{ $totalCount }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background-color: #ecfdf5; color: #059669;">
                                <i class="ri-checkbox-circle-line"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Completed</div>
                                <div class="fw-bold text-dark" style="font-size: 18px;">{{ $completedCount }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background-color: #eff6ff; color: #1d4ed8;">
                                <i class="ri-loader-4-line"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">In Progress</div>
                                <div class="fw-bold text-dark" style="font-size: 18px;">{{ $inProgressCount }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background-color: #fef2f2; color: #dc2626;">
                                <i class="ri-alarm-warning-line"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Delayed / Critical</div>
                                <div class="fw-bold text-dark" style="font-size: 18px;">{{ $delayedCount }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Main Table Card --}}
                <div class="card table-card">
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Project Milestones</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Project Milestones</li>
                                </ol>
                            </nav>
                        </div>
                        @can('milestone-create')
                            <a href="{{ route('milestones.create') }}" class="add-new">
                                <i class="ri-add-line me-1"></i> Add Milestone
                            </a>
                        @endcan
                    </div>

                    {{-- Dynamic Filters Bar --}}
                    <div class="card-body border-bottom" style="background-color: #f8fafc; padding: 14px 20px;">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-4 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Project</label>
                                <select id="filter_project" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Projects</option>
                                    @foreach($projects as $proj)
                                        <option value="{{ $proj->id }}">{{ $proj->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Status</label>
                                <select id="filter_status" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Statuses</option>
                                    @foreach($statuses as $st)
                                        <option value="{{ $st->value }}">{{ $st->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Visibility</label>
                                <select id="filter_published" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All</option>
                                    <option value="1">Published / Visible</option>
                                    <option value="0">Draft / Hidden</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-6 d-flex align-items-end">
                                <button type="button" id="reset_filters" class="btn btn-sm btn-outline-secondary w-100"
                                    style="height: 36px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                                    <i class="ri-refresh-line me-1"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Data Table --}}
                    <div class="card-body" style="padding: 20px;">
                        <table class="table dataTable w-100" id="milestones-table" style="min-width: 950px;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 45px;">SL</th>
                                    <th scope="col" style="width: 65px;" class="text-center">Photo</th>
                                    <!-- <th scope="col">Milestone Title</th> -->
                                    <th scope="col" style="width: 170px;">Project</th>
                                    <th scope="col" style="width: 140px;">Progress</th>
                                    <th scope="col" style="width: 130px;">Target Date</th>
                                    <th scope="col" style="width: 110px;">Status</th>
                                    <th scope="col" style="width: 70px;" class="text-center">Visible</th>
                                    <th scope="col" style="width: 110px;" class="text-center">Action</th>
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
    @can('milestone-delete')
        <div class="modal fade" id="deleteMilestoneModal" tabindex="-1" aria-labelledby="deleteMilestoneModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-0 shadow">
                    <div class="modal-body text-center p-4">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 56px; height: 56px; background-color: #fee2e2; color: #dc2626;">
                            <i class="ri-delete-bin-line" style="font-size: 28px;"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1" style="font-size: 16px;">Delete Milestone?</h5>
                        <p class="text-muted mb-3" style="font-size: 12.5px;">Are you sure you want to remove <strong
                                id="delete_item_title" class="text-dark"></strong>? This action cannot be undone.</p>
                        <input type="hidden" id="delete_item_id">
                        <div class="d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-light btn-sm px-3" data-bs-dismiss="modal"
                                style="height: 36px; font-weight: 600;">Cancel</button>
                            <button type="button" id="confirmDeleteBtn" class="btn btn-danger btn-sm px-3"
                                style="height: 36px; font-weight: 600; background-color: #dc2626; border-color: #dc2626;">
                                <i class="ri-delete-bin-line me-1"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection

@push('custom-script')
    <script type="text/javascript">
        $(document).ready(function () {
            var listUrl = "{{ route('milestones.index') }}";

            // Initialize DataTable
            var table = $('#milestones-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                lengthMenu: [10, 25, 50, 100],
                ajax: {
                    url: listUrl,
                    data: function (d) {
                        d.project_id = $('#filter_project').val();
                        d.status = $('#filter_status').val();
                        d.is_published = $('#filter_published').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'thumbnail', name: 'thumbnail', orderable: false, searchable: false, className: 'text-center' },
                    // { data: 'milestone_title', name: 'title', orderable: true, searchable: true },
                    { data: 'project_badge', name: 'project.title', orderable: true, searchable: true },
                    { data: 'progress_bar', name: 'progress_percentage', orderable: true, searchable: false },
                    { data: 'target_date_formatted', name: 'target_date', orderable: true, searchable: false },
                    { data: 'status_badge', name: 'status', orderable: true, searchable: true },
                    { data: 'published_toggle', name: 'is_published', orderable: false, searchable: false, className: 'text-center' },
                    {
                        data: 'action-btn',
                        orderable: false,
                        searchable: false,
                        render: function (data) {
                            var id = data.id;
                            var title = data.title;
                            var showUrl = data.show_url;
                            var editUrl = data.edit_url;
                            var canEdit = data.can_edit;
                            var canDelete = data.can_delete;

                            var html = '<div class="action-btn justify-content-center gap-1">';
                            // View details
                            html += '<a href="' + showUrl + '" class="btn btn-edit" title="View Milestone Details" style="background-color: #f1f5f9; color: #334155;"><i class="ri-eye-line"></i></a>';
                            // Edit
                            if (canEdit) {
                                html += '<a href="' + editUrl + '" class="btn btn-edit" title="Edit Milestone"><i class="ri-edit-line"></i></a>';
                            }
                            // Delete
                            if (canDelete) {
                                html += '<button type="button" class="btn btn-delete" title="Delete Milestone" onclick="openDeleteModal(' + id + ', \'' + addslashes(title) + '\')"><i class="ri-delete-bin-line"></i></button>';
                            }
                            html += '</div>';

                            return html;
                        }
                    }
                ],
                order: [[5, 'asc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search milestones by title, project, or status...",
                    processing: '<div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading milestones...'
                }
            });

            function addslashes(string) {
                return (string + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
            }

            // Filter triggers
            $('#filter_project, #filter_status, #filter_published').on('change', function () {
                table.draw();
            });

            $('#reset_filters').on('click', function () {
                $('#filter_project').val('');
                $('#filter_status').val('');
                $('#filter_published').val('');
                table.draw();
            });

            // Fast Toggle Publication / Visibility
            $(document).on('change', '.status-toggle', function () {
                var milestoneId = $(this).data('id');
                var toggleUrl = "{{ url('/dashboard/milestones') }}/" + milestoneId + "/toggle-status";

                $.ajax({
                    url: toggleUrl,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function (res) {
                        toastr.success(res.message || 'Milestone visibility updated', 'Success');
                    },
                    error: function (xhr) {
                        toastr.error('Failed to update visibility', 'Error');
                        table.draw(false);
                    }
                });
            });

            // Delete Modal
            window.openDeleteModal = function (id, title) {
                $('#delete_item_id').val(id);
                $('#delete_item_title').text('"' + title + '"');
                $('#deleteMilestoneModal').modal('show');
            };

            $('#confirmDeleteBtn').on('click', function () {
                var id = $('#delete_item_id').val();
                var deleteUrl = "{{ url('/dashboard/milestones') }}/" + id;

                $('#confirmDeleteBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status"></span> Deleting...');

                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        toastr.success(res.message || 'Milestone deleted successfully', 'Success');
                        $('#deleteMilestoneModal').modal('hide');
                        $('#confirmDeleteBtn').prop('disabled', false).html('<i class="ri-delete-bin-line me-1"></i> Delete');
                        table.draw(false);
                    },
                    error: function () {
                        toastr.error('Failed to delete milestone', 'Error');
                        $('#confirmDeleteBtn').prop('disabled', false).html('<i class="ri-delete-bin-line me-1"></i> Delete');
                    }
                });
            });
        });
    </script>
@endpush
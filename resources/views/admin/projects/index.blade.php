@extends('admin.app')
@section('title')
    Projects
@endsection

@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-12">
                <div class="card table-card">
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Project Portfolio</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Projects</li>
                                </ol>
                            </nav>
                        </div>
                        <a href="{{ route('projects.create') }}" class="add-new">
                            Create Project <i class="ms-1 ri-add-line"></i>
                        </a>
                    </div>

                    {{-- Filter Bar --}}
                    <div class="card-body border-bottom" style="background-color: #f8fafc; padding: 14px 20px;">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Status</label>
                                <select id="filter_status" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Statuses</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->value }}">{{ $status->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Category</label>
                                <select id="filter_category" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Featured</label>
                                <select id="filter_featured" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Projects</option>
                                    <option value="1">Featured Only</option>
                                    <option value="0">Standard Only</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex align-items-end">
                                <button type="button" id="reset_filters" class="btn btn-sm btn-outline-secondary w-100"
                                    style="height: 36px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                                    <i class="ri-refresh-line me-1"></i> Reset Filters
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Simplified Table Area --}}
                    <div class="card-body" style="overflow-x: auto; padding: 20px;">
                        <table class="table dataTable w-100" id="projects-table" style="min-width: 800px;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 45px;">SL</th>
                                    <th scope="col" style="width: 70px;">Media</th>
                                    <th scope="col">Project Title</th>
                                    <th scope="col" style="width: 110px;">Status</th>
                                    <th scope="col" style="width: 90px;" class="text-center">Featured</th>
                                    <th scope="col" style="width: 90px;" class="text-center">Published</th>
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
    <div class="modal fade" id="deleteProjectModal" tabindex="-1" aria-labelledby="deleteModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"
                style="border-radius: 10px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(11, 15, 23, 0.1);">
                <div class="modal-header"
                    style="background-color: #fee2e2; border-bottom: 1px solid #fca5a5; padding: 16px 20px;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ri-error-warning-line text-danger" style="font-size: 22px;"></i>
                        <h5 class="modal-title fw-bold text-danger mb-0" id="deleteModalTitle" style="font-size: 16px;">
                            Confirm Project Deletion</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <p class="mb-2" style="font-size: 14px; color: #334155;">
                        Are you sure you want to permanently delete project <strong id="deleteProjectTitle"
                            class="text-dark"></strong>?
                    </p>
                    <p class="text-muted mb-0" style="font-size: 12.5px;">
                        This action will remove all gallery media, specs, and documents associated with this project.
                        Historical client inquiries and activity logs will remain preserved.
                    </p>
                </div>
                <div class="modal-footer"
                    style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 12px 20px;">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3" data-bs-dismiss="modal"
                        style="font-size: 13px; height: 36px; border-radius: 6px;">Cancel</button>
                    <form id="deleteProjectForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger px-4"
                            style="font-size: 13px; height: 36px; border-radius: 6px; font-weight: 600;">
                            Delete Permanently
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var listUrl = "{{ route('projects.index') }}";

            var table = $('#projects-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 20,
                lengthMenu: [10, 20, 50, 100],
                ajax: {
                    url: listUrl,
                    data: function (d) {
                        d.status = $('#filter_status').val();
                        d.category = $('#filter_category').val();
                        d.featured = $('#filter_featured').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'thumbnail', name: 'thumbnail', orderable: false, searchable: false },
                    { data: 'title_details', name: 'title', orderable: true },
                    { data: 'status_badge', name: 'status', orderable: true },
                    { data: 'featured_toggle', name: 'featured', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'published_toggle', name: 'is_published', orderable: false, searchable: false, className: 'text-center' },
                    {
                        data: 'action-btn',
                        orderable: false,
                        searchable: false,
                        render: function (data) {
                            var id = data.id;
                            var title = (data.title || '').replace(/"/g, '&quot;');
                            var showUrl = "{{ url('/dashboard/projects') }}/" + id;
                            var editUrl = "{{ url('/dashboard/projects') }}/" + id + "/edit";
                            var deleteUrl = "{{ url('/dashboard/projects') }}/" + id;

                            var html = '<div class="action-btn justify-content-center">';
                            if (data.can_view !== false) {
                                html += '<a href="' + showUrl + '" class="btn btn-edit" title="View Project Details" style="background-color: #f1f5f9; color: #334155;"><i class="ri-eye-line"></i></a>';
                            }
                            if (data.can_edit) {
                                html += '<a href="' + editUrl + '" class="btn btn-edit" title="Edit Project"><i class="ri-edit-line"></i></a>';
                            }
                            if (data.can_delete) {
                                html += '<button type="button" class="btn btn-delete btn-delete-modal" data-id="' + id + '" data-title="' + title + '" data-url="' + deleteUrl + '" title="Delete Project"><i class="ri-delete-bin-2-line"></i></button>';
                            }
                            html += '</div>';
                            return html;
                        }
                    }
                ],
                order: [[2, 'asc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search projects by title, client, or location...",
                    processing: '<div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading projects...'
                }
            });

            // Filter trigger handlers
            $('#filter_status, #filter_category, #filter_featured').on('change', function () {
                table.draw();
            });

            $('#reset_filters').on('click', function () {
                $('#filter_status').val('');
                $('#filter_category').val('');
                $('#filter_featured').val('');
                table.draw();
            });

            // AJAX Toggle Switch for Featured
            $(document).on('change', '.toggle-project-feature', function () {
                var projectId = $(this).data('id');
                var isChecked = $(this).is(':checked') ? 1 : 0;
                var $switch = $(this);

                $.ajax({
                    url: "{{ url('/dashboard/projects') }}/" + projectId + "/toggle-status",
                    type: 'POST',
                    data: {
                        field: 'featured',
                        value: isChecked,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        if (res.success) {
                            toastr.success(res.message || 'Featured status updated');
                        } else {
                            toastr.error('Failed to update featured status');
                            $switch.prop('checked', !isChecked);
                        }
                    },
                    error: function () {
                        toastr.error('Network error updating featured status');
                        $switch.prop('checked', !isChecked);
                    }
                });
            });

            // AJAX Toggle Switch for Published
            $(document).on('change', '.toggle-project-publish', function () {
                var projectId = $(this).data('id');
                var isChecked = $(this).is(':checked') ? 1 : 0;
                var $switch = $(this);

                $.ajax({
                    url: "{{ url('/dashboard/projects') }}/" + projectId + "/toggle-status",
                    type: 'POST',
                    data: {
                        field: 'is_published',
                        value: isChecked,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        if (res.success) {
                            toastr.success(res.message || 'Published status updated');
                        } else {
                            toastr.error('Failed to update published status');
                            $switch.prop('checked', !isChecked);
                        }
                    },
                    error: function () {
                        toastr.error('Network error updating published status');
                        $switch.prop('checked', !isChecked);
                    }
                });
            });

            // Delete Modal setup
            $(document).on('click', '.btn-delete-modal', function () {
                var title = $(this).data('title');
                var url = $(this).data('url');

                $('#deleteProjectTitle').text(title);
                $('#deleteProjectForm').attr('action', url);
                $('#deleteProjectModal').modal('show');
            });
        });
    </script>
@endpush
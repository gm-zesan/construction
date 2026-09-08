@extends('admin.app')
@section('title', 'Client Reviews & Testimonials')

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
                                <i class="ri-feedback-line"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Total Reviews</div>
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
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Published Live</div>
                                <div class="fw-bold text-dark" style="font-size: 18px;">{{ $stats['published'] }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6">
                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background-color: #fff7ed; color: #ea580c;">
                                <i class="ri-star-line"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Featured on Home</div>
                                <div class="fw-bold text-dark" style="font-size: 18px;">{{ $stats['featured'] }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6">
                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background-color: #fef9c3; color: #ca8a04;">
                                <i class="ri-star-fill"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Average Rating</div>
                                <div class="fw-bold text-dark" style="font-size: 18px;">{{ $stats['avg_rating'] }} / 5.0
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Main Reviews Table Card --}}
                <div class="card table-card">
                    {{-- Card Header --}}
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Client Reviews &amp; Testimonials</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Client Reviews</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            @canany(['client-review-create'])
                                <a href="{{ route('client-reviews.create') }}" class="add-new">
                                    Add Review <i class="ms-1 ri-add-line"></i>
                                </a>
                            @endcanany
                        </div>
                    </div>

                    {{-- Dynamic Filter Bar --}}
                    <div class="card-body border-bottom" style="background-color: #f8fafc; padding: 14px 20px;">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Related
                                    Project</label>
                                <select id="filter_project_id" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Projects</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">
                                            {{ $project->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Star
                                    Rating</label>
                                <select id="filter_rating" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Ratings</option>
                                    <option value="5">★★★★★ (5 Stars)</option>
                                    <option value="4">★★★★☆ (4 Stars)</option>
                                    <option value="3">★★★☆☆ (3 Stars)</option>
                                    <option value="2">★★☆☆☆ (2 Stars)</option>
                                    <option value="1">★☆☆☆☆ (1 Star)</option>
                                </select>
                            </div>

                            <div class="col-md-2 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Visibility</label>
                                <select id="filter_status" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Visibility</option>
                                    <option value="1">Published / Live</option>
                                    <option value="0">Draft / Hidden</option>
                                </select>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Featured</label>
                                <select id="filter_featured" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Testimonials</option>
                                    <option value="1">Featured on Home</option>
                                    <option value="0">Standard Only</option>
                                </select>
                            </div>

                            <div class="col-md-2 col-sm-6 d-flex align-items-end">
                                <button type="button" id="btn_reset_filters" class="btn btn-sm btn-outline-secondary w-100"
                                    style="height: 36px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                                    <i class="ri-refresh-line me-1"></i> Reset Filters
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Data Table --}}
                    <div class="card-body" style="padding: 20px;">
                        <table class="table dataTable w-100" id="reviews-table" style="min-width: 950px;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 45px;">SL</th>
                                    <th scope="col" style="width: 55px;" class="text-center">Photo</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">Review</th>
                                    <th scope="col" style="width: 110px;">Rating</th>
                                    <th scope="col" style="width: 75px;" class="text-center">Featured</th>
                                    <th scope="col" style="width: 75px;" class="text-center">Visible</th>
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
    @canany(['client-review-delete'])
        <div class="modal fade" id="deleteReviewModal" tabindex="-1" aria-labelledby="deleteReviewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-0 shadow">
                    <div class="modal-body text-center p-4">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 56px; height: 56px; background-color: #fee2e2; color: #dc2626;">
                            <i class="ri-delete-bin-line" style="font-size: 28px;"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1" style="font-size: 16px;">Delete Client Review?</h5>
                        <p class="text-muted mb-2" style="font-size: 13px;">
                            Are you sure you want to delete testimonial from <strong id="delete_item_title"
                                class="text-dark"></strong>?
                        </p>
                        <p class="text-muted mb-0" style="font-size: 12.5px;">
                            This action cannot be undone. Associated client photo will be removed.
                        </p>
                        <input type="hidden" id="delete_item_id">
                    </div>
                    <div class="modal-footer"
                        style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 12px 20px;">
                        <button type="button" class="btn btn-sm btn-outline-secondary px-3" data-bs-dismiss="modal"
                            style="font-size: 13px; height: 36px; border-radius: 6px;">Cancel</button>
                        <button type="button" id="confirmDeleteBtn" class="btn btn-sm btn-danger px-4"
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
        $(document).ready(function () {
            var listUrl = "{{ route('client-reviews.index') }}";

            var table = $('#reviews-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 20,
                lengthMenu: [10, 20, 50, 100],
                order: [[0, 'asc']],
                ajax: {
                    url: listUrl,
                    data: function (d) {
                        d.status = $('#filter_status').val();
                        d.featured = $('#filter_featured').val();
                        d.rating = $('#filter_rating').val();
                        d.project_id = $('#filter_project_id').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'avatar', name: 'avatar', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'client_details', name: 'client_name', orderable: true, searchable: true },
                    { data: 'review_snippet', name: 'review', orderable: false, searchable: true },
                    { data: 'rating_badge', name: 'rating', orderable: true, searchable: false },
                    { data: 'featured_toggle', name: 'featured', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'published_toggle', name: 'is_published', orderable: false, searchable: false, className: 'text-center' },
                    {
                        data: 'action-btn',
                        orderable: false,
                        searchable: false,
                        render: function (data) {
                            var id = data.id;
                            var title = (data.client_name || '').replace(/"/g, '&quot;');
                            var showUrl = data.show_url;
                            var editUrl = data.edit_url;
                            var canEdit = data.can_edit;
                            var canDelete = data.can_delete;

                            var html = '<div class="action-btn justify-content-center gap-1">';
                            // View
                            html += '<a href="' + showUrl + '" class="btn btn-edit" title="View Review Details" style="background-color: #f1f5f9; color: #334155;"><i class="ri-eye-line"></i></a>';
                            // Edit
                            if (canEdit) {
                                html += '<a href="' + editUrl + '" class="btn btn-edit" title="Edit Review"><i class="ri-edit-line"></i></a>';
                            }
                            // Delete
                            if (canDelete) {
                                html += '<button type="button" class="btn btn-delete btn-delete-review" data-id="' + id + '" data-title="' + title + '" title="Delete Review"><i class="ri-delete-bin-2-line"></i></button>';
                            }
                            html += '</div>';

                            return html;
                        }
                    }
                ]
            });

            // Trigger filters
            $('#filter_status, #filter_featured, #filter_rating, #filter_project_id').on('change', function () {
                table.draw();
            });

            $('#btn_reset_filters').on('click', function () {
                $('#filter_status').val('');
                $('#filter_featured').val('');
                $('#filter_rating').val('');
                $('#filter_project_id').val('');
                table.draw();
            });

            // Toggle Featured Switch
            $(document).on('change', '.toggle-review-feature', function () {
                var reviewId = $(this).data('id');
                var isChecked = $(this).is(':checked') ? 1 : 0;
                var $switch = $(this);

                $.ajax({
                    url: "{{ url('/dashboard/client-reviews') }}/" + reviewId + "/toggle-status",
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

            // Toggle Published Switch
            $(document).on('change', '.toggle-review-publish', function () {
                var reviewId = $(this).data('id');
                var isChecked = $(this).is(':checked') ? 1 : 0;
                var $switch = $(this);

                $.ajax({
                    url: "{{ url('/dashboard/client-reviews') }}/" + reviewId + "/toggle-status",
                    type: 'POST',
                    data: {
                        field: 'is_published',
                        value: isChecked,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        if (res.success) {
                            toastr.success(res.message || 'Visibility status updated');
                        } else {
                            toastr.error('Failed to update visibility status');
                            $switch.prop('checked', !isChecked);
                        }
                    },
                    error: function () {
                        toastr.error('Network error updating visibility status');
                        $switch.prop('checked', !isChecked);
                    }
                });
            });

            // Delete Review Modal Handler
            $(document).on('click', '.btn-delete-review', function () {
                var id = $(this).data('id');
                var title = $(this).data('title');
                $('#delete_item_id').val(id);
                $('#delete_item_title').text(title);
                $('#deleteReviewModal').modal('show');
            });

            $('#confirmDeleteBtn').on('click', function () {
                var id = $('#delete_item_id').val();
                var $btn = $(this);
                $btn.prop('disabled', true);

                $.ajax({
                    url: "{{ url('/dashboard/client-reviews') }}/" + id,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        $('#deleteReviewModal').modal('hide');
                        toastr.success(res.message || 'Review deleted successfully');
                        table.draw(false);
                    },
                    error: function (xhr) {
                        var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Failed to delete review';
                        toastr.error(msg);
                    },
                    complete: function () {
                        $btn.prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endpush
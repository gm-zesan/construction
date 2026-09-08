@extends('admin.app')
@section('title')
    News & Articles
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

        .form-check-input:checked {
            background-color: #10b981;
            border-color: #10b981;
        }

        .form-check-input.featured-toggle:checked {
            background-color: #f59e0b;
            border-color: #f59e0b;
        }

        .form-check-input {
            width: 38px;
            height: 20px;
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-12">
                {{-- Quick Metrics Row (Media Index Style) --}}
                <div class="row g-3 mb-3">
                    <div class="col-xl-3 col-sm-6">
                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background-color: #eff6ff; color: #2563eb;">
                                <i class="ri-article-line"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Total Articles</div>
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
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Published Live</div>
                                <div class="fw-bold text-dark" style="font-size: 18px;">{{ $publishedCount }}</div>
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
                                <div class="fw-bold text-dark" style="font-size: 18px;">{{ $featuredCount }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6">
                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background-color: #fdf4ff; color: #a855f7;">
                                <i class="ri-eye-line"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Total Views</div>
                                <div class="fw-bold text-dark" style="font-size: 18px;">{{ number_format($totalViews) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Main Articles Table Card --}}
                <div class="card table-card">
                    {{-- Card Header --}}
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">News &amp; Field Updates</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">News & Articles</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('article-categories.index') }}" class="add-new" style="background-color: #f1f5f9; color: #334155; border: 1px solid #e2e8f0;">
                                <i class="ri-price-tag-3-line me-1"></i> Manage Categories
                            </a>
                            @canany(['article-create', 'blog-create'])
                                <a href="{{ route('articles.create') }}" class="add-new">
                                    Add Article <i class="ms-1 ri-add-line"></i>
                                </a>
                            @endcanany
                        </div>
                    </div>

                    {{-- Dynamic Filter Bar --}}
                    <div class="card-body border-bottom" style="background-color: #f8fafc; padding: 14px 20px;">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-4 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Category</label>
                                <select id="filter_category" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Visibility</label>
                                <select id="filter_status" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Visibility</option>
                                    <option value="1">Published Only</option>
                                    <option value="0">Draft Only</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Featured</label>
                                <select id="filter_featured" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Articles</option>
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
                        <table class="table dataTable w-100" id="articles-table" style="min-width: 950px;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 45px;">SL</th>
                                    <th scope="col" style="width: 65px;" class="text-center">Cover</th>
                                    <th scope="col">Article Title</th>
                                    <th scope="col" style="width: 150px;">Category</th>
                                    <th scope="col" style="width: 150px;">Author &amp; Date</th>
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
    @canany(['article-delete', 'blog-delete'])
        <div class="modal fade" id="deleteArticleModal" tabindex="-1" aria-labelledby="deleteModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content"
                    style="border-radius: 10px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(11, 15, 23, 0.1);">
                    <div class="modal-header"
                        style="background-color: #fee2e2; border-bottom: 1px solid #fca5a5; padding: 16px 20px;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ri-error-warning-line text-danger" style="font-size: 22px;"></i>
                            <h5 class="modal-title fw-bold text-danger mb-0" id="deleteModalTitle" style="font-size: 16px;">
                                Confirm Article Deletion</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="padding: 20px;">
                        <p class="mb-2" style="font-size: 14px; color: #334155;">
                            Are you sure you want to permanently delete article <strong id="deleteArticleTitle" class="text-dark"></strong>?
                        </p>
                        <p class="text-muted mb-0" style="font-size: 12.5px;">
                            This action will remove the article and its associated comments and data. This action cannot be undone.
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

@push('custom-scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var listUrl = "{{ route('articles.index') }}";

            var table = $('#articles-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                lengthMenu: [10, 20, 50, 100],
                order: [[0, 'asc']],
                ajax: {
                    url: listUrl,
                    data: function (d) {
                        d.category_id = $('#filter_category').val();
                        d.is_published = $('#filter_status').val();
                        d.featured = $('#filter_featured').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'id', orderable: false, searchable: false, className: 'align-middle text-center text-muted fw-semibold' },
                    { data: 'thumbnail', name: 'thumbnail', orderable: false, searchable: false, className: 'align-middle text-center' },
                    { data: 'article_title', name: 'title', className: 'align-middle' },
                    { data: 'category_badge', name: 'category_id', className: 'align-middle' },
                    { data: 'author_and_date', name: 'published_at', className: 'align-middle' },
                    { data: 'featured_toggle', name: 'featured', orderable: false, searchable: false, className: 'align-middle text-center' },
                    { data: 'published_toggle', name: 'is_published', orderable: false, searchable: false, className: 'align-middle text-center' },
                    {
                        data: 'action-btn',
                        name: 'action-btn',
                        orderable: false,
                        searchable: false,
                        className: 'align-middle text-center',
                        render: function (data) {
                            var showBtn = '<a href="' + data.show_url + '" class="btn btn-edit" title="View Article" style="background-color: #f1f5f9; color: #334155;"><i class="ri-eye-line"></i></a>';
                            var editBtn = data.can_edit
                                ? '<a href="' + data.edit_url + '" class="btn btn-edit" title="Edit Article"><i class="ri-edit-line"></i></a>'
                                : '';
                            var deleteBtn = data.can_delete
                                ? '<button type="button" class="btn btn-delete btn-delete-article" data-id="' + data.id + '" data-title="' + data.title.replace(/"/g, '&quot;') + '" title="Delete Article"><i class="ri-delete-bin-2-line"></i></button>'
                                : '';

                            return '<div class="action-btn justify-content-center">' + showBtn + editBtn + deleteBtn + '</div>';
                        }
                    }
                ],
                language: {
                    paginate: {
                        previous: "<i class='ri-arrow-left-s-line'></i>",
                        next: "<i class='ri-arrow-right-s-line'></i>"
                    },
                    search: "_INPUT_",
                    searchPlaceholder: "Search articles by title, author, or category...",
                    processing: '<div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading articles...'
                }
            });

            // Filter handlers
            $('#filter_category, #filter_status, #filter_featured').on('change', function () {
                table.draw();
            });

            $('#btn_reset_filters').on('click', function () {
                $('#filter_category').val('');
                $('#filter_status').val('');
                $('#filter_featured').val('');
                table.draw();
            });

            // Fast Toggle Visibility (Published)
            $(document).on('change', '.status-toggle', function () {
                var $switch = $(this);
                var articleId = $switch.data('id');
                var toggleUrl = "{{ url('/dashboard/articles') }}/" + articleId + "/toggle-status";

                $switch.prop('disabled', true);

                $.ajax({
                    url: toggleUrl,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        $switch.prop('disabled', false);
                        if (response.success) {
                            toastr.success(response.message || 'Article visibility updated.', 'Updated');
                        } else {
                            $switch.prop('checked', !$switch.prop('checked'));
                            toastr.error('Failed to update visibility.', 'Error');
                        }
                    },
                    error: function (xhr) {
                        $switch.prop('disabled', false);
                        $switch.prop('checked', !$switch.prop('checked'));
                        var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error updating visibility.';
                        toastr.error(msg, 'Error');
                    }
                });
            });

            // Fast Toggle Featured
            $(document).on('change', '.featured-toggle', function () {
                var $switch = $(this);
                var articleId = $switch.data('id');
                var toggleUrl = "{{ url('/dashboard/articles') }}/" + articleId + "/toggle-featured";

                $switch.prop('disabled', true);

                $.ajax({
                    url: toggleUrl,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        $switch.prop('disabled', false);
                        if (response.success) {
                            toastr.success(response.message || 'Featured state updated.', 'Updated');
                        } else {
                            $switch.prop('checked', !$switch.prop('checked'));
                            toastr.error('Failed to update featured state.', 'Error');
                        }
                    },
                    error: function (xhr) {
                        $switch.prop('disabled', false);
                        $switch.prop('checked', !$switch.prop('checked'));
                        var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error updating featured state.';
                        toastr.error(msg, 'Error');
                    }
                });
            });

            // Delete Modal Handling
            $(document).on('click', '.btn-delete-article', function () {
                var id = $(this).data('id');
                var title = $(this).data('title');

                $('#delete_item_id').val(id);
                $('#deleteArticleTitle').text(title);
                $('#deleteArticleModal').modal('show');
            });

            $('#confirmDeleteBtn').on('click', function () {
                var id = $('#delete_item_id').val();
                var deleteUrl = "{{ url('/dashboard/articles') }}/" + id;
                var $btn = $(this);

                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status"></span> Deleting...');

                $.ajax({
                    url: deleteUrl,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        $btn.prop('disabled', false).html('<i class="ri-delete-bin-line me-1"></i> Delete Permanently');
                        $('#deleteArticleModal').modal('hide');

                        if (response.success) {
                            toastr.success(response.message || 'Article deleted successfully.', 'Deleted');
                            table.ajax.reload(null, false);
                        } else {
                            toastr.error(response.message || 'Failed to delete article.', 'Error');
                        }
                    },
                    error: function (xhr) {
                        $btn.prop('disabled', false).html('<i class="ri-delete-bin-line me-1"></i> Delete Permanently');
                        var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'An error occurred during deletion.';
                        toastr.error(msg, 'Error');
                    }
                });
            });
        });
    </script>
@endpush

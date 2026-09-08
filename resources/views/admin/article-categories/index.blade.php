@extends('admin.app')
@section('title')
    Article Categories
@endsection

@push('custom-styles')
    <style>
        .mode-badge {
            font-size: 11px;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 4px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <div class="row g-3">

            {{-- Left Column: Categories DataTable --}}
            <div class="col-lg-8 col-12">
                <div class="card table-card">
                    <div class="card-header table-header d-flex justify-content-between align-items-center">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Article Categories</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">News & Articles</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Categories</li>
                                </ol>
                            </nav>
                        </div>
                        <a href="{{ route('articles.index') }}" class="add-new">
                            <i class="ri-article-line me-1"></i> All Articles
                        </a>
                    </div>

                    {{-- Data Table --}}
                    <div class="card-body" style="overflow-x: auto; padding: 20px;">
                        <table class="table dataTable w-100" id="categories-table" style="min-width: 650px;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 45px;">SL</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col" style="width: 110px;" class="text-center">Articles</th>
                                    <th scope="col" style="width: 90px;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right Column: Category Form (Single-Page Manage) --}}
            <div class="col-lg-4 col-12">
                <div class="card table-card sticky-top" style="top: 75px; z-index: 10;">
                    <div class="card-header table-header d-flex justify-content-between align-items-center">
                        <div>
                            <div class="table-title" id="form_card_title">Add New Category</div>
                        </div>
                        <span class="badge bg-primary mode-badge" id="form_mode_badge">Create Mode</span>
                    </div>
                    <div class="card-body custom-form">
                        <form id="categoryForm" action="{{ route('article-categories.store') }}" method="POST">
                            @csrf
                            <input type="hidden" id="edit_category_id" name="category_id" value="">
                            <input type="hidden" id="_method_field" name="_method" value="POST">

                            <div class="mb-3">
                                <label for="category_name" class="form-label custom-label">Category Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control custom-input" id="category_name" name="name"
                                    placeholder="e.g., Construction News, Market Updates" required autocomplete="off">
                                <div class="text-muted mt-1" style="font-size: 11.5px;">Slug is generated automatically.
                                </div>
                                <div class="text-danger mt-1 d-none" id="error_name" style="font-size: 12px;"></div>
                            </div>

                            <div class="mb-3">
                                <label for="category_description" class="form-label custom-label">Description <span
                                        class="text-muted" style="font-size: 11.5px;">(Optional)</span></label>
                                <textarea class="form-control custom-input" id="category_description" name="description"
                                    rows="4" placeholder="Brief overview or purpose of this category..."
                                    style="resize: none;"></textarea>
                                <div class="text-danger mt-1 d-none" id="error_description" style="font-size: 12px;"></div>
                            </div>

                            <div class="row g-2 pt-2">
                                <div class="col-12" id="submit_btn_container">
                                    <button type="submit" class="btn submit-button w-100" id="btn_submit_category">
                                        <i class="ri-check-line me-1"></i> <span id="submit_btn_text">Save Category</span>
                                    </button>
                                </div>
                                <div class="col-12 d-none" id="cancel_edit_container">
                                    <button type="button" class="btn leave-button w-100" id="btn_cancel_edit">
                                        <i class="ri-close-line me-1"></i> Cancel Edit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    @canany(['article-category-delete', 'blog-delete'])
        <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content"
                    style="border-radius: 10px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(11, 15, 23, 0.1);">
                    <div class="modal-header"
                        style="background-color: #fee2e2; border-bottom: 1px solid #fca5a5; padding: 16px 20px;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ri-error-warning-line text-danger" style="font-size: 22px;"></i>
                            <h5 class="modal-title fw-bold text-danger mb-0" id="deleteModalTitle" style="font-size: 16px;">
                                Confirm Category Deletion</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="padding: 20px;">
                        <p class="mb-2" style="font-size: 14px; color: #334155;">
                            Are you sure you want to permanently delete category <strong id="deleteCategoryTitle"
                                class="text-dark"></strong>?
                        </p>
                        <p class="text-muted mb-0" style="font-size: 12.5px;">
                            This action cannot be undone. Only categories with zero assigned articles can be deleted.
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
            var listUrl = "{{ route('article-categories.index') }}";
            var storeUrl = "{{ route('article-categories.store') }}";

            var table = $('#categories-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 20, 50, 100],
                order: [[0, 'asc']],
                ajax: {
                    url: listUrl
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'align-middle text-center text-muted fw-semibold' },
                    { data: 'category_name', name: 'name', className: 'align-middle' },
                    { data: 'description_text', name: 'description', className: 'align-middle' },
                    { data: 'articles_count_badge', name: 'articles_count', orderable: false, searchable: false, className: 'align-middle text-center' },
                    {
                        data: 'action-btn',
                        name: 'action-btn',
                        orderable: false,
                        searchable: false,
                        className: 'align-middle text-center',
                        render: function (data) {
                            var editBtn = data.can_edit
                                ? '<button type="button" class="btn btn-edit btn-edit-category" data-id="' + data.id + '" data-name="' + data.name.replace(/"/g, '&quot;') + '" data-desc="' + data.description.replace(/"/g, '&quot;') + '" title="Edit Category"><i class="ri-edit-line"></i></button>'
                                : '';
                            var deleteBtn = data.can_delete
                                ? '<button type="button" class="btn btn-delete btn-delete-category" data-id="' + data.id + '" data-title="' + data.name.replace(/"/g, '&quot;') + '" data-count="' + data.articles_count + '" title="Delete Category"><i class="ri-delete-bin-2-line"></i></button>'
                                : '';

                            return '<div class="action-btn justify-content-center">' + editBtn + deleteBtn + '</div>';
                        }
                    }
                ],
                language: {
                    paginate: {
                        previous: "<i class='ri-arrow-left-s-line'></i>",
                        next: "<i class='ri-arrow-right-s-line'></i>"
                    },
                    search: "",
                    searchPlaceholder: "Search categories...",
                    processing: '<div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading categories...'
                }
            });

            function resetFormToAddMode() {
                $('#categoryForm')[0].reset();
                $('#edit_category_id').val('');
                $('#_method_field').val('POST');
                $('#categoryForm').attr('action', storeUrl);
                $('#form_card_title').text('Add New Category');
                $('#form_mode_badge').text('Create Mode').removeClass('bg-warning text-dark').addClass('bg-primary');
                $('#submit_btn_text').text('Save Category');
                $('#cancel_edit_container').addClass('d-none');
                $('#error_name').addClass('d-none').text('');
                $('#error_description').addClass('d-none').text('');
            }

            // Click Edit Button
            $(document).on('click', '.btn-edit-category', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var desc = $(this).data('desc');

                $('#edit_category_id').val(id);
                $('#category_name').val(name);
                $('#category_description').val(desc);
                $('#_method_field').val('PUT');
                $('#categoryForm').attr('action', "{{ url('/dashboard/article-categories') }}/" + id);

                $('#form_card_title').text('Edit Category: ' + name);
                $('#form_mode_badge').text('Edit Mode').removeClass('bg-primary').addClass('bg-warning text-dark');
                $('#submit_btn_text').text('Update Category');
                $('#cancel_edit_container').removeClass('d-none');
                $('#error_name').addClass('d-none').text('');
                $('#error_description').addClass('d-none').text('');

                $('#category_name').focus();
            });

            // Click Cancel Edit Button
            $('#btn_cancel_edit').on('click', function () {
                resetFormToAddMode();
            });

            // Form Submit (AJAX)
            $('#categoryForm').on('submit', function (e) {
                e.preventDefault();
                var $form = $(this);
                var url = $form.attr('action');
                var formData = $form.serialize();
                var $submitBtn = $('#btn_submit_category');

                $('#error_name').addClass('d-none').text('');
                $('#error_description').addClass('d-none').text('');
                $submitBtn.prop('disabled', true);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        $submitBtn.prop('disabled', false);
                        if (response.success) {
                            toastr.success(response.message || 'Saved successfully.', 'Success');
                            resetFormToAddMode();
                            table.ajax.reload(null, false);
                        } else {
                            toastr.error(response.message || 'Operation failed.', 'Error');
                        }
                    },
                    error: function (xhr) {
                        $submitBtn.prop('disabled', false);
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.name) {
                                $('#error_name').removeClass('d-none').text(errors.name[0]);
                            }
                            if (errors.description) {
                                $('#error_description').removeClass('d-none').text(errors.description[0]);
                            }
                        } else {
                            var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'An error occurred.';
                            toastr.error(msg, 'Error');
                        }
                    }
                });
            });

            // Delete Modal Handling
            $(document).on('click', '.btn-delete-category', function () {
                var id = $(this).data('id');
                var title = $(this).data('title');
                var count = parseInt($(this).data('count'), 10) || 0;

                if (count > 0) {
                    toastr.warning('Cannot delete "' + title + '" because it has ' + count + ' assigned article(s). Please reassign or delete them first.', 'Category In Use');
                    return;
                }

                $('#delete_item_id').val(id);
                $('#deleteCategoryTitle').text(title);
                $('#deleteCategoryModal').modal('show');
            });

            $('#confirmDeleteBtn').on('click', function () {
                var id = $('#delete_item_id').val();
                var deleteUrl = "{{ url('/dashboard/article-categories') }}/" + id;
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
                        $('#deleteCategoryModal').modal('hide');

                        if (response.success) {
                            toastr.success(response.message || 'Category deleted successfully.', 'Deleted');
                            resetFormToAddMode();
                            table.ajax.reload(null, false);
                        } else {
                            toastr.error(response.message || 'Failed to delete category.', 'Error');
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
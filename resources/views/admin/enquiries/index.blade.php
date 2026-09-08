@extends('admin.app')
@section('title')
    Client Enquiries
@endsection

@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-12">
                <div class="card table-card">
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Client Enquiries</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Enquiries</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    {{-- Filter Bar --}}
                    <div class="card-body border-bottom" style="background-color: #f8fafc; padding: 14px 20px;">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-6 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Filter
                                    by Status</label>
                                <select id="filter_status" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Statuses</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->value }}">
                                            {{ $status === \App\Enums\EnquiryStatus::NEW ? 'Unread (New)' : $status->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6 d-flex align-items-end">
                                <button type="button" id="reset_filters" class="btn btn-sm btn-outline-secondary w-100"
                                    style="height: 36px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                                    <i class="ri-refresh-line me-1"></i> Reset Filters
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Simplified Table Area: Name, Email, Phone, Subject, Status, Action --}}
                    <div class="card-body" style="padding: 20px;">
                        <table class="table dataTable w-100" id="enquiries-table" style="min-width: 800px;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 20px;">SL</th>
                                    <th scope="col" style="width: 150px;">Name</th>
                                    <th scope="col" style="width: 200px;">Email</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col" style="width: 100px;" class="text-center">Status</th>
                                    <th scope="col" style="width: 90px;" class="text-center">Action</th>
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
    <div class="modal fade" id="deleteEnquiryModal" tabindex="-1" aria-labelledby="deleteModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"
                style="border-radius: 10px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(11, 15, 23, 0.1);">
                <div class="modal-header"
                    style="background-color: #fee2e2; border-bottom: 1px solid #fca5a5; padding: 16px 20px;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ri-error-warning-line text-danger" style="font-size: 22px;"></i>
                        <h5 class="modal-title fw-bold text-danger mb-0" id="deleteModalTitle" style="font-size: 16px;">
                            Confirm Enquiry Deletion</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <p class="mb-2" style="font-size: 14px; color: #334155;">
                        Are you sure you want to permanently delete the inquiry from <strong id="deleteEnquiryName"
                            class="text-dark"></strong> regarding <span id="deleteEnquirySubject"
                            class="fst-italic"></span>?
                    </p>
                    <p class="text-muted mb-0" style="font-size: 12.5px;">
                        This action cannot be undone. Associated activity logs for this deletion will be recorded.
                    </p>
                </div>
                <div class="modal-footer"
                    style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 12px 20px;">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3" data-bs-dismiss="modal"
                        style="font-size: 13px; height: 36px; border-radius: 6px;">Cancel</button>
                    <form id="deleteEnquiryForm" method="POST" action="">
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
            var listUrl = "{{ route('enquiries.index') }}";

            var table = $('#enquiries-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 20,
                lengthMenu: [10, 20, 50, 100],
                ajax: {
                    url: listUrl,
                    data: function (d) {
                        d.status = $('#filter_status').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name', orderable: true },
                    { data: 'email', name: 'email', orderable: true },
                    { data: 'subject', name: 'subject', orderable: true },
                    { data: 'status_badge', name: 'status', orderable: true, className: 'text-center' },
                    {
                        data: 'action-btn',
                        orderable: false,
                        searchable: false,
                        render: function (data) {
                            var id = data.id;
                            var name = (data.name || '').replace(/"/g, '&quot;');
                            var subject = (data.subject || '').replace(/"/g, '&quot;');
                            var showUrl = "{{ url('/dashboard/enquiries') }}/" + id;
                            var deleteUrl = "{{ url('/dashboard/enquiries') }}/" + id;

                            var html = '<div class="action-btn justify-content-center">';
                            if (data.can_view) {
                                html += '<a href="' + showUrl + '" class="btn btn-edit" title="View Full Enquiry"><i class="ri-eye-line"></i></a>';
                            }
                            if (data.can_delete) {
                                html += '<button type="button" class="btn btn-delete btn-delete-modal" data-id="' + id + '" data-name="' + name + '" data-subject="' + subject + '" data-url="' + deleteUrl + '" title="Delete Enquiry"><i class="ri-delete-bin-2-line"></i></button>';
                            }
                            html += '</div>';
                            return html;
                        }
                    }
                ],
                order: [[0, 'desc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search by client name, email, phone, or subject...",
                    processing: '<div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading enquiries...'
                }
            });

            // Filter trigger handlers
            $('#filter_status').on('change', function () {
                table.draw();
            });

            $('#reset_filters').on('click', function () {
                $('#filter_status').val('');
                table.draw();
            });

            // Delete Modal setup
            $(document).on('click', '.btn-delete-modal', function () {
                var name = $(this).data('name');
                var subject = $(this).data('subject');
                var url = $(this).data('url');

                $('#deleteEnquiryName').text(name);
                $('#deleteEnquirySubject').text('"' + subject + '"');
                $('#deleteEnquiryForm').attr('action', url);
                $('#deleteEnquiryModal').modal('show');
            });
        });
    </script>
@endpush
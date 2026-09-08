@extends('admin.app')
@section('title')
    Activity Logs
@endsection

@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-12">
                <div class="card table-card">
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Activity Logs</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Activity Logs</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    {{-- Dynamic Filter Bar --}}
                    <div class="card-body border-bottom" style="background-color: #f8fafc; padding: 14px 20px;">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Module</label>
                                <select id="filter_module" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Modules</option>
                                    @foreach($modules as $module)
                                        <option value="{{ $module }}">{{ ucfirst($module) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Action
                                    Type</label>
                                <select id="filter_action" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Actions</option>
                                    @foreach($actions as $act)
                                        <option value="{{ $act }}">{{ ucwords(str_replace('_', ' ', $act)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label mb-1 text-muted"
                                    style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">User
                                    / Operator</label>
                                <select id="filter_user" class="form-select form-select-sm custom-input"
                                    style="height: 36px; font-size: 13px;">
                                    <option value="">All Users</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                                    @endforeach
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

                    {{-- Table Area --}}
                    <div class="card-body" style="padding: 20px;">
                        <table class="table dataTable w-100" id="activity-logs-table" style="min-width: 950px;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 45px;">SL</th>
                                    <th scope="col" style="width: 180px;">User</th>
                                    <th scope="col" style="width: 100px;">Action</th>
                                    <th scope="col" style="width: 110px;">Module</th>
                                    <th scope="col">Description</th>
                                    <th scope="col" style="width: 120px;">IP Address</th>
                                    <th scope="col" style="width: 140px;">Timestamp</th>
                                    <th scope="col" style="width: 70px;" class="text-center">Action</th>
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
@endsection

@push('custom-script')
    <script type="text/javascript">
        $(document).ready(function () {
            var listUrl = "{{ route('activity-logs.index') }}";

            var table = $('#activity-logs-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                lengthMenu: [10, 25, 50, 100],
                ajax: {
                    url: listUrl,
                    data: function (d) {
                        d.module = $('#filter_module').val();
                        d.action = $('#filter_action').val();
                        d.user_id = $('#filter_user').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'user', name: 'user.name', orderable: false },
                    { data: 'action_badge', name: 'action', orderable: true },
                    { data: 'module_badge', name: 'module', orderable: true },
                    { data: 'description_text', name: 'description', orderable: true },
                    { data: 'ip_address', name: 'ip_address', orderable: false },
                    { data: 'timestamp', name: 'created_at', orderable: true },
                    {
                        data: 'action-btn',
                        orderable: false,
                        searchable: false,
                        render: function (data) {
                            var id = data.id;
                            var showUrl = "{{ url('/dashboard/activity-logs') }}/" + id;

                            return '<div class="action-btn justify-content-center">' +
                                '<a href="' + showUrl + '" class="btn btn-edit" title="View Audit Details" style="background-color: #f1f5f9; color: #334155;"><i class="ri-eye-line"></i></a>' +
                                '</div>';
                        }
                    }
                ],
                order: [[6, 'desc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search audit logs by user, action, or description...",
                    processing: '<div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading audit logs...'
                }
            });

            // Filter trigger handlers
            $('#filter_module, #filter_action, #filter_user').on('change', function () {
                table.draw();
            });

            $('#reset_filters').on('click', function () {
                $('#filter_module').val('');
                $('#filter_action').val('');
                $('#filter_user').val('');
                table.draw();
            });
        });
    </script>
@endpush
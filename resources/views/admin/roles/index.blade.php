@extends('admin.app')
@section('title')
    Roles &amp; Permissions
@endsection

@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-12">
                <div class="card table-card">
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Roles &amp; Permissions</div>
                            <nav aria-label="breadcrumb"> 
                                <ol class="breadcrumb mb-0"> 
                                    <li class="breadcrumb-item">
                                        <a href="{{route('dashboard')}}">Dashboard</a>
                                    </li> 
                                    <li class="breadcrumb-item active" aria-current="page">Roles</li> 
                                </ol> 
                            </nav>
                        </div>
                        @if (Auth::user()->hasRole('superadmin'))
                            <a href="{{route('role.create')}}" class="add-new">New Role<i class="ms-1 ri-add-line"></i></a>
                        @endif
                    </div>
                    <div class="card-body" style="padding: 20px;">
                        <table class="table dataTable w-100" id="data-table" style="min-width: 700px;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 80px;">SL NO</th>
                                    <th scope="col">Role Name</th>
                                    <th scope="col" style="width: 160px;">Users Assigned</th>
                                    <th scope="col" style="width: 120px;">Action</th>
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

@push('custom-scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var listUrl = "{{ route('role.index') }}";

            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 20,
                lengthMenu: [ 20, 50, 100, 500 ],
                ajax: {
                    url: listUrl,
                    type: 'GET'
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'display_name', name: 'name', orderable: true },
                    { data: 'users_count', name: 'users_count', orderable: false, searchable: false },
                    {
                        data: 'action-btn',
                        orderable: false,
                        searchable: false,
                        render: function (data) {
                            var id = data.id;
                            var canEdit = data.can_edit;
                            var canDelete = data.can_delete;
                            var editUrl = "{{ url('/dashboard/role/edit') }}/" + id;
                            var deleteUrl = "{{ url('/dashboard/role/delete') }}/" + id;

                            var btn = '<div class="action-btn">';
                            if (canEdit) {
                                btn += '<a href="' + editUrl + '" class="btn btn-edit" title="Edit Role"><i class="ri-edit-line"></i></a>';
                            }
                            if (canDelete) {
                                btn += '<a href="' + deleteUrl + '" class="btn btn-delete" title="Delete Role" onclick="return confirm(\'Are you sure you want to delete this role?\')"><i class="ri-delete-bin-2-line"></i></a>';
                            }
                            btn += '</div>';
                            return btn;
                        }
                    }
                ],
                order: [[1, 'asc']]
            });
        });
    </script>
@endpush

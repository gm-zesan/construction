@extends('admin.app')
@section('title')
    Users
@endsection

@section('content')
    {{-- Data Table --}}
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-12">
                <div class="card table-card">
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">User Management</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('dashboard')}}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                                </ol>
                            </nav>
                        </div>
                        <a href="{{route('user.create')}}" class="add-new">Create User<i class="ms-1 ri-add-line"></i></a>
                    </div>
                    <div class="card-body" style="padding: 20px;">
                        <table class="table dataTable w-100" id="data-table" style="min-width: 800px;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 80px;">SL NO</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col" style="width: 150px;">Role</th>
                                    <th scope="col">Phone No</th>
                                    <th scope="col" style="width: 140px;">Action</th>
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

    {{-- Assign Role Modal --}}
    <div class="modal fade" id="assignroleModal" tabindex="-1" aria-labelledby="modalName" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"
                style="border-radius: 10px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(11, 15, 23, 0.1);">
                <div class="modal-header"
                    style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 16px 20px;">
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0" id="modalName" style="font-size: 16px;">Assign Role
                        </h5>
                        <span id="modalEmail" class="text-muted" style="font-size: 13px;"></span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{route('user.assignRole')}}">
                    <div class="modal-body" style="padding: 20px;">
                        @csrf
                        <input type="hidden" name="email" value="" class="modalEmail">

                        <div class="mb-2">
                            <label class="form-label custom-label fw-semibold mb-2"
                                style="font-size: 13px; color: #475569;">Select Role :</label>
                            <div class="d-flex flex-wrap gap-2 pt-1">
                                @if(isset($roles))
                                    @foreach ($roles as $role)
                                        <div class="form-check form-check-inline role-outter-wrapper m-0">
                                            <input type="radio" id="modal_role_{{$role}}" name="role"
                                                class="role-input d-none form-check-input" value="{{$role}}" required>
                                            <label for="modal_role_{{$role}}" class="role-wrapper">
                                                <p>{{ucwords(str_replace('-', ' ', $role))}}</p>
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"
                        style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 12px 20px;">
                        <button type="button" class="btn btn-sm btn-outline-secondary px-3" data-bs-dismiss="modal"
                            style="font-size: 13px; height: 36px; border-radius: 6px;">Cancel</button>
                        <button type="submit" class="assign-role-btn">Assign Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('custom-script')
    <script type="text/javascript">
        $(document).ready(function () {
            var listUrl = "{{ route('users') }}";

            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 20,
                lengthMenu: [20, 50, 100, 500],
                ajax: {
                    url: listUrl,
                    type: 'GET'
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name', orderable: true },
                    { data: 'email', name: 'email', orderable: true },
                    { data: 'role', name: 'role', orderable: false },
                    { data: 'phone_no', name: 'phone_no', orderable: true },
                    {
                        data: 'action-btn',
                        orderable: false,
                        searchable: false,
                        render: function (data) {
                            var id = (typeof data === 'object' && data !== null) ? data.id : data;
                            var name = (typeof data === 'object' && data !== null) ? (data.name || '').replace(/"/g, '&quot;') : '';
                            var email = (typeof data === 'object' && data !== null) ? (data.email || '').replace(/"/g, '&quot;') : '';
                            var role = (typeof data === 'object' && data !== null) ? (data.role || '').replace(/"/g, '&quot;') : '';
                            var canDelete = (typeof data === 'object' && data !== null) ? data.can_delete : true;
                            var canEdit = (typeof data === 'object' && data !== null) ? data.can_edit : true;
                            var canAssign = (typeof data === 'object' && data !== null) ? data.can_assign : true;
                            var editUrl = "{{ url('/dashboard/user/edit') }}/" + id;
                            var deleteUrl = "{{ url('/dashboard/user/delete') }}/" + id;

                            var btn = '<div class="action-btn">';
                            if (canEdit) {
                                btn += '<a href="' + editUrl + '" class="btn btn-edit" title="Edit User"><i class="ri-edit-line"></i></a>';
                            }
                            if (canAssign) {
                                btn += '<button type="button" class="btn btn-role btn-assign-modal" data-id="' + id + '" data-name="' + name + '" data-email="' + email + '" data-role="' + role + '" title="Assign Role"><i class="ri-shield-user-line"></i></button>';
                            }
                            if (canDelete) {
                                btn += '<a href="' + deleteUrl + '" class="btn btn-delete" title="Delete User" onclick="return confirm(\'Are you sure you want to delete this user?\')"><i class="ri-delete-bin-2-line"></i></a>';
                            }
                            btn += '</div>';
                            return btn;
                        }
                    }
                ],
                order: [[1, 'asc']]
            });

            $(document).on('click', '.btn-assign-modal', function () {
                var name = $(this).data('name');
                var email = $(this).data('email');
                var role = $(this).data('role');

                $("#modalName").text(name);
                $("#modalEmail").text(email ? "(" + email + ")" : "");
                $(".modalEmail").val(email);

                $('.role-input').each(function () {
                    $(this).prop('checked', $(this).val() === role);
                });

                $('#assignroleModal').modal('show');
            });
        });
    </script>
@endpush
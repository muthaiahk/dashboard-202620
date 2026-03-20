@extends('layouts/layoutMaster')

@section('title', 'Roles & Permissions')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js'])
    @vite(['resources/js/app.js'])
@endsection


@section('content')
    <style>
        /* permission container */
        .permission-group {
            display: flex;
            justify-content: center;
            gap: 6px;
        }

        /* permission badge */
        .permission-badge {
            width: 26px;
            height: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            background: #f5f6f8;
            color: #9aa1a9;
            cursor: pointer;
            transition: 0.2s;
        }

        /* active permission */
        .permission-badge.active {
            background: #d8f3e6;
            color: #0f9d58;
            border-color: #0f9d58;
        }

        /* sticky first column */
        .table tbody .sticky-column {
            position: sticky;
            left: 0;
            background: #fff;
            z-index: 5;
        }

        /* header style */
        .table thead th {
            font-weight: 600;
            font-size: 14px;
        }

        /* role header */
        .role-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
        }

        .role-users {
            font-size: 12px;
            color: #6c757d;
        }

        .role-actions {
            font-size: 12px;
            display: flex;
            gap: 10px;
        }

        .role-actions a {
            cursor: pointer;
            color: #0076b6;
        }

        .role-actions a.delete {
            color: #dc3545;
        }

        .table thead .sticky-column {
            position: sticky;
            left: 0;
            background-color: #F5F8FA !important;
            color: #000;
            z-index: 30;
            border-right: 1px solid #dee2e6;
        }

        .table tbody .sticky-column {
            position: sticky;
            left: 0;
            background-color: #fff !important;
            color: #000 !important;
            z-index: 10;
            border-right: 1px solid #dee2e6;
        }

        .toggle-badge {
            cursor: pointer;
            padding: 5px 8px;
            border: 1px solid #6c757d;
            border-radius: 0.25rem;
            background-color: #e9ecef;
            color: #212529;
            transition: all 0.2s;
        }


        .toggle-badge.checked {
            background-color: #d1e7dd;
            color: #087441;
            border-color: #087441;
        }

        .sticky-top {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            z-index: 1020;
        }
    </style>
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header pb-1 d-flex align-items-start justify-content-between gap-5">
            <h3 class="card-title mb-1">Roles & Permissions</h3>
            <div class="d-flex justify-content-end align-items-center mb-2 gap-1">
                <a href="javascript:;" target="_blank" class="btn btn-sm fw-bold border border-primary" data-bs-toggle="modal"
                    data-bs-target="#kt_modal_user_log">
                    <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Audit Trail"><i
                            class="mdi mdi-account-clock-outline text-primary"></i></span>
                </a>
                <div class="searchBar" style="position: relative; width: 300px;">
                    <input class="form-control" type="text" name="searchQueryInput" placeholder="Search Role, User Name"
                        value="" oninput="toggleIcons(this)" style="padding-left: 35px;" />
                    <svg style="width:20px;height:20px;position:absolute;left:10px;top:50%;transform:translateY(-50%);fill:#0076b6;"
                        viewBox="0 0 24 24">
                        <path
                            d="M9.5,3A6.5,6.5 0 0,1 16,9.5
                                                                                                                                                                                                                                    C16,11.11 15.41,12.59 14.44,13.73
                                                                                                                                                                                                                                    L14.71,14H15.5L20.5,19L19,20.5
                                                                                                                                                                                                                                    L14,15.5V14.71L13.73,14.44
                                                                                                                                                                                                                                    C12.59,15.41 11.11,16
                                                                                                                                                                                                                                    9.5,16A6.5,6.5 0 0,1 3,9.5
                                                                                                                                                                                                                                    A6.5,6.5 0 0,1 9.5,3
                                                                                                                                                                                                                                    M9.5,5C7,5 5,7 5,9.5
                                                                                                                                                                                                                                    C5,12 7,14 9.5,14
                                                                                                                                                                                                                                    C12,14 14,12 14,9.5
                                                                                                                                                                                                                                    C14,7 12,5 9.5,5Z" />
                    </svg>
                </div>
                <a href="javascript:;" target="_blank" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal"
                    data-bs-target="#kt_modal_add_role">
                    <span class="me-2"><i class="mdi mdi-plus"></i></span>Add Role
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-lg-12">
                    <div class="roleTable">
                        <table class="table align-middle table-row-dashed table-hover gy-0 gs-1 list_page"
                            style="overflow-x:auto;">
                            <thead>
                                <tr class="text-center align-top fw-bold fs-6 gs-0 bg-gray-100">
                                    <th class="sticky-column">Module/Role</th>
                                    @foreach ($roles as $role)
                                        <th class="text-center">
                                            <div class="role-header">
                                                <div class="text-black">{{ $role->name }}</div>
                                                <div class="role-users">{{ $role->users->count() ?? 0 }} Users</div>
                                                <div class="role-actions ">
                                                    <a href="javascript:;" class="edit-role-btn"
                                                        data-id="{{ $role->id }}" data-name="{{ $role->name }}"
                                                        data-description="{{ $role->description }}" data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_update_role"><i
                                                            class="mdi mdi-pencil-outline"></i> Edit</a>
                                                    <span class="text-dark">|</span>
                                                    <a href="javascript:;" class="delete-role-btn delete"
                                                        data-id="{{ $role->id }}" data-name="{{ $role->name }}"
                                                        data-bs-toggle="modal" data-bs-target="#kt_modal_delete_role"><i
                                                            class="mdi mdi-trash-can-outline"></i> Delete</a>
                                                </div>
                                            </div>

                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modules as $module)
                                    <tr>
                                        <!-- Module -->
                                        <td class="sticky-column fw-medium">{{ $module }}</td>

                                        @foreach ($roles as $role)
                                            @php
                                                $perm = $role->permissions->firstWhere('module', $module);
                                                $pivot = $perm ? $perm->pivot : null;
                                            @endphp

                                            <td>
                                                <div class="permission-group">

                                                    <!-- CREATE -->
                                                    <span
                                                        class="permission-badge {{ $pivot && $pivot->is_create ? 'active' : '' }}"
                                                        data-role="{{ $role->id }}" data-module="{{ $module }}"
                                                        data-type="is_create">C</span>

                                                    <!-- READ -->
                                                    <span
                                                        class="permission-badge {{ $pivot && $pivot->is_read ? 'active' : '' }}"
                                                        data-role="{{ $role->id }}" data-module="{{ $module }}"
                                                        data-type="is_read">R</span>

                                                    <!-- UPDATE -->
                                                    <span
                                                        class="permission-badge {{ $pivot && $pivot->is_update ? 'active' : '' }}"
                                                        data-role="{{ $role->id }}" data-module="{{ $module }}"
                                                        data-type="is_update">U</span>

                                                    <!-- DELETE -->
                                                    <span
                                                        class="permission-badge {{ $pivot && $pivot->is_delete ? 'active' : '' }}"
                                                        data-role="{{ $role->id }}" data-module="{{ $module }}"
                                                        data-type="is_delete">D</span>

                                                    <!-- APPROVE -->
                                                    <span
                                                        class="permission-badge {{ $pivot && $pivot->is_approve ? 'active' : '' }}"
                                                        data-role="{{ $role->id }}" data-module="{{ $module }}"
                                                        data-type="is_approve">A</span>

                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- <div class="col-lg-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div> --}}
            </div>
        </div>
    </div>


    <!--begin::Modal - Delete Roles & Permissions-->
    <div class="modal fade pt-20" id="kt_modal_delete_role" tabindex="-1" aria-hidden="true" aria-hidden="true"
        data-bs-keyboard="false" data-bs-backdrop="static">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-m">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <div class="swal2-icon swal2-danger swal2-icon-show" style="display: flex;">
                    <div class="swal2-icon-content">
                        <img src="{{ asset('assets/images/dustbin.ico') }}" alt="Dustbin Icon" class="w-100px h-100px" />
                    </div>
                </div>
                <div class="swal2-html-container" id="swal2-html-container" style="display: block;">Are you sure you want
                    to delete Roles & Permissions ?
                    <div class="d-block fw-bold fs-5 py-2">
                        <input type="hidden" id="delete_role_id">
                        <label class="text-danger" id="delete_role_name"></label>
                        <!-- <span class="ms-2 me-2">-</span>
                                                                                                                                                                                                                          <label>2024/MDU/MU0001</label> -->
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center gap-3 pt-8">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">No,cancel</button>
                    <button type="button" id="confirm_delete_btn" class="btn btn-danger">
                        Yes, delete!
                    </button>
                </div><br><br>
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Delete Roles & Permissions-->

    <!--begin::Modal - Add Roles & Permission-->
    <div class="modal fade" id="kt_modal_add_role" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
        data-bs-backdrop="static" data-bs-focus="false">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-md">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
                    <h4 class="text-center text-black">Create Role</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary mb-4" data-bs-dismiss="modal">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-5 px-10 px-xl-20">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label class="text-black mb-1 fs-7 fw-medium">Role Name<span
                                    class="text-danger">*</span></label>
                            <input type="text" id="role_name" class="form-control required-field"
                                placeholder="Enter Role Name" />
                            <div class="text-danger fs-7 mt-1 error-message"></div>
                        </div>
                        {{-- <div class="col-lg-12 mb-3">
                            <label class="text-black mb-1 fs-7 fw-medium">Description</label>
                            <textarea id="role_description" class="form-control" rows="1" placeholder="Enter Description"></textarea>
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer pt-5">
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="create_role_btn">Create Role</button>
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add Roles & Permission-->


    <!--begin::Modal - Add Audit Trail-->
    <div class="modal fade" id="kt_modal_user_log" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
        data-bs-backdrop="static" data-bs-focus="false">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
                    <h4 class="text-center text-black">Audit Trail</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary mb-4" data-bs-dismiss="modal">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-5 px-10 px-xl-20">
                    <div class="row">
                        <div class="col-lg-12 table-wrapper mt-2">
                            <table class="table align-middle table-row-dashed table-hover gy-0 gs-1 list_page">
                                <thead class="table-header sticky-top">
                                    <tr class="text-center align-top fw-bold fs-6 gs-0 bg-gray-200">
                                        <th class="min-w-100px text-black">Role</th>
                                        <th class="min-w-100px text-black">Module</th>
                                        <th class="min-w-100px text-black">Update At</th>
                                        <th class="min-w-100px text-black">Update by</th>
                                        <th class="min-w-100px text-black">Details</th>
                                    </tr>
                                </thead>
                                <tbody class="text-black fw-semibold fs-7">
                                    <tr>
                                        <td>
                                            <label class="fw-medium fs-7">Supervisor</label>
                                        </td>
                                        <td>
                                            <label class="fw-medium fs-7">Manage Customer Asset</label>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium fs-7">15-Mar-2026</label>
                                                <label class="fs-8 text-danger">02:06 PM</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img class="rounded-circle w-45px h-45px"
                                                    src="{{ asset('assets/images/auth/user_1.png') }}">
                                                <label class="fw-medium fs-7">John Smith</label>
                                            </div>
                                        </td>
                                        <td>
                                            <label class="text-black fw-medium fs-7">Create Asset permission
                                                removed</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="fw-medium fs-7">Technician</label>
                                        </td>
                                        <td>
                                            <label class="fw-medium fs-7">Manage Work Order</label>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium fs-7">16-Mar-2026</label>
                                                <label class="fs-8 text-danger">10:15 AM</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img class="rounded-circle w-45px h-45px"
                                                    src="{{ asset('assets/images/auth/user_1.png') }}">
                                                <label class="fw-medium fs-7">David Lee</label>
                                            </div>
                                        </td>
                                        <td>
                                            <label class="text-black fw-medium fs-7">Work Order access granted</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="fw-medium fs-7">Engineer</label>
                                        </td>
                                        <td>
                                            <label class="fw-medium fs-7">Manage Inventory</label>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium fs-7">16-Mar-2026</label>
                                                <label class="fs-8 text-danger">01:40 PM</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img class="rounded-circle w-45px h-45px"
                                                    src="{{ asset('assets/images/auth/user_2.png') }}">
                                                <label class="fw-medium fs-7">Sarah Khan</label>
                                            </div>
                                        </td>
                                        <td>
                                            <label class="text-black fw-medium fs-7">Inventory edit permission
                                                updated</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="fw-medium fs-7">Admin</label>
                                        </td>
                                        <td>
                                            <label class="fw-medium fs-7">User Management</label>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium fs-7">17-Mar-2026</label>
                                                <label class="fs-8 text-danger">11:25 AM</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img class="rounded-circle w-45px h-45px"
                                                    src="{{ asset('assets/images/auth/user_1.png') }}">
                                                <label class="fw-medium fs-7">Michael Brown</label>
                                            </div>
                                        </td>
                                        <td>
                                            <label class="text-black fw-medium fs-7">Role changed from Technician to
                                                Supervisor</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="fw-medium fs-7">Supervisor</label>
                                        </td>
                                        <td>
                                            <label class="fw-medium fs-7">Reports</label>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium fs-7">17-Mar-2026</label>
                                                <label class="fs-8 text-danger">04:50 PM</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img class="rounded-circle w-45px h-45px"
                                                    src="{{ asset('assets/images/auth/user_2.png') }}">
                                                <label class="fw-medium fs-7">Emma Watson</label>
                                            </div>
                                        </td>
                                        <td>
                                            <label class="text-black fw-medium fs-7">Report download permission
                                                added</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="fw-medium fs-7">Technician</label>
                                        </td>
                                        <td>
                                            <label class="fw-medium fs-7">Tools & Equipment</label>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium fs-7">18-Mar-2026</label>
                                                <label class="fs-8 text-danger">09:10 AM</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img class="rounded-circle w-45px h-45px"
                                                    src="{{ asset('assets/images/auth/user_1.png') }}">
                                                <label class="fw-medium fs-7">Chris Evans</label>
                                            </div>
                                        </td>
                                        <td>
                                            <label class="text-black fw-medium fs-7">Equipment access revoked</label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add Audit Trail-->


    <!--begin::Modal - Update Roles & Permission-->
    <div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
        data-bs-backdrop="static" data-bs-focus="false">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-md">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
                    <h4 class="text-center text-black">Update Role</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary mb-4" data-bs-dismiss="modal">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-5 px-10 px-xl-20">
                    <div class="row">
                        <input type="hidden" id="edit_role_id">
                        <div class="col-lg-12 mb-3">
                            <label class="text-black mb-1 fs-7 fw-medium">Role Name<span
                                    class="text-danger">*</span></label>
                            <input type="text" id="edit_role_name" class="form-control"
                                placeholder="Enter Role Name" />
                        </div>
                        {{-- <div class="col-lg-12 mb-3">
                            <label class="text-black mb-1 fs-7 fw-medium">Description</label>
                            <textarea class="form-control" rows="1" placeholder="Enter Description"></textarea>
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer pt-5">
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="update_role_btn" class="btn btn-primary">
                            Update Role
                        </button>
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Update Roles & Permission-->


    <script>
        $(document).on('click', '.edit-role-btn', function() {
            $('#edit_role_id').val($(this).data('id'));
            $('#edit_role_name').val($(this).data('name'));
        });
        $(document).on('click', '.delete-role-btn', function() {
            $('#delete_role_id').val($(this).data('id'));
            $('#delete_role_name').text($(this).data('name'));
        });
        $('#update_role_btn').click(function() {

            let btn = $(this);

            // 🔥 start loading
            btn.prop('disabled', true);
            let originalText = btn.html();

            btn.html(`
        <span class="spinner-border spinner-border-sm me-2"></span>
        Updating...
    `);

            $.ajax({
                url: "{{ route('roles.update') }}",
                type: "POST",
                data: {
                    id: $('#edit_role_id').val(),
                    name: $('#edit_role_name').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },

                success: function(res) {
                    if (res.success) {
                        toastr.success(res.message);
                        $('#kt_modal_update_role').modal('hide');

                        setTimeout(() => {
                            location.reload();
                        }, 800);
                    }
                },

                error: function() {
                    toastr.error("Update failed");
                },

                complete: function() {
                    // 🔥 stop loading (only if not reloading)
                    btn.prop('disabled', false);
                    btn.html(originalText);
                }
            });

        });
        $('#confirm_delete_btn').click(function() {

            let btn = $(this);

            // 🔥 start loading
            btn.prop('disabled', true);
            let originalText = btn.html();

            btn.html(`
        <span class="spinner-border spinner-border-sm me-2"></span>
        Deleting...
    `);

            $.ajax({
                url: "{{ route('roles.delete') }}",
                type: "POST",
                data: {
                    id: $('#delete_role_id').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },

                success: function(res) {
                    if (res.success) {
                        toastr.success(res.message);
                        $('#kt_modal_delete_role').modal('hide');

                        setTimeout(() => {
                            location.reload();
                        }, 800);
                    }
                },

                error: function() {
                    toastr.error("Delete failed");
                },

                complete: function() {
                    // 🔥 stop loading (if no reload)
                    btn.prop('disabled', false);
                    btn.html(originalText);
                }
            });

        });
        $(document).on('click', '.permission-badge', function() {

            let el = $(this);

            el.toggleClass('active');

            $.post("{{ route('permissions.update') }}", {
                role_id: el.data('role'),
                module: el.data('module'),
                type: el.data('type'),
                value: el.hasClass('active') ? 1 : 0,
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function(res) {
                toastr.success(res.message);
            });

        });
        $(document).ready(function() {

            $('#create_role_btn').click(function() {

                let btn = $(this);
                let isValid = true;

                // Clear errors
                $('.error-message').text('');
                $('.required-field').removeClass('is-invalid');

                // Validate
                $('.required-field').each(function() {
                    if ($(this).val().trim() === '') {
                        $(this).addClass('is-invalid');
                        $(this).next('.error-message').text('This field is required');
                        isValid = false;
                    }
                });

                if (!isValid) return;

                // 🔥 START LOADING
                btn.prop('disabled', true);
                let originalText = btn.html();
                btn.html(`
            <span class="spinner-border spinner-border-sm me-2"></span>
            Creating...
        `);

                let formData = {
                    name: $('#role_name').val(),
                    description: $('#role_description').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                };

                $.ajax({
                    url: "{{ route('roles.store') }}",
                    type: "POST",
                    data: formData,

                    success: function(res) {
                        if (res.success) {

                            $('#kt_modal_add_role').modal('hide');

                            toastr.success(res.message);

                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },

                    error: function(xhr) {

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            if (errors.name) {
                                $('#role_name').addClass('is-invalid');
                                $('#role_name').next('.error-message').text(errors.name[0]);
                            }

                        } else {
                            toastr.error("Something went wrong");
                        }
                    },

                    complete: function() {
                        // 🔥 STOP LOADING (if no reload)
                        btn.prop('disabled', false);
                        btn.html(originalText);
                    }
                });

            });

        });
    </script>

    <script>
        function toggleBadge(el) {
            el.classList.toggle("active");
        }

        const menu = [{
                name: "Dashboard"
            },
            {
                name: "Manage Customer Asset"
            },
            {
                name: "Manage Work Order"
            },
            {
                name: "Manage Inventory"
            },
            {
                name: "Manage Procedure"
            },
            {
                name: "Manage Resources"
            },
            {
                name: "Tools & Equipment"
            },
            {
                name: "Roles & Permissions"
            },
            {
                name: "Manage Client"
            },
        ];

        const roles = [
            "Administrator",
            "Supervisor",
            "Technician",
            "Rigger",
            "Crane Operator"
        ];

        const permissions = ["C", "R", "U", "D", "A"];

        const tbody = document.getElementById("menu-table-body");

        menu.forEach(module => {

            const tr = document.createElement("tr");

            // Module name column
            const tdModule = document.createElement("td");
            tdModule.classList.add("sticky-column", "fw-medium");
            tdModule.innerText = module.name;
            tr.appendChild(tdModule);

            // Role columns
            roles.forEach(() => {

                const td = document.createElement("td");

                const div = document.createElement("div");
                div.className = "permission-group";

                permissions.forEach(p => {
                    const span = document.createElement("span");
                    span.className = "permission-badge";
                    span.innerText = p;
                    span.onclick = () => toggleBadge(span);
                    div.appendChild(span);
                });

                td.appendChild(div);
                tr.appendChild(td);

            });

            tbody.appendChild(tr);

        });
    </script>
    <script>
        $(".list_page").DataTable({
            "ordering": false,
            // "aaSorting":[],
            "language": {
                "lengthMenu": "Show _MENU_",
            },
            "dom": "<'row mb-3'" +
                // "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                // "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                // "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                // "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">"
        });
    </script>
@endsection

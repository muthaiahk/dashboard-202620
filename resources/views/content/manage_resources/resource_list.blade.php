@extends('layouts/layoutMaster')

@section('title', 'Manage Resources')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/dropzone/dropzone.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/nouislider/nouislider.js', 'resources/assets/vendor/libs/jquery-repeater/jquery-repeater.js', 'resources/assets/vendor/js/dropdown-hover.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/forms_date_time_pickers.js'])
    @vite(['resources/js/app.js'])
@endsection
@section('content')

    <style>
        .resource-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
            padding: 0rem;
            overflow-x: auto;
        }

        .resource-card {
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column;
            padding: 1rem 0rem;
            position: relative;
        }

        .avatar-status {
            display: flex;
            justify-content: space-between;
            align-items: start;
        }

        .avatar {
            width: 75px;
            height: 75px;
            background: #f0f0f0;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
        }


        .expired-badge {
            position: absolute;
            top: 0px;
            right: 0px;
            background: #ffcccc;
            color: #c00;
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 600;
            z-index: 2;
        }

        .name-role {
            display: flex;
            flex-direction: column;
            gap: 4px;
            align-items: center;
        }

        .name-role h6 {
            margin: 0;
            font-size: 1rem;
            font-weight: 500;
        }

        .role {
            font-size: 0.75rem;
            color: #000;
            border-radius: 50px;
            padding: 2px 4px;
            display: inline-block;
            margin-right: 0.5rem;
            background-color: #dbdbdb;
        }

        .status {
            font-size: 0.7rem;
            padding: 2px 4px;
            border-radius: 50px;
            font-weight: bold;
        }

        .status.active {
            background: #d4edda;
            color: #155724;
        }

        .status.on-leave {
            background: #fff3cd;
            color: #856404;
        }

        .card-body {
            margin-top: 0.5rem;
            font-size: 0.75rem;
        }

        .certifications,
        .permits {
            margin-top: 0.5rem;
        }

        .permit {
            background: #e8eaf6;
            color: #3f51b5;
            border: 1px solid #3f51b5;
            font-size: 0.65rem;
            padding: 4px;
            border-radius: 4px;
            margin-right: 2px;
        }

        .expired {
            color: red;
            font-weight: bold;
            margin-left: 4px;
        }

        .card-footer {
            margin-top: none;
            padding: 0px;
            padding-top: 8px;
            text-align: center;
        }

        .btn-manage {
            background: transparent;
            border: none;
            padding: 2px 8px;
            font-size: 0.75rem;
            cursor: pointer;
        }
    </style>
    <!-- Lead List Table -->
    <div class="card card-action">
        <div class="card-header pb-1">
            <div class="card-action-title">
                <h3 class="card-title mb-1">Manage Resources</h3>
                <div class="nav-align-top nav-tabs-shadow">
                    <ul class="nav nav-tabs" role="tablist" style="overflow-x:hidden !important;">
                        <li class="nav-item">
                            <a href="{{ url('/manage_resources') }}" type="button" class="nav-link active">
                                <span class="d-none d-sm-inline-flex align-items-center">
                                    <i class="mdi mdi-account-outline me-2"></i>
                                    Resources
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/manage_team') }}" type="button" class="nav-link">
                                <span class="d-none d-sm-inline-flex align-items-center">
                                    <i class="mdi mdi-account-group-outline me-2"></i>
                                    Team
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/resource_availability') }}" type="button" class="nav-link">
                                <span class="d-none d-sm-inline-flex align-items-center">
                                    <i class="mdi mdi-calendar-check-outline me-2"></i>
                                    Resource Availability
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-action-element">
                <div class="d-flex justify-content-end align-items-center mb-2 gap-2">
                    <div class="searchBar" style="position: relative; width: 300px;">
                        <input class="form-control" type="text" name="searchQueryInput" id="customSearchInput"
                            placeholder="Search Resources Name" value="" oninput="toggleIcons(this)"
                            style="padding-left: 35px;" />
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
                    <a href="javascript:void(0)" class="btn btn-sm fw-bold text-white btn-primary" data-bs-toggle="modal"
                        data-bs-target="#bulkUploadModal">
                        <i class="mdi mdi-tray-arrow-up"></i> Bulk Upload
                    </a>
                    <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_add_resources">
                        <span class="me-2"><i class="mdi mdi-plus"></i></span>Add Resources
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="resource-grid">

                @forelse($resources as $resource)

                    <div class="resource-card">

                        <div class="card-header d-flex flex-column align-items-center gap-1">

                            <div class="avatar">
                                <img src="{{ asset('assets/images/auth/user_1.png') }}" class="w-75px h-75px">
                            </div>

                            <div class="name-role">
                                <h6>{{ $resource->name }}</h6>

                                <div class="d-flex gap-1 justify-content-center">

                                    <span class="role">
                                        {{ $resource->role->name ?? '-' }}
                                    </span>

                                    <span class="status {{ $resource->status == 1 ? 'active' : 'on-leave' }}">
                                        {{ $resource->status == 1 ? 'Active' : 'Inactive' }}
                                    </span>

                                </div>

                            </div>

                        </div>

                        <div class="card-body bg-gray-100">

                            <div class="d-flex justify-content-between">
                                <span>ID: {{ $resource->id }}</span>
                                <span>{{ $resource->email }}</span>
                            </div>

                            {{-- CERTIFICATIONS --}}
                            <div class="certifications mt-2">

                                <h6 class="fw-semibold">
                                    <i class="mdi mdi-seal-variant me-1"></i>Certifications
                                </h6>

                                @php
                                    $certs = is_array($resource->certificates ?? null)
                                        ? $resource->certificates
                                        : json_decode($resource->certificates, true);
                                @endphp

                                @if (!empty($certs))
                                    @foreach ($certs as $cert)
                                        <label class="d-flex justify-content-between bg-white p-2 mb-1">
                                            <span>{{ $cert['name'] ?? '' }}</span>

                                            <span
                                                class="{{ isset($cert['expired']) && $cert['expired'] ? 'expired' : 'text-success' }}">
                                                {{ $cert['expired'] ?? 'Valid' }}
                                            </span>
                                        </label>
                                    @endforeach
                                @else
                                    <span class="text-muted">No certificates recorded.</span>
                                @endif

                            </div>

                        </div>

                        <div class="card-footer border-top text-center d-flex justify-content-center gap-2">

                            <!-- EDIT -->
                            <a href="javascript:;" class="btn-manage editResourceBtn" data-id="{{ $resource->id }}">
                                <i class="mdi mdi-pencil-outline"></i> Edit
                            </a>

                            <!-- DELETE -->
                            <a href="javascript:;" class="btn-manage text-danger deleteResourceBtn"
                                data-id="{{ $resource->id }}">
                                <i class="mdi mdi-trash-can-outline"></i> Delete
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="text-center w-100 py-5">
                        <h5 class="text-muted">No Resources Found</h5>
                    </div>

                @endforelse

            </div>
        </div>
    </div>
    <!--begin::Modal - Add Resource-->
    <div class="modal fade" id="kt_modal_add_resources" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
        data-bs-backdrop="static">

        <div class="modal-dialog modal-lg">

            <div class="modal-content rounded">

                <!-- HEADER -->
                <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
                    <h4 class="text-center text-black">Create Resource</h4>

                    <div class="btn btn-sm btn-icon btn-active-color-primary mb-4" data-bs-dismiss="modal">
                        ✕
                    </div>
                </div>

                <!-- BODY -->
                <div class="modal-body py-5 px-10 px-xl-20">

                    <div class="row">

                        <!-- NAME -->
                        <div class="col-lg-6 mb-3">
                            <label class="fs-7 fw-semibold">Resource Name<span class="text-danger">*</span></label>
                            <input type="text" id="res_name" class="form-control" placeholder="Enter Resource Name" />
                            <div class="text-danger" id="res_name_error"></div>
                        </div>

                        <!-- MOBILE -->
                        <div class="col-lg-6 mb-3">
                            <label class="fs-7 fw-semibold">Mobile Number<span class="text-danger">*</span></label>
                            <input type="text" id="res_mobile" class="form-control"
                                placeholder="Enter Mobile Number" />
                            <div class="text-danger" id="res_mobile_error"></div>
                        </div>

                        <!-- EMAIL -->
                        <div class="col-lg-6 mb-3">
                            <label class="fs-7 fw-semibold">Email<span class="text-danger">*</span></label>
                            <input type="text" id="res_email" class="form-control" placeholder="Enter Email" />
                            <div class="text-danger" id="res_email_error"></div>
                        </div>

                        <!-- ROLE -->
                        <div class="col-lg-6 mb-3">
                            <label class="fs-7 fw-semibold">Role<span class="text-danger">*</span></label>
                            <select id="res_role" class="select3 form-select">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="text-danger" id="res_role_error"></div>
                        </div>

                        <!-- STATUS -->
                        <div class="col-lg-6 mb-3">
                            <label class="fs-7 fw-semibold">Status<span class="text-danger">*</span></label>
                            <select id="res_status" class="select3 form-select">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">In Active</option>
                                <option value="3">In Work</option>
                            </select>
                            <div class="text-danger" id="res_status_error"></div>
                        </div>

                        <!-- ADDRESS -->
                        <div class="col-lg-6 mb-3">
                            <label class="fs-7 fw-semibold">Address</label>
                            <textarea class="form-control" id="res_address" rows="1" placeholder="Enter Address"></textarea>
                        </div>

                        <!-- DOCUMENT HEADER -->
                        <div class="col-lg-12 mb-2 d-flex justify-content-between align-items-center">
                            <label class="fw-semibold fs-6">Certificates & Permit Document</label>

                            <a href="javascript:;" class="btn btn-sm btn-primary" id="add_document">
                                + Add Document
                            </a>
                        </div>

                        <!-- DOCUMENT CONTAINER -->
                        <div class="document_container scroll-y max-h-400px" style="overflow-x:hidden;">

                            <!-- DOCUMENT ROW -->
                            <div class="document-row col-lg-12 mb-3 border rounded p-3">

                                <div class="row">

                                    <div class="col-lg-10">

                                        <div class="row">

                                            <!-- DOCUMENT NAME -->
                                            <div class="col-lg-6 mb-2">
                                                <label class="fs-7 fw-semibold">
                                                    Document Name<span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="doc_name[]" class="form-control"
                                                    placeholder="Enter Document Name">
                                                <div class="text-danger doc-name-error"></div>
                                            </div>

                                            <!-- VALIDITY DATE -->
                                            <div class="col-lg-6 mb-2">
                                                <label class="fs-7 fw-semibold">
                                                    Validity Date<span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="mdi mdi-calendar-month-outline"></i>
                                                    </span>
                                                    <input type="text" name="doc_date[]"
                                                        class="form-control common_datepicker" placeholder="Select Date">
                                                </div>
                                                <div class="text-danger doc-date-error"></div>
                                            </div>

                                            <!-- DROPZONE FILE UPLOAD UI -->
                                            <div class="col-lg-12 mb-2">

                                                <label class="fs-7 fw-semibold">
                                                    Attachment<span class="text-danger">*</span>
                                                </label>

                                                <div
                                                    class="dropzone-style border rounded p-3 text-center position-relative">

                                                    <i class="mdi mdi-cloud-upload-outline fs-2 text-primary"></i>

                                                    <div class="mt-1 small text-muted">
                                                        Drop file here or click to upload
                                                    </div>

                                                    <input type="file" name="doc_file[]"
                                                        class="form-control position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                                        style="cursor:pointer;">
                                                </div>

                                                <div class="text-danger doc-file-error"></div>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- DELETE BUTTON -->
                                    <div class="col-lg-2 d-flex align-items-center justify-content-center">

                                        <button type="button" class="btn btn-sm btn-danger delete-row"
                                            style="display:none;">
                                            <i class="mdi mdi-trash-can-outline fs-5"></i>
                                        </button>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer pt-5">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" id="submit_resource">Create Resource</button>
                </div>

            </div>

        </div>

    </div>
    <!--end::Modal-->
    <!-- BULK UPLOAD MODAL -->
    <div class="modal fade" id="bulkUploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">

            <div class="modal-content">

                <!-- HEADER -->
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Upload Resources</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- FORM -->
                <form id="bulkUploadForm" enctype="multipart/form-data">

                    @csrf

                    <!-- BODY -->
                    <div class="modal-body">

                        <!-- ALERT MESSAGE AREA -->
                        <div id="bulkUploadAlert"></div>

                        <!-- FILE UPLOAD -->
                        <div class="mb-3">
                            <label class="form-label">Upload Excel File</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>
                        </div>

                        <!-- DOWNLOAD SAMPLE -->
                        <div class="mb-3">
                            <a href="{{ asset('dummy_resources.xlsx') }}" class="btn btn-sm btn-outline-primary" download>
                                Download Sample Excel
                            </a>
                        </div>

                        <!-- INFO -->
                        <div class="alert alert-info">
                            <strong>Format:</strong><br>
                            name | mobile | email | role_id | status | address | cert_name | cert_date | cert_file
                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-success" id="uploadBtn">
                            Upload
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
    <!--begin::Modal - Edit Resource-->
    <div class="modal fade" id="kt_modal_edit_resources" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded">

                <!-- HEADER -->
                <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
                    <h4 class="text-center text-black">Edit Resource</h4>
                    <div class="btn btn-sm btn-icon btn-active-color-primary mb-4" data-bs-dismiss="modal">✕</div>
                </div>

                <!-- BODY -->
                <div class="modal-body py-5 px-10 px-xl-20">

                    <input type="hidden" id="edit_res_id">

                    <div class="row">

                        <!-- NAME -->
                        <div class="col-lg-6 mb-3">
                            <label class="fs-7 fw-semibold">Resource Name<span class="text-danger">*</span></label>
                            <input type="text" id="edit_res_name" class="form-control">
                            <div class="text-danger" id="edit_res_name_error"></div>
                        </div>

                        <!-- MOBILE -->
                        <div class="col-lg-6 mb-3">
                            <label class="fs-7 fw-semibold">Mobile Number<span class="text-danger">*</span></label>
                            <input type="text" id="edit_res_mobile" class="form-control">
                            <div class="text-danger" id="edit_res_mobile_error"></div>
                        </div>

                        <!-- EMAIL -->
                        <div class="col-lg-6 mb-3">
                            <label class="fs-7 fw-semibold">Email<span class="text-danger">*</span></label>
                            <input type="text" id="edit_res_email" class="form-control">
                            <div class="text-danger" id="edit_res_email_error"></div>
                        </div>

                        <!-- ROLE -->
                        <div class="col-lg-6 mb-3">
                            <label class="fs-7 fw-semibold">Role</label>
                            <select id="edit_res_role" class="form-select">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- STATUS -->
                        <div class="col-lg-6 mb-3">
                            <label class="fs-7 fw-semibold">Status</label>
                            <select id="edit_res_status" class="form-select">
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                                <option value="3">In Work</option>
                            </select>
                        </div>

                        <!-- ADDRESS -->
                        <div class="col-lg-6 mb-3">
                            <label class="fs-7 fw-semibold">Address</label>
                            <textarea id="edit_res_address" class="form-control"></textarea>
                        </div>

                        <!-- DOCUMENT HEADER -->
                        <div class="col-lg-12 mb-2 d-flex justify-content-between align-items-center">
                            <label class="fw-semibold fs-6">Certificates & Permit Document</label>
                            <a href="javascript:;" class="btn btn-sm btn-primary" id="edit_add_document">+ Add
                                Document</a>
                        </div>

                        <!-- DOCUMENT CONTAINER (SAME AS CREATE) -->
                        <div class="edit_document_container scroll-y max-h-400px" style="overflow-x:hidden;"></div>

                    </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer pt-5">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" id="update_resource">Update Resource</button>
                </div>

            </div>
        </div>
    </div>
    <!--end::Modal-->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#bulkUploadForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                // RESET ALERT
                $('#bulkUploadAlert').html('');

                $.ajax({
                    url: "{{ route('resources.bulkUpload') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    beforeSend: function() {

                        toastr.info("Uploading...");

                        // BUTTON LOADING
                        $('#uploadBtn')
                            .prop('disabled', true)
                            .html(
                                '<span class="spinner-border spinner-border-sm"></span> Uploading...'
                            );
                    },

                    success: function(res) {

                        $('#uploadBtn')
                            .prop('disabled', false)
                            .html('Upload');

                        if (res.status) {

                            toastr.success(res.message);

                            // SHOW SUCCESS INSIDE MODAL
                            $('#bulkUploadAlert').html(
                                `<div class="alert alert-success">${res.message}</div>`
                            );

                            // reset form
                            $('#bulkUploadForm')[0].reset();

                            // close modal after 1.5 sec
                            setTimeout(() => {
                                $('#bulkUploadModal').modal('hide');
                            }, 1500);

                        } else {

                            toastr.error(res.message);

                            // SHOW ERROR INSIDE MODAL
                            $('#bulkUploadAlert').html(
                                `<div class="alert alert-danger">${res.message}</div>`
                            );
                        }
                    },

                    error: function(xhr) {

                        $('#uploadBtn')
                            .prop('disabled', false)
                            .html('Upload');

                        let msg = "Something went wrong";

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }

                        toastr.error(msg);

                        // SHOW ERROR INSIDE MODAL
                        $('#bulkUploadAlert').html(
                            `<div class="alert alert-danger">${msg}</div>`
                        );
                    }
                });

            });

        });
    </script>
    <script>
        $(document).ready(function() {

            // =========================
            // ADD DOCUMENT ROW (CREATE)
            // =========================
            $(document).on("click", "#add_document", function() {
                let clone = $(".document-row:first").clone();

                clone.find("input").val("");
                clone.find("input[type='file']").val("");
                clone.find(".text-danger").html("");

                clone.find(".delete-row").show();

                $(".document_container").append(clone);
            });

            // DELETE ROW (CREATE)
            $(document).on("click", ".delete-row", function() {
                $(this).closest(".document-row").remove();
            });

            // =========================
            // CREATE RESOURCE
            // =========================
            $("#submit_resource").off("click").on("click", function() {

                let valid = true;
                $(".text-danger").html("");

                let name = $("#res_name").val().trim();
                let mobile = $("#res_mobile").val().trim();
                let email = $("#res_email").val().trim();
                let role = $("#res_role").val();
                let status = $("#res_status").val();

                if (!name) {
                    $("#res_name_error").html("Required");
                    valid = false;
                }
                if (!mobile) {
                    $("#res_mobile_error").html("Required");
                    valid = false;
                }
                if (!email) {
                    $("#res_email_error").html("Required");
                    valid = false;
                }
                if (!role) {
                    $("#res_role_error").html("Required");
                    valid = false;
                }
                if (!status) {
                    $("#res_status_error").html("Required");
                    valid = false;
                }

                // DOCUMENT VALIDATION
                $(".document-row").each(function() {

                    let dName = $(this).find("input[name='doc_name[]']").val().trim();
                    let dDate = $(this).find("input[name='doc_date[]']").val().trim();
                    let dFileLength = $(this).find("input[name='doc_file[]']")[0].files.length;

                    if (dName === "" && dDate === "" && dFileLength === 0) {
                        return; // Skip completely empty rows
                    }

                    if (dName === "") {
                        $(this).find(".doc-name-error").html("Required");
                        valid = false;
                    }

                    if (dDate === "") {
                        $(this).find(".doc-date-error").html("Required");
                        valid = false;
                    }

                    if (dFileLength === 0) {
                        $(this).find(".doc-file-error").html("Required");
                        valid = false;
                    }
                });

                if (!valid) return;

                let formData = new FormData();
                formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

                formData.append("name", name);
                formData.append("mobile_number", mobile);
                formData.append("email", email);
                formData.append("role_id", role);
                formData.append("status", status);
                formData.append("address", $("#res_address").val());

                $(".document-row").each(function(index) {

                    let docName = $(this).find("input[name='doc_name[]']").val().trim();
                    let docDate = $(this).find("input[name='doc_date[]']").val().trim();
                    let docFile = $(this).find("input[name='doc_file[]']")[0].files[0];

                    if (docName === "" && docDate === "" && !docFile) return;

                    formData.append(`doc_name[${index}]`, docName);
                    formData.append(`doc_date[${index}]`, docDate);

                    if (docFile) {
                        formData.append(`doc_file[${index}]`, docFile);
                    }
                });

                $.ajax({
                    url: "/resources/store",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status) {
                            toastr.success(res.message);
                            $("#kt_modal_add_resources").modal("hide");
                            location.reload();
                        }
                    },
                    error: function(err) {
                        toastr.error(err.responseText);
                    }
                });
            });


            // =========================
            // OPEN EDIT MODAL (GET DATA)
            // =========================
            $(document).on("click", ".editResourceBtn", function() {

                let id = $(this).data("id");

                $.get("/resources/show/" + id, function(res) {

                    if (res.status) {

                        let data = res.data;

                        $("#edit_res_id").val(data.id);
                        $("#edit_res_name").val(data.name);
                        $("#edit_res_mobile").val(data.mobile_number);
                        $("#edit_res_email").val(data.email);
                        $("#edit_res_role").val(data.role_id);
                        $("#edit_res_status").val(data.status);
                        $("#edit_res_address").val(data.address);

                        $(".edit_document_container").html("");

                        if (data.certificates && data.certificates.length > 0) {
                            data.certificates.forEach(doc => {
                                $(".edit_document_container").append(createEditRow(doc));
                            });
                        } else {
                            $(".edit_document_container").append(createEditRow());
                        }

                        $("#kt_modal_edit_resources").modal("show");
                    }
                });
            });


            // =========================
            // ADD DOCUMENT (EDIT)
            // =========================
            $(document).on("click", "#edit_add_document", function() {
                $(".edit_document_container").append(createEditRow());
            });


            // DELETE ROW (EDIT)
            $(document).on("click", ".edit_delete_row", function() {
                $(this).closest(".document-row").remove();
            });


            // =========================
            // UPDATE RESOURCE
            // =========================
            $("#update_resource").off("click").on("click", function() {

                let id = $("#edit_res_id").val();

                let formData = new FormData();

                formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

                formData.append("name", $("#edit_res_name").val());
                formData.append("mobile_number", $("#edit_res_mobile").val());
                formData.append("email", $("#edit_res_email").val());
                formData.append("role_id", $("#edit_res_role").val());
                formData.append("status", $("#edit_res_status").val());
                formData.append("address", $("#edit_res_address").val());

                $(".edit_document_container .document-row").each(function(i) {

                    let docName = $(this).find(".edit_doc_name").val().trim();
                    let docDate = $(this).find(".edit_doc_date").val().trim();
                    let file = $(this).find(".edit_doc_file")[0].files[0];
                    let oldFile = $(this).find(".edit_old_doc_file").val() || "";

                    if (docName === "" && docDate === "" && !file && oldFile === "") return;

                    formData.append(`doc_name[${i}]`, docName);
                    formData.append(`doc_date[${i}]`, docDate);

                    if (file) {
                        formData.append(`doc_file[${i}]`, file);
                    }
                    
                    formData.append(`old_doc_file[${i}]`, oldFile);
                });

                $.ajax({
                    url: "/resources/update/" + id,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(res) {
                        if (res.status) {
                            toastr.success(res.message);
                            $("#kt_modal_edit_resources").modal("hide");
                            location.reload();
                        } else {
                            toastr.success(res.message);
                        }
                    },

                    error: function(err) {
                        toastr.error(err.responseText);
                    }
                });
            });


            // =========================
            // EDIT ROW TEMPLATE
            // =========================
            function createEditRow(doc = {}) {

                return `
    <div class="document-row col-lg-12 mb-3 border rounded p-3">

        <div class="row">

            <div class="col-lg-10">

                <div class="row">

                    <!-- DOCUMENT NAME -->
                    <div class="col-lg-6 mb-2">
                        <label class="fs-7 fw-semibold">
                            Document Name<span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            name="doc_name[]"
                            class="form-control edit_doc_name"
                            value="${doc.name ?? ''}"
                            placeholder="Enter Document Name">

                        <div class="text-danger doc-name-error"></div>
                    </div>

                    <!-- VALIDITY DATE (SAME UI) -->
                    <div class="col-lg-6 mb-2">
                        <label class="fs-7 fw-semibold">
                            Validity Date<span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="mdi mdi-calendar-month-outline"></i>
                            </span>

                            <input type="text"
                                name="doc_date[]"
                                class="form-control common_datepicker edit_doc_date"
                                value="${doc.validity_date ?? ''}"
                                placeholder="Select Date">
                        </div>

                        <div class="text-danger doc-date-error"></div>
                    </div>

                    <!-- FILE UPLOAD (SAME DROPZONE UI) -->
                    <div class="col-lg-12 mb-2">

                        <label class="fs-7 fw-semibold">
                            Attachment<span class="text-danger">*</span>
                        </label>

                        <div class="dropzone-style border rounded p-3 text-center position-relative">

                            <i class="mdi mdi-cloud-upload-outline fs-2 text-primary"></i>

                            <div class="mt-1 small text-muted">
                                Drop file here or click to upload
                            </div>

                            ${doc.file ? `
                                <div class="mt-2 mb-2 d-flex justify-content-center gap-2" style="position:relative; z-index:10;">
                                    <a href="/${doc.file}" target="_blank" class="btn btn-sm btn-outline-primary px-2 py-1">
                                        <i class="mdi mdi-eye-outline me-1"></i> View
                                    </a>
                                    <a href="/${doc.file}" download class="btn btn-sm btn-primary px-2 py-1">
                                        <i class="mdi mdi-download-outline me-1"></i> Download
                                    </a>
                                </div>
                            ` : ''}
                            <input type="hidden" class="edit_old_doc_file" value="${doc.file ?? ''}">

                            <input type="file"
                                name="doc_file[]"
                                class="form-control position-absolute top-0 start-0 w-100 h-100 opacity-0 edit_doc_file"
                                style="cursor:pointer;">
                        </div>

                        <div class="text-danger doc-file-error"></div>

                    </div>

                </div>

            </div>

            <!-- DELETE BUTTON -->
            <div class="col-lg-2 d-flex align-items-center justify-content-center">

                <button type="button" class="btn btn-sm btn-danger edit_delete_row">
                    <i class="mdi mdi-trash-can-outline fs-5"></i>
                </button>

            </div>

        </div>
    </div>
    `;
            }

        });
    </script>
    <script>
        $(document).ready(function() {

            // ADD DOCUMENT ROW
            $("#add_document").click(function() {

                let clone = $(".document-row:first").clone();

                clone.find("input").val("");
                clone.find("input[type='file']").val("");
                clone.find(".text-danger").html("");

                clone.find(".delete-row").show();

                $(".document_container").append(clone);
            });

            // DELETE ROW
            $(document).on("click", ".delete-row", function() {
                $(this).closest(".document-row").remove();
            });

            // =========================
            // SEARCH FILTER
            // =========================
            $("#customSearchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                
                $(".resource-grid .resource-card").filter(function() {
                    let cardText = $(this).text().toLowerCase();
                    $(this).toggle(cardText.indexOf(value) > -1);
                });
            });

        });



    </script>
@endsection

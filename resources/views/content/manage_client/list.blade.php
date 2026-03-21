@extends('layouts/layoutMaster')

@section('title', 'Manage Client')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/dropzone/dropzone.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/nouislider/nouislider.js', 'resources/assets/vendor/libs/jquery-repeater/jquery-repeater.js', 'resources/assets/vendor/js/dropdown-hover.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/forms_date_time_pickers.js'])
@endsection
@section('content')


    <!-- Lead List Table -->
    <div class="card card-action">
        <div class="card-header pb-1">
            <div class="card-action-title">
                <h3 class="card-title mb-1">Manage Client</h3>
            </div>
            <div class="card-action-element">
                <div class="d-flex justify-content-end align-items-center mb-2 gap-2">
                    <div class="searchBar" style="position: relative; width: 300px;">
                        <input class="form-control" type="text" id="ClientSearchInput" placeholder="Search Client Name"
                            style="padding-left: 35px;" />
                        <svg style="width:20px;height:20px;position:absolute;left:10px;top:50%;transform:translateY(-50%);fill:#0076b6;"
                            viewBox="0 0 24 24">
                            <path d="M9.5,3A6.5,6.5 0 0,1 16,9.5
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
                    <!-- <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary-outline border border-primary text-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_bulk_upload">
                            <span class="me-2"><i class="mdi mdi-tray-arrow-up"></i></span>Bulk Upload
                        </a> -->
                    <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_add_client">
                        <span class="me-2"><i class="mdi mdi-plus"></i></span>Add Client
                    </a>
                </div>
            </div>
        </div>
        @php
            $helper = new \App\Helpers\Helpers();
            $current_date = date('Y-m-d');
        @endphp
        <div class="card-body">
            <div class="row">
                @if (count($lists) > 0)
                    @foreach ($lists as $list)
                        @php
                            $client_status = isset($list->status) && !empty($list->status) ? $list->status : null;
                            $sector_data =
                                isset($list->sector_data) && !empty($list->sector_data) ? $list->sector_data : [];

                            $encryptedValue = $list->id;
                        @endphp
                        <div class="col-lg-3 client-card">
                            <div class="p-3 rounded border d-flex flex-column bg-white">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="rounded p-3" style="background:#f3e5f5; color:#4a148c; ">
                                            <i class="mdi mdi-office-building fs-3"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <label
                                                class="text-black fw-semibold fs-6">{{ isset($list->company_name) && !empty($list->company_name) ? ucfirst($list->company_name) : '-' }}</label>
                                            @if ($client_status == 0)
                                                <label class="badge bg-label-success fw-semibold fs-8"
                                                    style="width:fit-content;">Active</label>
                                            @elseif($client_status == 1)
                                                <label class="badge bg-label-secondary fw-semibold fs-8"
                                                    style="width:fit-content;">Inactive</label>
                                            @endif
                                        </div>
                                    </div>
                                    <a class="btn btn-icon btn-sm p-0 me-2" id="" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical fs-3 text-black"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_edit_client"
                                            onclick="edit_client_details('{{ $encryptedValue }}')">
                                            <span><i class="mdi mdi-pencil-outline fs-3 text-black me-1"></i></span>
                                            <span>Edit</span>
                                        </a>
                                        <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_delete_client"
                                            onclick="deleteFetch('{{ $encryptedValue }}', '{{ $list->company_name }}')">
                                            <span><i class="mdi mdi-trash-can-outline fs-3 text-black me-1"></i></span>
                                            <span>Delete</span>
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex flex-column gap-1">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mdi mdi-email-outline text-secondary"></span>
                                        <label
                                            class="text-dark fs-7 fw-semibold">{{ isset($list->email_id) && !empty($list->email_id) ? $list->email_id : '-' }}</label>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mdi mdi-phone-outline text-secondary"></span>
                                        <label
                                            class="text-dark fs-7 fw-semibold">{{ isset($list->mobile_no) && !empty($list->mobile_no) ? $list->mobile_no : '-' }}</label>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ isset($list->location) && !empty($list->location) ? $list->location : '-' }}"
                                            target="_blank"><span
                                                class="mdi mdi-map-marker-outline text-secondary"></span></a>
                                        <label
                                            class="text-dark fs-7 fw-semibold">{{ isset($list->address) && !empty($list->address) ? $list->address : '-' }}</label>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <!-- <span class="mdi mdi-city text-secondary"></span> -->
                                        <div class="d-flex flex-row align-items-start justify-content-start">
                                            <div class="d-flex flex-column align-items-start justify-content-start">
                                                <div class="d-flex flex-row" style="align-items: baseline;">
                                                    <label class="fs-6 fw-semibold text-black"><i
                                                            class="mdi mdi-account-outline text-secondary fs-5 me-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Position"></i></label>
                                                    <label
                                                        class="fs-7 me-2 fw-bold">{{ isset($sector_data[0]['client_name']) && !empty($sector_data[0]['client_name']) ? $sector_data[0]['client_name'] : '-' }}</label>
                                                </div>
                                                <div class="d-flex flex-row" style="align-items: baseline;">
                                                    <label class="fs-6 fw-semibold text-black"><i
                                                            class="mdi mdi-domain text-secondary fs-5 me-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Company Name"></i></label>
                                                    <label class="text-dark rounded fw-bold fs-7"
                                                        style="white-space: nowrap;"
                                                        title="">{{ isset($sector_data[0]['sector_name']) && !empty($sector_data[0]['sector_name']) ? $sector_data[0]['sector_name'] : '-' }}</label>
                                                </div>
                                            </div>
                                            @if (!empty($sector_data) && count($sector_data) > 0)
                                                <a href="javascript:;" class="dropdown-toggle hide-arrow px-2"
                                                    data-bs-toggle="dropdown" data-trigger="hover">
                                                    <div class="badge bg-label-primary fs-8 px-2 py-2 text-center">
                                                        +{{ count($sector_data) - 1 ?? '0' }}<br>more</div>
                                                </a>
                                                <div class="dropdown-menu py-4 px-4 text-black scroll-y w-300px"
                                                    style="max-height: 250px; overflow-y: auto;overflow-x: hidden;">
                                                    @php
                                                        $hr_sno = 1;
                                                    @endphp
                                                    @foreach ($sector_data as $hr_index => $option_data)
                                                        @if ($hr_index > 0)
                                                            @php
                                                                $place_reasons_his_count = count($sector_data) - 1 ?? 0;
                                                            @endphp
                                                            <div
                                                                class="d-flex flex-column align-items-start justify-content-start">
                                                                <div class="d-flex flex-row"
                                                                    style="align-items: baseline;">
                                                                    <label class="fs-6 fw-semibold text-black"><i
                                                                            class="mdi mdi-account-outline text-black fs-5 me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-placement="bottom"
                                                                            title="Position"></i></label>
                                                                    <label class="text-dark rounded fw-bold fs-7"
                                                                        style="white-space: nowrap;"
                                                                        title="">{{ isset($option_data['client_name']) && !empty($option_data['client_name']) ? $option_data['client_name'] : '-' }}</label>
                                                                </div>
                                                                <div class="d-flex flex-row"
                                                                    style="align-items: baseline;">
                                                                    <label class="fs-6 fw-semibold text-black"><i
                                                                            class="mdi mdi-domain text-black fs-5 me-1"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-placement="bottom"
                                                                            title="Company Name"></i></label>
                                                                    <label class="text-dark rounded fw-bold fs-7"
                                                                        style="white-space: nowrap;"
                                                                        title="">{{ isset($option_data['sector_name']) && !empty($option_data['sector_name']) ? $option_data['sector_name'] : '-' }}</label>
                                                                </div>
                                                            </div>
                                                            @if ($hr_sno != $place_reasons_his_count)
                                                                <hr class="bg-gray-400">
                                                            @endif
                                                            @php $hr_sno++; @endphp
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="text-center py-5">
                                                    <i class="mdi mdi-monitor-dashboard fs-1 text-muted"></i>
                                                    <h5 class="mt-3 text-muted">No monitoring data available</h5>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="empty-state" id="noDataMessage" style="display:none">
                        <div class="empty-box">
                            <div class="empty-icon">
                                <i class="fa fa-user-times"></i>
                            </div>
                            <div class="empty-title">Client Not Found</div>
                            <div class="empty-text">
                                No client records available. Please add a new client to get started.
                            </div>
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-box">
                            <div class="empty-icon">
                                <i class="fa fa-user-times"></i>
                            </div>
                            <div class="empty-title">Client Not Found</div>
                            <div class="empty-text">
                                No client records available. Please add a new client to get started.
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>


    <!--begin::Modal - Bulk Upload-->
    <div class="modal fade" id="kt_modal_bulk_upload" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
        data-bs-backdrop="static" data-bs-focus="false">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-md">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
                    <h4 class="text-center text-black">Bulk Upload Resouces</h4>
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
                        <div class="dropzone needsclick">
                            <div class="dz-message fs-6">
                                <div class="text-center text-black">
                                    Drop files here or click to upload
                                </div>
                            </div>
                            <div class="fallback">
                                <input type="file" name="attachment[]" multiple class="required-field" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-5">
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Upload</button>
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Bulk Upload-->


    <!--begin::Modal - Add Client-->
    <div class="modal fade" id="kt_modal_add_client" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
        data-bs-backdrop="static" data-bs-focus="false">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
                    <h4 class="text-center text-black">Create Client</h4>
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
                    <form method="POST" id="add_gen_settings_form" action="{{ route('add_manage_client') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Company Name<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="company_name"
                                    placeholder="Enter Company Name" id="add_company_name" />
                                <div id="add_company_name_error"></div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Mobile Number<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="mob_no"
                                    placeholder="Enter Mobile Number" id="add_mob_no" />
                                <div id="add_mob_no_error"></div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Email<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="email_id" placeholder="Enter Email"
                                    id="add_email_id" />
                                <div id="add_email_id_error"></div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Location URL</label>
                                <input type="text" class="form-control" name="location"
                                    placeholder="Enter Location URL" id="add_location" />
                                <div id="add_location_error"></div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Address</label>
                                <textarea class="form-control" rows="1" name="address" placeholder="Enter Address" id="add_address"></textarea>
                                <div id="add_address_error"></div>
                            </div>
                            <!-- <div class="col-lg-6 mb-3" >
                                <label class="text-black mb-1 fs-7 fw-semibold">Status<span class="text-danger">*</span></label>
                                <select class="select3 form-select" id="add_status">
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="2">In Active</option>
                                </select>
                            </div>     -->
                            <div class="col-lg-12 d-flex align-items-center justify-content-between gap-5">
                                <label class="text-black mb-1 fs-7 fw-semibold">Clients & Sector</label>
                                <a href="javascript:;"
                                    class="btn btn-sm btn-primary-outline text-primary border border-primary"
                                    id="add_more_client" onclick="addMoresector()">
                                    <i class="mdi mdi-plus fs-5 text-primary"></i> Add Client
                                </a>
                            </div>

                            <div class="client_container">
                                <input type="hidden" id="add_more_client_count" value="1">
                                <div class="client-row col-lg-12 mb-2 scroll-y max-h-400px" style="overflow-x: hidden;"
                                    id="add_client_row_div">

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer pt-5">
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="AddvalidateForm_topics()">Create
                            Client</button>
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add Client-->



    <!--begin::Modal - Update Client-->
    <div class="modal fade" id="kt_modal_edit_client" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
        data-bs-backdrop="static" data-bs-focus="false">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
                    <h4 class="text-center text-black">Update Client</h4>
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
                    <form method="POST" id="update_gen_settings_form" action="{{ route('update_manage_client') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="update_sno" id="update_sno">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Company Name<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Company Name"
                                    name="company_name" id="update_company_name" />
                                <div id="update_company_name_error"></div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Mobile Number<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Mobile Number"
                                    name="mob_no" id="update_mob_no" />
                                <div id="update_mob_no_error"></div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Email<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Email" name="email_id"
                                    id="update_email_id" />
                                <div id="update_email_id_error"></div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Location URL</label>
                                <input type="text" class="form-control" placeholder="Enter Location URL"
                                    name="location" id="update_location" />
                                <div id="update_location_error"></div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Address</label>
                                <textarea class="form-control" rows="1" placeholder="Enter Address" name="address" id="update_address"></textarea>
                                <div id="update_address_error"></div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Status<span
                                        class="text-danger">*</span></label>
                                <select class="select3 form-select" name="status" id="update_status">
                                    <option value="">Select Status</option>
                                    <option value="0">Active</option>
                                    <option value="1">In Active</option>
                                </select>
                                <div id="update_status_error"></div>
                            </div>
                            <div class="col-lg-12 d-flex align-items-center justify-content-between gap-5">
                                <label class="text-black mb-1 fs-7 fw-semibold">Clients & Sector</label>
                                <a href="javascript:;"
                                    class="btn btn-sm btn-primary-outline text-primary border border-primary"
                                    id="update_more_client" onclick="UpdateMoresector()">
                                    <i class="mdi mdi-plus fs-5 text-primary"></i> Add Client
                                </a>
                            </div>

                            <div class="client_container">
                                <input type="hidden" id="update_more_client_count" value="1">
                                <div class="client-row col-lg-12 mb-2 scroll-y max-h-400px" style="overflow-x: hidden;"
                                    id="update_client_row_div">

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer pt-5">
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="update_training_btn"
                            onclick="UpdatevalidateForm_topics()">Update Client</button>
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Update Client-->


    <!--begin::Modal - Delete Client-->
    <div class="modal fade pt-20" id="kt_modal_delete_client" tabindex="-1" aria-hidden="true" aria-hidden="true"
        data-bs-keyboard="false" data-bs-backdrop="static">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-m">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <div class="swal2-icon swal2-danger swal2-icon-show" style="display: flex;">
                    <div class="swal2-icon-content">
                        <img src="{{ asset('assets/images/dustbin.ico') }}" alt="Dustbin Icon"
                            class="w-100px h-100px" />
                    </div>
                </div>
                <div class="swal2-html-container" id="swal2-html-container" style="display: block;">
                    <div class="d-block fw-bold fs-5 py-2">
                        <label id="delete_message"></label>
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center gap-3 pt-8">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">No,cancel</button>
                    <button type="button" class="btn btn-danger" onclick="deleteAppointmentReason()">Yes,
                        delete!</button>
                </div><br><br>
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Delete Client-->


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <style>
        /* Customize Toastr container */
        .toast {
            background-color: #39484f;
        }

        /* Customize Toastr notification */
        .toast-success {
            background-color: green;
        }

        /* Customize Toastr notification */
        .toast-error {
            background-color: red;
        }
    </style>

    <script>
        // Display Toastr messages
        @if (Session::has('toastr'))
            var type = "{{ Session::get('toastr')['type'] }}";
            var message = "{{ Session::get('toastr')['message'] }}";
            toastr[type](message);
        @endif
    </script>

    <script>
        // $(document).ready(function(){

        //     function initSelect2(element){
        //         element.find(".select3").select2({
        //             width: "100%",
        //             dropdownParent: $("#kt_modal_add_client")
        //         });
        //     }

        //     initSelect2($(document));

        //     $("#add_client").click(function(){

        //         var clone = $(".client-row:first").clone();

        //         clone.find("input").val("");
        //         clone.find("select").val("").removeClass("select2-hidden-accessible").next(".select2").remove();

        //         clone.find(".delete-row").show();

        //         clone.appendTo(".client_container");
        //         initSelect2(clone);
        //     });

        //     $(document).on("click",".delete-row",function(){
        //         $(this).closest(".client-row").remove();
        //     });

        // });
    </script>

    <script>
        // $(document).ready(function(){

        //     function initSelect2(element){
        //         element.find(".select3").select2({
        //             width: "100%",
        //             dropdownParent: $("#kt_modal_edit_client")
        //         });
        //     }

        //     initSelect2($(document));

        //     $("#edit_client").click(function(){

        //         var clone = $(".client-row:first").clone();

        //         clone.find("input").val("");
        //         clone.find("select").val("").removeClass("select2-hidden-accessible").next(".select2").remove();

        //         clone.find(".delete-row").show();

        //         clone.appendTo(".client_container");
        //         initSelect2(clone);
        //     });

        //     $(document).on("click",".delete-row",function(){
        //         $(this).closest(".client-row").remove();
        //     });

        // });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('input', '[id^="add_mob_no"]', function() {
                this.value = this.value.replace(/\D/g, '');
            });

            $("#ClientSearchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                var visibleCount = 0;

                $(".client-card").filter(function() {
                    let cardText = $(this).text().toLowerCase();
                    let match = cardText.indexOf(value) > -1;

                    $(this).toggle(match);

                    if (match) {
                        visibleCount++;
                    }
                });

                // Show / Hide No Data Message
                if (visibleCount === 0) {
                    $("#noDataMessage").show();
                } else {
                    $("#noDataMessage").hide();
                }
            });

        });


        addMoresector();

        function addMoresector() {

            var add_more_client_count = $(`#add_more_client_count`).val();
            console.log(add_more_client_count);
            var add_more_client_incre = parseInt(add_more_client_count) + 1;

            var appent_add_html = `<div class="row" id="add_more_row_id_${add_more_client_count}">
        <input type="hidden" class="add_more_row_code" value="${add_more_client_count}">
        <div class="col-lg-10">
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label class="text-black mb-1 fs-7 fw-semibold">Client Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Client Name" name="sector_details[${add_more_client_count}][client_name]" id="add_more_client_name_${add_more_client_count}" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Industry Sector<span class="text-danger">*</span></label>
                    <select class="form-select sector_select" name="sector_details[${add_more_client_count}][industry_id]" id="add_more_industry_id_${add_more_client_count}">
                        <option value="">Select Industry Sector</option>
                    </select>
                    <div id="add_more_industry_id_${add_more_client_count}_error"></div>
                </div>
            </div>
        </div>`;

            if (parseInt(add_more_client_count) > 1) {
                appent_add_html += `<div class="col-lg-2 mb-3 d-flex align-items-center">
                    <label class="text-black mb-1 fs-7 fw-semibold">&nbsp;&nbsp;</label>
                    <button class="btn btn-danger-outline border border-danger text-danger btn-sm" onclick="AddDeleteRow(${add_more_client_count})" style="display:none;">
                        <i class="mdi mdi-trash-can-outline fs-4 text-danger"></i>
                    </button>
                </div>`;
            }

            appent_add_html += `</div>`;

            $('#add_client_row_div').append(appent_add_html);

            // $(".select3").each(function() {
            //     if ($(this).hasClass('select2-hidden-accessible')) {
            //         $(this).select2('destroy');
            //     }
            //     $(this).select2({
            //         // Add your Select2 options here
            //     });
            // });
            get_sector_list(`add_more_industry_id_${add_more_client_count}`);
            $('#add_more_client_count').val(add_more_client_incre);
        }

        function AddDeleteRow(row_id) {
            $(`#add_more_row_id_${row_id}`).remove();
        }

        function UpdateMoresector() {

            var update_more_client_count = $(`#update_more_client_count`).val();

            var update_more_client_incre = parseInt(update_more_client_count) + 1;

            var appent_update_html = `<div class="row" id="update_more_row_id_${update_more_client_count}">
        <input type="hidden" class="update_more_row_code" value="${update_more_client_count}">
        <div class="col-lg-10">
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <label class="text-black mb-1 fs-7 fw-semibold">Client Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Client Name" name="sector_details[${update_more_client_count}][client_name]" id="update_more_client_name_${update_more_client_count}" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Industry Sector<span class="text-danger">*</span></label>
                    <select class="form-select sector_select" name="sector_details[${update_more_client_count}][industry_id]" id="update_more_industry_id_${update_more_client_count}">
                        <option value="">Select Industry Sector</option>
                    </select>
                    <div id="update_more_industry_id_${update_more_client_count}_error"></div>
                </div>
            </div>
        </div>`;

            if (parseInt(update_more_client_count) > 1) {
                appent_update_html += `<div class="col-lg-2 mb-3 d-flex align-items-center">
                    <label class="text-black mb-1 fs-7 fw-semibold">&nbsp;&nbsp;</label>
                    <button class="btn btn-danger-outline border border-danger text-danger btn-sm" onclick="UpdateDeleteRow(${update_more_client_count})" style="display:none;">
                        <i class="mdi mdi-trash-can-outline fs-4 text-danger"></i>
                    </button>
                </div>`;
            }

            appent_update_html += `</div>`;

            $('#update_client_row_div').append(appent_update_html);

            // $(".select3").each(function() {
            //     if ($(this).hasClass('select2-hidden-accessible')) {
            //         $(this).select2('destroy');
            //     }
            //     $(this).select2({
            //         // update your Select2 options here
            //     });
            // });
            get_sector_list(`update_more_industry_id_${update_more_client_count}`);
            $('#update_more_client_count').val(update_more_client_incre);
        }

        function UpdateDeleteRow(row_id) {
            $(`#update_more_row_id_${row_id}`).remove();
        }

        function get_sector_list(field_id = '', select_val = '') {
            $.ajax({
                url: "{{ url('/settings/sector/sector_list') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status === 200 && response.data) {
                        var selectDropdown = $(`#${field_id}`);
                        selectDropdown.empty();
                        selectDropdown.append($(
                            '<option value="">Select Sector</option>'));
                        response.data.forEach(function(dept) {
                            selectDropdown.append($('<option></option>').attr('value', dept.id).text(
                                dept.name));
                        });
                        selectDropdown.val(select_val).change();
                    }
                },
                error: function(error) {
                    selectDropdown.append($('<option value="">Select Sector</option>'));
                }
            });
        }

        function AddvalidateForm_topics() {

            var errorMessage = 0;
            $('.errorMessage').remove();

            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            // var urlPattern = /^https?:\/\/(www\.)?google\.com\/maps/i;

            var add_company_name = document.getElementById('add_company_name').value.trim();
            var add_mob_no = document.getElementById('add_mob_no').value.trim();
            var add_email_id = document.getElementById('add_email_id').value.trim();
            var add_location = document.getElementById('add_location').value.trim();
            var add_address = document.getElementById('add_address').value.trim();
            let add_contactMobilePairs = new Set();

            if (add_company_name === '') {
                $('#add_company_name_error').after(
                    '<div class="text-danger errorMessage mt-1">Company name is Required..!</div>');
                errorMessage = 1;
            }

            if (add_mob_no === '') {
                $('#add_mob_no_error').after('<div class="text-danger errorMessage mt-1">Mobile No is Required..!</div>');
                errorMessage = 1;
            }

            if (add_email_id === '') {
                // $('#add_email_id_error').after('<div class="text-danger errorMessage mt-1">Email ID is Required..!</div>');
                // errorMessage = 1;
            } else if (!emailPattern.test(add_email_id)) {
                $('#add_email_id_error').after(
                    `<div class="text-danger errorMessage mt-1">Please Enter valid Email ID..!</div>`);
                errorMessage = 1;
            }

            if (add_location === '') {
                $('#add_location_error').after(
                    '<div class="text-danger errorMessage mt-1">Location URL is Required..!</div>');
                errorMessage = 1;
            }

            if (add_address === '') {
                $('#add_address_error').after('<div class="text-danger errorMessage mt-1">Address is Required..!</div>');
                errorMessage = 1;
            }

            $('.add_more_row_code').each(function() {

                let val = $(this).val();
                let client_name = $(`#add_more_client_name_${val}`).val().trim();
                let industry_id = $(`#add_more_industry_id_${val}`).val().trim();

                if (!client_name) {
                    $(`#add_more_client_name_${val}`).after(
                        `<div class="text-danger errorMessage">Client Name is Required..!</div>`);
                    errorMessage = 1;
                }

                if (!industry_id || industry_id === '' || industry_id === undefined || industry_id === null) {
                    $(`#add_more_industry_id_${val}_error`).after(
                        `<div class="text-danger errorMessage">Industry is Required..!</div>`);
                    errorMessage = 1;
                }

                // Duplicate Check
                if (client_name && industry_id) {
                    let key = `${client_name.toLowerCase()}|${industry_id}`;
                    if (add_contactMobilePairs.has(key)) {
                        $(`#add_more_industry_id_${val}_error`).after(
                            `<div class="text-danger errorMessage">Duplicate Client Name & Industry Found..!</div>`
                        );
                        errorMessage = 1;
                    } else {
                        add_contactMobilePairs.add(key);
                    }
                }

            });

            if (errorMessage == 0) {
                $('#add_gen_settings_form').submit();
            } else {
                return false;
            }
        }

        async function edit_client_details(client_id) {

            if (!client_id) return;

            $('#update_training_btn').prop('disabled', true);

            try {
                const res = await fetch(`{{ url('/manage_client/edit_client') }}/${client_id}`);
                const data = await res.json();

                if (data.status !== 200) throw new Error('Failed to load data');

                const client_details = data.data ?? {};
                const sector_details = data.sector_details ?? {};

                $('#update_sno').val(client_id ?? '');
                $('#update_company_name').val(client_details.company_name ?? '');
                $('#update_mob_no').val(client_details.mobile_no ?? '');
                $('#update_email_id').val(client_details.email_id ?? '');
                $('#update_location').val(client_details.location ?? '');
                $('#update_address').val(client_details.address ?? '');
                $('#update_status').val(client_details.status ?? '').change();

                const keys = Object.keys(sector_details);

                if (keys.length > 0) {


                    $('#update_client_row_div').empty();

                    // Set the next row index (max key + 1)
                    const maxKey = Math.max(...keys.map(Number));
                    $('#update_more_client_count').val(maxKey + 1);

                    Object.entries(sector_details).forEach(([key, item]) => {

                        console.log(item);

                        var appent_update_html = `<div class="row" id="update_more_row_id_${key}">
                    <input type="hidden" class="update_more_row_code" value="${key}">
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <label class="text-black mb-1 fs-7 fw-semibold">Client Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Client Name" name="sector_details[${key}][client_name]" id="update_more_client_name_${key}" value="${item.client_name}" />
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Industry Sector<span class="text-danger">*</span></label>
                                <select class="form-select sector_select" name="sector_details[${key}][industry_id]" id="update_more_industry_id_${key}">
                                    <option value="">Select Industry Sector</option>
                                </select>
                                <div id="update_more_industry_id_${key}_error"></div>
                            </div>
                        </div>
                    </div>`;

                        if (parseInt(key) > 1) {
                            appent_update_html += `<div class="col-lg-2 mb-3 d-flex align-items-center">
                                <label class="text-black mb-1 fs-7 fw-semibold">&nbsp;&nbsp;</label>
                                <button class="btn btn-danger-outline border border-danger text-danger btn-sm" onclick="UpdateDeleteRow(${key})" style="display:none;">
                                    <i class="mdi mdi-trash-can-outline fs-4 text-danger"></i>
                                </button>
                            </div>`;
                        }

                        appent_update_html += `</div>`;

                        $('#update_client_row_div').append(appent_update_html);

                        get_sector_list(`update_more_industry_id_${key}`, item.industry_id);
                    });

                } else {
                    $('#update_more_client_count').val(1);
                    UpdateMoresector();
                }


            } catch (err) {
                console.error('Error editing client details:', err);
                alert('Failed to load client details');
            } finally {
                $('#update_training_btn').prop('disabled', false);
            }
        }

        function UpdatevalidateForm_topics() {

            var errorMessage = 0;
            $('.errorMessage').remove();

            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            // var urlPattern = /^https?:\/\/(www\.)?google\.com\/maps/i;

            var update_company_name = document.getElementById('update_company_name').value.trim();
            var update_mob_no = document.getElementById('update_mob_no').value.trim();
            var update_email_id = document.getElementById('update_email_id').value.trim();
            var update_location = document.getElementById('update_location').value.trim();
            var update_address = document.getElementById('update_address').value.trim();
            let update_contactMobilePairs = new Set();

            if (update_company_name === '') {
                $('#update_company_name_error').after(
                    '<div class="text-danger errorMessage mt-1">Company name is Required..!</div>');
                errorMessage = 1;
            }

            if (update_mob_no === '') {
                $('#update_mob_no_error').after(
                    '<div class="text-danger errorMessage mt-1">Mobile No is Required..!</div>');
                errorMessage = 1;
            }

            if (update_email_id === '') {
                // $('#update_email_id_error').after('<div class="text-danger errorMessage mt-1">Email ID is Required..!</div>');
                // errorMessage = 1;
            } else if (!emailPattern.test(update_email_id)) {
                $('#update_email_id_error').after(
                    `<div class="text-danger errorMessage mt-1">Please Enter valid Email ID..!</div>`);
                errorMessage = 1;
            }

            if (update_location === '') {
                $('#update_location_error').after(
                    '<div class="text-danger errorMessage mt-1">Location URL is Required..!</div>');
                errorMessage = 1;
            }

            if (update_address === '') {
                $('#update_address_error').after('<div class="text-danger errorMessage mt-1">Address is Required..!</div>');
                errorMessage = 1;
            }

            $('.update_more_row_code').each(function() {

                let val = $(this).val();
                let client_name = $(`#update_more_client_name_${val}`).val().trim();
                let industry_id = $(`#update_more_industry_id_${val}`).val().trim();

                if (!client_name) {
                    $(`#update_more_client_name_${val}`).after(
                        `<div class="text-danger errorMessage">Client Name is Required..!</div>`);
                    errorMessage = 1;
                }

                if (!industry_id || industry_id === '' || industry_id === undefined || industry_id === null) {
                    $(`#update_more_industry_id_${val}_error`).after(
                        `<div class="text-danger errorMessage">Industry is Required..!</div>`);
                    errorMessage = 1;
                }

                // Duplicate Check
                if (client_name && industry_id) {
                    let key = `${client_name.toLowerCase()}|${industry_id}`;
                    if (update_contactMobilePairs.has(key)) {
                        $(`#update_more_industry_id_${val}_error`).after(
                            `<div class="text-danger errorMessage">Duplicate Client Name & Industry Found..!</div>`
                        );
                        errorMessage = 1;
                    } else {
                        update_contactMobilePairs.add(key);
                    }
                }

            });

            if (errorMessage == 0) {
                $('#update_gen_settings_form').submit();
            } else {
                return false;
            }
        }

        function deleteFetch(sno, cat_name) {
            document.querySelector('#kt_modal_delete_client .btn-danger').setAttribute('data-id', sno);
            $('#delete_message').html('Are you sure you want to delete this <br> <b class="text-danger"> ' + cat_name +
                '</b> Client ?');
        }

        // Delete Domain
        function deleteAppointmentReason() {
            var domainId = $('#kt_modal_delete_client .btn-danger').attr('data-id');

            fetch(`{{ url('/manage_client/delete_client') }}/${domainId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 200) {
                        toastr.success('Client deleted successfully!');
                        location.reload();
                    } else {
                        console.log('Error deleting status :', data.error_msg);
                    }
                })
                .catch(error => {
                    console.log('Error deleting status :', error);
                });
        }
    </script>


    <script>
        $(".list_page").DataTable({
            "ordering": false,
            // "aaSorting":[],
            "language": {
                "lengthMenu": "Show _MENU_",
            },
            "dom": "<'row mb-3'" +
                "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">"
        });
    </script>
@endsection

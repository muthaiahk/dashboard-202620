@extends('layouts/layoutMaster')

@section('title', 'Manage Work Order')

@section('vendor-style')
@vite([
'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
'resources/assets/vendor/libs/select2/select2.scss',
'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss',
'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
'resources/assets/vendor/libs/dropzone/dropzone.scss',
])
@endsection

@section('vendor-script')
@vite([
'resources/assets/vendor/libs/select2/select2.js',
'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js',
'resources/assets/vendor/libs/flatpickr/flatpickr.js',
'resources/assets/vendor/libs/nouislider/nouislider.js',
'resources/assets/vendor/libs/jquery-repeater/jquery-repeater.js',
'resources/assets/vendor/js/dropdown-hover.js'
])
@endsection

@section('page-script')
@vite(['resources/assets/js/forms_date_time_pickers.js'])
@endsection
@section('content')

<style>
    .view-switch{
        display:inline-flex;
        background: #148ecf;
        padding:4px;
        border-radius:10px;
        gap:4px;
    }

    .view-btn{
        display:flex;
        align-items:center;
        gap:6px;
        padding:6px 14px;
        border-radius:8px;
        font-size:14px;
        font-weight:500;
        color: #fff !important;
        text-decoration:none;
        transition:all 0.2s ease;
    }

    .view-btn i{
        font-size:18px;
    }

    .view-btn.active{
        background: #ffffff;
        color: #0076b6 !important;
        box-shadow:0 1px 3px rgba(0,0,0,0.1);
    }

    #workorderCalendar{
        background:#fff;
        border-radius:10px;
        padding:10px;
    }

    .fc-event{
        font-size:12px;
        padding:4px;
        border-radius:6px;
        font-weight: 500;
    }

    .fc-daygrid-event {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #fff;
    }

    .calendar-popup{
        position:fixed;
        width:260px;
        background:#fff;
        border-radius:8px;
        box-shadow:0 4px 15px rgba(0,0,0,0.15);
        z-index:9999;
        padding:10px;
    }

    .popup-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        font-weight:600;
        border-bottom:1px solid #eee;
        padding-bottom:6px;
    }

    .popup-close{
        cursor:pointer;
        font-size:18px;
    }

    .popup-body{
        padding-top:8px;
        font-size:13px;
    }

    .popup-body p{
        margin-bottom:6px;
    }

    .edit-event-icon{
        color: #ffffff;
        transition:0.2s;
    }

    .edit-event-icon:hover{
        transform:scale(1.2);
    }
</style>

<!-- Lead List Table -->
<div class="card card-action" style="overflow-x: hidden;">
    <div class="card-header pb-1">
        <div class="card-action-title">
            <h3 class="card-title mb-1">Manage Work Order</h3>
        </div>
        <div class="card-action-element">
            <div class="d-flex justify-content-end align-items-center mb-2 gap-2">
                <div class="view-switch">
                    <a href="{{ url('/manage_work_order') }}" class="view-btn">
                        <i class="mdi mdi-format-list-checkbox"></i>
                        List
                    </a>
                    <a href="{{ url('/manage_work_order/calendar_view') }}" class="view-btn active">
                        <i class="mdi mdi-calendar-blank-outline"></i>
                        Calendar
                    </a>
                </div>
                <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary-outline border border-primary text-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_bulk_upload">
                    <span class="me-2"><i class="mdi mdi-tray-arrow-up"></i></span>Bulk Upload
                </a>
                <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_workorder">
                    <span class="me-2"><i class="mdi mdi-plus"></i></span>Add Work Order
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="workorderCalendar"></div>
        <div id="eventPopup" class="calendar-popup d-none">
            <div class="popup-header">
                <span>Work Order Details</span>
                <i class="mdi mdi-close popup-close"></i>
            </div>
            <div class="popup-body">
                <p><strong>Tag:</strong> <span id="popupTag"></span></p>
                <p><strong>Location:</strong> <span id="popupLocation"></span></p>
                <p><strong>Sector:</strong> <span id="popupSector"></span></p>
                <p><strong>Priority:</strong> <span id="popupPriority"></span></p>
                <p><strong>Status:</strong> <span id="popupStatus"></span></p>
            </div>
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
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
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


<!--begin::Modal - Add Work Order-->
<div class="modal fade" id="kt_modal_add_workorder" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
    data-bs-backdrop="static" data-bs-focus="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-lg">
        <!--begin::Modal content-->
      <div class="modal-content rounded">
        <!--begin::Modal header-->
        <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
          <h4 class="text-center text-black">Create Work Order</h4>
          <!--begin::Close-->
          <div class="btn btn-sm btn-icon btn-active-color-primary mb-4" data-bs-dismiss="modal">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
              </svg>
            <!--end::Svg Icon-->
          </div>
          <!--end::Close-->
        </div>
        <!--end::Modal header-->
        <!--begin::Modal body-->
        <div class="modal-body py-5 px-10 px-xl-20">
            <div class="row scroll-y" style="max-height: 650px;">
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Client<span class="text-danger">*</span></label>
                    <select class="select3 form-select">
                        <option value="">Select Client</option>
                        <option value="1">Qatar Energy</option>
                        <option value="2">Qatar Gas</option>
                        <option value="3">Oryx GTL</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Asset<span class="text-danger">*</span></label>
                    <select class="select3 form-select">
                        <option value="">Select Asset</option>
                        <option value="1">11-SRV-1</option>
                        <option value="2">AST-GV-032</option>
                        <option value="3">AST-CV-017</option>
                        <option value="4">AST-SRV-027</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Procedure<span class="text-danger">*</span></label>
                    <select class="select3 form-select">
                        <option value="">Select Procedure</option>
                        <option value="1">Standard SRV Removal & Transport</option>
                        <option value="2">SRV bench Testing & Calibration</option>
                    </select>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Order Title</label>
                    <input type="text" class="form-control" placeholder="Enter Order Title" />
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Description</label>
                    <textarea class="form-control" rows="1" placeholder="Enter Description"></textarea>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-2 fs-7 fw-semibold">Assign Tools & Equipments</label>
                    <div class="row border p-3 g-2 rounded scroll-y max-h-250px">
                        <div class="d-flex align-items-center justify-content-between gap-5 bg-gray-100 p-3">
                            <div class="d-flex align-items-center justify-content-start gap-2 bg-gray-100">
                                <input class="form-check-input rounded w-25px h-25px" type="checkbox" />
                                <div class="d-flex flex-column">
                                    <label class="fw-medium text-black fs-7">50T Mobile Crane</label>
                                    <label class="fw-medium text-dark fs-7">CR-SD-220-X</label>
                                </div>
                            </div>
                            <label class="fw-medium text-danger bg-label-danger fs-7">Expired</label>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-5 bg-gray-100 p-3">
                            <div class="d-flex align-items-center justify-content-start gap-2 bg-gray-100">
                                <input class="form-check-input rounded w-25px h-25px" type="checkbox" />
                                <div class="d-flex flex-column">
                                    <label class="fw-medium text-black fs-7">Hydraulic Torque Wrench Kit</label>
                                    <label class="fw-medium text-dark fs-7">HTW-004-A</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-5 bg-gray-100 p-3">
                            <div class="d-flex align-items-center justify-content-start gap-2 bg-gray-100">
                                <input class="form-check-input rounded w-25px h-25px" type="checkbox" />
                                <div class="d-flex flex-column">
                                    <label class="fw-medium text-black fs-7">Grinding Machine</label>
                                    <label class="fw-medium text-dark fs-7">GM-154-S</label>
                                </div>
                            </div>
                            <label class="fw-medium text-danger bg-label-danger fs-7">Expired</label>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-5 bg-gray-100 p-3">
                            <div class="d-flex align-items-center justify-content-start gap-2 bg-gray-100">
                                <input class="form-check-input rounded w-25px h-25px" type="checkbox" />
                                <div class="d-flex flex-column">
                                    <label class="fw-medium text-black fs-7">Valve Testing Bench</label>
                                    <label class="fw-medium text-dark fs-7">VTB-097-A</label>
                                </div>
                            </div>
                            <label class="fw-medium text-danger bg-label-danger fs-7">Expired</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Order Type<span class="text-danger">*</span></label>
                    <select class="select3 form-select">
                        <option value="">Select Order Type</option>
                        <option value="1">Maintanence</option>
                        <option value="2">Repair</option>
                        <option value="3">Inspection</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Priority<span class="text-danger">*</span></label>
                    <select class="select3 form-select">
                        <option value="">Select Priority</option>
                        <option value="1">A</option>
                        <option value="2">B</option>
                        <option value="3">C</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Compliance Date<span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar-month-outline fs-4"></i>
                        </span>
                        <input type="text" class="form-control common_datepicker" placeholder="Select Date">
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Assigned Date<span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar-month-outline fs-4"></i>
                        </span>
                        <input type="text" class="form-control common_datepicker" placeholder="Select Date">
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Tentative Removal<span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar-month-outline fs-4"></i>
                        </span>
                        <input type="text" class="form-control common_datepicker" placeholder="Select Date">
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">ABC Ind.</label>
                    <input type="text" class="form-control" placeholder="Enter ABC Ind." />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Scheudling Grp</label>
                    <input type="text" class="form-control" placeholder="Enter Scheudling Grp" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Haz Area</label>
                    <input type="text" class="form-control" placeholder="Enter Haz Area" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Act Type</label>
                    <input type="text" class="form-control" placeholder="Enter Act Type" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Cnfn No</label>
                    <input type="text" class="form-control" placeholder="Enter Cnfn No" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">No.Men</label>
                    <input type="text" class="form-control" placeholder="Enter No.Men" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Dur. Hrs</label>
                    <input type="text" class="form-control" placeholder="Enter Dur. Hrs" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">St Txt Key</label>
                    <input type="text" class="form-control" placeholder="Enter St Txt Key" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Oper No.</label>
                    <input type="text" class="form-control" placeholder="Enter Oper No." />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Catalog Profile</label>
                    <input type="text" class="form-control" placeholder="Enter Catalog Profile" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">O&M Manual Doc.No.</label>
                    <input type="text" class="form-control" placeholder="Enter O&M Manual Doc.No." />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Material No & Desc</label>
                    <input type="text" class="form-control" placeholder="Enter Material No & Desc" />
                </div>
               <div class="col-lg-6 mb-3">
                    <div class="d-flex align-items-center justify-content-start gap-2">
                        <input class="form-check-input rounded w-25px h-25px" type="checkbox" id="recurrence_check"/>
                        <label class="text-black fs-7 fw-semibold">Recurrence<span class="text-danger">*</span></label>
                    </div>
                    <select class="select3 form-select d-none mt-2" id="recurrence_select">
                        <option value="">Select Recurrence</option>
                        <option value="1">Quarterly</option>
                        <option value="2">Yearly</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="row">
                        <div class="col-lg-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input rounded w-25px h-25px" type="checkbox" id="scaffolding">
                                <label class="form-check-label text-black fw-semibold" for="scaffolding">
                                    Scaffolding
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input rounded w-25px h-25px" type="checkbox" id="crane">
                                <label class="form-check-label text-black fw-semibold" for="crane">
                                    Crane
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pt-5">
          <div class="d-flex justify-content-end align-items-center">
            <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Create Work Order</button>
          </div>
        </div>
        <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Add Work Order-->


<!--begin::Modal - Update Work Order-->
<div class="modal fade" id="kt_modal_update_workorder" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
    data-bs-backdrop="static" data-bs-focus="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-lg">
        <!--begin::Modal content-->
      <div class="modal-content rounded">
        <!--begin::Modal header-->
        <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
          <h4 class="text-center text-black">Update Work Order</h4>
          <!--begin::Close-->
          <div class="btn btn-sm btn-icon btn-active-color-primary mb-4" data-bs-dismiss="modal">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
              </svg>
            <!--end::Svg Icon-->
          </div>
          <!--end::Close-->
        </div>
        <!--end::Modal header-->
        <!--begin::Modal body-->
        <div class="modal-body py-5 px-10 px-xl-20">
            <div class="row scroll-y" style="max-height: 650px;">
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Client<span class="text-danger">*</span></label>
                    <select class="select3 form-select">
                        <option value="">Select Client</option>
                        <option value="1">Qatar Energy</option>
                        <option value="2">Qatar Gas</option>
                        <option value="3">Oryx GTL</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Asset<span class="text-danger">*</span></label>
                    <select class="select3 form-select">
                        <option value="">Select Asset</option>
                        <option value="1">11-SRV-1</option>
                        <option value="2">AST-GV-032</option>
                        <option value="3">AST-CV-017</option>
                        <option value="4">AST-SRV-027</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Procedure<span class="text-danger">*</span></label>
                    <select class="select3 form-select">
                        <option value="">Select Procedure</option>
                        <option value="1">Standard SRV Removal & Transport</option>
                        <option value="2">SRV bench Testing & Calibration</option>
                    </select>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Order Title</label>
                    <input type="text" class="form-control" placeholder="Enter Order Title" />
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Description</label>
                    <textarea class="form-control" rows="1" placeholder="Enter Description"></textarea>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-2 fs-7 fw-semibold">Assign Tools & Equipments</label>
                    <div class="row border p-3 g-2 rounded scroll-y max-h-250px">
                        <div class="d-flex align-items-center justify-content-between gap-5 bg-gray-100 p-3">
                            <div class="d-flex align-items-center justify-content-start gap-2 bg-gray-100">
                                <input class="form-check-input rounded w-25px h-25px" type="checkbox" />
                                <div class="d-flex flex-column">
                                    <label class="fw-medium text-black fs-7">50T Mobile Crane</label>
                                    <label class="fw-medium text-dark fs-7">CR-SD-220-X</label>
                                </div>
                            </div>
                            <label class="fw-medium text-danger bg-label-danger fs-7">Expired</label>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-5 bg-gray-100 p-3">
                            <div class="d-flex align-items-center justify-content-start gap-2 bg-gray-100">
                                <input class="form-check-input rounded w-25px h-25px" type="checkbox" />
                                <div class="d-flex flex-column">
                                    <label class="fw-medium text-black fs-7">Hydraulic Torque Wrench Kit</label>
                                    <label class="fw-medium text-dark fs-7">HTW-004-A</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-5 bg-gray-100 p-3">
                            <div class="d-flex align-items-center justify-content-start gap-2 bg-gray-100">
                                <input class="form-check-input rounded w-25px h-25px" type="checkbox" />
                                <div class="d-flex flex-column">
                                    <label class="fw-medium text-black fs-7">Grinding Machine</label>
                                    <label class="fw-medium text-dark fs-7">GM-154-S</label>
                                </div>
                            </div>
                            <label class="fw-medium text-danger bg-label-danger fs-7">Expired</label>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-5 bg-gray-100 p-3">
                            <div class="d-flex align-items-center justify-content-start gap-2 bg-gray-100">
                                <input class="form-check-input rounded w-25px h-25px" type="checkbox" />
                                <div class="d-flex flex-column">
                                    <label class="fw-medium text-black fs-7">Valve Testing Bench</label>
                                    <label class="fw-medium text-dark fs-7">VTB-097-A</label>
                                </div>
                            </div>
                            <label class="fw-medium text-danger bg-label-danger fs-7">Expired</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Order Type<span class="text-danger">*</span></label>
                    <select class="select3 form-select">
                        <option value="">Select Order Type</option>
                        <option value="1">Maintanence</option>
                        <option value="2">Repair</option>
                        <option value="3">Inspection</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Priority<span class="text-danger">*</span></label>
                    <select class="select3 form-select">
                        <option value="">Select Priority</option>
                        <option value="1">A</option>
                        <option value="2">B</option>
                        <option value="3">C</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Compliance Date<span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar-month-outline fs-4"></i>
                        </span>
                        <input type="text" class="form-control common_datepicker" placeholder="Select Date">
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Assigned Date<span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar-month-outline fs-4"></i>
                        </span>
                        <input type="text" class="form-control common_datepicker" placeholder="Select Date">
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Tentative Removal<span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar-month-outline fs-4"></i>
                        </span>
                        <input type="text" class="form-control common_datepicker" placeholder="Select Date">
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">ABC Ind.</label>
                    <input type="text" class="form-control" placeholder="Enter ABC Ind." />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Scheudling Grp</label>
                    <input type="text" class="form-control" placeholder="Enter Scheudling Grp" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Haz Area</label>
                    <input type="text" class="form-control" placeholder="Enter Haz Area" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Act Type</label>
                    <input type="text" class="form-control" placeholder="Enter Act Type" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Cnfn No</label>
                    <input type="text" class="form-control" placeholder="Enter Cnfn No" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">No.Men</label>
                    <input type="text" class="form-control" placeholder="Enter No.Men" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Dur. Hrs</label>
                    <input type="text" class="form-control" placeholder="Enter Dur. Hrs" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">St Txt Key</label>
                    <input type="text" class="form-control" placeholder="Enter St Txt Key" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Oper No.</label>
                    <input type="text" class="form-control" placeholder="Enter Oper No." />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Catalog Profile</label>
                    <input type="text" class="form-control" placeholder="Enter Catalog Profile" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">O&M Manual Doc.No.</label>
                    <input type="text" class="form-control" placeholder="Enter O&M Manual Doc.No." />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Material No & Desc</label>
                    <input type="text" class="form-control" placeholder="Enter Material No & Desc" />
                </div>
               <div class="col-lg-6 mb-3">
                    <div class="d-flex align-items-center justify-content-start gap-2">
                        <input class="form-check-input rounded w-25px h-25px" type="checkbox" id="recurrence_check"/>
                        <label class="text-black fs-7 fw-semibold">Recurrence<span class="text-danger">*</span></label>
                    </div>
                    <select class="select3 form-select d-none mt-2" id="recurrence_select">
                        <option value="">Select Recurrence</option>
                        <option value="1">Quarterly</option>
                        <option value="2">Yearly</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="row">
                        <div class="col-lg-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input rounded w-25px h-25px" type="checkbox" id="scaffolding">
                                <label class="form-check-label text-black fw-semibold" for="scaffolding">
                                    Scaffolding
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input rounded w-25px h-25px" type="checkbox" id="crane">
                                <label class="form-check-label text-black fw-semibold" for="crane">
                                    Crane
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pt-5">
          <div class="d-flex justify-content-end align-items-center">
            <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Update Work Order</button>
          </div>
        </div>
        <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Update Work Order-->


<script>
    document.addEventListener('DOMContentLoaded', function () {

        let calendarEl = document.getElementById('workorderCalendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {

            initialView: 'dayGridMonth',
            height: 650,

            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },

            events: [ 
                { 
                    title: 'SRV Valve Inspection', 
                    start: '2026-03-14', 
                    extendedProps: { 
                        tag: '11-SRV-1', 
                        location: 'FHSP / V1106', 
                        sector: 'OOD-FHSP', 
                        priority: 'C', 
                        status: 'Preparation' 
                    } 
                }, 
                { 
                    title: 'Relief Valve Overhaul', 
                    start: '2026-03-20', 
                    extendedProps: 
                    { 
                        tag: '12-SRV-4019-101', 
                        location: 'KUFA Plant', 
                        sector: 'Gas Compression', 
                        priority: 'C', 
                        status: 'Execution' 
                    } 
                }, 
                { 
                    title: 'Valve Seat Replacement', 
                    start: '2026-02-15', 
                    extendedProps: 
                    { 
                        tag: '14-SRV-5232-01', 
                        location: 'FHSP / V1107', 
                        sector: 'OOD-FHSP', 
                        priority: 'B', 
                        status: 'Approval' 
                    } 
                }, 
                { 
                    title: 'Safety Valve Testing', 
                    start: '2026-02-14', 
                    extendedProps: 
                    { 
                        tag: '11-SRV-3', 
                        location: 'FHSP / V1108', 
                        sector: 'OOD-FHSP', 
                        priority: 'C', 
                        status: 'Completed' 
                    } 
                } 
            ],

            eventDidMount: function(info) {
                let priority = info.event.extendedProps.priority;
                let status = info.event.extendedProps.status;

                // Priority based colors
                if(priority === "A"){
                    info.el.style.backgroundColor = "#dc3545"; // red
                    info.el.style.borderColor = "#dc3545";
                    info.el.style.color = "#fff";
                }
                else if(priority === "B"){
                    info.el.style.backgroundColor = "#fd7e14"; // orange
                    info.el.style.borderColor = "#fd7e14";
                    info.el.style.color = "#fff";
                }
                else if(priority === "C"){
                    info.el.style.backgroundColor = "#ffc107"; // yellow
                    info.el.style.borderColor = "#ffc107";
                    info.el.style.color = "#000";
                }
                else{
                    info.el.style.backgroundColor = "#198754"; // green
                    info.el.style.borderColor = "#198754";
                    info.el.style.color = "#fff";
                }

                let editIcon = document.createElement("i");
                editIcon.className = "mdi mdi-pencil-outline edit-event-icon";
                editIcon.style.display = "none";
                editIcon.style.cursor = "pointer";
                editIcon.style.fontSize = "16px";

                let wrapper = document.createElement("div");
                wrapper.className = "d-flex justify-content-between align-items-center";
                let title = document.createElement("span");
                title.innerText = info.event.title;

                wrapper.appendChild(title);
                wrapper.appendChild(editIcon);

                info.el.innerHTML = "";
                info.el.appendChild(wrapper);

                info.el.addEventListener("mouseenter", function(){
                    editIcon.style.display = "inline-block";
                });

                info.el.addEventListener("mouseleave", function(){
                    editIcon.style.display = "none";
                });

                editIcon.addEventListener("click", function(e){
                    e.stopPropagation();

                    let modal = new bootstrap.Modal(document.getElementById('kt_modal_update_workorder'));
                    modal.show();
                });
            },

            eventClick: function(info) {

                let popup = document.getElementById("eventPopup");
                let data = info.event.extendedProps;

                document.getElementById("popupTag").innerText = data.tag;
                document.getElementById("popupLocation").innerText = data.location;
                document.getElementById("popupSector").innerText = data.sector;
                document.getElementById("popupPriority").innerText = data.priority;
                document.getElementById("popupStatus").innerText = data.status;

                popup.classList.remove("d-none");

                let eventRect = info.el.getBoundingClientRect();

                popup.style.position = "fixed";
                popup.style.top = (eventRect.bottom + 10) + "px";
                popup.style.left = (eventRect.left) + "px";
            }

        });

        calendar.render();
    });

    document.addEventListener("click", function(e){
        if(e.target.classList.contains("popup-close")){
            document.getElementById("eventPopup").classList.add("d-none");
        }
    });
</script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>


@endsection
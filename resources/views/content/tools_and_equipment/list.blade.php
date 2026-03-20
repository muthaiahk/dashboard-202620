@extends('layouts/layoutMaster')

@section('title', 'Manage Tools And Equipments')

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
    .sticky-top {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 1020;
    }
</style>
<!-- Lead List Table -->
<div class="card card-action">
    <div class="card-header pb-1">
        <div class="card-action-title">
            <h3 class="card-title mb-1">Manage Tools And Equipments</h3>
            <div class="nav-align-top nav-tabs-shadow" >
                <ul class="nav nav-tabs" role="tablist" style="overflow-x:hidden !important;">
                    <li class="nav-item">
                        <a
                        href="{{ url('/manage_tools_equipments') }}"
                        type="button"
                        class="nav-link active">
                        <span class="d-none d-sm-inline-flex align-items-center">
                            <i class="mdi mdi-wrench-outline me-2"></i>
                            Tools & Equipments
                        </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                        href="{{ url('/manage_vehicle') }}"
                        type="button"
                        class="nav-link">
                        <span class="d-none d-sm-inline-flex align-items-center">
                            <i class="mdi mdi-car-estate me-2"></i>
                            Vehicles
                        </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-action-element">
            <div class="d-flex justify-content-end align-items-center mb-2 gap-2">
                <div class="searchBar" style="position: relative; width: 300px;">
                    <input class="form-control" type="text" name="searchQueryInput"
                        placeholder="Search Equipments " value=""
                        oninput="toggleIcons(this)"
                        style="padding-left: 35px;" />
                    <svg style="width:20px;height:20px;position:absolute;left:10px;top:50%;transform:translateY(-50%);fill:#0076b6;" viewBox="0 0 24 24">
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
                                C14,7 12,5 9.5,5Z"/>
                    </svg>
                </div>
                <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_equipments">
                    <span class="me-2"><i class="mdi mdi-plus"></i></span>Add Equipment
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-lg-3">
                <div class="p-3 rounded border d-flex flex-column bg-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex gap-2 align-items-center">                            
                            <div class="d-flex flex-column">
                                <label class="text-secondary fw-semibold fs-8">Crane</label>   
                                <label class="text-black fw-semibold fs-6">SN-10001</label>                                
                            </div>
                        </div>
                        <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Update"><i class="mdi mdi-pencil-outline  text-secondary me-1 cursor-pointer"  data-bs-toggle="modal" data-bs-target="#kt_modal_update_equipments"></i></span>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex flex-column gap-2">

                        

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mdi mdi-tag-outline text-secondary"></span>
                                <label class="text-secondary fs-7 fw-semibold">Serial No</label>
                            </div>
                            <label class="text-black fs-7 fw-semibold">CR-50-2022-X</label>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mdi mdi-shield-outline text-secondary"></span>
                                <label class="text-secondary fs-7 fw-semibold">Cert. Exp</label>
                            </div>
                            <label class="badge bg-label-danger text-danger fs-7 fw-semibold">Expired</label>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mdi mdi-office-building-outline text-secondary"></span>
                                <label class="text-secondary fs-7 fw-semibold">Owner</label>
                            </div>
                            <label class="text-black fs-7 fw-semibold">HeavyLift Co.</label>
                        </div>
                        
                    </div>
                    <hr class="my-3">
                    <div class="row">
                        <div class="col-lg-12 d-flex align-items-center gap-1">                            
                            <span class="mdi mdi-check-decagram-outline fw-semibold text-success"></span>
                            <label class="text-success fs-7 fw-semibold ">Available</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="p-3 rounded border d-flex flex-column bg-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex gap-2 align-items-center">                            
                            <div class="d-flex flex-column">
                                <label class="text-secondary fw-semibold fs-8">Power Tool</label>   
                                <label class="text-black fw-semibold fs-6">Hydraulic Torque Wrench Kit</label>                                
                            </div>
                        </div>
                        <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Update"><i class="mdi mdi-pencil-outline  text-secondary me-1 cursor-pointer"  data-bs-toggle="modal" data-bs-target="#kt_modal_update_equipments"></i></span>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex flex-column gap-2">

                        

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mdi mdi-tag-outline text-secondary"></span>
                                <label class="text-secondary fs-7 fw-semibold">Serial No</label>
                            </div>
                            <label class="text-black fs-7 fw-semibold">HTW-004-A</label>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mdi mdi-shield-outline text-secondary"></span>
                                <label class="text-secondary fs-7 fw-semibold">Cert. Exp</label>
                            </div>
                            <label class="badge bg-label-danger text-danger fs-7 fw-semibold">Expired</label>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mdi mdi-office-building-outline text-secondary"></span>
                                <label class="text-secondary fs-7 fw-semibold">Owner</label>
                            </div>
                            <label class="text-black fs-7 fw-semibold">HeavyLift Co.</label>
                        </div>
                        
                    </div>
                    <hr class="my-3">
                    <div class="row">
                        <div class="col-lg-12 d-flex align-items-center gap-1">                            
                            <span class="mdi mdi-check-decagram-outline fw-semibold text-success"></span>
                            <label class="text-success fs-7 fw-semibold ">Available</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="p-3 rounded border d-flex flex-column bg-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex gap-2 align-items-center">                            
                            <div class="d-flex flex-column">
                                <label class="text-secondary fw-semibold fs-8 " >Calibration Instrument</label>   
                                <label class="text-black fw-semibold fs-6 text-truncate" style="max-width:200px;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Digital Pressure Gauge (0-5000 PSI)">Digital Pressure Gauge (0-5000 PSI)</label>                                
                            </div>
                        </div>
                        <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Update"><i class="mdi mdi-pencil-outline  text-secondary me-1 cursor-pointer"  data-bs-toggle="modal" data-bs-target="#kt_modal_update_equipments"></i></span>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex flex-column gap-2">

                        

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mdi mdi-tag-outline text-secondary"></span>
                                <label class="text-secondary fs-7 fw-semibold">Serial No</label>
                            </div>
                            <label class="text-black fs-7 fw-semibold">DPG-5000-x1</label>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mdi mdi-shield-outline text-secondary"></span>
                                <label class="text-secondary fs-7 fw-semibold">Calib.Due</label>
                            </div>
                            <label class="badge bg-label-danger text-danger fs-7 fw-semibold">Expired</label>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mdi mdi-office-building-outline text-secondary"></span>
                                <label class="text-secondary fs-7 fw-semibold">Owner</label>
                            </div>
                            <label class="text-black fs-7 fw-semibold">Internal</label>
                        </div>
                        
                    </div>
                    <hr class="my-3">
                    <div class="row">
                        <div class="col-lg-12 d-flex align-items-center gap-1">                            
                            <span class="mdi mdi-reload fw-semibold text-primary"></span>
                            <label class="text-primary fs-7 fw-semibold ">In Use</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="p-3 rounded border d-flex flex-column bg-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex gap-2 align-items-center">                            
                            <div class="d-flex flex-column">
                                <label class="text-secondary fw-semibold fs-8 " >Scaffolding</label>   
                                <label class="text-black fw-semibold fs-6 " >Scaffold Tower (Type A)</label>                                
                            </div>
                        </div>
                        <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Update"><i class="mdi mdi-pencil-outline  text-secondary me-1 cursor-pointer"  data-bs-toggle="modal" data-bs-target="#kt_modal_update_equipments"></i></span>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mdi mdi-tag-outline text-secondary"></span>
                                <label class="text-secondary fs-7 fw-semibold">Serial No</label>
                            </div>
                            <label class="text-black fs-7 fw-semibold">SCF-A-099</label>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mdi mdi-shield-outline text-secondary"></span>
                                <label class="text-secondary fs-7 fw-semibold">Cert. Exp</label>
                            </div>
                            <label class="badge bg-label-danger text-danger fs-7 fw-semibold">Expired</label>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mdi mdi-office-building-outline text-secondary"></span>
                                <label class="text-secondary fs-7 fw-semibold">Owner</label>
                            </div>
                            <label class="text-black fs-7 fw-semibold">SafeAccess LTD</label>
                        </div>
                        
                    </div>
                    <hr class="my-3">
                    <div class="row">
                        <div class="col-lg-12 d-flex align-items-center gap-1">                            
                            <span class="mdi mdi-check-decagram-outline fw-semibold text-success"></span>
                            <label class="text-success fs-7 fw-semibold ">Available</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="p-3 rounded border d-flex flex-column bg-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex gap-2 align-items-center">                            
                            <div class="d-flex flex-column">
                                <label class="text-secondary fw-semibold fs-8 " >Lifting Gear</label>   
                                <label class="text-black fw-semibold fs-6 " >Chain Block 5T</label>                                
                            </div>
                        </div>
                        <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Update"><i class="mdi mdi-pencil-outline  text-secondary me-1 cursor-pointer"  data-bs-toggle="modal" data-bs-target="#kt_modal_update_equipments"></i></span>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mdi mdi-tag-outline text-secondary"></span>
                                <label class="text-secondary fs-7 fw-semibold">Serial No</label>
                            </div>
                            <label class="text-black fs-7 fw-semibold">CB-5T-100</label>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mdi mdi-shield-outline text-secondary"></span>
                                <label class="text-secondary fs-7 fw-semibold">Cert. Exp</label>
                            </div>
                            <label class="badge bg-label-danger text-danger fs-7 fw-semibold">Expired</label>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mdi mdi-office-building-outline text-secondary"></span>
                                <label class="text-secondary fs-7 fw-semibold">Owner</label>
                            </div>
                            <label class="text-black fs-7 fw-semibold">Internal</label>
                        </div>
                        
                    </div>
                    <hr class="my-3">
                    <div class="row">
                        <div class="col-lg-12 d-flex align-items-center gap-1">                            
                            <span class="mdi mdi-alert-decagram-outline fw-semibold text-warning"></span>
                            <label class="text-warning fs-7 fw-semibold ">Maintenance</label>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>




<!--begin::Modal - Add Equipments-->
<div class="modal fade" id="kt_modal_add_equipments" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
    data-bs-backdrop="static" data-bs-focus="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-lg">
        <!--begin::Modal content-->
      <div class="modal-content rounded">
        <!--begin::Modal header-->
        <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
          <h4 class="text-center text-black">Create New Equipment</h4>
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
            <div class="nav-align-top p-0">
                <ul class="nav nav-tabs mb-4" role="tablist">
                    <li class="nav-item">
                        <button type="button"class="nav-link active" role="tab"data-bs-toggle="tab"data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">Details & Specs</button>
                    </li>
                    <li class="nav-item">
                        <button type="button"class="nav-link" role="tab"data-bs-toggle="tab" data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false">Maintenance</button>
                    </li>
                    <li class="nav-item">
                        <button type="button"class="nav-link" role="tab"data-bs-toggle="tab" data-bs-target="#usage-history" aria-controls="usage-history" aria-selected="false">Usage History</button>
                    </li>
                </ul>
                <div class="tab-content  p-0"  style="box-shadow:none !important;">
                    <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Equipment Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Equipment Name" />
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Category<span class="text-danger">*</span></label>
                                <select class="select3 form-select" >
                                    <option value="">Select Category</option>
                                    <option value="1">Power Tool</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Serial Number<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Serial Number" />
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Manufacturer<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Manufacturer" />
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Model<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Model" />
                            </div>
                            <div class="col-lg-12 my-1">
                                <label class="text-secondary mb-1 fs-7 fw-semibold">Ownership & Status</label>
                            </div>
                            <div class="col-lg-6 mb-3" >
                                <label class="text-black mb-1 fs-7 fw-semibold">Ownership<span class="text-danger">*</span></label>
                                <select class="select3 form-select" >
                                    <option value="">Select Ownership</option>
                                    <option value="1">Internal</option>
                                    <option value="2">SafeAccess LTD</option>
                                    <option value="3">HeavyLift Co.</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3" >
                                <label class="text-black mb-1 fs-7 fw-semibold">Current Status<span class="text-danger">*</span></label>
                                <select class="select3 form-select" >
                                    <option value="">Select Current Status</option>
                                    <option value="1">Calibration</option>
                                    <option value="2">Repair</option>
                                    <option value="3">Maintance</option>
                                    <option value="3">Inspection</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Current Location<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Current Location" />
                            </div>
                            <div class="col-lg-12 my-1">
                                <label class="text-secondary mb-1 fs-7 fw-semibold">Certification & Date</label>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Certificate<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Certificate" />
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">
                                    Expiry Date<span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-calendar-month-outline fs-4"></i>
                                    </span>
                                    <input type="text" class="form-control common_datepicker" placeholder="Select Date">
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-12 my-1">
                                <label class="text-secondary mb-1 fs-7 fw-semibold">Add New Entry</label>
                            </div>
                            <div class="col-lg-6 mb-3" >
                                <select class="select3 form-select" id="selectStatus">
                                    <option value="">Select Status</option>
                                    <option value="1">Calibration</option>
                                    <option value="2">Repair</option>
                                    <option value="3">Maintance</option>
                                    <option value="3">Inspection</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-calendar-month-outline fs-4"></i>
                                    </span>
                                    <input type="text" class="form-control common_datepicker" placeholder="Select Date" id="newDate">
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <textarea class="form-control" rows="1" placeholder="Description Of Work Performed..." id="descText"></textarea>
                            </div> 
                            <div class="col-lg-6 mb-3" >
                                <select class="select3 form-select" id="ownerStatus">
                                    <option value="0">Select Ownership</option>
                                    <option value="1">Internal</option>
                                    <option value="2">SafeAccess LTD</option>
                                    <option value="3">HeavyLift Co.</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3 d-flex align-items-end justify-content-end">
                                <label class="btn btn-outline-primary btn-sm" onclick="addLog()">Add Log</label>
                            </div>
                            <div class="col-lg-12 my-1">
                                <label class="text-secondary mb-1 fs-7 fw-semibold">Historical Records</label>
                            </div>
                            <div class="col-lg-12 my-3">
                                <table class="table align-middle table-row-dashed table-striped table-hover gy-0 gs-1 ">
                                    <thead>
                                        <tr class="text-start align-top  fw-bold fs-6 gs-0 bg-gray-100">
                                            <th class="min-w-100px text-black">Purpose</th>
                                            <th class="min-w-100px text-black">Date</th>
                                            <th class="min-w-100px text-black">Description</th>
                                            <th class="min-w-100px text-black">Ownership</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-black fw-semibold fs-7" id="newData"></tbody>
                                </table>
                            </div>                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="usage-history" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-12 mb-3 table-wrapper scroll-y max-h-300px">
                                <table class="table align-middle table-row-dashed table-striped table-hover gy-0 gs-1 ">
                                    <thead class="sticky-top">
                                        <tr class="text-start align-top  fw-bold fs-6 gs-0 bg-gray-100">
                                            <th class="min-w-100px text-black">Start Date</th>
                                            <th class="min-w-100px text-black">Ticket</th>
                                            <th class="min-w-100px text-black">Closed Date</th>
                                            <th class="min-w-100px text-black">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-black fw-semibold fs-7">
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">13-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">The Tools Need Calibration</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">14-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Calibration Completed</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">10-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Torque wrench issued for SRV valve tightening</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">10-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Returned after inspection work completion</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">11-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Pressure gauge used for valve pressure testing</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">11-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Returned and verified by tool supervisor</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">12-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Chain pulley block used for lifting heavy valve</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">12-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Returned after lifting operation</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">13-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Valve lapping machine used for seat polishing</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">13-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Cleaning completed and returned</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">14-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Flange spreader used to separate pipeline flange</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">14-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Returned and inspected for damages</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">15-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Hydraulic torque wrench issued for bolt tightening</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">15-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Returned after maintenance activity</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">16-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Air compressor used for pneumatic valve testing</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">16-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Returned and stored in equipment room</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">17-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Bearing puller used for valve component removal</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">17-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Returned after dismantling operation</label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pt-5">
          <div class="d-flex justify-content-end align-items-center">
            <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Create New Equipment</button>
          </div>
        </div>
        <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Add Equipments-->




<!--begin::Modal - Update Equipments-->
<div class="modal fade" id="kt_modal_update_equipments" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
    data-bs-backdrop="static" data-bs-focus="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-lg">
        <!--begin::Modal content-->
      <div class="modal-content rounded">
        <!--begin::Modal header-->
        <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
          <h4 class="text-center text-black">Update Equipment</h4>
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
            <div class="nav-align-top p-0">
                <ul class="nav nav-tabs mb-4" role="tablist">
                    <li class="nav-item">
                        <button type="button"class="nav-link active" role="tab"data-bs-toggle="tab"data-bs-target="#navs-top-home_edit" aria-controls="navs-top-home_edit" aria-selected="true">Details & Specs</button>
                    </li>
                    <li class="nav-item">
                        <button type="button"class="nav-link" role="tab"data-bs-toggle="tab" data-bs-target="#navs-top-profile_edit" aria-controls="navs-top-profile_edit" aria-selected="false">Maintenance</button>
                    </li>
                    <li class="nav-item">
                        <button type="button"class="nav-link" role="tab"data-bs-toggle="tab" data-bs-target="#usage-history-edit" aria-controls="usage-history-edit" aria-selected="false">Usage History</button>
                    </li>
                </ul>
                <div class="tab-content  p-0"  style="box-shadow:none !important;">
                    <div class="tab-pane fade show active" id="navs-top-home_edit" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Equipment Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Equipment Name" value="Industrial Air Compressor"/>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Category<span class="text-danger">*</span></label>
                                <select class="select3 form-select" >
                                    <option value="">Select Category</option>
                                    <option value="1"selected>Power Tool</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Serial Number<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Serial Number" value="CR-50-2022-X"/>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Manufacturer<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Manufacturer" value="Atlas Copco"/>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Model<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Model" value="GA 75 VSD+"/>
                            </div>
                            <div class="col-lg-12 my-1">
                                <label class="text-secondary mb-1 fs-7 fw-semibold">Ownership & Status</label>
                            </div>
                            <div class="col-lg-6 mb-3" >
                                <label class="text-black mb-1 fs-7 fw-semibold">Ownership<span class="text-danger">*</span></label>
                                <select class="select3 form-select" >
                                    <option value="">Select Ownership</option>
                                    <option value="1"selected>Internal</option>
                                    <option value="2">SafeAccess LTD</option>
                                    <option value="3">HeavyLift Co.</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3" >
                                <label class="text-black mb-1 fs-7 fw-semibold">Current Status<span class="text-danger">*</span></label>
                                <select class="select3 form-select" >
                                    <option value="">Select Current Status</option>
                                    <option value="1"selected>Available</option>
                                    <option value="2">In Use</option>
                                    <option value="3">Maintance</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Current Location<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Current Location" value="Plant 2 Utility Room"/>
                            </div>
                            <div class="col-lg-12 my-1">
                                <label class="text-secondary mb-1 fs-7 fw-semibold">Certification & Date</label>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">Certificate<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Certificate" value="ISO 8573 Air Quality Certificate"/>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="text-black mb-1 fs-7 fw-semibold">
                                    Expiry Date<span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-calendar-month-outline fs-4"></i>
                                    </span>
                                    <input type="text" class="form-control common_datepicker" placeholder="Select Date" value="30-12-2027">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-profile_edit" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-12 my-1">
                                <label class="text-secondary mb-1 fs-7 fw-semibold">Add New Entry</label>
                            </div>
                            <div class="col-lg-6 mb-3" >
                                    <select class="select3 form-select" id="editselectStatus">
                                        <option value="0">Select Purpose</option>
                                        <option value="1">Inspection</option>
                                    </select>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-calendar-month-outline fs-4"></i>
                                    </span>
                                    <input type="text" class="form-control common_datepicker" placeholder="Select Date" id="editnewDate">
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <textarea class="form-control" rows="1" placeholder="Description Of Work Performed..." id="editdescText"></textarea>
                            </div> 
                            <div class="col-lg-6 mb-3" >
                                <select class="select3 form-select" id="editownerStatus">
                                    <option value="0">Select Ownership</option>
                                    <option value="1">Internal</option>
                                    <option value="2">SafeAccess LTD</option>
                                    <option value="3">HeavyLift Co.</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3 d-flex align-items-end justify-content-end">
                                <label class="btn btn-outline-primary btn-sm" onclick="editaddLog()">Add Log</label>
                            </div>
                            <div class="col-lg-12 my-1">
                                <label class="text-secondary mb-1 fs-7 fw-semibold">Historical Records</label>
                            </div>
                            <div class="col-lg-12 my-3">
                                <table class="table align-middle table-row-dashed table-striped table-hover gy-0 gs-1 ">
                                    <thead>
                                        <tr class="text-start align-top  fw-bold fs-6 gs-0 bg-gray-100">
                                            <th class="min-w-100px text-black">Purpose</th>
                                            <th class="min-w-100px text-black">Date</th>
                                            <th class="min-w-100px text-black">Description</th>
                                            <th class="min-w-100px text-black">Ownership</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-black fw-semibold fs-7" id="editnewData">
                                        <tr>
                                            <td>
                                                <label class="">Inspection</label>
                                            </td>
                                            <td>
                                                <label class="">12-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="">-</label>
                                            </td>
                                            <td>
                                                <label class="">Internal</label>
                                            </td>
                                            
                                        </tr>     
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="usage-history-edit" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-12 mb-3 table-wrapper scroll-y max-h-300px">
                                <table class="table align-middle table-row-dashed table-striped table-hover gy-0 gs-1 ">
                                    <thead class="sticky-top">
                                        <tr class="text-start align-top  fw-bold fs-6 gs-0 bg-gray-100">
                                            <th class="min-w-100px text-black">Start Date</th>
                                            <th class="min-w-100px text-black">Ticket</th>
                                            <th class="min-w-100px text-black">Closed Date</th>
                                            <th class="min-w-100px text-black">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-black fw-semibold fs-7">
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">13-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">The Tools Need Calibration</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">14-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Calibration Completed</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">10-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Torque wrench issued for SRV valve tightening</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">10-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Returned after inspection work completion</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">11-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Pressure gauge used for valve pressure testing</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">11-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Returned and verified by tool supervisor</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">12-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Chain pulley block used for lifting heavy valve</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">12-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Returned after lifting operation</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">13-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Valve lapping machine used for seat polishing</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">13-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Cleaning completed and returned</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">14-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Flange spreader used to separate pipeline flange</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">14-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Returned and inspected for damages</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">15-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Hydraulic torque wrench issued for bolt tightening</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">15-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Returned after maintenance activity</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">16-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Air compressor used for pneumatic valve testing</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">16-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Returned and stored in equipment room</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="fw-medium text-black fs-7">17-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Bearing puller used for valve component removal</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">17-Mar-2026</label>
                                            </td>
                                            <td>
                                                <label class="fw-medium text-black fs-7">Returned after dismantling operation</label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pt-5">
          <div class="d-flex justify-content-end align-items-center">
            <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Update Equipment</button>
          </div>
        </div>
        <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Update Equipments-->



<script>
    function addLog(){
        let selectStatus = document.getElementById("selectStatus");
        let selectedText = selectStatus.options[selectStatus.selectedIndex].text;

        let descText = document.getElementById("descText").value;
        let newDate = document.getElementById("newDate").value;

        let ownerStatus = document.getElementById("ownerStatus");
        let ownerStatusText = ownerStatus.options[ownerStatus.selectedIndex].text;

        let newData = document.getElementById("newData");

        if(selectStatus.value !== "" && descText !== "" && newDate !== "" && ownerStatus.value !== "0"){

            newData.insertAdjacentHTML("beforeend", `
                <tr>
                    <td><label>${selectedText}</label></td>
                    <td><label>${newDate}</label></td>
                    <td><label>${descText}</label></td>
                    <td><label>${ownerStatusText}</label></td>
                </tr>
            `);

            document.getElementById("descText").value = "";
            document.getElementById("newDate").value = "";
            document.getElementById("ownerStatus").selectedIndex = 0;
            document.getElementById("selectStatus").selectedIndex = 0;

        } else {
            alert("Enter All Fields");
        }
    }
</script>


<script>
    function editaddLog(){
        let editselectStatus = document.getElementById("editselectStatus");
        let selectedText  = editselectStatus.options[editselectStatus.selectedIndex].text;

        let editdescText = document.getElementById("editdescText").value;
        let editnewDate = document.getElementById("editnewDate").value;
        let editownerStatus = document.getElementById("editownerStatus");
        let ownerStatusText = editownerStatus.options[editownerStatus.selectedIndex].text;

        let editnewData = document.getElementById("editnewData");

        if(selectedText !== "Select Status" && descText !== "" && newDate !== "" && ownerStatusText !== "Select Status"){
            editnewData.insertAdjacentHTML("beforeend" , `
                <tr>
                    <td>
                        <label class="">${selectedText}</label>
                    </td>
                    <td>
                        <label class="">${editnewDate}</label>
                    </td>
                    <td>
                        <label class="">${editdescText}</label>
                    </td>
                    <td>
                        <label class="">${ownerStatusText}</label>
                    </td>
                    
                </tr>                 
            `)
            document.getElementById("descText").value = "" ;
            document.getElementById("newDate").value = "" ;
            document.getElementById("ownerStatus").selectedIndex  = 0;
            document.getElementById("selectStatus").selectedIndex  = 0;
         }
         else{
            alert("Enter All Fields")
         }
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
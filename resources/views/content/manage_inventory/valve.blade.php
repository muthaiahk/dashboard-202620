@extends('layouts/layoutMaster')

@section('title', 'Manage Inventory')

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


<!-- Lead List Table -->
<div class="card card-action">
        <div class="card-header pb-1">
            <div class="card-action-title">
                <div class="d-flex align-items-center  justify-content-between">
                    <h3 class="card-title mb-1">Manage Inventory</h3>
                    <div class="searchBar" style="position: relative; width: 300px;">
                        <input class="form-control" type="text" name="searchQueryInput"
                            placeholder="Search Valves By SN,Type,Manufacture" value=""
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
                    <!-- <label class="card-title mb-1 text-secondary fw-medium">Manage Stock Levels For Valves And Componenents</label> -->
                </div>
            </div>
            <div class="card-action-element">
                <div class="d-flex justify-content-end align-items-center mb-2">
                    <!-- <a href="javascript:;" class="btn btn-sm fw-bold btn-primary-outline border border-primary text-white me-1" id="filter">
                        <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Filter"><i class="mdi mdi-filter-outline text-primary text-center"></i></span>
                    </a> -->
                    <!-- <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_client">
                        <span class="me-2"><i class="mdi mdi-plus"></i></span>Add Client
                    </a> -->
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-lg-12">
                    <div class="d-flex gap-4 align-items-center border-bottom ">
                        <a href="{{ url('/manage_inventory') }}">
                            <label class="fw-medium text-black fs-6  pb-2 cursor-pointer"  >Dashboard</label>
                        </a>

                        <a href="{{ url('/manage_inventory_valve') }}">
                            <label class="fw-medium text-primary fs-6 pb-2 cursor-pointer" style="border-bottom:2px solid #4496C5;">Valves</label>
                        </a>

                        <a href="{{ url('/manage_inventory_spare_parts') }}">
                            <label class="fw-medium text-black fs-6 pb-2 cursor-pointer">Spare Parts</label>
                        </a>

                        <a href="{{ url('/manage_inventory_calibration') }}">
                            <label class="fw-medium text-black fs-6 pb-2 cursor-pointer">Calibration Queue</label>
                        </a>
                        <a href="{{ url('/store_management') }}">
                            <label class="fw-medium text-black fs-6 pb-2 cursor-pointer">Store Management</label>
                        </a>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="p-3 rounded border d-flex flex-column bg-white">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex gap-2 align-items-center">

                                        <div class="rounded p-3" style="background:#e3f2fd; color:#0d47a1; ">
                                            <i class="mdi mdi-cog fs-3"></i>
                                        </div>
                                        
                                        <div class="d-flex flex-column">
                                            <label class="text-black fw-semibold fs-6">SN-10001</label>
                                            <label class="text-secondary fw-semibold fs-8" >Gate Valve. 4"</label>
                                        </div>

                                    </div>
                                    <span class="badge bg-label-success fw-semibold ">In Store</span>
                                </div>
                                <hr class="my-3">
                                <div class="d-flex flex-column gap-2">

                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="mdi mdi-map-marker text-secondary"></span>
                                            <label class="text-secondary fs-7 fw-semibold">Location</label>
                                        </div>
                                        <label class="text-black fs-7 fw-semibold">Main Store</label>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="mdi mdi-cogs text-secondary"></span>
                                            <label class="text-secondary fs-7 fw-semibold">Manufacture</label>
                                        </div>
                                        <label class="text-black fs-7 fw-semibold">FlowServe</label>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="mdi mdi-link-variant text-secondary"></span>
                                            <label class="text-secondary fs-7 fw-semibold">Connection</label>
                                        </div>
                                        <label class="text-black fs-7 fw-semibold">Flanged</label>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="mdi mdi-phone text-secondary"></span>
                                            <label class="text-secondary fs-7 fw-semibold">Next Call</label>
                                        </div>
                                        <label class="text-danger fs-7 fw-semibold">12-03-2026</label>
                                    </div>
                                    
                                </div>
                                <hr class="my-3">
                                <div class="row">
                                    <div class="col-lg-12 d-flex align-items-center justify-content-center">
                                        <button class="btn btn-sm  py-2 btn-outline-secondary  text-nowrap" style="padding-left:70px; padding-right:70px;" data-bs-toggle="modal" data-bs-target="#kt_modal_view_details">View Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="p-3 rounded border d-flex flex-column bg-white">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex gap-2 align-items-center">

                                        <div class="rounded p-3" style="background:#e3f2fd; color:#0d47a1; ">
                                            <i class="mdi mdi-cog fs-3"></i>
                                        </div>
                                        
                                        <div class="d-flex flex-column">
                                            <label class="text-black fw-semibold fs-6">SN-10002</label>
                                            <label class="text-secondary fw-semibold fs-8" >Control Valve. 6"</label>
                                        </div>

                                    </div>
                                    <span class="badge bg-label-warning text-black fw-semibold ">Under Calibration</span>
                                </div>
                                <hr class="my-3">
                                <div class="d-flex flex-column gap-2">

                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="mdi mdi-map-marker text-secondary"></span>
                                            <label class="text-secondary fs-7 fw-semibold">Location</label>
                                        </div>
                                        <label class="text-black fs-7 fw-semibold">QE Calibration Facility</label>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="mdi mdi-cogs text-secondary"></span>
                                            <label class="text-secondary fs-7 fw-semibold">Manufacture</label>
                                        </div>
                                        <label class="text-black fs-7 fw-semibold">Fisher</label>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="mdi mdi-link-variant text-secondary"></span>
                                            <label class="text-secondary fs-7 fw-semibold">Connection</label>
                                        </div>
                                        <label class="text-black fs-7 fw-semibold">Welded</label>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="mdi mdi-phone text-secondary"></span>
                                            <label class="text-secondary fs-7 fw-semibold">Next Call</label>
                                        </div>
                                        <label class="text-danger fs-7 fw-semibold">14-03-2026</label>
                                    </div>
                                    
                                </div>
                                <hr class="my-3">
                                <div class="row">
                                    <div class="col-lg-12 d-flex align-items-center justify-content-center">
                                        <button class="btn btn-sm  py-2 btn-outline-secondary text-nowrap" style="padding-left:70px; padding-right:70px;"data-bs-toggle="modal" data-bs-target="#kt_modal_view_details">View Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--begin::Modal - View Details-->
<div class="modal fade" id="kt_modal_view_details" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
    data-bs-backdrop="static" data-bs-focus="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-md">
        <!--begin::Modal content-->
      <div class="modal-content rounded">
        <!--begin::Modal header-->
        <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
          <h4 class="text-center text-black">View Valve Details</h4>
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
                <div class="col-lg-6 mb-3 d-flex flex-column">
                    <label class="text-dark fw-medium fs-7">Serial Number</label>
                    <label class="text-black fw-semibold fs-6">SN-001</label>
                </div>
                <div class="col-lg-6 mb-3 d-flex flex-column">
                    <label class="text-dark fw-medium fs-7">Type</label>
                    <label class="text-black fw-semibold fs-6">Safety Relief Valve</label>
                </div>
                <div class="col-lg-6 mb-3 d-flex flex-column">
                    <label class="text-dark fw-medium fs-7">Size</label>
                    <label class="text-black fw-semibold fs-6">4"</label>
                </div>
                <div class="col-lg-6 mb-3 d-flex flex-column">
                    <label class="text-dark fw-medium fs-7">Status</label>
                    <label class="">
                        <span class="badge bg-label-success rounded fs-7">In Store</span>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <div class="card bg-gray-100 border rounded px-2 py-2">
                        <div class="row mb-2"> 
                            <div class="col-lg-12 d-flex align-items-center justify-content-start gap-2 mb-2">
                                <i class="mdi mdi-calendar-blank-outline text-black fs-5"></i>
                                <label class="fw-medium text-black fs-6">Calibration Tracking</label>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-6 mb-2 d-flex align-items-center justify-content-start gap-2">
                                <label class="fw-medium text-dark fs-7">Frequency</label>
                                <label class="fw-medium text-dark fs-7">:</label>
                                <label class="fw-medium text-black fs-7">12 Months</label>
                            </div>
                            <div class="col-lg-6 mb-2 d-flex align-items-center justify-content-start gap-2">
                                <label class="fw-medium text-dark fs-7">Last Calibrated</label>
                                <label class="fw-medium text-dark fs-7">:</label>
                                <label class="fw-medium text-black fs-7">10-Mar-2025</label>
                            </div>
                            <div class="col-lg-6 mb-2 d-flex align-items-center justify-content-start gap-2">
                                <label class="fw-medium text-dark fs-7">Next Due</label>
                                <label class="fw-medium text-dark fs-7">:</label>
                                <label class="fw-medium text-black fs-7">10-Mar-2026</label>
                            </div>
                            <div class="col-lg-6 mb-2 d-flex align-items-center justify-content-start gap-2">
                                <label class="fw-medium text-dark fs-7">Certificate</label>
                                <label class="fw-medium text-dark fs-7">:</label>
                                <a href="{{ asset('assets/images/def_doc_img.png') }}" download>View PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2"> 
                <div class="col-lg-12 d-flex align-items-center justify-content-start gap-2 mb-2">
                    <i class="mdi mdi-clock-outline text-black fs-5"></i>
                    <label class="fw-medium text-black fs-6">Movement History</label>
                </div>
                <div class="col-lg-12 mb-3 table-wrapper scroll-y max-h-300px">
                    <table class="table align-middle table-row-dashed table-striped table-hover gy-0 gs-1 ">
                        <thead class="sticky-top">
                            <tr class="text-start align-top  fw-bold fs-6 gs-0 bg-gray-100">
                                <th class="min-w-100px text-black">Date</th>
                                <th class="min-w-100px text-black">From -> to</th>
                                <th class="min-w-100px text-black">Supervisor</th>
                                <th class="min-w-100px text-black">Vehicle</th>
                            </tr>
                        </thead>
                        <tbody class="text-black fw-semibold fs-7">
                            <tr>
                                <td>
                                    <label class="fw-medium text-black fs-7">13-Mar-2026 10:25 AM</label>
                                </td>
                                <td>
                                    <label class="fw-medium text-black fs-7">Main Store -> QE Calibration</label>
                                </td>
                                <td>
                                    <label class="fw-medium text-black fs-7">John Smith</label>
                                </td>
                                <td>
                                    <label class="fw-medium text-black fs-7">Truck 01</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="fw-medium text-black fs-7">10-Mar-2026 02:05 PM</label>
                                </td>
                                <td>
                                    <label class="fw-medium text-black fs-7">Supplier -> Main Store</label>
                                </td>
                                <td>
                                    <label class="fw-medium text-black fs-7">Christopher</label>
                                </td>
                                <td>
                                    <label class="fw-medium text-black fs-7">-</label>
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
<!--end::Modal - View Details-->
@endsection
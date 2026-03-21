@extends('layouts/layoutMaster')

@section('title', 'Manage Vehicles')

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
                <h3 class="card-title mb-1">Manage Vehicles</h3>
                <div class="nav-align-top nav-tabs-shadow">
                    <ul class="nav nav-tabs" role="tablist" style="overflow-x:hidden !important;">
                        <li class="nav-item">
                            <a href="{{ url('/manage_tools_equipments') }}" type="button" class="nav-link">
                                <span class="d-none d-sm-inline-flex align-items-center">
                                    <i class="mdi mdi-wrench-outline me-2"></i>
                                    Tools & Equipments
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/manage_vehicle') }}" type="button" class="nav-link active">
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
                        <input class="form-control" type="text" name="searchQueryInput" placeholder="Search Vehicle "
                            value="" id="vehicleSearchInput" style="padding-left: 35px;" />
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
                    <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_add_vehicle">
                        <span class="me-2"><i class="mdi mdi-plus"></i></span>Add Vehicles
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @if (count($vehicles) > 0)
                    @foreach ($vehicles as $vehicle)
                        <div class="col-lg-3 vehicle-card">
                            <div class="p-3 rounded border d-flex flex-column bg-white">

                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex gap-2 align-items-center">
                                        <label class="text-black fw-semibold fs-6">
                                            {{ $vehicle->vehicle_name }}
                                        </label>
                                    </div>

                                    <span data-bs-toggle="tooltip" title="Update">
                                        <i class="mdi mdi-pencil-outline text-secondary me-1 cursor-pointer"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_update_vehicle"
                                            onclick="editVehicle(
                                            '{{ $vehicle->id }}',
                                            '{{ $vehicle->vehicle_name }}',
                                            '{{ $vehicle->brand }}',
                                            '{{ $vehicle->manufacturer }}',
                                            '{{ $vehicle->model }}',
                                            '{{ $vehicle->registered_number }}',
                                            '{{ $vehicle->engine_number }}',
                                            '{{ $vehicle->chasis_number }}',
                                            '{{ $vehicle->current_location }}',
                                            '{{ $vehicle->capacity }}',
                                            '{{ $vehicle->length }}'
                                        )">
                                        </i>
                                    </span>
                                </div>

                                <hr class="my-3">

                                <!-- Body -->
                                <div class="d-flex flex-column gap-2">

                                    <!-- Reg No -->
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="mdi mdi-tag-outline text-secondary"></span>
                                            <label class="text-secondary fs-7 fw-semibold">Reg No</label>
                                        </div>
                                        <label class="text-black fs-7 fw-semibold">
                                            {{ $vehicle->registered_number }}
                                        </label>
                                    </div>

                                    <!-- Manufacturer -->
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="mdi mdi-shield-outline text-secondary"></span>
                                            <label class="text-secondary fs-7 fw-semibold">Manufacturer</label>
                                        </div>
                                        <label class="badge bg-label-danger text-danger fs-7 fw-semibold">
                                            {{ $vehicle->manufacturer }}
                                        </label>
                                    </div>

                                    <!-- Model -->
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="mdi mdi-office-building-outline text-secondary"></span>
                                            <label class="text-secondary fs-7 fw-semibold">Model</label>
                                        </div>
                                        <label class="text-black fs-7 fw-semibold">
                                            {{ $vehicle->model }}
                                        </label>
                                    </div>

                                </div>

                                <hr class="my-3">

                                <!-- Status (Static for now) -->
                                <div class="row">
                                    <div class="col-lg-12 d-flex align-items-center gap-1">

                                        {{-- Example logic (optional dynamic later) --}}
                                        @if ($vehicle->status == 'available')
                                            <span class="mdi mdi-check-decagram-outline text-success"></span>
                                            <label class="text-success fs-7 fw-semibold">Available</label>
                                        @elseif($vehicle->status == 'in_use')
                                            <span class="mdi mdi-refresh text-primary"></span>
                                            <label class="text-primary fs-7 fw-semibold">In Use</label>
                                        @elseif($vehicle->status == 'maintenance')
                                            <span class="mdi mdi-information-outline text-warning"></span>
                                            <label class="text-warning fs-7 fw-semibold">Maintenance</label>
                                        @else
                                            <span class="mdi mdi-check-decagram-outline text-success"></span>
                                            <label class="text-success fs-7 fw-semibold">Available</label>
                                        @endif

                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                    <div class="empty-state" id="noDataMessage" style="display:none">
                        <div class="empty-box">
                            <div class="empty-icon">
                                <svg width="80" height="80" viewBox="0 0 24 24" fill="none">
                                    <rect x="1" y="10" width="13" height="6" rx="1.5" stroke="#9CA3AF"
                                        stroke-width="1.5" />
                                    <path d="M14 12h4l3 3v1h-7z" stroke="#9CA3AF" stroke-width="1.5"
                                        stroke-linejoin="round" />
                                    <circle cx="5" cy="18" r="1.5" stroke="#9CA3AF" stroke-width="1.5" />
                                    <circle cx="17" cy="18" r="1.5" stroke="#9CA3AF" stroke-width="1.5" />
                                </svg>
                            </div>
                            <div class="empty-title">vehicle Not Found</div>
                            <div class="empty-text">
                                No vehicle records available. Please add a new vehicle to get started.
                            </div>
                        </div>
                    </div>
                @else
                    <div class="empty-state" id="noDataMessage" style="display:none">
                        <div class="empty-box">
                            <div class="empty-icon">
                                <svg width="80" height="80" viewBox="0 0 24 24" fill="none">
                                    <rect x="1" y="10" width="13" height="6" rx="1.5" stroke="#9CA3AF"
                                        stroke-width="1.5" />
                                    <path d="M14 12h4l3 3v1h-7z" stroke="#9CA3AF" stroke-width="1.5"
                                        stroke-linejoin="round" />
                                    <circle cx="5" cy="18" r="1.5" stroke="#9CA3AF" stroke-width="1.5" />
                                    <circle cx="17" cy="18" r="1.5" stroke="#9CA3AF" stroke-width="1.5" />
                                </svg>
                            </div>
                            <div class="empty-title">vehicle Not Found</div>
                            <div class="empty-text">
                                No vehicle records available. Please add a new vehicle to get started.
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>




    <!--begin::Modal - Add Vehicle-->
    <div class="modal fade" id="kt_modal_add_vehicle" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
        data-bs-backdrop="static" data-bs-focus="false">

        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg">

            <!--begin::Modal content-->
            <div class="modal-content rounded">

                <!--begin::Modal header-->
                <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
                    <h4 class="text-center text-black">Create Vehicle</h4>

                    <div class="btn btn-sm btn-icon btn-active-color-primary mb-4" data-bs-dismiss="modal">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </div>
                </div>
                <!--end::Modal header-->

                <!--begin::Form-->
                <form id="vehicleForm">

                    <!--begin::Modal body-->
                    <div class="modal-body py-5 px-10 px-xl-20">

                        <div class="nav-align-top p-0">

                            <!-- Tabs -->
                            <ul class="nav nav-tabs mb-4">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#navs-top-home">Details & Specs</button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#navs-top-profile">Maintenance</button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#usage-history">Usage History</button>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content p-0" style="box-shadow:none !important;">

                                <!-- Details Tab -->
                                <div class="tab-pane fade show active" id="navs-top-home">
                                    <div class="row">

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">
                                                Vehicle Name<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="vehicle_name" class="form-control"
                                                placeholder="Enter Vehicle Name" />
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">
                                                Brand<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="brand" class="form-control"
                                                placeholder="Enter Brand" />
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">
                                                Manufacturer<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="manufacturer" class="form-control"
                                                placeholder="Enter Manufacturer" />
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">
                                                Model<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="model" class="form-control"
                                                placeholder="Enter Model" />
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">
                                                Registered Number<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="registered_number" class="form-control"
                                                placeholder="Enter Registered Number" />
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">
                                                Engine Number<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="engine_number" class="form-control"
                                                placeholder="Enter Engine Number" />
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">
                                                Chasis Number<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="chasis_number" class="form-control"
                                                placeholder="Enter Chasis Number" />
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">
                                                Current Location<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="current_location" class="form-control"
                                                placeholder="Enter Current Location" />
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Capacity</label>
                                            <input type="text" class="form-control" placeholder="Enter Capacity" />
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Length</label>
                                            <input type="text" class="form-control" placeholder="Enter Length" />
                                        </div>

                                    </div>
                                </div>

                                <!-- Maintenance Tab -->
                                <div class="tab-pane fade" id="navs-top-profile">
                                    <div class="row">

                                        <div class="col-lg-12 my-1">
                                            <label class="text-secondary mb-1 fs-7 fw-semibold">Add New Entry</label>
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <select class="select3 form-select" id="selectStatus">
                                                <option value="">Select Status</option>
                                                <option>Calibration</option>
                                                <option>Repair</option>
                                                <option>Maintance</option>
                                                <option>Inspection</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-6 mb-2">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text">
                                                    <i class="mdi mdi-calendar-month-outline fs-4"></i>
                                                </span>
                                                <input type="text" class="form-control common_datepicker"
                                                    placeholder="Select Date" id="newDate">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mb-3">
                                            <textarea class="form-control" rows="1" id="descText" placeholder="Description Of Work Performed..."></textarea>
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <select class="select3 form-select" id="ownerStatus">
                                                <option value="0">Select Ownership</option>
                                                <option>Internal</option>
                                                <option>SafeAccess LTD</option>
                                                <option>HeavyLift Co.</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-6 mb-3 d-flex align-items-end justify-content-end">
                                            <label class="btn btn-outline-primary btn-sm" onclick="addLog()">Add
                                                Log</label>
                                        </div>

                                        <div class="col-lg-12 my-1">
                                            <label class="text-secondary mb-1 fs-7 fw-semibold">Historical Records</label>
                                        </div>

                                        <div class="col-lg-12 my-3">
                                            <table class="table table-striped table-hover">
                                                <thead class="bg-gray-100">
                                                    <tr>
                                                        <th>Purpose</th>
                                                        <th>Date</th>
                                                        <th>Description</th>
                                                        <th>Ownership</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="newData"></tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>

                                <!-- Usage History Tab (UNCHANGED) -->
                                <div class="tab-pane fade" id="usage-history">
                                    <!-- Your same static table kept exactly -->
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer pt-5">
                        <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Vehicle</button>
                    </div>

                </form>
                <!--end::Form-->

            </div>
        </div>
    </div>
    <!--end::Modal-->



    <!--begin::Modal - Update Vehicle-->
    <div class="modal fade" id="kt_modal_update_vehicle" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
        data-bs-backdrop="static" data-bs-focus="false">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
                    <h4 class="text-center text-black">Update Vehicle</h4>
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
                <form id="updateVehicleForm">
                    @csrf
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body py-5 px-10 px-xl-20">
                        <div class="nav-align-top p-0">
                            <ul class="nav nav-tabs mb-4" role="tablist">
                                <li class="nav-item">
                                    <button type="button"class="nav-link active" role="tab"data-bs-toggle="tab"
                                        data-bs-target="#navs-top-home_edit" aria-controls="navs-top-home_edit"
                                        aria-selected="true">Details & Specs</button>
                                </li>
                                <li class="nav-item">
                                    <button type="button"class="nav-link" role="tab"data-bs-toggle="tab"
                                        data-bs-target="#navs-top-profile_edit" aria-controls="navs-top-profile_edit"
                                        aria-selected="false">Maintenance</button>
                                </li>
                                <li class="nav-item">
                                    <button type="button"class="nav-link" role="tab"data-bs-toggle="tab"
                                        data-bs-target="#usage-history-edit" aria-controls="usage-history-edit"
                                        aria-selected="false">Usage History</button>
                                </li>
                            </ul>

                            <div class="tab-content  p-0" style="box-shadow:none !important;">
                                <div class="tab-pane fade show active" id="navs-top-home_edit" role="tabpanel">
                                    <div class="row">
                                        <input type="hidden" id="edit_id" name="id">
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Vehicle Name<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="edit_vehicle_name" name="vehicle_name"
                                                class="form-control" placeholder="Enter Vehicle Name" />
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Brand<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="edit_brand" name="brand"
                                                placeholder="Enter Brand" />
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Manufacturer<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="edit_manufacturer"
                                                name="manufacturer" placeholder="Enter Manufacturer" />
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Model<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="edit_model" name="model"
                                                placeholder="Enter Model" />
                                        </div>
                                        <div class="col-lg-12 my-1">
                                            <label class="text-secondary mb-1 fs-7 fw-semibold">Vehicle Details</label>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Registered Number<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="edit_registered_number" name="registered_number"
                                                class="form-control" placeholder="Enter Registered Number" />
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Engine Number<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="edit_engine_number" name="engine_number"
                                                class="form-control" placeholder="Enter Engine Number" />
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Chasis Number<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="edit_chasis_number" name="chasis_number"
                                                class="form-control" placeholder="Enter Chasis Number" />
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Current Location<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="edit_current_location" name="current_location"
                                                class="form-control" placeholder="Enter Current Location" />
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Capacity</label>
                                            <input type="text" id="edit_capacity" name="capacity"
                                                class="form-control" placeholder="Enter Capacity" />
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Length</label>
                                            <input type="text" id="edit_length" name="length" class="form-control"
                                                placeholder="Enter Length" />
                                        </div>
                                    </div>
                                    <div class="modal-footer pt-5">
                                        <div class="d-flex justify-content-end align-items-center">
                                            <button type="reset" class="btn btn-secondary me-3"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" id="updateVehicleSubmitBtn"
                                                class="btn btn-primary">Update
                                                Vehicle</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="navs-top-profile_edit" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 my-1">
                                            <label class="text-secondary mb-1 fs-7 fw-semibold">Add New Entry</label>
                                        </div>
                                        <div class="col-lg-6 mb-3">
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
                                                <input type="text" class="form-control common_datepicker"
                                                    placeholder="Select Date" id="editnewDate">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <textarea class="form-control" rows="1" placeholder="Description Of Work Performed..." id="editdescText"></textarea>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <select class="select3 form-select" id="editownerStatus">
                                                <option value="0">Select Ownership</option>
                                                <option value="1">Internal</option>
                                                <option value="2">SafeAccess LTD</option>
                                                <option value="3">HeavyLift Co.</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 mb-3 d-flex align-items-end justify-content-end">
                                            <label class="btn btn-outline-primary btn-sm" onclick="editaddLog()">Add
                                                Log</label>
                                        </div>
                                        <div class="col-lg-12 my-1">
                                            <label class="text-secondary mb-1 fs-7 fw-semibold">Historical Records</label>
                                        </div>
                                        <div class="col-lg-12 my-3">
                                            <table
                                                class="table align-middle table-row-dashed table-striped table-hover gy-0 gs-1 ">
                                                <thead>
                                                    <tr class="text-start align-top  fw-bold fs-6 gs-0 bg-gray-100">
                                                        <th class="min-w-100px text-black">Purpose</th>
                                                        <th class="min-w-100px text-black">Date</th>
                                                        <th class="min-w-100px text-black">Description</th>
                                                        <th class="min-w-100px text-black">Ownership</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-black fw-semibold fs-7" id="editnewData">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="usage-history-edit" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3 table-wrapper scroll-y max-h-300px">
                                            <table
                                                class="table align-middle table-row-dashed table-striped table-hover gy-0 gs-1 ">
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
                                                            <label class="fw-medium text-black fs-7">The Tools Need
                                                                Calibration</label>
                                                        </td>
                                                        <td>
                                                            <label class="fw-medium text-black fs-7">14-Mar-2026</label>
                                                        </td>
                                                        <td>
                                                            <label class="fw-medium text-black fs-7">Calibration
                                                                Completed</label>
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
                </form>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Update Vehicles-->

    <script>
        $("#vehicleSearchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            var visibleCount = 0;

            $(".vehicle-card").filter(function() {
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

        function editVehicle(id, name, brand, manufacturer, model, reg, engine, chasis, location, capacity, length) {

            // Fill vehicle details
            $('#edit_id').val(id);
            $('#edit_vehicle_name').val(name);
            $('#edit_brand').val(brand);
            $('#edit_manufacturer').val(manufacturer);
            $('#edit_model').val(model);
            $('#edit_registered_number').val(reg);
            $('#edit_engine_number').val(engine);
            $('#edit_chasis_number').val(chasis);
            $('#edit_current_location').val(location);
            $('#edit_capacity').val(capacity);
            $('#edit_length').val(length);

            // ✅ CLEAR OLD DATA
            $('#editnewData').html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');

            // ✅ FETCH MAINTENANCE HISTORY
            fetch('/vehicle/maintenance/' + id)
                .then(res => res.json())
                .then(rows => {

                    let html = '';

                    if (rows.length === 0) {
                        html = '<tr><td colspan="4" class="text-center text-muted">No maintenance records</td></tr>';
                    } else {
                        rows.forEach(row => {

                            let d = new Date(row.date);
                            let displayDate = d.toLocaleDateString('en-GB', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric'
                            });

                            html += `
                        <tr>
                            <td>${row.purpose}</td>
                            <td>${displayDate}</td>
                            <td>${row.description ?? '-'}</td>
                            <td>${row.ownership}</td>
                        </tr>
                    `;
                        });
                    }

                    document.getElementById('editnewData').innerHTML = html;
                })
                .catch(() => {
                    document.getElementById('editnewData').innerHTML =
                        '<tr><td colspan="4" class="text-danger text-center">Failed to load</td></tr>';
                });
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {

            // Add Vehicle Form
            $('#vehicleForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let submitBtn = $('#vehicleSubmitBtn');
                let formData = form.serialize();

                // Remove old errors
                $('.error-text').remove();
                $('.is-invalid').removeClass('is-invalid');

                // Disable button and show loading
                submitBtn.prop('disabled', true);
                submitBtn.html('<span class="spinner-border spinner-border-sm"></span> Saving...');

                $.ajax({
                    url: "{{ route('vehicles.store') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        form[0].reset();
                        $('#kt_modal_add_vehicle').modal('hide');

                        // Reset button BEFORE reload
                        submitBtn.prop('disabled', false);
                        submitBtn.html('<span class="btn-text">Save Vehicle</span>');

                        // Reload page or update table dynamically
                        location.reload();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                let input = $('[name="' + key + '"]');
                                input.addClass('is-invalid');
                                input.after('<small class="text-danger error-text">' +
                                    value[0] + '</small>');
                            });
                        } else {
                            toastr.error('Something went wrong.');
                        }
                    }
                });
            });

            // Update Vehicle Form
            $('#updateVehicleForm').submit(function(e) {
                e.preventDefault();

                let form = $(this);
                let submitBtn = $('#updateVehicleSubmitBtn');
                let id = $('#edit_id').val();

                // Disable button and show loading
                submitBtn.prop('disabled', true);
                submitBtn.html('<span class="spinner-border spinner-border-sm"></span> Updating...');

                $.ajax({
                    url: '/update-vehicle/' + id,
                    type: 'POST',
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        toastr.success(res.message);
                        $('#kt_modal_update_vehicle').modal('hide');

                        // Reset button BEFORE reload
                        submitBtn.prop('disabled', false);
                        submitBtn.html('<span class="btn-text">Update Vehicle</span>');

                        location.reload();
                    },
                    error: function(err) {
                        if (err.responseJSON && err.responseJSON.errors) {
                            toastr.error('Validation failed.');
                        } else {
                            toastr.error('Something went wrong.');
                        }

                        // Reset button even if error
                        submitBtn.prop('disabled', false);
                        submitBtn.html('<span class="btn-text">Update Vehicle</span>');
                    }
                });
            });

        });
    </script>

    <script>
        function addLog() {
            let selectStatus = document.getElementById("selectStatus");
            let selectedText = selectStatus.options[selectStatus.selectedIndex].text;

            let descText = document.getElementById("descText").value;
            let newDate = document.getElementById("newDate").value;

            let ownerStatus = document.getElementById("ownerStatus");
            let ownerStatusText = ownerStatus.options[ownerStatus.selectedIndex].text;

            let newData = document.getElementById("newData");

            if (selectStatus.value !== "" && descText !== "" && newDate !== "" && ownerStatus.value !== "0") {

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
        // function editaddLog() {
        //     let editselectStatus = document.getElementById("editselectStatus");
        //     let selectedText = editselectStatus.options[editselectStatus.selectedIndex].text;

        //     let editdescText = document.getElementById("editdescText").value;
        //     let editnewDate = document.getElementById("editnewDate").value;
        //     let editownerStatus = document.getElementById("editownerStatus");
        //     let ownerStatusText = editownerStatus.options[editownerStatus.selectedIndex].text;

        //     let editnewData = document.getElementById("editnewData");

        //     if (selectedText !== "Select Status" && descText !== "" && newDate !== "" && ownerStatusText !==
        //         "Select Status") {
        //         editnewData.insertAdjacentHTML("beforeend", `
    //         <tr>
    //             <td>
    //                 <label class="">${selectedText}</label>
    //             </td>
    //             <td>
    //                 <label class="">${editnewDate}</label>
    //             </td>
    //             <td>
    //                 <label class="">${editdescText}</label>
    //             </td>
    //             <td>
    //                 <label class="">${ownerStatusText}</label>
    //             </td>

    //         </tr>                 
    //     `)
        //         document.getElementById("descText").value = "";
        //         document.getElementById("newDate").value = "";
        //         document.getElementById("ownerStatus").selectedIndex = 0;
        //         document.getElementById("selectStatus").selectedIndex = 0;
        //     } else {
        //         alert("Enter All Fields")
        //     }
        // }
    </script>


    <script>
        window.editaddLog = function() {

            let vehicleId = document.getElementById("edit_id").value;

            let purposeSelect = document.getElementById("editselectStatus");
            let purposeText = purposeSelect.options[purposeSelect.selectedIndex].text;
            let purposeVal = purposeSelect.value;

            let date = document.getElementById("editnewDate").value;
            let desc = document.getElementById("editdescText").value;

            let ownerSelect = document.getElementById("editownerStatus");
            let ownerText = ownerSelect.options[ownerSelect.selectedIndex].text;
            let ownerVal = ownerSelect.value;

            if (!vehicleId) {
                alert("Vehicle ID missing. Reopen modal.");
                return;
            }

            if (purposeVal === "0" || ownerVal === "0" || !date || !desc) {
                alert("Enter all fields");
                return;
            }

            fetch('/vehicle/maintenance/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        vehicle_id: vehicleId,
                        purpose: purposeText,
                        date: date,
                        ownership: ownerText,
                        description: desc
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {

                        document.getElementById("editnewData").insertAdjacentHTML("beforeend", `
                <tr>
                    <td><label>${purposeText}</label></td>
                    <td><label>${date}</label></td>
                    <td><label>${desc}</label></td>
                    <td><label>${ownerText}</label></td>
                </tr>
            `);

                        document.getElementById("editdescText").value = "";
                        document.getElementById("editnewDate").value = "";
                        document.getElementById("editownerStatus").selectedIndex = 0;
                        document.getElementById("editselectStatus").selectedIndex = 0;

                        toastr.success("Maintenance log added successfully");
                    }
                })
                .catch(error => {
                    toastr.success("Failed to add log");
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

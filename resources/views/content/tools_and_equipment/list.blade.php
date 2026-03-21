@extends('layouts/layoutMaster')

@section('title', 'Manage Tools And Equipments')

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
                <h3 class="card-title mb-1">Manage Tools And Equipments</h3>
                <div class="nav-align-top nav-tabs-shadow">
                    <ul class="nav nav-tabs" role="tablist" style="overflow-x:hidden !important;">
                        <li class="nav-item">
                            <a href="{{ url('/manage_tools_equipments') }}" type="button" class="nav-link active">
                                <span class="d-none d-sm-inline-flex align-items-center">
                                    <i class="mdi mdi-wrench-outline me-2"></i>
                                    Tools & Equipments
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/manage_vehicle') }}" type="button" class="nav-link">
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
                        <input class="form-control" type="text" id="toolsSearchinput" name="searchQueryInput"
                            placeholder="Search Equipments " value="" style="padding-left: 35px;" />
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
                        data-bs-target="#kt_modal_add_equipments">
                        <span class="me-2"><i class="mdi mdi-plus"></i></span>Add Equipment
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @if (count($equipments) > 0)
                    @foreach ($equipments as $equipment)
                        <div class="col-lg-3 toolscard">
                            <div class="p-3 rounded border d-flex flex-column bg-white">
                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="d-flex flex-column">
                                            <label
                                                class="text-secondary fw-semibold fs-8">{{ $equipment->category }}</label>
                                            <label class="text-black fw-semibold fs-6 text-truncate"
                                                style="max-width:200px;" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="{{ $equipment->equipment_name }}">
                                                {{ $equipment->equipment_name }}
                                            </label>
                                        </div>
                                    </div>
                                    <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Update">
                                        <i class="mdi mdi-pencil-outline text-secondary me-1 cursor-pointer"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_update_equipments"
                                            data-id="{{ $equipment->id }}" data-name="{{ $equipment->equipment_name }}"
                                            data-category="{{ $equipment->category }}"
                                            data-serial="{{ $equipment->serial_number }}"
                                            data-manufacturer="{{ $equipment->manufacturer }}"
                                            data-model="{{ $equipment->model }}"
                                            data-ownership="{{ $equipment->ownership }}"
                                            data-status="{{ $equipment->current_status }}"
                                            data-location="{{ $equipment->current_location }}"
                                            data-certificate="{{ $equipment->certificate }}"
                                            data-expiry="{{ $equipment->expiry_date }}"></i>
                                    </span>
                                </div>

                                <hr class="my-3">

                                <!-- Details -->
                                <div class="d-flex flex-column gap-2">

                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="mdi mdi-tag-outline text-secondary"></span>
                                            <label class="text-secondary fs-7 fw-semibold">Serial No</label>
                                        </div>
                                        <label class="text-black fs-7 fw-semibold">{{ $equipment->serial_number }}</label>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="mdi mdi-shield-outline text-secondary"></span>
                                            <label class="text-secondary fs-7 fw-semibold">Cert. Exp</label>
                                        </div>
                                        @if ($equipment->expiry_date && $equipment->expiry_date < now())
                                            <label
                                                class="badge bg-label-danger text-danger fs-7 fw-semibold">Expired</label>
                                        @else
                                            <label
                                                class="badge bg-label-success text-success fs-7 fw-semibold">Valid</label>
                                        @endif
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="mdi mdi-office-building-outline text-secondary"></span>
                                            <label class="text-secondary fs-7 fw-semibold">Owner</label>
                                        </div>
                                        <label class="text-black fs-7 fw-semibold">{{ $equipment->ownership }}</label>
                                    </div>

                                </div>

                                <hr class="my-3">

                                <!-- Status -->
                                <div class="row">
                                    <div class="col-lg-12 d-flex align-items-center gap-1">
                                        @php
                                            $status = $equipment->current_status;
                                            $statusClasses = [
                                                'Available' => [
                                                    'icon' => 'mdi-check-decagram-outline',
                                                    'color' => 'success',
                                                ],
                                                'In Use' => ['icon' => 'mdi-reload', 'color' => 'primary'],
                                                'Maintenance' => [
                                                    'icon' => 'mdi-alert-decagram-outline',
                                                    'color' => 'warning',
                                                ],
                                                'Calibration' => ['icon' => 'mdi-tools', 'color' => 'info'],
                                                'Repair' => ['icon' => 'mdi-hammer-wrench', 'color' => 'danger'],
                                                'Inspection' => ['icon' => 'mdi-magnify', 'color' => 'primary'],
                                            ];
                                            $class = $statusClasses[$status] ?? [
                                                'icon' => 'mdi-help-circle-outline',
                                                'color' => 'secondary',
                                            ];
                                        @endphp

                                        <span
                                            class="mdi {{ $class['icon'] }} fw-semibold text-{{ $class['color'] }}"></span>
                                        <label
                                            class="badge bg-label-{{ $class['color'] }} text-{{ $class['color'] }} fs-7 fw-semibold">
                                            {{ $status }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="empty-state" id="noDataMessage" style="display:none">
                        <div class="empty-box">
                            <div class="empty-icon">
                                <svg width="80" height="80" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18v3h3l6.3-6.3a4 4 0 0 0 5.4-5.4l-2.1 2.1-3.3-3.3 2.4-2.4z"
                                        stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="empty-title">Tools Not Found</div>
                            <div class="empty-text">
                                No Tools records available. Please add a new Tools to get started.
                            </div>
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-box">
                            <div class="empty-icon">
                                <svg width="80" height="80" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18v3h3l6.3-6.3a4 4 0 0 0 5.4-5.4l-2.1 2.1-3.3-3.3 2.4-2.4z"
                                        stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="empty-title">Tools Not Found</div>
                            <div class="empty-text">
                                No Tools records available. Please add a new Tools to get started.
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!--begin::Modal - Add Equipments-->
    <div class="modal fade" id="kt_modal_add_equipments" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
        data-bs-backdrop="static" data-bs-focus="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded">

                <!-- Modal header -->
                <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
                    <h4 class="text-center text-black">Create New Equipment</h4>
                    <div class="btn btn-sm btn-icon btn-active-color-primary mb-4" data-bs-dismiss="modal">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </div>
                </div>

                <!-- Modal body -->
                <div class="modal-body py-5 px-10 px-xl-20">
                    <form id="equipmentForm">

                        <!-- Tabs -->
                        <div class="nav-align-top p-0">
                            <ul class="nav nav-tabs mb-4" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-top-home">Details & Specs</button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-top-profile">Maintenance</button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#usage-history">Usage History</button>
                                </li>
                            </ul>

                            <div class="tab-content p-0" style="box-shadow:none !important;">

                                <!-- Details & Specs Tab -->
                                <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Equipment Name<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="equipment_name"
                                                placeholder="Enter Equipment Name" />
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Category<span
                                                    class="text-danger">*</span></label>
                                            <select class="select3 form-select" name="category">
                                                <option value="">Select Category</option>
                                                <option value="Power Tool">Power Tool</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Serial Number<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="serial_number"
                                                placeholder="Enter Serial Number" />
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Manufacturer<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="manufacturer"
                                                placeholder="Enter Manufacturer" />
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Model<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="model"
                                                placeholder="Enter Model" />
                                        </div>

                                        <div class="col-lg-12 my-1">
                                            <label class="text-secondary mb-1 fs-7 fw-semibold">Ownership & Status</label>
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Ownership<span
                                                    class="text-danger">*</span></label>
                                            <select class="select3 form-select" name="ownership">
                                                <option value="">Select Ownership</option>
                                                <option value="Internal">Internal</option>
                                                <option value="SafeAccess LTD">SafeAccess LTD</option>
                                                <option value="HeavyLift Co.">HeavyLift Co.</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Current Status<span
                                                    class="text-danger">*</span></label>
                                            <select class="select3 form-select" name="current_status">
                                                <option value="">Select Current Status</option>
                                                <option value="Available">Available</option>
                                                <option value="Calibration">Calibration</option>
                                                <option value="Repair">Repair</option>
                                                <option value="Maintance">Maintenance</option>
                                                <option value="Inspection">Inspection</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Current Location<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="current_location"
                                                placeholder="Enter Current Location" />
                                        </div>

                                        <div class="col-lg-12 my-1">
                                            <label class="text-secondary mb-1 fs-7 fw-semibold">Certification &
                                                Date</label>
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Certificate<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="certificate"
                                                placeholder="Enter Certificate" />
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Expiry Date<span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i
                                                        class="mdi mdi-calendar-month-outline fs-4"></i></span>
                                                <input type="text" class="form-control common_datepicker"
                                                    name="expiry_date" placeholder="Select Date">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Details & Specs Tab -->

                                <!-- Maintenance Tab -->
                                <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 my-1">
                                            <label class="text-secondary mb-1 fs-7 fw-semibold">Add New Entry</label>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <select class="select3 form-select" id="selectStatus">
                                                <option value="">Select Status</option>
                                                <option value="Calibration">Calibration</option>
                                                <option value="Repair">Repair</option>
                                                <option value="Maintance">Maintenance</option>
                                                <option value="Inspection">Inspection</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 mb-2">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i
                                                        class="mdi mdi-calendar-month-outline fs-4"></i></span>
                                                <input type="text" class="form-control common_datepicker"
                                                    id="newDate" placeholder="Select Date">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <textarea class="form-control" rows="1" placeholder="Description Of Work Performed..." id="descText"></textarea>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <select class="select3 form-select" id="ownerStatus">
                                                <option value="0">Select Ownership</option>
                                                <option value="1">Internal</option>
                                                <option value="2">SafeAccess LTD</option>
                                                <option value="3">HeavyLift Co.</option>
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
                                            <table
                                                class="table align-middle table-row-dashed table-striped table-hover gy-0 gs-1">
                                                <thead>
                                                    <tr class="text-start align-top fw-bold fs-6 gs-0 bg-gray-100">
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
                                <!-- End Maintenance Tab -->

                                <!-- Usage History Tab -->
                                <div class="tab-pane fade" id="usage-history" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3 table-wrapper scroll-y max-h-300px">
                                            <table
                                                class="table align-middle table-row-dashed table-striped table-hover gy-0 gs-1">
                                                <thead class="sticky-top">
                                                    <tr class="text-start align-top fw-bold fs-6 gs-0 bg-gray-100">
                                                        <th class="min-w-100px text-black">Start Date</th>
                                                        <th class="min-w-100px text-black">Ticket</th>
                                                        <th class="min-w-100px text-black">Closed Date</th>
                                                        <th class="min-w-100px text-black">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-black fw-semibold fs-7">
                                                    <tr>
                                                        <td>13-Mar-2026</td>
                                                        <td>The Tools Need Calibration</td>
                                                        <td>14-Mar-2026</td>
                                                        <td>Calibration Completed</td>
                                                    </tr>
                                                    <tr>
                                                        <td>10-Mar-2026</td>
                                                        <td>Torque wrench issued for SRV valve tightening</td>
                                                        <td>10-Mar-2026</td>
                                                        <td>Returned after inspection work completion</td>
                                                    </tr>
                                                    <!-- Additional rows -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Usage History Tab -->

                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer pt-5">
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="reset" class="btn btn-secondary me-3"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Create New Equipment</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <!--begin::Modal - Update Equipments-->
    <div class="modal fade" id="kt_modal_update_equipments" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
        data-bs-backdrop="static" data-bs-focus="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded">
                <!-- Modal Header -->
                <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
                    <h4 class="text-center text-black">Update Equipment</h4>
                    <div class="btn btn-sm btn-icon btn-active-color-primary mb-4" data-bs-dismiss="modal">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="modal-body py-5 px-10 px-xl-20">
                    <input type="hidden" name="edit_equipment_id">

                    <div class="nav-align-top p-0">
                        <ul class="nav nav-tabs mb-4" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-top-home_edit" aria-selected="true">Details & Specs</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-top-profile_edit" aria-selected="false">Maintenance</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#usage-history-edit" aria-selected="false">Usage History</button>
                            </li>
                        </ul>

                        <div class="tab-content p-0" style="box-shadow:none !important;">
                            <!-- Details & Specs -->
                            <div class="tab-pane fade show active" id="navs-top-home_edit" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <label class="text-black mb-1 fs-7 fw-semibold">Equipment Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="edit_equipment_name"
                                            placeholder="Enter Equipment Name" />
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-black mb-1 fs-7 fw-semibold">Category<span
                                                class="text-danger">*</span></label>
                                        <select class="select3 form-select" name="edit_category">
                                            <option value="">Select Category</option>
                                            <option value="Power Tool">Power Tool</option>
                                            <option value="Crane">Crane</option>
                                            <option value="Calibration Instrument">Calibration Instrument</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-black mb-1 fs-7 fw-semibold">Serial Number<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="edit_serial_number"
                                            placeholder="Enter Serial Number" />
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-black mb-1 fs-7 fw-semibold">Manufacturer<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="edit_manufacturer"
                                            placeholder="Enter Manufacturer" />
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-black mb-1 fs-7 fw-semibold">Model<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="edit_model"
                                            placeholder="Enter Model" />
                                    </div>

                                    <div class="col-lg-12 my-1">
                                        <label class="text-secondary mb-1 fs-7 fw-semibold">Ownership & Status</label>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-black mb-1 fs-7 fw-semibold">Ownership<span
                                                class="text-danger">*</span></label>
                                        <select class="select3 form-select" name="edit_ownership">
                                            <option value="">Select Ownership</option>
                                            <option value="Internal">Internal</option>
                                            <option value="SafeAccess LTD">SafeAccess LTD</option>
                                            <option value="HeavyLift Co.">HeavyLift Co.</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-black mb-1 fs-7 fw-semibold">Current Status<span
                                                class="text-danger">*</span></label>
                                        <select class="select3 form-select" name="edit_current_status">
                                            <option value="">Select Current Status</option>
                                            <option value="Available">Available</option>
                                            <option value="Calibration">Calibration</option>
                                            <option value="Repair">Repair</option>
                                            <option value="Maintance">Maintenance</option>
                                            <option value="Inspection">Inspection</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-black mb-1 fs-7 fw-semibold">Current Location<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="edit_current_location"
                                            placeholder="Enter Current Location" />
                                    </div>

                                    <div class="col-lg-12 my-1">
                                        <label class="text-secondary mb-1 fs-7 fw-semibold">Certification & Date</label>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-black mb-1 fs-7 fw-semibold">Certificate<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="edit_certificate"
                                            placeholder="Enter Certificate" />
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-black mb-1 fs-7 fw-semibold">Expiry Date<span
                                                class="text-danger">*</span></label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i
                                                    class="mdi mdi-calendar-month-outline fs-4"></i></span>
                                            <input type="text" class="form-control common_datepicker"
                                                name="edit_expiry_date" placeholder="Select Date" />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer pt-5">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <button type="reset" class="btn btn-secondary me-3"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="updateEquipmentBtn">Update
                                            Equipment</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Maintenance -->
                            <div class="tab-pane fade" id="navs-top-profile_edit" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12 my-1">
                                        <label class="text-secondary mb-1 fs-7 fw-semibold">Add New Entry</label>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <select class="select3 form-select" id="editselectStatus">
                                            <option value="">Select Purpose</option>
                                            <option value="Inspection">Inspection</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i
                                                    class="mdi mdi-calendar-month-outline fs-4"></i></span>
                                            <input type="text" class="form-control common_datepicker" id="editnewDate"
                                                placeholder="Select Date">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <textarea class="form-control" rows="1" placeholder="Description Of Work Performed..." id="editdescText"></textarea>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <select class="select3 form-select" id="editownerStatus">
                                            <option value="">Select Ownership</option>
                                            <option value="Internal">Internal</option>
                                            <option value="SafeAccess LTD">SafeAccess LTD</option>
                                            <option value="HeavyLift Co.">HeavyLift Co.</option>
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
                                            class="table align-middle table-row-dashed table-striped table-hover gy-0 gs-1">
                                            <thead>
                                                <tr class="text-start align-top fw-bold fs-6 gs-0 bg-gray-100">
                                                    <th class="min-w-100px text-black">Purpose</th>
                                                    <th class="min-w-100px text-black">Date</th>
                                                    <th class="min-w-100px text-black">Description</th>
                                                    <th class="min-w-100px text-black">Ownership</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-black fw-semibold fs-7" id="editnewData">
                                                <tr>
                                                    <td><label>Inspection</label></td>
                                                    <td><label>12-Mar-2026</label></td>
                                                    <td><label>-</label></td>
                                                    <td><label>Internal</label></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Usage History -->
                            <div class="tab-pane fade" id="usage-history-edit" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12 mb-3 table-wrapper scroll-y max-h-300px">
                                        <table
                                            class="table align-middle table-row-dashed table-striped table-hover gy-0 gs-1">
                                            <thead class="sticky-top">
                                                <tr class="text-start align-top fw-bold fs-6 gs-0 bg-gray-100">
                                                    <th class="min-w-100px text-black">Start Date</th>
                                                    <th class="min-w-100px text-black">Ticket</th>
                                                    <th class="min-w-100px text-black">Closed Date</th>
                                                    <th class="min-w-100px text-black">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-black fw-semibold fs-7" id="usageHistoryEdit">
                                                <tr>
                                                    <td>13-Mar-2026</td>
                                                    <td>The Tools Need Calibration</td>
                                                    <td>14-Mar-2026</td>
                                                    <td>Calibration Completed</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $("#toolsSearchinput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                var visibleCount = 0;

                $(".toolscard").filter(function() {
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

            /* =====================================================
               DATE PICKER
            ======================================================*/
            $('.common_datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });

            /* =====================================================
               GLOBAL EQUIPMENT ID (for edit modal)
            ======================================================*/
            let currentEquipmentId = null;

            /* =====================================================
               OPEN EDIT MODAL + FILL DATA
            ======================================================*/
            $('#kt_modal_update_equipments').on('show.bs.modal', function(event) {

                var button = $(event.relatedTarget);
                var modal = $(this);

                // ✅ If modal opened without clicking edit icon, do nothing
                if (!button || !button.data('id')) {
                    console.warn('Modal opened without equipment ID');
                    return;
                }

                var equipmentId = button.data('id');

                // ✅ Store ID in BOTH places
                currentEquipmentId = equipmentId;
                modal.find('[name="edit_equipment_id"]').val(equipmentId);

                // Fill other fields
                modal.find('[name="edit_equipment_name"]').val(button.data('name'));
                modal.find('[name="edit_category"]').val(button.data('category')).trigger('change');
                modal.find('[name="edit_serial_number"]').val(button.data('serial'));
                modal.find('[name="edit_manufacturer"]').val(button.data('manufacturer'));
                modal.find('[name="edit_model"]').val(button.data('model'));
                modal.find('[name="edit_ownership"]').val(button.data('ownership')).trigger('change');
                modal.find('[name="edit_current_status"]').val(button.data('status')).trigger('change');
                modal.find('[name="edit_current_location"]').val(button.data('location'));
                modal.find('[name="edit_certificate"]').val(button.data('certificate'));
                modal.find('[name="edit_expiry_date"]').val(button.data('expiry'));

                console.log("Editing equipment ID:", equipmentId); // 🧪 debug

                loadMaintenanceLogs(equipmentId);
            });

            /* =====================================================
               ADD EQUIPMENT FORM SUBMIT
            ======================================================*/
            $('#equipmentForm').on('submit', function(e) {
                e.preventDefault();
                $('.text-danger').remove();

                var formData = $(this).serialize();
                var submitBtn = $('#equipmentForm button[type="submit"]');
                var originalBtnText = submitBtn.html();

                submitBtn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-2"></span>Saving...'
                );

                $.ajax({
                    url: "{{ route('equipments.store') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Equipment created successfully!');
                            $('#kt_modal_add_equipments').modal('hide');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $('[name="' + key + '"]').after(
                                    '<span class="text-danger">' + value[0] +
                                    '</span>');
                            });
                            toastr.error('Please fix the errors.');
                        } else {
                            toastr.error('Something went wrong!');
                        }
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                    }
                });
            });

            /* =====================================================
               UPDATE EQUIPMENT
            ======================================================*/
            $('#updateEquipmentBtn').on('click', function() {

                var modal = $('#kt_modal_update_equipments');
                var btn = $(this);
                var original = btn.html();

                btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-2"></span>Updating...'
                );

                var data = {
                    id: modal.find('[name="edit_equipment_id"]').val(),
                    equipment_name: modal.find('[name="edit_equipment_name"]').val(),
                    category: modal.find('[name="edit_category"]').val(),
                    serial_number: modal.find('[name="edit_serial_number"]').val(),
                    manufacturer: modal.find('[name="edit_manufacturer"]').val(),
                    model: modal.find('[name="edit_model"]').val(),
                    ownership: modal.find('[name="edit_ownership"]').val(),
                    current_status: modal.find('[name="edit_current_status"]').val(),
                    current_location: modal.find('[name="edit_current_location"]').val(),
                    certificate: modal.find('[name="edit_certificate"]').val(),
                    expiry_date: modal.find('[name="edit_expiry_date"]').val()
                };

                $.ajax({
                    url: '/update-equipment',
                    type: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        toastr.success("Equipment updated successfully!");
                        modal.modal('hide');
                        location.reload();
                    },
                    error: function() {
                        toastr.error("Update failed!");
                    },
                    complete: function() {
                        btn.prop('disabled', false).html(original);
                    }
                });
            });

            /* =====================================================
               ADD MAINTENANCE LOG (ADD MODAL)
            ======================================================*/
            window.addLog = function() {

                let purpose = $('#selectStatus option:selected').text();
                let purposeVal = $('#selectStatus').val();
                let date = $('#newDate').val();
                let desc = $('#descText').val();
                let owner = $('#ownerStatus option:selected').text();
                let ownerVal = $('#ownerStatus').val();

                if (!purposeVal || !date || !desc || ownerVal === "0") {
                    alert("Enter all fields");
                    return;
                }

                appendRow('#newData', purpose, date, desc, owner);

                $('#selectStatus').val('');
                $('#newDate').val('');
                $('#descText').val('');
                $('#ownerStatus').val('0');
            };

            /* =====================================================
               ADD MAINTENANCE LOG (EDIT MODAL)
            ======================================================*/
            window.editaddLog = function() {

                let equipmentId = $('[name="edit_equipment_id"]').val(); // ✅ always available

                let purpose = $('#editselectStatus option:selected').text();
                let purposeVal = $('#editselectStatus').val();
                let date = $('#editnewDate').val();
                let desc = $('#editdescText').val();
                let owner = $('#editownerStatus option:selected').text();
                let ownerVal = $('#editownerStatus').val();

                if (!equipmentId) {
                    toastr.error("Equipment ID missing. Please reopen modal.");
                    return;
                }

                if (!purposeVal || !date || !desc || !ownerVal) {
                    alert("Enter all fields");
                    return;
                }

                $.ajax({
                    url: '/maintenance/add',
                    type: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify({
                        equipment_id: equipmentId, // ✅ FIXED
                        purpose: purpose,
                        date: date,
                        ownership: owner,
                        description: desc
                    }),
                    success: function() {
                        toastr.success("Maintenance log added");
                        appendRow('#editnewData', purpose, date, desc, owner);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        toastr.error("Failed to add log");
                    }
                });
            };

            /* =====================================================
               LOAD MAINTENANCE LOGS
            ======================================================*/
            function loadMaintenanceLogs(equipmentId) {
                $.get(`/maintenance/list/${equipmentId}`, function(logs) {
                    let rows = '';
                    logs.forEach(log => {
                        let d = new Date(log.date).toLocaleDateString('en-GB');
                        rows += `<tr>
                    <td><label>${log.purpose}</label></td>
                    <td><label>${d}</label></td>
                    <td><label>${log.description || '-'}</label></td>
                    <td><label>${log.ownership}</label></td>
                </tr>`;
                    });
                    $('#editnewData').html(rows);
                });
            }

            /* =====================================================
               COMMON ROW APPEND FUNCTION
            ======================================================*/
            function appendRow(tbody, purpose, date, desc, owner) {
                $(tbody).append(`<tr>
            <td><label>${purpose}</label></td>
            <td><label>${date}</label></td>
            <td><label>${desc}</label></td>
            <td><label>${owner}</label></td>
        </tr>`);
            }

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

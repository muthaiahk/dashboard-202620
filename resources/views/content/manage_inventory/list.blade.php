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
            <div class="d-flex flex-column">
                <h3 class="card-title mb-1">Manage Inventory</h3>
            </div>
        </div>
        <div class="card-action-element">
            <div class="d-flex justify-content-end align-items-center mb-2">
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-lg-12">
                <div class="d-flex gap-4 align-items-center border-bottom ">
                    <a href="{{ url('/manage_inventory') }}">
                        <label class="fw-medium text-primary fs-6  pb-2 cursor-pointer"  style="border-bottom:2px solid #4496C5;">Dashboard</label>
                    </a>
                    <a href="{{ url('/manage_inventory_valve') }}">
                        <label class="fw-medium text-black fs-6 pb-2 cursor-pointer">Valves</label>
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
                    <div class="col-lg-2">
                        <div class="card border rounded" style="box-shadow:1px 1px #4496C5;">
                            <div class="card-body p-2">
                                <div class="d-flex flex-column align-items-start justify-content-strat">
                                    <label class="text-secondary fs-7 fw-medium">Total Valves</label>
                                    <label class="text-black fs-2 fw-semibold">02</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card border rounded" style="box-shadow:1px 1px #4496C5;">
                            <div class="card-body p-2">
                                <div class="d-flex flex-column align-items-start justify-content-strat">
                                    <label class="text-secondary fs-7 fw-medium">In Store</label>
                                    <label class="text-black fs-2 fw-semibold">01</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card border rounded" style="box-shadow:1px 1px #4496C5;">
                            <div class="card-body p-2">
                                <div class="d-flex flex-column align-items-start justify-content-strat">
                                    <label class="text-secondary fs-7 fw-medium">Installed</label>
                                    <label class="text-black fs-2 fw-semibold">00</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card border rounded" style="box-shadow:1px 1px #4496C5;">
                            <div class="card-body p-2">
                                <div class="d-flex flex-column align-items-start justify-content-strat">
                                    <label class="text-secondary fs-7 fw-medium">Under Calibration</label>
                                    <label class="text-black fs-2 fw-semibold">01</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card border rounded" style="box-shadow:1px 1px #4496C5;">
                            <div class="card-body p-2">
                                <div class="d-flex flex-column align-items-start justify-content-strat">
                                    <label class="text-secondary fs-7 fw-medium">Calibration Backlog</label>
                                    <label class="text-black fs-2 fw-semibold">02</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card border rounded" style="box-shadow:1px 1px #4496C5;">
                            <div class="card-body p-2">
                                <div class="d-flex flex-column align-items-start justify-content-strat">
                                    <label class="text-secondary fs-7 fw-medium">Reserved</label>
                                    <label class="text-black fs-2 fw-semibold">00</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card border rounded" style="min-height:118px;">
                            <div class="card-header p-3 bg-gray-100 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="mdi mdi-alert"></span>
                                    <label class="text-black fs-6 fw-medium">Action Required</label>
                                </div>
                            </div>
                            <div class="card-body py-4 px-3">
                                <div class="d-flex align-items-start gap-2">
                                    <span class="mdi mdi-cog"></span>
                                    <div class="d-flex flex-column">
                                        <label class="text-black fs-7 fw-medium">Spare Available For Planning: Valve SN-1001</label>
                                        <label class="text-secondary fs-8 fw-medium">Type: Gate Valve , Size : 4"</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card border rounded" style="min-height:118px;">
                            <div class="card-header p-3 bg-gray-100 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="mdi mdi-map-marker"></span>
                                    <label class="text-black fs-6 fw-medium">Valve Usage By Plant</label>
                                </div>
                            </div>
                            <div class="card-body py-4 px-3">
                                <div class="card bg-gray-100 p-2 border rounded mb-2">
                                    <div class="d-flex align-items-center justify-content-between gap-5">
                                    <div class="d-flex align-items-center justify-content-start gap-2">
                                        <span class="badge bg-label-primary rounded p-2">
                                            <i class="mdi mdi-valve fs-3 text-primary"></i>
                                        </span>
                                        <div class="d-flex flex-column">
                                            <label class="fw-medium text-black fs-6" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Valve">SN-10001</label>
                                            <label class="fw-medium text-dark fs-7" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Plant">METC-FUFU</label>
                                        </div>
                                    </div>
                                    <label class="text-danger fw-medium fs-7" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Used Date">12-Mar-2026</label>
                                    </div>
                                </div>
                                <div class="card bg-gray-100 p-2 border rounded mb-2">
                                    <div class="d-flex align-items-center justify-content-between gap-5">
                                        <div class="d-flex align-items-center justify-content-start gap-2">
                                            <span class="badge bg-label-primary rounded p-2">
                                                <i class="mdi mdi-valve fs-3 text-primary"></i>
                                            </span>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium text-black fs-6" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Valve">SN-10002</label>
                                                <label class="fw-medium text-dark fs-7" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Plant">METC-FUFU</label>
                                            </div>
                                        </div>
                                        <label class="text-danger fw-medium fs-7" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Used Date">14-Mar-2026</label>
                                    </div>
                                </div>
                                <div class="card bg-gray-100 p-2 border rounded mb-2">
                                    <div class="d-flex align-items-center justify-content-between gap-5">
                                        <div class="d-flex align-items-center justify-content-start gap-2">
                                            <span class="badge bg-label-primary rounded p-2">
                                                <i class="mdi mdi-valve fs-3 text-primary"></i>
                                            </span>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium text-black fs-6" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Valve">SN-10003</label>
                                                <label class="fw-medium text-dark fs-7" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Plant">METC-FUFU</label>
                                            </div>
                                        </div>
                                        <label class="text-danger fw-medium fs-7" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Used Date">16-Mar-2026</label>
                                    </div>
                                </div>
                                <div class="card bg-gray-100 p-2 border rounded mb-2">
                                    <div class="d-flex align-items-center justify-content-between gap-5">
                                        <div class="d-flex align-items-center justify-content-start gap-2">
                                            <span class="badge bg-label-primary rounded p-2">
                                                <i class="mdi mdi-valve fs-3 text-primary"></i>
                                            </span>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium text-black fs-6" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Valve">SN-10004</label>
                                                <label class="fw-medium text-dark fs-7" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Plant">METC-FUFU</label>
                                            </div>
                                        </div>
                                        <label class="text-danger fw-medium fs-7" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Used Date">18-Mar-2026</label>
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


@endsection
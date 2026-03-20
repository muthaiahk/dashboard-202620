@extends('layouts/layoutMaster')

@section('title', 'Manage Customer Customer Assets')

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
    .asset-container{
        position:relative;
        width:100%;
        display:grid;
        grid-template-columns:380px 1fr;
        gap:20px;
        transform:translateX(100%);
        opacity:0;
        visibility:hidden;
        transition:all 0.5s ease;
    }

    .asset-container.show-panel{
        transform:translateX(0);
        opacity:1;
        visibility:visible;
    }

    .asset-list-panel{
        background:#fff;
        border-radius:10px;
        border:1px solid #e5e7eb;
        display:flex;
        flex-direction:column;
        overflow:hidden;
    }

    .panel-header{
        padding:15px;
        display:flex;
        gap:10px;
        border-bottom:1px solid #eee;
    }

    .search-box{
        flex:1;
        padding:8px;
        border-radius:6px;
        border:1px solid #ddd;
    }

    .btn-add{
        width:35px;
        height:35px;
        border:none;
        background:#2f6fed;
        color:#fff;
        border-radius:6px;
    }

    .asset-list{
        overflow-y:auto;
    }

    .asset-item{
        padding:14px;
        border-bottom:1px solid #f1f1f1;
        cursor:pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .asset-item.active{
        background: #e7f5fc;
        border-left:3px solid #0076b6;
    }

    .asset-size{
        color: #2c2c2c;
        font-weight: 400;
    }

    .asset-title{
        font-weight:600;
    }

    .asset-meta{
        font-size:12px;
        margin-top:4px;
    }

    .tag{
        background: #d2d4d6;
        padding:4px 6px;
        font-weight: 500;
        border-radius:4px;
    }

    .priority{
        background: #ffe5e5;
        padding:2px 6px;
        border-radius:4px;
        color: #f84a4a;
        border: 1px solid #f84a4a;
    }

    .priority_b {
        background: #fff7f0;
        padding:2px 6px;
        border-radius:4px;
        color: #ff7b00;
        border: 1px solid #ff7b00;
    }

    .asset-detail-panel{
        background:#fff;
        border-radius:10px;
        border:1px solid #e5e7eb;
        display:flex;
        flex-direction:column;
    }

    .detail-header{
        padding:18px;
        display:flex;
        justify-content:space-between;
        border-bottom:1px solid #eee;
    }

    .detail-desc{
        display: flex;
        flex-direction: column;
    }

    .detail-body{
        padding:10px 20px;
        overflow-y:auto;
    }
    .admin-body{
        padding:10px 20px;
        overflow-y:auto;
    }

    .admin-grid{
        display: grid;
        grid-template-columns: 2fr 2fr 2fr;
        gap: 10px;
    }

    .detail-grid{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:20px;
    }

    .detail-card{
        background:#f8fafc;
        padding:16px;
        border-radius:8px;
        border:1px solid #e6e6e6;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .detail-spec{
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .history-body{
        padding:10px 20px;
        overflow-y:auto;
    }

    .sticky-top {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 1020;
    }

    .asset_table_panel{
        transition:all 0.5s ease;
    }

    .asset_table_panel.hide-table{
        transform:translateX(-100%);
        opacity:0;
    }
</style>

<!-- Lead List Table -->
<div class="card card-action" style="overflow-x: hidden;">
    <div class="card-header pb-1">
        <div class="card-action-title">
            <h3 class="card-title mb-1">Manage Customer Asset</h3>
        </div>
        <div class="card-action-element">
            <div class="d-flex justify-content-end align-items-center mb-2 gap-2">
                <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary-outline border border-primary text-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_bulk_upload">
                    <span class="me-2"><i class="mdi mdi-tray-arrow-up"></i></span>Bulk Upload
                </a>
                <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_Customer Asset">
                    <span class="me-2"><i class="mdi mdi-plus"></i></span>Add Customer Asset
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row asset_table_panel">
            <div class="col-lg-12">
                <table class="table align-middle table-row-dashed table-hover gy-0 gs-1 asset_list">
                    <thead>
                        <tr class="text-center align-top fw-bold fs-6 gs-0 bg-gray-200">
                            <th class="min-w-100px text-black">Customer Asset</th>
                            <th class="min-w-100px text-black">Asset Type</th>
                            <th class="min-w-100px text-black">Valve Type</th>
                            <th class="min-w-100px text-black">Description</th>
                            <th class="min-w-100px text-black">Actual Size</th>
                            <th class="min-w-100px text-black">Plant/Sector</th>
                            <th class="min-w-100px text-black">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-black fw-semibold fs-7">
                        <tr>
                            <td>
                                <label class="text-black fw-medium fs-7">11-SRV-1</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">SRV</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Safety Relief Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">VALVE, BSTR I/L SCRB v-1106, 11-SRV-1, MEC</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">4" X300</label>
                            </td>
                            <td>
                                <div class="d-flex align-items-start flex-column">
                                    <label class="text-black fw-medium fs-7">FHSP</label>
                                    <label class="text-dark fw-medium fs-8">OOD-FHSP</label>
                                </div>
                            </td>
                            <td>
                                <span class="text-end">
                                    <a href="#" class="btn btn-icon btn-sm me-2">
                                        <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="View">
                                            <i class="mdi mdi-eye fs-3 text-black"></i>
                                        </span>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="text-black fw-medium fs-7">12-SRV-4019-101</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">SRV</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Safety Relief Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">VALVE, RELIEF OUTLET SCRUBBER, 12-SRV-4019-101</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">6" X300</label>
                            </td>
                            <td>
                                <div class="d-flex align-items-start flex-column">
                                    <label class="text-black fw-medium fs-7">KUFA</label>
                                    <label class="text-dark fw-medium fs-8">Gas Compression</label>
                                </div>
                            </td>
                            <td>
                                <span class="text-end">
                                    <a href="#" class="btn btn-icon btn-sm me-2">
                                        <span data-bs-toggle="tooltip" title="View">
                                            <i class="mdi mdi-eye fs-3 text-black"></i>
                                        </span>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="text-black fw-medium fs-7">14-GV-5232-01</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Gate Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Gate Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">VALVE, MAIN FEED LINE ISOLATION</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">8" X150</label>
                            </td>
                            <td>
                                <div class="d-flex align-items-start flex-column">
                                    <label class="text-black fw-medium fs-7">FHSP</label>
                                    <label class="text-dark fw-medium fs-8">Crude Processing</label>
                                </div>
                            </td>
                            <td>
                                <span class="text-end">
                                    <a href="#" class="btn btn-icon btn-sm me-2">
                                        <span data-bs-toggle="tooltip" title="View">
                                            <i class="mdi mdi-eye fs-3 text-black"></i>
                                        </span>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="text-black fw-medium fs-7">16-BV-7781-12</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Ball Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Ball Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">VALVE, TANK DRAIN ISOLATION</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">3" X300</label>
                            </td>
                            <td>
                                <div class="d-flex align-items-start flex-column">
                                    <label class="text-black fw-medium fs-7">Storage Tank</label>
                                    <label class="text-dark fw-medium fs-8">Tank Farm</label>
                                </div>
                            </td>
                            <td>
                                <span class="text-end">
                                    <a href="#" class="btn btn-icon btn-sm me-2">
                                        <span data-bs-toggle="tooltip" title="View">
                                            <i class="mdi mdi-eye fs-3 text-black"></i>
                                        </span>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="text-black fw-medium fs-7">18-CV-9902-04</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Check Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Swing Check Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">VALVE, PUMP DISCHARGE NON RETURN</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">5" X150</label>
                            </td>
                            <td>
                                <div class="d-flex align-items-start flex-column">
                                    <label class="text-black fw-medium fs-7">Pump Station</label>
                                    <label class="text-dark fw-medium fs-8">Utilities</label>
                                </div>
                            </td>
                            <td>
                                <span class="text-end">
                                    <a href="#" class="btn btn-icon btn-sm me-2">
                                        <span data-bs-toggle="tooltip" title="View">
                                            <i class="mdi mdi-eye fs-3 text-black"></i>
                                        </span>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="text-black fw-medium fs-7">21-GV-3301-09</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Gate Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Gate Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">VALVE, FIRE WATER SUPPLY LINE</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">10" X150</label>
                            </td>
                            <td>
                                <div class="d-flex align-items-start flex-column">
                                    <label class="text-black fw-medium fs-7">Fire Station</label>
                                    <label class="text-dark fw-medium fs-8">Safety Utilities</label>
                                </div>
                            </td>
                            <td>
                                <span class="text-end">
                                    <a href="#" class="btn btn-icon btn-sm me-2">
                                        <span data-bs-toggle="tooltip" title="View">
                                            <i class="mdi mdi-eye fs-3 text-black"></i>
                                        </span>
                                    </a>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="asset-container">
            <div class="asset-list-panel">
                <div class="panel-header">
                    <input type="text" placeholder="Search Tag, Plant, Size..." class="form-control">
                    <button class="btn btn-sm btn-dark back_to_table">
                        <i class="mdi mdi-arrow-left"></i> Back
                    </button>
                </div>
                <div class="asset-list">
                    <div class="asset-item active">
                        <div>
                            <div class="asset-title">
                                <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Asset Tag" class="fs-7 text-black fw-medium">11-SRV-1</span>
                            </div>  
                            <div class="asset-meta">
                                <span class="tag" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Plant">FHSP</span>
                            </div>
                        </div>
                        <div class="asset-size">
                            <span class="fs-7">4" X 300</span>
                        </div>
                    </div>
                    <div class="asset-item">
                        <div>
                            <div class="asset-title">
                                <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Asset Tag" class="fs-7 text-black fw-medium">14-SRV-4601-03</span>
                            </div>  
                            <div class="asset-meta">
                                <span class="tag" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Plant">FAHM</span>
                            </div>
                        </div>
                        <div class="asset-size">
                            <span class="fs-7">6" X 1500</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="asset-detail-panel">
                <div class="detail-header">
                    <div class="detail-desc">
                        <h4>11-SRV-1</h4>
                        <span class="text-dark fw-semibold fs-7">VALVE, BSTL I/L, SCRB V-1106,11-SRV-1, MEC</span>
                    </div>
                    <div class="detail-desc">
                        <div class="mb-3">
                            <span class="tag" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Plant">FHSP</span>
                            <a href="javscript:;" type="button" class="btn btn-sm btn-primary-outline border border-primary text-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_update_Customer Asset"><i class="mdi mdi-pencil-outline"></i>Edit</a>
                        </div>
                        <div>
                            <label id="status_badge" 
                                class="badge bg-label-success fw-medium fs-7 border border-success rounded status-toggle" 
                                style="cursor:pointer;">
                                <i class="mdi mdi-check text-success"></i>
                                Active
                            </label>
                        </div>
                    </div>
                </div>
                <div class="detail-body">
                    <div class="detail-grid">
                        <div>
                            <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                <span>
                                    <i class="mdi mdi-ruler text-dark fs-7"></i>
                                </span>
                                <label class="fs-5 text-black">Technical Specifications</label>
                            </div>
                            <div class="detail-card">
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">
                                        Actual Size
                                    </span>
                                    <span class="text-black fw-medium fs-6">
                                        4" X300
                                    </span>
                                </div>
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">
                                        Estimated Size
                                    </span>
                                    <span class="text-black fw-medium fs-6">
                                        4" X300
                                    </span>
                                </div>
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">
                                        Pressure Class
                                    </span>
                                    <span class="text-black fw-medium fs-6">
                                        300
                                    </span>
                                </div>
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">
                                        Valve Type
                                    </span>
                                    <span class="text-black fw-medium fs-6">
                                        Safety Relief Valve
                                    </span>
                                </div>
                                <hr class="my-1">
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">
                                        Scaffolding Req
                                    </span>
                                    <span class="text-danger fw-medium fs-6">
                                        YES
                                    </span>
                                </div>
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">
                                        Crane Req
                                    </span>
                                    <span class="text-danger fw-medium fs-6">
                                        YES
                                    </span>
                                </div>
                                <hr class="my-1">
                                <div class="d-flex flex-column gap-1">
                                    <span class="text-dark fw-semibold fs-6">
                                        <i class="mdi mdi-wrench-outline me-1"></i>Special Tools & Equipments
                                    </span>
                                    <span class="text-black fw-medium fs-6">
                                        Hydraulic Torque Wrench
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                <span>
                                    <i class="mdi mdi-map-marker-radius-outline text-dark fs-7"></i>
                                </span>
                                <label class="fs-5 text-black">Location & Context</label>
                            </div>
                            <div class="detail-card">
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">
                                        Main Plant
                                    </span>
                                    <span class="text-black fw-medium fs-6">
                                        FHSP
                                    </span>
                                </div>
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">
                                        Sector
                                    </span>
                                    <span class="text-black fw-medium fs-6">
                                        OOD-FHSP
                                    </span>
                                </div>
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">
                                        Room / Sub-Location
                                    </span>
                                    <span class="text-black fw-medium fs-6">
                                        V1106
                                    </span>
                                </div>
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">
                                        Work Center
                                    </span>
                                    <span class="text-black fw-medium fs-6">
                                        METC
                                    </span>
                                </div>
                                <hr class="my-1">
                                <div class="d-flex flex-column gap-1">
                                    <span class="text-dark fw-semibold fs-6">
                                        <i class="mdi mdi-navigation-variant-outline text-primary cursor-pointer"></i>Geo-Location
                                    </span>
                                    <span class="text-black fw-medium fs-6">
                                        25.271458, 55.448726
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="admin-body">
                    <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                        <span>
                            <i class="mdi mdi-clipboard-text-outline text-dark fs-7"></i>
                        </span>
                        <label class="fs-5 text-black">Administration and Planning</label>
                    </div>
                    <div class="admin-grid">
                        <div class="d-flex flex-column border border-gray-100 rounded p-4">
                            <span class="text-dark fw-semibold">Linked Order</span>
                            <span class="text-black fw-semibold">1257106</span>
                        </div>
                        <div class="d-flex flex-column border border-gray-100 rounded p-4">
                            <span class="text-dark fw-semibold">Compilance Due Date</span>
                            <span class="text-black fw-semibold">31-Mar-2026</span>
                        </div>
                        <div class="d-flex flex-column border border-gray-100 rounded p-4">
                            <span class="text-dark fw-semibold">Order Type</span>
                            <span class="text-black fw-semibold">Prev</span>
                        </div>
                    </div>
                </div>
                <div class="history-body">
                    <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                        <span>
                            <i class="mdi mdi-clock-outline text-dark fs-7"></i>
                        </span>
                        <label class="fs-5 text-black">History of Services</label>
                    </div>
                    <div class="col-lg-12 table-wrapper mt-2"  style="max-height:500px; overflow-y:auto;">
                        <table class="table align-middle table-row-dashed table-striped table-hover gy-0 gs-1 ">
                            <thead class="table-header sticky-top">
                                <tr class="text-center align-top fw-bold fs-6 gs-0 bg-gray-100">
                                    <th class="min-w-100px text-black">Date</th>
                                    <th class="min-w-100px text-black">Type</th>
                                    <th class="min-w-100px text-black">Description</th>
                                    <th class="min-w-100px text-black">Technician</th>
                                </tr>
                            </thead>
                            <tbody class="text-black fw-semibold fs-7">
                                <tr>
                                    <td>
                                        <label class="text-black fw-medium fs-7">25-Feb-2026</label>
                                    </td>
                                    <td>
                                        <label class="text-black fw-medium fs-7">Prev</label>
                                    </td>
                                    <td>
                                        <label class="text-black fw-medium fs-7">VALVE, BSTR I/L SCRB v-1106, 11-SRV-1, MEC</label>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <img src="{{ asset('assets/images/auth/user_1.png') }}" class="w-45px h-45px rounded-circle border-2 border-dark border"/>
                                            <label class="text-black fw-medium fs-7">Joshua</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="text-black fw-medium fs-7">26-Feb-2026</label>
                                    </td>
                                    <td>
                                        <label class="text-black fw-medium fs-7">Reg</label>
                                    </td>
                                    <td>
                                        <label class="text-black fw-medium fs-7">VALVE, BSTL I/L SCRB V-1107, 11-SRV-2, MEC</label>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <img src="{{ asset('assets/images/auth/user_9.png') }}" class="w-45px h-45px rounded-circle border-2 border-dark border"/>
                                            <label class="text-black fw-medium fs-7">Daniel</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="text-black fw-medium fs-7">27-Feb-2026</label>
                                    </td>
                                    <td>
                                        <label class="text-black fw-medium fs-7">Prev</label>
                                    </td>
                                    <td>
                                        <label class="text-black fw-medium fs-7">VALVE, BSTL O/L SCRB V-1108, 12-SRV-1, MEC</label>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <img src="{{ asset('assets/images/auth/user_3.png') }}" class="w-45px h-45px rounded-circle border-2 border-dark border"/>
                                            <label class="text-black fw-medium fs-7">Michael</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="text-black fw-medium fs-7">28-Feb-2026</label>
                                    </td>
                                    <td>
                                        <label class="text-black fw-medium fs-7">Reg</label>
                                    </td>
                                    <td>
                                        <label class="text-black fw-medium fs-7">VALVE, BSTR I/L SCRB V-1110, 12-SRV-2, MEC</label>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <img src="{{ asset('assets/images/auth/user_4.png') }}" class="w-45px h-45px rounded-circle border-2 border-dark border"/>
                                            <label class="text-black fw-medium fs-7">Samuel</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="text-black fw-medium fs-7">01-Mar-2026</label>
                                    </td>
                                    <td>
                                        <label class="text-black fw-medium fs-7">Prev</label>
                                    </td>
                                    <td>
                                        <label class="text-black fw-medium fs-7">VALVE, BSTL I/L SCRB V-1112, 13-SRV-1, MEC</label>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <img src="{{ asset('assets/images/auth/user_5.png') }}" class="w-45px h-45px rounded-circle border-2 border-dark border"/>
                                            <label class="text-black fw-medium fs-7">Andrew</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="text-black fw-medium fs-7">02-Mar-2026</label>
                                    </td>
                                    <td>
                                        <label class="text-black fw-medium fs-7">Reg</label>
                                    </td>
                                    <td>
                                        <label class="text-black fw-medium fs-7">VALVE, BSTR O/L SCRB V-1115, 13-SRV-2, MEC</label>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <img src="{{ asset('assets/images/auth/user_8.png') }}" class="w-45px h-45px rounded-circle border-2 border-dark border"/>
                                            <label class="text-black fw-medium fs-7">David</label>
                                        </div>
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


<!--begin::Modal - Add Customer Assets-->
<div class="modal fade" id="kt_modal_add_asset" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
    data-bs-backdrop="static" data-bs-focus="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-lg">
        <!--begin::Modal content-->
      <div class="modal-content rounded">
        <!--begin::Modal header-->
        <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
          <h4 class="text-center text-black">Create Customer Asset</h4>
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
            <div class="row scroll-y" style="max-height: 550px;">
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Asset Type<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Customer Asset Type" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Customer Asset Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Customer Asset Name" />
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Description</label>
                    <textarea class="form-control" rows="1" placeholder="Enter Description"></textarea>
                </div>
                <hr class="my-1">
                <div class="col-lg-12 mb-2">
                    <label class="text-dark fw-semibold fs-6">Technical Specification</label>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Valve Type<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Valve Type" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Actual Size<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Actual Size" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Estimated Size<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Estimated Size" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Pressure Class<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Pressure Class" />
                </div>
                <hr class="my-1">
                <div class="col-lg-12 mb-2">
                    <label class="text-dark fw-semibold fs-6">Location</label>
                </div>
                <div class="col-lg-6 mb-3" >
                    <label class="text-black mb-1 fs-7 fw-semibold">Sector<span class="text-danger">*</span></label>
                    <select class="select3 form-select">
                        <option value="">Select Sector</option>
                        <option value="1">OOD-FHSP</option>
                        <option value="2">OOG-SHSP</option>
                        <option value="3">OOD-FHES</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3" >
                    <label class="text-black mb-1 fs-7 fw-semibold">Plant<span class="text-danger">*</span></label>
                    <select class="select3 form-select">
                        <option value="">Select Plant</option>
                        <option value="1">FHSP</option>
                        <option value="2">SHSP</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3" >
                    <label class="text-black mb-1 fs-7 fw-semibold">Room<span class="text-danger">*</span></label>
                    <select class="select3 form-select">
                        <option value="">Select Room</option>
                        <option value="1">V1106</option>
                        <option value="2">V2650</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Work Center<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Work Center" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Latitude</label>
                    <input type="text" class="form-control" placeholder="Enter Latitude" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Longitude</label>
                    <input type="text" class="form-control" placeholder="Enter Longitude" />
                </div>
                <hr class="my-1">
                <div class="col-lg-12 mb-2">
                    <label class="text-dark fw-semibold fs-6">Special Tools & Equipments</label>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Special Tools</label>
                    <textarea class="form-control" rows="1" placeholder="Enter Special Tools"></textarea>
                </div>
                <div class="col-lg-6 mb-3" >
                    <div class="form-check form-check-inline">
                        <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="scaffolding" />
                        <label class="form-check-label" for="">Scaffolding</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="crane" />
                        <label class="form-check-label" for="">Crane</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pt-5">
          <div class="d-flex justify-content-end align-items-center">
            <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Create Customer Asset</button>
          </div>
        </div>
        <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Add Customer Assets-->


<!--begin::Modal - Update Customer Assets-->
<div class="modal fade" id="kt_modal_update_asset" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
    data-bs-backdrop="static" data-bs-focus="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-lg">
        <!--begin::Modal content-->
      <div class="modal-content rounded">
        <!--begin::Modal header-->
        <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
          <h4 class="text-center text-black">Update Customer Asset</h4>
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
            <div class="row scroll-y" style="max-height: 550px;">
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Asset Type<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Asset Type" value="Control Valve"/>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Customer Asset Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Customer Asset Name" value="CV-101 Main Steam Valve"/>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Description</label>
                    <textarea class="form-control" rows="1" placeholder="Enter Description">Regulates steam flow to turbine line</textarea>
                </div>
                <hr class="my-1">
                <div class="col-lg-12 mb-2">
                    <label class="text-dark fw-semibold fs-6">Technical Specification</label>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Valve Type<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Valve Type" value="Globe Valve"/>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Actual Size<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Actual Size" value="6 Inch"/>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Estimated Size<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Estimated Size" value="5.8 Inch"/>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Pressure Class<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Pressure Class" value="Class 300" />
                </div>
                <hr class="my-1">
                <div class="col-lg-12 mb-2">
                    <label class="text-dark fw-semibold fs-6">Location</label>
                </div>
                <div class="col-lg-6 mb-3" >
                    <label class="text-black mb-1 fs-7 fw-semibold">Sector<span class="text-danger">*</span></label>
                    <select class="select3 form-select">
                        <option value="">Select Sector</option>
                        <option value="1"selected>OOD-FHSP</option>
                        <option value="2">OOG-SHFP</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3" >
                    <label class="text-black mb-1 fs-7 fw-semibold">Plant<span class="text-danger">*</span></label>
                    <select class="select3 form-select">
                        <option value="">Select Plant</option>
                        <option value="1"selected>FHSP</option>
                        <option value="2">SHSP</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3" >
                    <label class="text-black mb-1 fs-7 fw-semibold">Room<span class="text-danger">*</span></label>
                    <select class="select3 form-select">
                        <option value="">Select Room</option>
                        <option value="1"selected>V1106</option>
                        <option value="2">V2650</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Work Center<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Work Center" value="WC-TURB-204" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Latitude</label>
                    <input type="text" class="form-control" placeholder="Enter Latitude" value="9.9252"/>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Longitude</label>
                    <input type="text" class="form-control" placeholder="Enter Longitude" value="78.1198"/>
                </div>
                <hr class="my-1">
                <div class="col-lg-12 mb-2">
                    <label class="text-dark fw-semibold fs-6">Special Tools & Equipments</label>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Special Tools</label>
                    <textarea class="form-control" rows="1" placeholder="Enter Special Tools">Torque Wrench Set</textarea>
                </div>
                <div class="col-lg-6 mb-3" >
                    <div class="form-check form-check-inline">
                        <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="scaffolding" checked/>
                        <label class="form-check-label" for="">Scaffolding</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="crane" checked/>
                        <label class="form-check-label" for="">Crane</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pt-5">
          <div class="d-flex justify-content-end align-items-center">
            <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Update Customer Asset</button>
          </div>
        </div>
        <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Update Customer Assets-->


<script>
$(document).ready(function(){

    $(".mdi-eye").click(function(e){

        e.preventDefault();

        $(".asset_table_panel").addClass("hide-table");

        setTimeout(function(){
            $(".asset_table_panel").hide();
            $(".asset-container").addClass("show-panel");
        },300);

    });

    $(".back_to_table").click(function(){

        $(".asset-container").removeClass("show-panel");

        setTimeout(function(){
            $(".asset_table_panel").show().removeClass("hide-table");
        },300);

    });

});
</script>

<script>
    $('#filter').click(function() {
        $('.filter_tbox').slideToggle('slow');
    });
</script>

<script>
    function date_fill_issue_rpt() {
        var dt_fill_issue_rpt = document.getElementById('dt_fill_issue_rpt').value;
        var today_dt_iss_rpt = document.getElementById('today_dt_iss_rpt');
        var week_from_dt_iss_rpt = document.getElementById('week_from_dt_iss_rpt');
        var week_to_dt_iss_rpt = document.getElementById('week_to_dt_iss_rpt');
        var monthly_dt_iss_rpt = document.getElementById('monthly_dt_iss_rpt');
        var from_dt_iss_rpt = document.getElementById('from_dt_iss_rpt');
        var to_dt_iss_rpt = document.getElementById('to_dt_iss_rpt');
        var from_date_fillter_iss_rpt = document.getElementById('from_date_fillter_iss_rpt');
        var to_date_fillter_iss_rpt = document.getElementById('to_date_fillter_iss_rpt');

        if (dt_fill_issue_rpt == "today") {
            today_dt_iss_rpt.style.display = "block";
            monthly_dt_iss_rpt.style.display = "none";
            from_dt_iss_rpt.style.display = "none";
            to_dt_iss_rpt.style.display = "none";
            week_from_dt_iss_rpt.style.display = "none";
            week_to_dt_iss_rpt.style.display = "none";
        } else if (dt_fill_issue_rpt == "week") {
            today_dt_iss_rpt.style.display = "none";
            week_from_dt_iss_rpt.style.display = "block";
            week_to_dt_iss_rpt.style.display = "block";
            monthly_dt_iss_rpt.style.display = "none";
            from_dt_iss_rpt.style.display = "none";
            to_dt_iss_rpt.style.display = "none";

            var curr = new Date; // get current date
            var first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
            var last = first + 6; // last day is the first day + 6

            var firstday = new Date(curr.setDate(first)).toISOString().slice(0, 10);
            firstday = firstday.split("-").reverse().join("-");
            var lastday = new Date(curr.setDate(last)).toISOString().slice(0, 10);
            lastday = lastday.split("-").reverse().join("-");
            $('#week_from_date_fil').val(firstday);
            $('#week_to_date_fil').val(lastday);

        } else if (dt_fill_issue_rpt == "monthly") {
            today_dt_iss_rpt.style.display = "none";
            monthly_dt_iss_rpt.style.display = "block";
            from_dt_iss_rpt.style.display = "none";
            to_dt_iss_rpt.style.display = "none";
            week_from_dt_iss_rpt.style.display = "none";
            week_to_dt_iss_rpt.style.display = "none";
        } else if (dt_fill_issue_rpt == "custom_date") {
            today_dt_iss_rpt.style.display = "none";
            monthly_dt_iss_rpt.style.display = "none";
            from_dt_iss_rpt.style.display = "block";
            to_dt_iss_rpt.style.display = "block";
            week_from_dt_iss_rpt.style.display = "none";
            week_to_dt_iss_rpt.style.display = "none";
        } else {
            today_dt_iss_rpt.style.display = "none";
            monthly_dt_iss_rpt.style.display = "none";
            from_dt_iss_rpt.style.display = "none";
            to_dt_iss_rpt.style.display = "none";
            week_from_dt_iss_rpt.style.display = "none";
            week_to_dt_iss_rpt.style.display = "none";
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
            // "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            // "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +

            "<'table-responsive'tr>" +

            "<'row'" +
            // "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            // "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
    });

    $(".asset_list").DataTable({
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
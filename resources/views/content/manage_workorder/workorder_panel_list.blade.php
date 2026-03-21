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
    .timeline-wrapper {
        width: 100%;
        margin: 20px auto;
    }

    .timeline-row {
        display: grid;
        grid-template-columns: 100px 40px 1fr;
        align-items: stretch; /* KEY FIX */
        /* margin-bottom: 25px; */
    }

    /* TIME */
    .timeline-time {
        text-align: right;
        padding-right: 10px;
        font-size: 14px;
        color: #555;
        font-weight: 500;
    }

    /* CENTER COLUMN FIX */
    .timeline-center {
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%; /* Fills row height automatically */
        position: relative;
        /* border: 1px solid red; */
    }

    .timeline-dot {
        width: 14px;
        height: 14px;
        background: #0076b6;
        border-radius: 50%;
        z-index: 2;
    }

    /* AUTO-ADJUSTING LINE */
    .timeline-line {
        width: 2px;
        background: #ced4da;
        flex-grow: 1; /* LINE AUTO ADJUSTS */
        margin-top: 4px;
    }

    /* Remove line from last item */
    .timeline-row:last-child .timeline-line {
        display: none;
    }

    /* CONTENT */
    .timeline-content {
        padding-left: 10px;
    }

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

    .asset-list{
        overflow-y:auto;
    }

    .asset-row.active{
        background: #c1e9ff54;
        border-left:4px solid #0076b6;
    }

    .badge-dot{
        width:6px;
        height:6px;
        display:inline-block;
        border-radius:50%;
        margin-right:6px;
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

    .wizard-steps{
        display:flex;
        align-items:center;
        justify-content:space-between;
        margin-bottom:10px;
        padding: 20px;
    }

    .wizard-step{
        text-align:center;
        position:relative;
    }

    .wizard-icon{
        width:42px;
        height:42px;
        border-radius:50%;
        border:4px solid #cfd3e0;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:18px;
        background: #fff;
        margin:auto;
        color: #cfd3e0;
    }

    .wizard-step.active .wizard-icon{
        border-color: #0076b6;
        color: #0076b6;
        background: #0076b624;
    }

    .wizard-step.active .wizard-label{
        color: #0076b6;
        font-weight: 500;
    }

    .wizard-label{
        font-size: 14px;
        margin-top:6px;
        color: #cfd3e0;
    }

    .wizard-line{
        flex:1;
        height:2px;
        background:#e5e7eb;
        margin:0 10px;
    }

    .require-box{
        border:1px solid #f3d7a3;
        background:#fbf5e6;
        padding:14px;
        border-radius:8px;
        text-align:center;
    }

    .wizard-panel{
        display:none;
    }

    .wizard-panel.active{
        display:block;
    }

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


    .img-download-box{
        position: relative;
        width:100px;
        height:100px;
    }

    .doc-img{
        width:100%;
        height:100%;
        object-fit:cover;
        border-radius:6px;
    }

    .download-icon{
        position:absolute;
        top:50%;
        left:50%;
        transform:translate(-50%,-50%);
        font-size:32px;
        color:#fff;
        opacity:0;
        transition:0.3s;
        cursor:pointer;
        z-index:3; /* above overlay */
    }

    .img-download-box::after{
        content:'';
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:rgba(0,0,0,0.4);
        opacity:0;
        transition:0.3s;
        border-radius:6px;
        z-index:2; /* overlay above image but below icon */
    }

    .img-download-box:hover::after{
        opacity:1;
    }

    .img-download-box:hover .download-icon{
        opacity:1;
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
        justify-content: start;
        gap: 10px;
    }

    .modern-dropzone {
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        padding: 25px;
        background: #fafafa;
        transition: all 0.3s ease;
    }

    .modern-dropzone:hover {
        border-color: #0d6efd;
        background: #f0f7ff;
    }

    .upload-area {
        text-align: center;
        cursor: pointer;
    }

    .upload-icon {
        /* font-size: 40px; */
        color: #0d6efd;
    }

    .upload-text span {
        color: #0d6efd;
        font-weight: 500;
    }

    .file-preview-list {
        margin-top: 20px;
    }

    .file-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 12px;
        border-radius: 10px;
        background: #fff;
        border: 1px solid #eee;
        margin-bottom: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .file-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .file-icon {
        font-size: 22px;
        color: #6c757d;
    }

    .file-name {
        font-size: 14px;
        font-weight: 500;
    }

    .progress-bar-container {
        width: 100%;
        height: 5px;
        background: #eee;
        border-radius: 5px;
        margin-top: 5px;
    }

    .progress-bar {
        height: 100%;
        width: 0%;
        background: #0d6efd;
        border-radius: 5px;
        transition: width 0.3s;
    }

    .file-status {
        font-size: 12px;
        color: #6c757d;
    }

    .remove-btn {
        color: red;
        cursor: pointer;
        font-size: 14px;
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
                    <a href="{{ url('/manage_work_order') }}" class="view-btn active">
                        <i class="mdi mdi-format-list-checkbox"></i>
                        List
                    </a>
                    <a href="{{ url('/manage_work_order/calendar_view') }}" class="view-btn">
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
        <div class="row asset_table_panel">
            <div class="col-lg-12">
                <table class="table align-middle table-row-dashed table-hover gy-0 gs-1 list_page">
                    <thead>
                        <tr class="text-center align-top fw-bold fs-6 gs-0 bg-gray-200">
                            <th class="min-w-100px text-black">Order/Type</th>
                            <th class="min-w-100px text-black">Company/Number</th>
                            <th class="min-w-100px text-black">Priority</th>
                            <th class="min-w-100px text-black">Work Ctr/Plant</th>
                            <th class="min-w-100px text-black">Description</th>
                            <th class="min-w-100px text-black">Team</th>
                            <th class="min-w-100px text-black">Status</th>
                            <th class="min-w-100px text-black">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-black fw-semibold fs-7">
                        @foreach($workOrders as $order)
                        <tr>
                            <td>
                                <div class="d-flex align-items-start flex-column">
                                    <label class="text-black fw-medium fs-7">{{ $order->id }}</label>
                                    <label class="text-info fw-medium fs-8">{{ $order->order_type }}</label>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-start flex-column">
                                    <label class="text-black fw-medium fs-7">{{ $order->client->company_name ?? 'N/A' }}</label>
                                    <label class="text-dark fw-medium fs-8">{{ $order->client->mobile_no ?? '' }}</label>
                                </div>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">{{ $order->priority }} {{ $order->title ? '- '.$order->title : '' }}</label>
                            </td>
                            <td>
                                <div class="d-flex align-items-start flex-column">
                                    <label class="text-black fw-medium fs-7">{{ $order->asset->work_center ?? 'N/A' }}</label>
                                    <label class="text-dark fw-medium fs-8">{{ $order->asset->plant->plant_name ?? '' }}</label>
                                </div>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7 text-truncate max-w-150px" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $order->description }}">
                                    {{ $order->description ?? 'No Description' }}
                                </label>
                            </td>
                            <td>
                                <ul class="list-unstyled users-list d-flex align-items-center avatar-group">
                                    <li class="avatar pull-up">
                                        <img class="rounded-circle" src="{{ asset('assets/images/auth/user_2.png') }}" alt="Avatar">
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <label class="fw-medium fs-7 badge rounded" style="border: 1px solid #198754;color: #198754;background-color: #19875412;">{{ ucfirst($order->status) }}</label>
                            </td>
                            <td>
                                <span class="text-end">
                                    <a href="#" class="btn btn-icon btn-sm me-2 view_work_order" data-id="{{ $order->id }}">
                                        <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="View/Edit">
                                            <i class="mdi mdi-eye fs-3 text-black"></i>
                                        </span>
                                    </a>
                                    <a href="#" class="btn btn-icon btn-sm me-2 delete_work_order" data-id="{{ $order->id }}">
                                        <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
                                            <i class="mdi mdi-trash-can-outline fs-3 text-danger"></i>
                                        </span>
                                    </a>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="asset-container">
            <div class="asset-list-panel">
                <div class="panel-header">
                    <input type="text" placeholder="Search Work Order..." class="form-control">
                    <button class="btn btn-sm btn-primary-outline border border-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Import">
                        <i class="mdi mdi-import text-primary"></i>
                    </button>
                    <button class="btn btn-sm btn-dark back_to_table">
                        <i class="mdi mdi-arrow-left"></i> Back
                    </button>
                </div>
                <div class="asset-list">
                    <table class="table align-middle table-row-dashed table-hover gy-0 gs-1 asset_list">
                        <thead>
                            <tr class="text-start align-middle fw-bold fs-7 bg-gray-200">
                                <th class="min-w-100px text-black">Order / Tag/ Priority</th>
                                <th class="min-w-100px text-black">Client</th>
                                <th class="min-w-100px text-black">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($workOrders as $order)
                            <tr class="asset-row" data-id="{{ $order->id }}">
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold text-black">{{ $order->id }}</span>
                                        <span class="text-dark fw-medium fs-8">{{ $order->asset->tag_number ?? $order->asset->name ?? 'N/A' }}</span>
                                        <span class="fw-bold text-danger">{{ $order->priority }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-black fw-medium fs-7">{{ $order->client->company_name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <label class="fw-medium fs-7 badge rounded"
                                        style="border: 1px solid #f59e0b; color: #f59e0b; background-color: #f59e0b1a;">
                                        {{ ucfirst($order->status) }}
                                    </label>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="asset-detail-panel">
                <div class="detail-header">
                    <div class="detail-desc">
                        <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                            <h4 class="my-0 py-0" id="detail_asset_tag">--</h4>
                            <span class="badge bg-gray-100 border text-black rounded fs-7 fw-medium" id="detail_wo_id">--</span>
                            <span class="badge bg-label-primary border border-primary text-black rounded fs-7 fw-medium" id="detail_priority">Priority: --</span>
                        </div>
                        <span class="text-dark fw-semibold fs-7" id="detail_desc">--</span>
                    </div>
                    <div class="detail-desc">
                        <div class="mb-3">
                            <label id="status_badge" 
                                class="badge bg-label-success fw-medium fs-7 border border-success rounded status-toggle" 
                                style="cursor:pointer;">
                                <i class="mdi mdi-check text-success"></i>
                                Active
                            </label>
                            <a href="javscript:;" type="button" class="btn btn-sm btn-primary-outline border border-primary text-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_update_workorder"><i class="mdi mdi-pencil-outline me-1"></i>Edit</a>
                            <a href="javscript:;" type="button" class="btn btn-sm btn-primary-outline border border-primary text-primary" data-bs-toggle="offcanvas" data-bs-target="#workorder_history_tab"><i class="mdi mdi-history me-1"></i>History</a>
                        </div>
                    </div>
                </div>
                <div class="detail-body">
                    <div class="workorder-wizard mb-6">
                        <div class="wizard-steps">
                            <div class="wizard-step active">
                                <div class="wizard-icon">
                                    <i class="mdi mdi-file-document-edit-outline"></i>
                                </div>
                                <div class="wizard-label">Inspection & Permit</div>
                            </div>
                            <div class="wizard-line"></div>
                            <div class="wizard-step">
                                <div class="wizard-icon">
                                    <i class="mdi mdi-file-document-check-outline"></i>
                                </div>
                                <div class="wizard-label">Validation</div>
                            </div>
                            <div class="wizard-line"></div>
                            <div class="wizard-step">
                                <div class="wizard-icon">
                                    <i class="mdi mdi-clipboard-text-outline"></i>
                                </div>
                                <div class="wizard-label">Preparation</div>
                            </div>
                            <div class="wizard-line"></div>
                            <div class="wizard-step">
                                <div class="wizard-icon">
                                    <i class="mdi mdi-shield-check-outline"></i>
                                </div>
                                <div class="wizard-label">Approval</div>
                            </div>
                            <div class="wizard-line"></div>
                            <div class="wizard-step">
                                <div class="wizard-icon">
                                    <i class="mdi mdi-cogs"></i>
                                </div>
                                <div class="wizard-label">Execution</div>
                            </div>
                            <div class="wizard-line"></div>
                            <div class="wizard-step">
                                <div class="wizard-icon">
                                    <i class="mdi mdi-flag-checkered"></i>
                                </div>
                                <div class="wizard-label">Closure</div>
                            </div>
                        </div>
                    </div>
                    <form id="wizardForm">
                        <input type="hidden" name="work_order_id" id="wizard_work_order_id">
                        <div class="wizard-content p-2">
                            <div class="wizard-panel active">
                            <div class="card border mx-3 mb-3 bg-gray-100 rounded">
                                <div class="card-header pb-0 d-flex align-items-center justify-content-between gap-5">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="mdi mdi-map-marker-radius-outline"></i> Site Inspection Report
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Site Condition Notes</label>
                                            <textarea class="form-control" name="site_condition_notes" rows="1" placeholder="Enter Site Condition Notes"></textarea>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Obstruction Notes</label>
                                            <textarea class="form-control" name="obstruction_notes" rows="1" placeholder="Enter Obstruction Notes"></textarea>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Special Tools Required</label>
                                            <input type="text" class="form-control" name="special_tools_required" placeholder="Enter Special Tools Required" />
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Access Issues</label>
                                            <textarea class="form-control" name="access_issues" rows="1" placeholder="Enter Access Issues"></textarea>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Safety Concerns</label>
                                            <textarea class="form-control" name="safety_concerns" rows="1" placeholder="Enter Safety Concerns"></textarea>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Permit Number</label>
                                            <input type="text" class="form-control" name="permit_number" placeholder="Enter Permit Number" />
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Permit Transferred By</label>
                                            <select class="form-select select3 assign_team" name="permit_transferred_by">
                                                <option value="">Select Staff</option>
                                                <option value="1">Michael Brown</option>
                                                <option value="2">Mike</option>
                                                <option value="3">Alice Wrench</option>
                                                <option value="4">Sarah Connor</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Staff Mobile No</label>
                                            <input type="text" class="form-control" name="staff_mobile_no" placeholder="Enter Staff Mobile No" />
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Staff Email Id</label>
                                            <input type="text" class="form-control" name="staff_email_id" placeholder="Enter Staff Email Id" />
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-7 fw-semibold">Assign Team<span class="text-danger">*</span></label>
                                            <select class="form-select select3 assign_team" name="assign_team">
                                                <option value="">Select Team</option>
                                                <option value="1">Team A</option>
                                                <option value="2">Team B</option>
                                                <option value="3">Team C</option>
                                                <option value="4">Team D</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-12 mb-3 d-none team_details">
                                            <div class="row  bg-white rounded p-2 border">
                                                <div class="col-lg-6 mb-2">
                                                    <div class="row">
                                                        <label class="col-5 fw-medium text-black fs-7">Supervisor</label>
                                                        <label class="col-1 fw-medium text-black fs-7">:</label>
                                                        <label class="col-6 fw-semibold text-black fs-7">John Smith <span class="text-danger">(Expired)</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-2">
                                                    <div class="row">
                                                        <label class="col-5 fw-medium text-black fs-7">Driver</label>
                                                        <label class="col-1 fw-medium text-black fs-7">:</label>
                                                        <label class="col-6 fw-semibold text-black fs-7">Andrew Thomas</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-2">
                                                    <div class="row">
                                                        <label class="col-5 fw-medium text-black fs-7">Technician</label>
                                                        <label class="col-1 fw-medium text-black fs-7">:</label>
                                                        <label class="col-6 fw-semibold text-black fs-7">Iqbaul <span class="text-danger">(Expired)</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-2">
                                                    <div class="row">
                                                        <label class="col-5 fw-medium text-black fs-7">Technician</label>
                                                        <label class="col-1 fw-medium text-black fs-7">:</label>
                                                        <label class="col-6 fw-semibold text-black fs-7">Fazil</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-2">
                                                    <div class="row">
                                                        <label class="col-5 fw-medium text-black fs-7">Technician</label>
                                                        <label class="col-1 fw-medium text-black fs-7">:</label>
                                                        <label class="col-6 fw-semibold text-black fs-7">Lawrence</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-2">
                                                    <div class="row">
                                                        <label class="col-5 fw-medium text-black fs-7">Rigger</label>
                                                        <label class="col-1 fw-medium text-black fs-7">:</label>
                                                        <label class="col-6 fw-semibold text-black fs-7">Tom</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <div class="modern-dropzone">
                                                <input type="file" class="file-input" multiple hidden>
                                                <div class="upload-area">
                                                    <i class="mdi mdi-cloud-upload-outline fs-1 upload-icon"></i>
                                                    <p class="upload-text">Drag & drop files or <span>Browse</span></p>
                                                </div>
                                                <div class="file-preview-list"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-panel">
                            <div class="row bg-gray-200 rounded p-3">
                                <div class="col-lg-12 mb-1">
                                    <div class="card border rounded p-4 mb-2">
                                        <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="tbt_100_percent_checked"/>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium text-black fs-7">ToolBox Talks (TBT) 100%</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-1">
                                    <div class="card border rounded p-4 mb-2">
                                        <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="assigned_members_checked"/>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium text-black fs-7">Assigned Members</label>
                                            </div>
                                        </div>
                                        <div class="row mt-2 p-2 bg-white rounded">
                                            <div class="col-lg-3 mb-2 d-flex flex-column">
                                                <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                                    <i class="mdi mdi-account-supervisor-outline fs-4 text-black"></i>
                                                    <span class="fw-semibold text-dark fs-7">Supervisor</span>
                                                </div>
                                                <span class="fw-semibold text-black fs-7">John Smith</span>
                                            </div>  
                                            <div class="col-lg-3 mb-2 d-flex flex-column">
                                                <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                                    <i class="mdi mdi-account-hard-hat-outline fs-4 text-black"></i>
                                                    <span class="fw-semibold text-dark fs-7">Technician</span>
                                                </div>
                                                <span class="fw-semibold text-black fs-7">Tom Slayer</span>
                                            </div>  
                                            <div class="col-lg-3 mb-2 d-flex flex-column">
                                                <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                                    <i class="mdi mdi-account-hard-hat-outline fs-4 text-black"></i>
                                                    <span class="fw-semibold text-dark fs-7">Technician</span>
                                                </div>
                                                <span class="fw-semibold text-black fs-7">Andrew Borman</span>
                                            </div>  
                                            <div class="col-lg-3 mb-2 d-flex flex-column">
                                                <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                                    <i class="mdi mdi-car fs-4 text-black"></i>
                                                    <span class="fw-semibold text-dark fs-7">Driver</span>
                                                </div>
                                                <span class="fw-semibold text-black fs-7">Andrew Borman</span>
                                            </div>  
                                            <div class="col-lg-3 mb-2 d-flex flex-column">
                                                <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                                    <i class="mdi mdi-hook fs-4 text-black"></i>
                                                    <span class="fw-semibold text-dark fs-7">Rigger</span>
                                                </div>
                                                <span class="fw-semibold text-black fs-7">Mohammed</span>
                                            </div>  
                                            <div class="col-lg-3 mb-2 d-flex flex-column">
                                                <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                                    <i class="mdi mdi-crane fs-4 text-black"></i>
                                                    <span class="fw-semibold text-dark fs-7">Crane</span>
                                                </div>
                                                <span class="fw-semibold text-black fs-7">Iqbual</span>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-1">
                                    <div class="card border rounded p-4 mb-2">
                                        <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="obstruction_notes_checked"/>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium text-black fs-7">Obstruction Notes</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                Pipeline partially blocked by electrical cable tray; ladder required for access.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-1">
                                    <div class="card border rounded p-4 mb-2">
                                        <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="special_tools_checked"/>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium text-black fs-7">Special Tools Required</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                Torque wrench, valve lapping kit, flange spreader.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-1">
                                    <div class="card border rounded p-4 mb-2">
                                        <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="access_issues_checked"/>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium text-black fs-7">Access Issues</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                Valve installed at 3.5m height; scaffolding or mobile ladder required.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-1">
                                    <div class="card border rounded p-4 mb-2">
                                        <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="safety_concerns_checked"/>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium text-black fs-7">Safety Concerns</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                Hot surface near steam line; technicians must wear heat-resistant gloves.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-1">
                                    <div class="card border rounded p-4 mb-2">
                                        <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="site_condition_checked"/>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium text-black fs-7">Site Condition Notes</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                Hot surface near steam line; technicians must wear heat-resistant gloves.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-1">
                                    <div class="card border rounded p-4 mb-2">
                                        <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="documents_permits_checked"/>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium text-black fs-7">Documents  & Permits</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 mb-2">
                                                <label class="text-black fw-semibold fs-6">Permit Number: PTW-2026-VAL-1045</label>
                                            </div>
                                            <div class="col-lg-12"> 
                                                <div class="d-flex align-items-center justify-content-start gap-2">
                                                    <div class="img-download-box">
                                                        <img src="{{ asset('assets/images/def_doc_img.png') }}" class="doc-img"/>
                                                        <a href="{{ asset('assets/images/def_doc_img.png') }}" download>
                                                            <i class="mdi mdi-download-circle-outline download-icon text-white"></i>
                                                        </a>
                                                    </div>
                                                    <div class="img-download-box">
                                                        <img src="{{ asset('assets/images/def_doc_img.png') }}" class="doc-img"/>
                                                        <a href="{{ asset('assets/images/def_doc_img.png') }}" download>
                                                            <i class="mdi mdi-download-circle-outline download-icon text-white"></i>
                                                        </a>
                                                    </div>
                                                    <div class="img-download-box">
                                                        <img src="{{ asset('assets/images/def_doc_img.png') }}" class="doc-img"/>
                                                        <a href="{{ asset('assets/images/def_doc_img.png') }}" download>
                                                            <i class="mdi mdi-download-circle-outline download-icon text-white"></i>
                                                        </a>
                                                    </div>
                                                    <div class="img-download-box">
                                                        <img src="{{ asset('assets/images/def_doc_img.png') }}" class="doc-img"/>
                                                        <a href="{{ asset('assets/images/def_doc_img.png') }}" download>
                                                            <i class="mdi mdi-download-circle-outline download-icon text-white"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-panel">
                            <div class="card border mx-3 mb-3 bg-gray-100 rounded">
                                <div class="card-header pb-0">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="mdi mdi-map-marker-radius-outline"></i> Asset Location
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label class="text-muted fs-7">Tag</label>
                                            <div class="fw-semibold">11-SRV-1</div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="text-muted fs-7">Location</label>
                                            <div class="fw-semibold">25.27699 , 55.29625</div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="text-muted fs-7">Sector</label>
                                            <div class="fw-semibold">OOD-FHSP</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border mx-3 mb-3 bg-gray-100 rounded">
                                <div class="card-header ">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="mdi mdi-tools"></i> Job Requirements
                                    </h6>
                                </div>
                                <div class="card-body px-2 py-2">
                                    <div class="row">
                                        <div class="col-lg-6 mb-3">
                                            <div class="require-box">
                                                <div class="fw-semibold text-warning">Scaffolding</div>
                                                <small>Required</small>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="require-box">
                                                <div class="fw-semibold text-warning">Crane / Lifting</div>
                                                <small>Required</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <label class="text-dark mb-2 fs-6">Assigned Tools</label>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card border rounded p-4 mb-2">
                                                    <div class="d-flex align-items-center justify-content-start gap-2">
                                                        <input class="form-check-input rounded w-25px h-25px" type="checkbox" checked/>
                                                        <div class="d-flex flex-column">
                                                            <label class="fw-medium text-black fs-7">50T Mobile Crane</label>
                                                            <label class="fw-medium text-dark fs-7">CR-SD-220-X</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card border rounded p-4 mb-2">
                                                    <div class="d-flex align-items-center justify-content-start gap-2">
                                                        <input class="form-check-input rounded w-25px h-25px" type="checkbox" checked/>
                                                        <div class="d-flex flex-column">
                                                            <label class="fw-medium text-black fs-7">Hydraulic Torque Wrench Kit</label>
                                                            <label class="fw-medium text-dark fs-7">HTW-004-A</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card border rounded p-4 mb-2">
                                                    <div class="d-flex align-items-center justify-content-start gap-2">
                                                        <input class="form-check-input rounded w-25px h-25px" type="checkbox" checked/>
                                                        <div class="d-flex flex-column">
                                                            <label class="fw-medium text-black fs-7">Grinding Machine</label>
                                                            <label class="fw-medium text-dark fs-7">GM-154-S</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card border rounded p-4 mb-2">
                                                    <div class="d-flex align-items-center justify-content-start gap-2">
                                                        <input class="form-check-input rounded w-25px h-25px" type="checkbox" checked/>
                                                        <div class="d-flex flex-column">
                                                            <label class="fw-medium text-black fs-7">Valve Testing Bench</label>
                                                            <label class="fw-medium text-dark fs-7">VTB-097-A</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mx-3 mb-3 bg-label-warning border border-warning rounded">
                                <div class="card-header border-bottom border-warning">
                                    <div class="d-flex align-items-center justify-content-start gap-2">
                                        <span><i class="mdi mdi-shield-check-outline fw-semibold fs-4" style="color: #8a2405"></i></span>
                                        <label class="fw-semibold fs-6" style="color: #8a2405">Pre-Checklist</label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card border rounded p-4 mb-2">
                                                <div class="d-flex align-items-center justify-content-start gap-2">
                                                    <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="pre_ptw_approved"/>
                                                    <div class="d-flex flex-column">
                                                        <label class="fw-medium text-black fs-7">PTW (Permit To Work) Approved & Signed</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card border rounded p-4 mb-2">
                                                <div class="d-flex align-items-center justify-content-start gap-2">
                                                    <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="pre_gate_pass_valid"/>
                                                    <div class="d-flex flex-column">
                                                        <label class="fw-medium text-black fs-7">Gate Pass & Access Control Valid</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card border rounded p-4 mb-2">
                                                <div class="d-flex align-items-center justify-content-start gap-2">
                                                    <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="pre_weather_verified"/>
                                                    <div class="d-flex flex-column">
                                                        <label class="fw-medium text-black fs-7">Weathers Conditions Verified (No High Wind/Rain)</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card border rounded p-4 mb-2">
                                                <div class="d-flex align-items-center justify-content-start gap-2">
                                                    <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="pre_equipment_readiness"/>
                                                    <div class="d-flex flex-column">
                                                        <label class="fw-medium text-black fs-7">Equipment & Lifting Gear Readiness Verified</label>
                                                        <label>
                                                            <span class="fw-medium bg-label-info badge fs-7">Required: Lifting Gear</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card border rounded p-4 mb-2">
                                                <div class="d-flex align-items-center justify-content-start gap-2">
                                                    <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="pre_team_certs_valid"/>
                                                    <div class="d-flex flex-column">
                                                        <label class="fw-medium text-black fs-7">Team Certifications & Competency Valid</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card border rounded p-4 mb-2">
                                                <div class="d-flex align-items-center justify-content-start gap-2">
                                                    <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="pre_loto_applied"/>
                                                    <div class="d-flex flex-column">
                                                        <label class="fw-medium text-black fs-7">LOTO (Log Out /Tag Out) Applied</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-2">
                                            <div class="d-flex align-items-center justify-content-between gap-5 mb-2">
                                                <label class="text-black fs-7 fw-semibold">Tehnical Notes</label>
                                                <div class="d-flex align-items-center justify-content-start gap-2">
                                                    <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="escalate_prep"/>
                                                    <label class="fw-semibold text-black fs-7">Escalate</label>
                                                </div>
                                            </div>
                                            <textarea class="form-control" name="tech_notes_prep" rows="5" placeholder="Enter Tehnical Notes"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-panel">
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <div class="d-flex align-items-center justify-content-between gap-5 mb-2">
                                        <label class="text-black fs-7 fw-semibold">Tehnical Notes</label>
                                        <div class="d-flex align-items-center justify-content-start gap-2">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="escalate_approval"/>
                                            <label class="fw-semibold text-black fs-7">Escalate</label>
                                        </div>
                                    </div>
                                    <textarea class="form-control" name="tech_notes_approval" rows="5" placeholder="Enter Tehnical Notes"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-panel">
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <div class="detail-card mb-2">
                                        <div class="detail-spec">
                                            <span class="text-dark fw-bold fs-6">4. Safety Precautions</span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_safety_loto"/>
                                            <span class="text-black fw-medium fs-6">
                                                Ensure lockout/tagout (LOTO) of the valve and connected system.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_safety_depressurized"/>
                                            <span class="text-black fw-medium fs-6">
                                                Confirm that the system is depressurized and drained.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_safety_lifting"/>
                                            <span class="text-black fw-medium fs-6">
                                                Use proper lifting techniques and tools for heavy valves.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_safety_ventilation"/>
                                            <span class="text-black fw-medium fs-6">
                                                Maintain proper ventilation for solvent cleaning.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_safety_ppe"/>
                                            <span class="text-black fw-medium fs-6">
                                                Use PPE at all times.
                                            </span>
                                        </div>
                                        <hr class="my-1">
                                        <div class="detail-spec">
                                            <span class="text-dark fw-bold fs-6">5. Procedure</span>
                                        </div>
                                        <div class="detail-spec">
                                            <span class="text-dark fw-semibold fs-6">5.1 Pre-Repair Inspection</span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_proc_pre_verify"/>
                                            <span class="text-black fw-medium fs-6">
                                                Verify valve type, size, and identification tag.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_proc_pre_check"/>
                                            <span class="text-black fw-medium fs-6">
                                                Check prior maintenance records for recurring issues.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_proc_pre_inspect"/>
                                            <span class="text-black fw-medium fs-6">
                                                Visually inspect for leaks, corrosion, cracks, and physical damage.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_proc_pre_document"/>
                                            <span class="text-black fw-medium fs-6">
                                                Document the condition with photos and notes.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <span class="text-dark fw-semibold fs-6">5.2 Valve Isolation & Preparation</span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_iso_isolate"/>
                                            <span class="text-black fw-medium fs-6">
                                                Isolate the valve from the process line.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_iso_depressurize"/>
                                            <span class="text-black fw-medium fs-6">
                                                Depressurize and drain any residual fluid.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_iso_clean"/>
                                            <span class="text-black fw-medium fs-6">
                                                Clean the valve exterior to prevent contamination during repair.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_iso_prepare"/>
                                            <span class="text-black fw-medium fs-6">
                                                Prepare tools, spare parts, and work area.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <span class="text-dark fw-semibold fs-6">5.3 Disassembly</span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_dis_loosen"/>
                                            <span class="text-black fw-medium fs-6">
                                                Loosen and remove bolts, nuts, and fasteners carefully.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_dis_remove"/>
                                            <span class="text-black fw-medium fs-6">
                                                Remove valve bonnet, stem, disc, and other components systematically.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_dis_organize"/>
                                            <span class="text-black fw-medium fs-6">
                                                Keep parts organized and labeled for reassembly.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_dis_inspect"/>
                                            <span class="text-black fw-medium fs-6">
                                                Inspect components for wear, corrosion, or damage.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <span class="text-dark fw-semibold fs-6">5.4 Component Cleaning & Repair</span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_clean_solvents"/>
                                            <span class="text-black fw-medium fs-6">
                                                Clean all parts using appropriate solvents.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_clean_grind"/>
                                            <span class="text-black fw-medium fs-6">
                                                Grind or lap valve seats and discs if required.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_clean_replace"/>
                                            <span class="text-black fw-medium fs-6">
                                                Replace worn or damaged seals, gaskets, stems, or other components.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_clean_lubricate"/>
                                            <span class="text-black fw-medium fs-6">
                                                Lubricate moving parts with recommended industrial lubricants.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <span class="text-dark fw-semibold fs-6">5.5 Reassembly</span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_reassemble_reverse"/>
                                            <span class="text-black fw-medium fs-6">
                                                Reassemble components in reverse order of disassembly.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_reassemble_torque"/>
                                            <span class="text-black fw-medium fs-6">
                                                Apply recommended torque on bolts using a calibrated torque wrench.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_reassemble_align"/>
                                            <span class="text-black fw-medium fs-6">
                                                Ensure proper alignment and sealing of moving parts.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <span class="text-dark fw-semibold fs-6">5.6 Testing & Quality Check</span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_test_pressure"/>
                                            <span class="text-black fw-medium fs-6">
                                                Perform pressure testing according to valve specification (hydraulic/pneumatic).
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_test_leaks"/>
                                            <span class="text-black fw-medium fs-6">
                                                Check for leaks, proper movement, and operational integrity.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_test_record"/>
                                            <span class="text-black fw-medium fs-6">
                                                Record test results and validate against manufacturer standards.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <span class="text-dark fw-semibold fs-6">5.7 Reinstallation</span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_reinstall_reinstall"/>
                                            <span class="text-black fw-medium fs-6">
                                                Reinstall valve into the system, ensuring alignment with pipeline.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_reinstall_remove_loto"/>
                                            <span class="text-black fw-medium fs-6">
                                                Remove lockout/tagout after confirming safety.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_reinstall_pressurize"/>
                                            <span class="text-black fw-medium fs-6">
                                                Gradually pressurize the system and check for leaks.
                                            </span>
                                        </div>
                                        <div class="detail-spec">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="exec_reinstall_update_records"/>
                                            <span class="text-black fw-medium fs-6">
                                                Update maintenance records and log repair details.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <label class="text-black mb-1 fs-7 fw-semibold">Remarks</label>
                                    <textarea class="form-control" name="exec_remarks" rows="1" placeholder="Enter Remarks"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-panel">
                            <div class="row p-4 g-2">
                                <div class="col-lg-12 mb-3">
                                    <label class="fw-semibold text-black fs-7 mb-2">Before Image</label>
                                    <div class="modern-dropzone" id="beforeDropzone">
                                        <input type="file" class="file-input" name="before_images[]" multiple hidden>
                                        <div class="upload-area">
                                            <i class="mdi mdi-cloud-upload-outline fs-1 upload-icon"></i>
                                            <p class="upload-text">Drag & drop files or <span>Browse</span></p>
                                        </div>
                                        <div class="file-preview-list"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label class="fw-semibold text-black fs-7 mb-2">During Image</label>
                                    <div class="modern-dropzone" id="duringDropzone">
                                        <input type="file" class="file-input" name="during_images[]" multiple hidden>
                                        <div class="upload-area">
                                            <i class="mdi mdi-cloud-upload-outline fs-1 upload-icon"></i>
                                            <p class="upload-text">Drag & drop files or <span>Browse</span></p>
                                        </div>
                                        <div class="file-preview-list"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label class="fw-semibold text-black fs-7 mb-2">After Image</label>
                                    <div class="modern-dropzone" id="afterDropzone">
                                        <input type="file" class="file-input" name="after_images[]" multiple hidden>
                                        <div class="upload-area">
                                            <i class="mdi mdi-cloud-upload-outline fs-1 upload-icon"></i>
                                            <p class="upload-text">Drag & drop files or <span>Browse</span></p>
                                        </div>
                                        <div class="file-preview-list"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Workflow Status<span class="text-danger">*</span></label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="workflow" id="workflow_removed"
                                                value="1" checked />
                                            <label class="form-check-label" for="workflow_removed">Removed</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="workflow" id="workflow_with_shop"
                                                value="2" />
                                            <label class="form-check-label" for="workflow_with_shop">Workshop</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="workflow" id="workflow_in_store"
                                                value="3" />
                                            <label class="form-check-label" for="workflow_in_store">In Store</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="text-black mb-1 fs-6 fw-semibold">Final Status<span class="text-danger">*</span></label>
                                    <div class="d-block">
                                        <button type="button" id="submitWizard" class="btn btn-success btn-sm">Submit / Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-5 bg-white py-5 px-2">
                            <button class="btn btn-secondary" id="prevStep">
                                Previous
                            </button>
                            <button class="btn btn-primary" id="nextStep">
                                Next Step
                                <i class="mdi mdi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
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


<!--begin::Offcanvas - Work Order History-->
<div class="offcanvas offcanvas-end w-600px" id="workorder_history_tab" tabindex="-1" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
  <div class="offcanvas-header border-bottom d-block bg-label-primary">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="offcanvas-title text-black fw-bold">Work Order History</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
  </div>
  <div class="offcanvas-body flex-grow-1">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="d-flex align-items-center justify-content-between gap-5 mb-2">
                <label class="text-black fs-7 fw-semibold">Comments</label>
                <a href="javascript:;" class="btn btn-sm btn-primary-outline border border-primary text-primary">Add Comments</a>
            </div>
            <textarea class="form-control" rows="5" placeholder="Enter Access Issues"></textarea>
        </div>
        <div class="col-lg-12 mb-3">
            <label class="text-black fs-7 fw-semibold">Timeline</label>
            <div class="timeline-wrapper scroll-y" style="max-height: 700px;">
                <div class="timeline-row">
                    <div class="timeline-time">12-Mar-2026 09:00 AM</div>
                    <div class="timeline-center">
                        <span class="timeline-dot"></span>
                        <span class="timeline-line"></span>
                    </div>
                    <div class="timeline-content">
                        <h6>Arun Prakash</h6>
                        <p>Inspection permit created for SRV valve inspection.</p>
                    </div>
                </div>
                <div class="timeline-row">
                    <div class="timeline-time">12-Mar-2026 09:20 AM</div>
                    <div class="timeline-center">
                        <span class="timeline-dot"></span>
                        <span class="timeline-line"></span>
                    </div>
                    <div class="timeline-content">
                        <h6>David Mathew</h6>
                        <p>Permit approved for inspection activity.</p>
                    </div>
                </div>
                <div class="timeline-row">
                    <div class="timeline-time">12-Mar-2026 10:05 AM</div>
                    <div class="timeline-center">
                        <span class="timeline-dot"></span>
                        <span class="timeline-line"></span>
                    </div>
                    <div class="timeline-content">
                        <h6>Arun Prakash</h6>
                        <p>Pre-inspection checklist completed and verified.</p>
                    </div>
                </div>
                <div class="timeline-row">
                    <div class="timeline-time">12-Mar-2026 10:40 AM</div>
                    <div class="timeline-center">
                        <span class="timeline-dot"></span>
                        <span class="timeline-line"></span>
                    </div>
                    <div class="timeline-content">
                        <h6>Sneha Reddy</h6>
                        <p>Inspection procedure document uploaded for validation.</p>
                    </div>
                </div>
                <div class="timeline-row">
                    <div class="timeline-time">12-Mar-2026 11:15 AM</div>
                    <div class="timeline-center">
                        <span class="timeline-dot"></span>
                        <span class="timeline-line"></span>
                    </div>
                    <div class="timeline-content">
                        <h6>Supervisor - Rajesh Kumar</h6>
                        <p>Inspection request reviewed and approved.</p>
                    </div>
                </div>
                <div class="timeline-row">
                    <div class="timeline-time">12-Mar-2026 01:30 PM</div>
                    <div class="timeline-center">
                        <span class="timeline-dot"></span>
                        <span class="timeline-line"></span>
                    </div>
                    <div class="timeline-content">
                        <h6>Technician - Manoj Kumar</h6>
                        <p>Valve inspection execution started.</p>
                    </div>
                </div>
                <div class="timeline-row">
                    <div class="timeline-time">12-Mar-2026 02:20 PM</div>
                    <div class="timeline-center">
                        <span class="timeline-dot"></span>
                        <span class="timeline-line"></span>
                    </div>
                    <div class="timeline-content">
                        <h6>Technician - Manoj Kumar</h6>
                        <p>Issue identified during inspection and recorded for review.</p>
                    </div>
                </div>
                <div class="timeline-row">
                    <div class="timeline-time">12-Mar-2026 03:10 PM</div>
                    <div class="timeline-center">
                        <span class="timeline-dot"></span>
                        <span class="timeline-line"></span>
                    </div>
                    <div class="timeline-content">
                        <h6>John Smith</h6>
                        <p>Comment added: Access to the valve area was restricted due to nearby maintenance work.</p>
                    </div>
                </div>
                <div class="timeline-row">
                    <div class="timeline-time">12-Mar-2026 04:00 PM</div>
                    <div class="timeline-center">
                        <span class="timeline-dot"></span>
                        <span class="timeline-line"></span>
                    </div>
                    <div class="timeline-content">
                        <h6>Arun Prakash</h6>
                        <p>Inspection images uploaded (Before, During, After).</p>
                    </div>
                </div>
                <div class="timeline-row">
                    <div class="timeline-time">12-Mar-2026 04:45 PM</div>
                    <div class="timeline-center">
                        <span class="timeline-dot"></span>
                        <span class="timeline-line"></span>
                    </div>
                    <div class="timeline-content">
                        <h6>Supervisor - Rajesh Kumar</h6>
                        <p>Inspection completed and work order moved to closure.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<!--end::Offcanvas - Work Order History-->


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
        <form id="addWorkOrderForm">
        @csrf
        <div class="modal-body py-5 px-10 px-xl-20">
            <div class="row scroll-y" style="max-height: 650px;">
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Client<span class="text-danger">*</span></label>
                    <select class="select3 form-select" name="client_id" required>
                        <option value="">Select Client</option>
                        @foreach($clients as $val)
                            <option value="{{ $val->id }}">{{ $val->company_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Asset<span class="text-danger">*</span></label>
                    <select class="select3 form-select" name="asset_id" required>
                        <option value="">Select Asset</option>
                        @foreach($assets as $val)
                            <option value="{{ $val->id }}">{{ $val->tag_number ?? $val->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Procedure<span class="text-danger">*</span></label>
                    <select class="select3 form-select" name="procedure_id" required>
                        <option value="">Select Procedure</option>
                         @foreach($procedures as $val)
                            <option value="{{ $val->id }}">{{ $val->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Order Title</label>
                    <input type="text" class="form-control" name="title" placeholder="Enter Order Title" />
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Description</label>
                    <textarea class="form-control" name="description" rows="1" placeholder="Enter Description"></textarea>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-2 fs-7 fw-semibold">Assign Tools & Equipments</label>
                    <div class="row border p-3 g-2 rounded scroll-y max-h-250px">
                        @foreach($tools as $tool)
                        <div class="d-flex align-items-center justify-content-between gap-5 bg-gray-100 p-3">
                            <div class="d-flex align-items-center justify-content-start gap-2 bg-gray-100">
                                <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="tools[]" value="{{ $tool->id }}" />
                                <div class="d-flex flex-column">
                                    <label class="fw-medium text-black fs-7">{{ $tool->name }}</label>
                                    <label class="fw-medium text-dark fs-7">{{ $tool->serial_number ?? $tool->type }}</label>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Order Type<span class="text-danger">*</span></label>
                    <select class="select3 form-select" name="order_type" required>
                        <option value="">Select Order Type</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="Repair">Repair</option>
                        <option value="Inspection">Inspection</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Priority<span class="text-danger">*</span></label>
                    <select class="select3 form-select" name="priority" required>
                        <option value="">Select Priority</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Compliance Date<span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar-month-outline fs-4"></i>
                        </span>
                        <input type="text" name="compliance_date" class="form-control common_datepicker" placeholder="Select Date" required>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Assigned Date<span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar-month-outline fs-4"></i>
                        </span>
                        <input type="text" name="assigned_date" class="form-control common_datepicker" placeholder="Select Date" required>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Tentative Removal<span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar-month-outline fs-4"></i>
                        </span>
                        <input type="text" name="tentative_removal_date" class="form-control common_datepicker" placeholder="Select Date" required>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">ABC Ind.</label>
                    <input type="text" class="form-control" name="abc_ind" placeholder="Enter ABC Ind." />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Scheudling Grp</label>
                    <input type="text" class="form-control" name="scheduling_grp" placeholder="Enter Scheudling Grp" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Haz Area</label>
                    <input type="text" class="form-control" name="haz_area" placeholder="Enter Haz Area" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Act Type</label>
                    <input type="text" class="form-control" name="act_type" placeholder="Enter Act Type" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Cnfn No</label>
                    <input type="text" class="form-control" name="cnfn_no" placeholder="Enter Cnfn No" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">No.Men</label>
                    <input type="text" class="form-control" name="no_men" placeholder="Enter No.Men" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Dur. Hrs</label>
                    <input type="text" class="form-control" name="dur_hrs" placeholder="Enter Dur. Hrs" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">St Txt Key</label>
                    <input type="text" class="form-control" name="st_txt_key" placeholder="Enter St Txt Key" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Oper No.</label>
                    <input type="text" class="form-control" name="oper_no" placeholder="Enter Oper No." />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Catalog Profile</label>
                    <input type="text" class="form-control" name="catalog_profile" placeholder="Enter Catalog Profile" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">O&M Manual Doc.No.</label>
                    <input type="text" class="form-control" name="om_manual_doc_no" placeholder="Enter O&M Manual Doc.No." />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Material No & Desc</label>
                    <input type="text" class="form-control" name="material_no_desc" placeholder="Enter Material No & Desc" />
                </div>
               <div class="col-lg-6 mb-3">
                    <div class="d-flex align-items-center justify-content-start gap-2">
                        <input class="form-check-input rounded w-25px h-25px" type="checkbox" id="recurrence_check"/>
                        <label class="text-black fs-7 fw-semibold" for="recurrence_check">Recurrence</label>
                    </div>
                    <div id="recurrence_wrapper" class="d-none mt-2">
                        <select class="select3 form-select" name="recurrence" id="recurrence_select">
                            <option value="">Select Recurrence</option>
                            <option value="Quarterly">Quarterly</option>
                            <option value="Yearly">Yearly</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="row">
                        <div class="col-lg-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="scaffolding_add" value="Scaffolding" name="scaff_crane">
                                <label class="form-check-label text-black fw-semibold" for="scaffolding_add">
                                    Scaffolding
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="crane_add" value="Crane" name="scaff_crane">
                                <label class="form-check-label text-black fw-semibold" for="crane_add">
                                    Crane
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="scaff_crane_add" value="Scaffolding + Crane" name="scaff_crane">
                                <label class="form-check-label text-black fw-semibold" for="scaff_crane_add">
                                    Scaffolding + Crane
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
            <button type="submit" class="btn btn-primary" id="btn_save_workorder">Create Work Order</button>
          </div>
        </div>
        </form>
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
        <form id="updateWorkOrderForm">
        @csrf
        <input type="hidden" name="work_order_id" id="update_work_order_id">
        <div class="modal-body py-5 px-10 px-xl-20">
            <div class="row scroll-y" style="max-height: 650px;">
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Client<span class="text-danger">*</span></label>
                    <select class="select3 form-select" name="client_id" id="up_client_id" required>
                        <option value="">Select Client</option>
                        @foreach($clients as $val)
                            <option value="{{ $val->id }}">{{ $val->company_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Asset<span class="text-danger">*</span></label>
                    <select class="select3 form-select" name="asset_id" id="up_asset_id" required>
                        <option value="">Select Asset</option>
                        @foreach($assets as $val)
                            <option value="{{ $val->id }}">{{ $val->tag_number ?? $val->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Procedure<span class="text-danger">*</span></label>
                    <select class="select3 form-select" name="procedure_id" id="up_procedure_id" required>
                        <option value="">Select Procedure</option>
                         @foreach($procedures as $val)
                            <option value="{{ $val->id }}">{{ $val->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Order Title</label>
                    <input type="text" class="form-control" name="title" id="up_title" placeholder="Enter Order Title" />
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Description</label>
                    <textarea class="form-control" name="description" id="up_description" rows="1" placeholder="Enter Description"></textarea>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-2 fs-7 fw-semibold">Assign Tools & Equipments</label>
                    <div class="row border p-3 g-2 rounded scroll-y max-h-250px">
                        @foreach($tools as $tool)
                        <div class="d-flex align-items-center justify-content-between gap-5 bg-gray-100 p-3">
                            <div class="d-flex align-items-center justify-content-start gap-2 bg-gray-100">
                                <input class="form-check-input rounded w-25px h-25px up_tools" type="checkbox" name="tools[]" value="{{ $tool->id }}" id="up_tool_{{ $tool->id }}" />
                                <div class="d-flex flex-column">
                                    <label class="fw-medium text-black fs-7" for="up_tool_{{ $tool->id }}">{{ $tool->name }}</label>
                                    <label class="fw-medium text-dark fs-7">{{ $tool->serial_number ?? $tool->type }}</label>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Order Type<span class="text-danger">*</span></label>
                    <select class="select3 form-select" name="order_type" id="up_order_type" required>
                        <option value="">Select Order Type</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="Repair">Repair</option>
                        <option value="Inspection">Inspection</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Priority<span class="text-danger">*</span></label>
                    <select class="select3 form-select" name="priority" id="up_priority" required>
                        <option value="">Select Priority</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Compliance Date<span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar-month-outline fs-4"></i>
                        </span>
                        <input type="text" name="compliance_date" id="up_compliance_date" class="form-control common_datepicker" placeholder="Select Date" required>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Assigned Date<span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar-month-outline fs-4"></i>
                        </span>
                        <input type="text" name="assigned_date" id="up_assigned_date" class="form-control common_datepicker" placeholder="Select Date" required>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Tentative Removal<span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar-month-outline fs-4"></i>
                        </span>
                        <input type="text" name="tentative_removal_date" id="up_tentative_removal_date" class="form-control common_datepicker" placeholder="Select Date" required>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">ABC Ind.</label>
                    <input type="text" class="form-control" name="abc_ind" id="up_abc_ind" placeholder="Enter ABC Ind." />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Scheudling Grp</label>
                    <input type="text" class="form-control" name="scheduling_grp" id="up_scheduling_grp" placeholder="Enter Scheudling Grp" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Haz Area</label>
                    <input type="text" class="form-control" name="haz_area" id="up_haz_area" placeholder="Enter Haz Area" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Act Type</label>
                    <input type="text" class="form-control" name="act_type" id="up_act_type" placeholder="Enter Act Type" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Cnfn No</label>
                    <input type="text" class="form-control" name="cnfn_no" id="up_cnfn_no" placeholder="Enter Cnfn No" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">No.Men</label>
                    <input type="text" class="form-control" name="no_men" id="up_no_men" placeholder="Enter No.Men" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Dur. Hrs</label>
                    <input type="text" class="form-control" name="dur_hrs" id="up_dur_hrs" placeholder="Enter Dur. Hrs" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">St Txt Key</label>
                    <input type="text" class="form-control" name="st_txt_key" id="up_st_txt_key" placeholder="Enter St Txt Key" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Oper No.</label>
                    <input type="text" class="form-control" name="oper_no" id="up_oper_no" placeholder="Enter Oper No." />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Catalog Profile</label>
                    <input type="text" class="form-control" name="catalog_profile" id="up_catalog_profile" placeholder="Enter Catalog Profile" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">O&M Manual Doc.No.</label>
                    <input type="text" class="form-control" name="om_manual_doc_no" id="up_om_manual_doc_no" placeholder="Enter O&M Manual Doc.No." />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Material No & Desc</label>
                    <input type="text" class="form-control" name="material_no_desc" id="up_material_no_desc" placeholder="Enter Material No & Desc" />
                </div>
               <div class="col-lg-6 mb-3">
                    <div class="d-flex align-items-center justify-content-start gap-2">
                        <input class="form-check-input rounded w-25px h-25px" type="checkbox" id="up_recurrence_check"/>
                        <label class="text-black fs-7 fw-semibold" for="up_recurrence_check">Recurrence</label>
                    </div>
                    <div id="up_recurrence_wrapper" class="d-none mt-2">
                        <select class="select3 form-select" name="recurrence" id="up_recurrence_select">
                            <option value="">Select Recurrence</option>
                            <option value="Quarterly">Quarterly</option>
                            <option value="Yearly">Yearly</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="row">
                        <div class="col-lg-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="up_scaffolding" name="scaff_crane" value="Scaffolding">
                                <label class="form-check-label text-black fw-semibold" for="up_scaffolding">
                                    Scaffolding
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="up_crane" name="scaff_crane" value="Crane">
                                <label class="form-check-label text-black fw-semibold" for="up_crane">
                                    Crane
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="up_scaff_crane" name="scaff_crane" value="Scaffolding + Crane">
                                <label class="form-check-label text-black fw-semibold" for="up_scaff_crane">
                                    Scaffolding + Crane
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
            <button type="submit" class="btn btn-primary" id="btn_update_workorder">Update Work Order</button>
          </div>
        </div>
        </form>
        <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Update Work Order-->
<script>
document.addEventListener("DOMContentLoaded", function () {

    let currentStep = 0;

    const steps = document.querySelectorAll(".wizard-step");
    const panels = document.querySelectorAll(".wizard-panel");

    const nextBtn = document.getElementById("nextStep");
    const prevBtn = document.getElementById("prevStep");
    const radios = document.querySelectorAll('input[name="workflow"]');

    function showStep(step) {

        // Panel switching
        panels.forEach((panel, i) => {
            panel.classList.toggle("active", i === step);
        });

        steps.forEach((stepItem, i) => {
            stepItem.classList.toggle("active", i === step);
        });

        // Previous button
        prevBtn.style.display = step === 0 ? "none" : "inline-block";

        updateButton(); // 🔥 important
    }

    function updateButton() {

        const selectedRadio = document.querySelector('input[name="workflow"]:checked');
        const selected = selectedRadio ? selectedRadio.value : null;

        // LAST STEP
        if (currentStep === panels.length - 1) {

            if (selected === "2") {
                nextBtn.innerHTML = 'Move to Calibration <i class="mdi mdi-arrow-right"></i>';
                nextBtn.classList.remove("btn-primary", "btn-success");
                nextBtn.classList.add("btn-warning");
            } else {
                nextBtn.innerHTML = '<i class="mdi mdi-check"></i> Submit Work Order';
                nextBtn.classList.remove("btn-primary", "btn-warning");
                nextBtn.classList.add("btn-success");
            }

        } else {
            // NORMAL STEPS
            nextBtn.innerHTML = 'Next Step <i class="mdi mdi-arrow-right"></i>';
            nextBtn.classList.remove("btn-success", "btn-warning");
            nextBtn.classList.add("btn-primary");
        }
    }

    // NEXT CLICK
    nextBtn.addEventListener("click", function () {

        if (currentStep === panels.length - 1) {

            const selected = document.querySelector('input[name="workflow"]:checked')?.value;

            if (selected === "2") {
                alert("Moved to Calibration");
            } else {
                alert("Work Order Submitted");
            }

            return;
        }

        if (currentStep < panels.length - 1) {
            currentStep++;
            showStep(currentStep);
        }
    });

    // PREVIOUS CLICK
    prevBtn.addEventListener("click", function () {
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
        }
    });

    // RADIO CHANGE
    radios.forEach(radio => {
        radio.addEventListener("change", updateButton);
    });

    // INIT
    showStep(currentStep);

});
</script>
<script>
    $(document).ready(function () {
        $('#recurrence_check').change(function () {
            if ($(this).is(':checked')) {
                $('#recurrence_select').removeClass('d-none');
            } else {
                $('#recurrence_select').addClass('d-none');
            }
        });
    });
</script>

<script>
$(document).ready(function () {

    $('.assign_team').on('change', function () {

        if ($(this).val() && $(this).val().length > 0) {
            $('.team_details').removeClass('d-none');
        } else {
            $('.team_details').addClass('d-none');
        }

    });

});
</script>

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

    $(".asset_list").DataTable({
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
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Clear validation errors on input
    $('#addWorkOrderForm, #kt_modal_update_workorder_form').on('input change', 'input, select, textarea', function() {
        $(this).removeClass('is-invalid');
    });

    // Toggle Recurrence Add Modal
    $('#recurrence_check').on('change', function() {
        if ($(this).is(':checked')) {
            $('#recurrence_wrapper').removeClass('d-none');
            $('#recurrence_select').prop('required', true);
        } else {
            $('#recurrence_wrapper').addClass('d-none');
            $('#recurrence_select').prop('required', false).val('').trigger('change');
        }
    });

    // Toggle Recurrence Update Modal
    $('#up_recurrence_check').on('change', function() {
        if ($(this).is(':checked')) {
            $('#up_recurrence_wrapper').removeClass('d-none');
            $('#up_recurrence_select').prop('required', true);
        } else {
            $('#up_recurrence_wrapper').addClass('d-none');
            $('#up_recurrence_select').prop('required', false).val('').trigger('change');
        }
    });

    // Add Work Order
    $('#addWorkOrderForm').on('submit', function(e) {
        e.preventDefault();
        $(this).find('.is-invalid').removeClass('is-invalid');
        var formData = new FormData(this);
        $.ajax({
            url: "{{ url('manage_work_order/store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#btn_save_workorder').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...');
            },
            complete: function() {
                $('#btn_save_workorder').prop('disabled', false).html('Create Work Order');
            },
            success: function(response) {
                if(response.success) {
                    $('#kt_modal_add_workorder').modal('hide');
                    if(typeof toastr !== 'undefined') toastr.success(response.message || 'Work order created successfully.');
                    else alert(response.message || 'Work order created successfully.');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    if (response.errors) {
                        var errorMsg = '';
                        $.each(response.errors, function(key, value) {
                            errorMsg += value[0] + '<br>';
                            $('#addWorkOrderForm [name="'+key+'"]').addClass('is-invalid');
                        });
                        if(typeof toastr !== 'undefined') toastr.error(errorMsg, 'Validation Error');
                        else alert('Validation Error:\n' + errorMsg.replace(/<br>/g, '\n'));
                    } else {
                        if(typeof toastr !== 'undefined') toastr.error(response.message || 'Error creating work order.');
                        else alert(response.message || 'Error creating work order.');
                    }
                }
            },
            error: function(xhr) {
                if(typeof toastr !== 'undefined') toastr.error('An error occurred. Check your network or server logs.'); 
                else alert('An error occurred.');
            }
        });
    });

    // Fetch Work Order (Populate Update Modal and Detail Panel)
    $(document).on('click', '.view_work_order', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        
        $.ajax({
            url: "{{ url('manage_work_order/show') }}/" + id,
            type: "GET",
            success: function(response) {
                if(response && response.success) {
                    var data = response.data;
                    // Populate Update Form
                    $('#update_id').val(data.id);
                    $('#update_title').val(data.title);
                    $('#update_description').val(data.description);
                    $('#update_order_type').val(data.order_type).trigger('change');
                    $('#update_priority').val(data.priority).trigger('change');
                    $('#update_company_id').val(data.company_id).trigger('change');
                    $('#update_asset_id').val(data.asset_id).trigger('change');
                    $('#update_procedure_id').val(data.procedure_id).trigger('change');
                    
                    // Set Date Pickers using Flatpickr API if available
                    if (data.compliance_date && $('#up_compliance_date')[0]._flatpickr) {
                        $('#up_compliance_date')[0]._flatpickr.setDate(data.compliance_date);
                    } else {
                        $('#up_compliance_date').val(data.compliance_date);
                    }
                    if (data.assigned_date && $('#up_assigned_date')[0]._flatpickr) {
                        $('#up_assigned_date')[0]._flatpickr.setDate(data.assigned_date);
                    } else {
                        $('#up_assigned_date').val(data.assigned_date);
                    }
                    if (data.tentative_removal_date && $('#up_tentative_removal_date')[0]._flatpickr) {
                        $('#up_tentative_removal_date')[0]._flatpickr.setDate(data.tentative_removal_date);
                    } else {
                        $('#up_tentative_removal_date').val(data.tentative_removal_date);
                    }

                    $('#up_abc_ind').val(data.abc_ind);
                    $('#up_scheduling_grp').val(data.scheduling_grp);
                    $('#up_haz_area').val(data.haz_area);
                    $('#up_act_type').val(data.act_type);
                    $('#up_cnfn_no').val(data.cnfn_no);
                    $('#up_no_men').val(data.no_men);
                    $('#up_dur_hrs').val(data.dur_hrs);
                    $('#up_st_txt_key').val(data.st_txt_key);
                    $('#up_oper_no').val(data.oper_no);
                    $('#up_catalog_profile').val(data.catalog_profile);
                    $('#up_om_manual_doc_no').val(data.om_manual_doc_no);
                    $('#up_material_no_desc').val(data.material_no_desc);

                    $('#up_recurrence_select').val(data.recurrence).trigger('change');
                    if(data.recurrence) {
                        $('#up_recurrence_check').prop('checked', true);
                        $('#up_recurrence_wrapper').removeClass('d-none');
                        $('#up_recurrence_select').prop('required', true);
                    } else {
                        $('#up_recurrence_check').prop('checked', false);
                        $('#up_recurrence_wrapper').addClass('d-none');
                        $('#up_recurrence_select').prop('required', false);
                    }

                    if(data.scaff_crane) {
                        $('input[name="scaff_crane"][value="'+data.scaff_crane+'"]').prop('checked', true);
                    } else {
                        $('input[name="scaff_crane"]').prop('checked', false);
                    }
                    
                    // Clear and set tools
                    $('input[name="tools[]"]').prop('checked', false);
                    if(data.tools) {
                        data.tools.forEach(function(tool) {
                            $('#up_tool_' + tool.id).prop('checked', true);
                        });
                    }

                    // Populate Detail Panel
                    var assetLabel = 'N/A';
                    if(data.asset) {
                        assetLabel = data.asset.tag_number ? data.asset.tag_number : data.asset.name;
                    }
                    $('#detail_asset_tag').text(assetLabel);
                    $('#detail_wo_id').text(data.id);
                    $('#detail_priority').text('Priority: ' + (data.priority ? data.priority : '--'));
                    $('#detail_desc').text(data.description ? data.description : '--');

                    // Populate Wizard Form
                    $('#wizardForm')[0].reset();
                    $('#wizard_work_order_id').val(data.id);
                    if(data.wizard_data) {
                        try {
                            var parsedWizardData = typeof data.wizard_data === 'string' ? JSON.parse(data.wizard_data) : data.wizard_data;
                            $.each(parsedWizardData, function(key, value) {
                                var $field = $('#wizardForm [name="'+key+'"]');
                                if($field.length > 0) {
                                    if($field.is('input[type="checkbox"]')) {
                                        if (value === 'on' || value === true || value === 1 || value === '1') {
                                            $field.prop('checked', true);
                                        }
                                    } else if($field.is('input[type="radio"]')) {
                                        $field.filter('[value="'+value+'"]').prop('checked', true);
                                    } else {
                                        $field.val(value).trigger('change');
                                    }
                                }
                            });
                        } catch(e) { console.error('Error parsing wizard data:', e); }
                    }
                } else if (!response.success) {
                    if(typeof toastr !== 'undefined') toastr.error(response.message || 'Error fetching details.');
                }
            }
        });
    });

    // Asset Map View Data Fetching from Detail Panel Row
    $(document).on('click', '.asset-row', function(e) {
        var id = $(this).data('id');
        if(id) {
            $('.view_work_order[data-id="'+id+'"]').trigger('click');
        }
    });

    // Update Work Order
    $('#kt_modal_update_workorder_form').on('submit', function(e) {
        e.preventDefault();
        $(this).find('.is-invalid').removeClass('is-invalid');
        var id = $('#update_id').val();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ url('manage_work_order/update') }}/" + id,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#btn_update_workorder').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...');
            },
            complete: function() {
                $('#btn_update_workorder').prop('disabled', false).html('Update Work Order');
            },
            success: function(response) {
                if(response.success) {
                    $('#kt_modal_update_workorder').modal('hide');
                    if(typeof toastr !== 'undefined') toastr.success(response.message || 'Work order updated successfully.'); 
                    else alert(response.message || 'Work order updated successfully.');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    if (response.errors) {
                        var errorMsg = '';
                        $.each(response.errors, function(key, value) {
                            errorMsg += value[0] + '<br>';
                            $('#kt_modal_update_workorder_form [name="'+key+'"]').addClass('is-invalid');
                        });
                        if(typeof toastr !== 'undefined') toastr.error(errorMsg, 'Validation Error');
                        else alert('Validation Error:\n' + errorMsg.replace(/<br>/g, '\n'));
                    } else {
                        if(typeof toastr !== 'undefined') toastr.error(response.message || 'Error updating work order.');
                        else alert(response.message || 'Error updating work order.');
                    }
                }
            },
            error: function(xhr) {
                if(typeof toastr !== 'undefined') toastr.error('An error occurred.'); else alert('An error occurred.');
            }
        });
    });

    // Save Wizard Form
    $('#submitWizard').on('click', function(e) {
        e.preventDefault();
        
        var workOrderId = $('#wizard_work_order_id').val();
        if(!workOrderId) {
            if(typeof toastr !== 'undefined') toastr.error('No Work Order selected for wizard.');
            else alert('No Work Order selected for wizard.');
            return;
        }

        var formData = new FormData($('#wizardForm')[0]);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        var $btn = $(this);
        $.ajax({
            url: "{{ url('manage_work_order/update_wizard') }}/" + workOrderId,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> Saving...');
            },
            complete: function() {
                $btn.prop('disabled', false).html('Submit / Close');
            },
            success: function(response) {
                if(response.success) {
                    if(typeof toastr !== 'undefined') toastr.success(response.message || 'Wizard data saved successfully.');
                    else alert(response.message || 'Wizard data saved successfully.');
                } else {
                    if(typeof toastr !== 'undefined') toastr.error(response.message || 'Error saving wizard data.');
                    else alert(response.message || 'Error saving wizard data.');
                }
            },
            error: function(xhr) {
                if(typeof toastr !== 'undefined') toastr.error('An error occurred while saving wizard.');
                else alert('An error occurred while saving wizard.');
            }
        });
    });

    // Delete Work Order
    $(document).on('click', '.delete_work_order', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this work order?')) {
            $.ajax({
                url: "{{ url('manage_work_order/delete') }}/" + id,
                type: "DELETE",
                success: function(response) {
                    if(response.success) {
                        if(typeof toastr !== 'undefined') toastr.success(response.message || 'Work order deleted successfully.'); else alert(response.message || 'Work order deleted successfully.');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        if(typeof toastr !== 'undefined') toastr.error(response.message || 'Error deleting work order.'); else alert(response.message || 'Error deleting work order.');
                    }
                },
                error: function(xhr) {
                    if(typeof toastr !== 'undefined') toastr.error('An error occurred while deleting.'); else alert('An error occurred while deleting.');
                }
            });
        }
    });
});
</script>
@endsection
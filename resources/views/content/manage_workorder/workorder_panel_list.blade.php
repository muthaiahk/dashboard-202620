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
@vite(['resources/assets/js/forms_date_time_pickers.js', 'resources/js/app.js'])
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

    .wizard-step.completed .wizard-icon {
        border-color: #28a745;
        background-color: #28a745;
        color: white;
    }

    .wizard-step.completed .wizard-label {
        color: #28a745;
        font-weight: 600;
    }

    .wizard-line.completed {
        background-color: #28a745;
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
                @if (auth()->user()->hasPermission('Manage Work Order', 'is_create'))
                    <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary-outline border border-primary text-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_bulk_upload">
                        <span class="me-2"><i class="mdi mdi-tray-arrow-up"></i></span>Bulk Upload
                    </a>
                    <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_workorder">
                        <span class="me-2"><i class="mdi mdi-plus"></i></span>Add Work Order
                    </a>
                @endif
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
                                    @if (auth()->user()->hasPermission('Manage Work Order', 'is_delete'))
                                        <a href="#" class="btn btn-icon btn-sm me-2 delete_work_order" data-id="{{ $order->id }}">
                                            <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
                                                <i class="mdi mdi-trash-can-outline fs-3 text-danger"></i>
                                            </span>
                                        </a>
                                    @endif
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
                            @if (auth()->user()->hasPermission('Manage Work Order', 'is_update'))
                                <a href="javscript:;" type="button" class="btn btn-sm btn-primary-outline border border-primary text-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_update_workorder"><i class="mdi mdi-pencil-outline me-1"></i>Edit</a>
                            @endif
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
                                            <select class="form-select select3" name="permit_transferred_by">
                                                <option value="">Select Staff</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" 
                                                        {{ old('permit_transferred_by', $workOrder->permit_transferred_by ?? '') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
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
                                                @foreach($teams as $team)
                                                    <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-12 mb-3 d-none team_details" id="team_details_container">
                                            <!-- Dynamic team members rendered here -->
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
                                            <div class="col-lg-12" id="dynamic_assigned_tools">
                                                <!-- Dynamic tools rendered here -->
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
                                        <div class="col-lg-12" id="dynamic_pre_checklist">
                                            <!-- Dynamic pre-checklist rendered here -->
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
                                            <span class="text-dark fw-bold fs-6">5. Procedure Checklist</span>
                                        </div>
                                        <div id="dynamic_procedure_checklist">
                                            <!-- Dynamic Procedure steps rendered here -->
                                        </div>
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
                                        @if (auth()->user()->hasPermission('Manage Work Order', 'is_update'))
                                            <button type="button" id="submitWizard" class="btn btn-success btn-sm">Submit / Close</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-5 bg-white py-5 px-2">
                            <button type="button" class="btn btn-secondary" id="prevStep">
                                Previous
                            </button>
                            @if (auth()->user()->hasPermission('Manage Work Order', 'is_update'))
                                <button type="button" class="btn btn-primary" id="nextStep">
                                    Next Step
                                    <i class="mdi mdi-arrow-right"></i>
                                </button>
                            @endif
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
          <h4 class="text-center text-black">Bulk Upload Work Orders</h4>
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
                <div class="col-12 mb-5 text-center">
                    <a href="{{ route('work-order.downloadSample') }}" class="btn btn-sm btn-light-primary">
                        <i class="mdi mdi-download me-1"></i>Download Sample CSV
                    </a>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Select File (CSV/XLSX)</label>
                    <input type="file" id="bulk_work_order_file" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                </div>
            </div>
        </div>
        <div class="modal-footer pt-5">
          <div class="d-flex justify-content-end align-items-center">
            <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="button" id="btn_bulk_upload_submit" class="btn btn-primary">Upload</button>
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
                <a href="javascript:;" id="btn_add_comment" class="btn btn-sm btn-primary-outline border border-primary text-primary">Add Comments</a>
            </div>
            <textarea id="history_comment_textarea" class="form-control" rows="5" placeholder="Enter Comments"></textarea>
        </div>
        <div class="col-lg-12 mb-3">
            <label class="text-black fs-7 fw-semibold">Timeline</label>
            <div id="timeline_container" class="timeline-wrapper scroll-y" style="max-height: 700px;">
                <!-- Dynamic timeline content -->
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
window.wizardCurrentStep = 0;
window.wizardMaxStep = 0;

document.addEventListener("DOMContentLoaded", function () {
    const steps = document.querySelectorAll(".wizard-step");
    const panels = document.querySelectorAll(".wizard-panel");
    const lines = document.querySelectorAll(".wizard-line");

    const nextBtn = document.getElementById("nextStep");
    const prevBtn = document.getElementById("prevStep");
    const radios = document.querySelectorAll('input[name="workflow"]');
    const submitBtn = document.getElementById("submitWizard");

    window.showWizardStep = function(step) {
        window.wizardCurrentStep = step;

        panels.forEach((panel, i) => {
            panel.classList.toggle("active", i === step);
        });

        steps.forEach((stepItem, i) => {
            stepItem.classList.toggle("active", i === step);
            // Mark completed steps
            if (i < window.wizardMaxStep) {
                stepItem.classList.add("completed");
            } else {
                stepItem.classList.remove("completed");
            }
        });

        // Mark completed lines
        if(lines) {
            lines.forEach((line, i) => {
                if (i < window.wizardMaxStep) {
                    line.classList.add("completed");
                } else {
                    line.classList.remove("completed");
                }
            });
        }

        prevBtn.style.display = step === 0 ? "none" : "inline-block";
        updateButton();
    };

    function updateButton() {
        const selectedRadio = document.querySelector('input[name="workflow"]:checked');
        const selected = selectedRadio ? selectedRadio.value : null;

        if (window.wizardCurrentStep === panels.length - 1) {
            nextBtn.style.display = 'none';
            if(submitBtn) submitBtn.style.display = 'inline-block';
        } else {
            nextBtn.style.display = 'inline-block';
            if(submitBtn) submitBtn.style.display = 'none';
            nextBtn.innerHTML = 'Next Step <i class="mdi mdi-arrow-right"></i>';
            nextBtn.classList.remove("btn-success", "btn-warning");
            nextBtn.classList.add("btn-primary");
        }
    }

    function saveWizardStep(stepToSave) {
        const workOrderId = $('#wizard_work_order_id').val();
        if(!workOrderId) {
            if(typeof toastr !== 'undefined') toastr.error('No Work Order selected.');
            else alert('No Work Order selected.');
            return;
        }

        let formData = new FormData($('#wizardForm')[0]);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('step', stepToSave);

        let btnToDisable = (stepToSave === panels.length - 1) ? submitBtn : nextBtn;
        
        // Prevent double submission which captures 'Saving...' as originalText
        if(btnToDisable.disabled || $(btnToDisable).hasClass('saving')) return;

        let originalText = btnToDisable.innerHTML;

        $.ajax({
            url: "{{ url('manage_work_order/update_wizard') }}/" + workOrderId,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                btnToDisable.disabled = true;
                $(btnToDisable).addClass('saving');
                btnToDisable.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Saving...';
            },
            complete: function() {
                btnToDisable.disabled = false;
                $(btnToDisable).removeClass('saving');
                // Rely on updateButton to set the correct text depending on the new step
                updateButton(); 
            },
            success: function(response) {
                if(response.success) {
                    if(typeof toastr !== 'undefined') toastr.success(response.message);
                    window.wizardMaxStep = parseInt(response.wizard_current_step || 0);
                    
                    if (stepToSave === panels.length - 1) {
                         // Final step submitted
                         $('#kt_modal_add_wizard').modal('hide');
                         setTimeout(() => location.reload(), 1500);
                    } else if (window.wizardCurrentStep < panels.length - 1) {
                         window.showWizardStep(window.wizardCurrentStep + 1);
                    } else if (window.wizardMaxStep > window.wizardCurrentStep) {
                         window.showWizardStep(window.wizardCurrentStep); // refresh CSS
                    }
                } else {
                    if(typeof toastr !== 'undefined') toastr.error(response.message || 'Error saving step');
                    else alert(response.message || 'Error saving step');
                }
            },
            error: function() {
                if(typeof toastr !== 'undefined') toastr.error('Network error occurred.'); else alert('Network error occurred.');
            }
        });
    }

    nextBtn.addEventListener("click", function (e) {
        e.preventDefault();
        saveWizardStep(window.wizardCurrentStep);
    });

    if(submitBtn) {
        submitBtn.addEventListener("click", function(e) {
            e.preventDefault();
            saveWizardStep(window.wizardCurrentStep);
        });
    }

    prevBtn.addEventListener("click", function (e) {
        e.preventDefault();
        if (window.wizardCurrentStep > 0) {
            window.showWizardStep(window.wizardCurrentStep - 1);
        }
    });

    radios.forEach(radio => {
        radio.addEventListener("change", updateButton);
    });

    steps.forEach((stepItem, i) => {
        stepItem.addEventListener("click", function() {
            if (i <= window.wizardMaxStep) {
                window.showWizardStep(i);
            }
        });
        stepItem.style.cursor = "pointer";
    });

    window.showWizardStep(window.wizardCurrentStep);
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

    const teamsData = @json($teams);

    function renderTeamMembers(teamId) {
        let container = $('#team_details_container');
        container.empty().addClass('d-none');
        if (!teamId) return;

        let team = teamsData.find(t => t.id == teamId);
        if (!team) return;

        let html = '<div class="row bg-white rounded p-2 border">';
        
        if (team.all_members_data && team.all_members_data.length > 0) {
            team.all_members_data.forEach(function(member) {
                let statusBadge = (member.status === '0' || member.status === 'Expired') ? '<span class="text-danger">(Expired)</span>' : '';
                html += `
                    <div class="col-lg-6 mb-2">
                        <div class="row">
                            <label class="col-5 fw-medium text-black fs-7">${member.role}</label>
                            <label class="col-1 fw-medium text-black fs-7">:</label>
                            <label class="col-6 fw-semibold text-black fs-7">${member.name} ${statusBadge}</label>
                        </div>
                    </div>
                `;
            });
        } else {
            html += '<div class="col-12 text-muted">No members assigned to this team.</div>';
        }

        html += '</div>';
        container.html(html).removeClass('d-none');
    }

    $(document).on('change', '.assign_team', function() {
        renderTeamMembers($(this).val());
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
                    $('#update_work_order_id').val(data.id);
                    $('#up_title').val(data.title);
                    $('#up_description').val(data.description);
                    $('#up_order_type').val(data.order_type).trigger('change');
                    $('#up_priority').val(data.priority).trigger('change');
                    $('#up_client_id').val(data.client_id).trigger('change');
                    $('#up_asset_id').val(data.asset_id).trigger('change');
                    $('#up_procedure_id').val(data.procedure_id).trigger('change');
                    
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
                    $('#wizardForm input[type="checkbox"], #wizardForm input[type="radio"]').prop('checked', false);
                    $('#wizardForm .file-preview-list').empty(); // Clear old uploaded images
                    $('#wizard_work_order_id').val(data.id);
                    
                    window.wizardMaxStep = parseInt(data.wizard_current_step || 0);
                    
                    // Helper to populate fields
                    function populateStepData(obj, mapping = null) {
                        if(!obj) return;
                        $.each(obj, function(key, value) {
                            let fieldName = mapping && mapping[key] ? mapping[key] : key;
                            let $field = $('#wizardForm [name="' + fieldName + '"]');
                            if($field.length > 0) {
                                if($field.is('input[type="checkbox"]')) {
                                    $field.prop('checked', (value == 1 || value == true));
                                } else if($field.is('input[type="radio"]')) {
                                    $field.filter('[value="' + value + '"]').prop('checked', true);
                                } else {
                                    $field.val(value).trigger('change');
                                }
                            }
                        });
                    }

                    // Step 0: Inspection
                    if(data.inspection) {
                        populateStepData(data.inspection);
                        if(data.inspection.assigned_team_id) {
                            $('#wizardForm [name="assign_team"]').val(data.inspection.assigned_team_id).trigger('change');
                            renderTeamMembers(data.inspection.assigned_team_id);
                        }
                    }

                    // Step 1: Validation
                    if(data.validation) {
                        let valMap = {
                            'tools': 'tbt_100_percent_checked',
                            'assigned_members': 'assigned_members_checked',
                            'obstruction_notes': 'obstruction_notes_checked',
                            'special_tools': 'special_tools_checked',
                            'access_issues': 'access_issues_checked',
                            'safety_concerns': 'safety_concerns_checked',
                            'site_condition_notes': 'site_condition_checked',
                            'documents_permits': 'documents_permits_checked'
                        };
                        populateStepData(data.validation, valMap);
                    }

                    // Prep Dynamic Views
                    $('#dynamic_assigned_tools').empty();
                    if(data.tools && data.tools.length > 0) {
                        data.tools.forEach(function(tool) {
                            let toolHtml = `
                                <div class="card border rounded p-4 mb-2">
                                    <div class="d-flex align-items-center justify-content-start gap-2">
                                        <i class="mdi mdi-check-circle text-success fs-4"></i>
                                        <div class="d-flex flex-column">
                                            <label class="fw-medium text-black fs-7">${tool.name}</label>
                                            <label class="fw-medium text-dark fs-7">${tool.tag_number}</label>
                                        </div>
                                    </div>
                                </div>
                            `;
                            $('#dynamic_assigned_tools').append(toolHtml);
                        });
                    } else {
                        $('#dynamic_assigned_tools').html('<p class="text-muted">No tools assigned.</p>');
                    }

                    $('#dynamic_pre_checklist').empty();
                    if(data.procedure && data.procedure.pre_checklist) {
                        let savedPreChecklist = (data.preparation && data.preparation.pre_checklist) ? data.preparation.pre_checklist : [];
                        let preChecklistArr = typeof data.procedure.pre_checklist === 'string' ? JSON.parse(data.procedure.pre_checklist) : data.procedure.pre_checklist;
                        
                        if(Array.isArray(preChecklistArr)) {
                            preChecklistArr.forEach(function(item) {
                                let isChecked = savedPreChecklist.includes(item) ? 'checked' : '';
                                let itemHtml = `
                                    <div class="card border rounded p-3 mb-2">
                                        <div class="d-flex align-items-center justify-content-start gap-2">
                                            <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="pre_checklist[]" value="${item}" ${isChecked}/>
                                            <div class="d-flex flex-column">
                                                <label class="fw-medium text-black fs-7">${item}</label>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                $('#dynamic_pre_checklist').append(itemHtml);
                            });
                        }
                    } else {
                        $('#dynamic_pre_checklist').html('<p class="text-muted">No pre-checklist items defined for this procedure.</p>');
                    }

                    // Step 2: Preparation
                    if(data.preparation) {
                        populateStepData(data.preparation);
                        if(data.preparation.escalate) $('#wizardForm [name="escalate_prep"]').prop('checked', true);
                        if(data.preparation.tech_notes) $('#wizardForm [name="tech_notes_prep"]').val(data.preparation.tech_notes);
                    }

                    // Step 3: Approval
                    if(data.approval) {
                        populateStepData(data.approval);
                        if(data.approval.escalate) $('#wizardForm [name="escalate_approval"]').prop('checked', true);
                        if(data.approval.tech_notes) $('#wizardForm [name="tech_notes_approval"]').val(data.approval.tech_notes);
                    }

                    // Step 4: Execution
                    $('#dynamic_procedure_checklist').empty();
                    if(data.procedure && data.procedure.steps) {
                        let savedProcedureChecklist = (data.execution && data.execution.procedure_checklist) ? data.execution.procedure_checklist : [];
                        let execChecklistArr = typeof data.procedure.steps === 'string' ? JSON.parse(data.procedure.steps) : data.procedure.steps;
                        
                        if(Array.isArray(execChecklistArr)) {
                            execChecklistArr.forEach(function(item) {
                                let isChecked = savedProcedureChecklist.includes(item) ? 'checked' : '';
                                let itemHtml = `
                                    <div class="detail-spec">
                                        <input class="form-check-input rounded w-25px h-25px" type="checkbox" name="procedure_checklist[]" value="${item}" ${isChecked}/>
                                        <span class="text-black fw-medium fs-6">${item}</span>
                                    </div>
                                `;
                                $('#dynamic_procedure_checklist').append(itemHtml);
                            });
                        }
                    } else {
                        $('#dynamic_procedure_checklist').html('<p class="text-muted">No execution steps defined for this procedure.</p>');
                    }

                    if(data.execution) {
                        populateStepData(data.execution.safety_checklist);
                        // populateStepData(data.execution.procedure_checklist); // Handled by dynamic renderer above
                        if(data.execution.remarks) $('#wizardForm [name="exec_remarks"]').val(data.execution.remarks);
                    }

                    // Step 5: Closure
                    if(data.closure) {
                        if(data.closure.workflow_status) {
                            $('#wizardForm [name="workflow"]').filter('[value="' + data.closure.workflow_status + '"]').prop('checked', true);
                        }

                        // Render existing images
                        function renderUploadedImages(dropzoneId, imagesJson) {
                            let previewList = $('#' + dropzoneId + ' .file-preview-list');
                            previewList.empty(); // Clear existing
                            if (!imagesJson) return;
                            try {
                                let images = typeof imagesJson === 'string' ? JSON.parse(imagesJson) : imagesJson;
                                if (Array.isArray(images)) {
                                    images.forEach(function(imgPath) {
                                        let fullUrl = "{{ asset('') }}" + imgPath;
                                        let html = `
                                            <div class="file-preview-item mt-3 me-3" style="display:inline-block;">
                                                <div class="img-download-box" style="width:100px; height:100px;">
                                                    <img src="${fullUrl}" class="doc-img" alt="Preview" style="width:100%; height:100%; object-fit:cover; border-radius:6px; border:1px solid #ccc;">
                                                    <a href="${fullUrl}" target="_blank" title="Download">
                                                        <i class="mdi mdi-cloud-download-outline download-icon"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        `;
                                        previewList.append(html);
                                    });
                                }
                            } catch(e) {
                                console.error("Error parsing images", e);
                            }
                        }

                        renderUploadedImages('beforeDropzone', data.closure.before_image);
                        renderUploadedImages('duringDropzone', data.closure.during_image);
                        renderUploadedImages('afterDropzone', data.closure.after_image);
                    }

                    let startStep = window.wizardMaxStep > 5 ? 5 : window.wizardMaxStep;
                    if(typeof window.showWizardStep === 'function') {
                        window.showWizardStep(startStep);
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
    $('#updateWorkOrderForm').on('submit', function(e) {
        e.preventDefault();
        $(this).find('.is-invalid').removeClass('is-invalid');
        var id = $('#update_work_order_id').val();
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
                            $('#updateWorkOrderForm [name="'+key+'"]').addClass('is-invalid');
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

    // The Save Wizard Form block (#submitWizard) has been replaced. Logic is now part of the nextBtn handler in showWizardStep.

    // Bulk Upload Submission
    $('#btn_bulk_upload_submit').on('click', function() {
        let fileInput = $('#bulk_work_order_file')[0];
        if (fileInput.files.length === 0) {
            if(typeof toastr !== 'undefined') toastr.warning('Please select a file to upload.');
            return;
        }

        let formData = new FormData();
        formData.append('file', fileInput.files[0]);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ route('work-order.bulkUpload') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#btn_bulk_upload_submit').prop('disabled', true).text('Uploading...');
            },
            complete: function() {
                $('#btn_bulk_upload_submit').prop('disabled', false).text('Upload');
            },
            success: function(response) {
                if(response.status) {
                    $('#kt_modal_bulk_upload').modal('hide');
                    $('#bulk_work_order_file').val('');
                    if(typeof toastr !== 'undefined') toastr.success(response.message);
                    // Refresh table if needed
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    if(typeof toastr !== 'undefined') toastr.error(response.message || 'Error during upload.');
                }
            },
            error: function(xhr) {
                if(typeof toastr !== 'undefined') toastr.error('An error occurred during upload.');
            }
        });
    });

    // History Offcanvas Logic
    function renderHistory(workOrderId) {
        let container = $('#timeline_container');
        container.html('<div class="text-center p-5"><div class="spinner-border text-primary" role="status"></div></div>');
        
        $.ajax({
            url: "{{ url('manage_work_order/history') }}/" + workOrderId,
            type: "GET",
            success: function(response) {
                if(response.success) {
                    let html = '';
                    if(response.data.length === 0) {
                        html = '<p class="text-muted p-3 text-center">No history recorded yet.</p>';
                    } else {
                        response.data.forEach(function(item) {
                            html += `
                                <div class="timeline-row">
                                    <div class="timeline-time">${item.time}</div>
                                    <div class="timeline-center">
                                        <span class="timeline-dot"></span>
                                        <span class="timeline-line"></span>
                                    </div>
                                    <div class="timeline-content">
                                        <h6>${item.user_name}</h6>
                                        <p>${item.action}${item.description ? ': ' + item.description : ''}</p>
                                    </div>
                                </div>
                            `;
                        });
                    }
                    container.html(html);
                }
            }
        });
    }

    // Load history when offcanvas is shown
    $('#workorder_history_tab').on('show.bs.offcanvas', function() {
        let workOrderId = $('#wizard_work_order_id').val();
        if(workOrderId) renderHistory(workOrderId);
    });

    // Add Comment
    $('#btn_add_comment').on('click', function() {
        let workOrderId = $('#wizard_work_order_id').val();
        let comment = $('#history_comment_textarea').val();
        if(!comment) {
            if(typeof toastr !== 'undefined') toastr.warning('Please enter a comment.');
            return;
        }
        
        $.ajax({
            url: "{{ url('manage_work_order/add_comment') }}/" + workOrderId,
            type: "POST",
            data: { comment: comment },
            beforeSend: function() {
                $('#btn_add_comment').prop('disabled', true).text('Saving...');
            },
            complete: function() {
                $('#btn_add_comment').prop('disabled', false).text('Add Comments');
            },
            success: function(response) {
                if(response.success) {
                    $('#history_comment_textarea').val('');
                    renderHistory(workOrderId);
                    if(typeof toastr !== 'undefined') toastr.success(response.message);
                } else {
                    if(typeof toastr !== 'undefined') toastr.error(response.message || 'Error adding comment.');
                }
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
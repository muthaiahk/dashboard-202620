@extends('layouts/layoutMaster')

@section('title', 'Manage Procedure')

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
        display:grid;
        grid-template-columns:380px 1fr;
        gap:20px;
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

    /* ASSET ITEM */

    .asset-item{
        padding:14px;
        border-bottom:1px solid #f1f1f1;
        cursor:pointer;
        display: flex;
        align-items: start;
        flex-direction: column;
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
        color: #0076b6;
        font-weight: 500;
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
        gap: 2px;
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
        grid-template-columns: 12fr;
        gap:20px;
    }

    .detail-card{
        /* background:#f8fafc; */
        padding:16px;
        /* border-radius:8px;
        border:1px solid #e6e6e6; */
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
            <h3 class="card-title mb-1">Manage Procedure</h3>
        </div>
        <div class="card-action-element">
            <div class="d-flex justify-content-end align-items-center mb-2">
                <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary" id="add-procedure-btn">
                    <span class="me-2"><i class="mdi mdi-plus"></i></span>Add Procedure
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="asset-container">
            <div class="asset-list-panel">
                <div class="panel-header">
                    <input type="text" placeholder="Search Procedure, Asset, Work Category, ..." class="form-control">
                </div>
                <div class="asset-list">
                    @foreach($procedures as $proc)
                    <div class="asset-item procedure-sidebar-item {{ $loop->first ? 'active' : '' }}" data-id="{{ $proc->id }}">
                        <div class="d-flex align-items-center justify-content-between gap-5">
                            <div class="asset-title">
                                <span class="fs-7 text-black fw-medium">{{ $proc->title }}</span>
                            </div>
                            <div class="asset-size">
                                <span class="fs-8 bg-label-dark badge rounded" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Asset Type">{{ $proc->asset_type ?: '-' }}</span>
                            </div>
                        </div>
                        <div class="asset-meta">
                            <span class="tag fs-7" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Work Category">{{ $proc->work_category ?: '-' }}</span>
                        </div>
                        <div>
                            <span class="text-secondary fw-semibold fs-7">{{ Str::limit($proc->description, 80) }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-start gap-3">
                            <span class="text-dark fw-semibold fs-8">{{ $proc->procedure_code ?: '-' }}</span>
                            <span class="text-muted fw-semibold badge badge-dot bg-secondary p-0 fs-9"></span>
                            <span class="text-dark fw-semibold fs-8">{{ $proc->created_at ? $proc->created_at->format('d-M-Y') : '-' }}</span>
                        </div>
                    </div>
                    @endforeach
                    @if($procedures->isEmpty())
                    <div class="text-center py-5 text-muted">No procedures found. Click "Add Procedure" to create one.</div>
                    @endif
                </div>
            </div>
            <div class="asset-detail-panel">
                <div id="existing-sop-panel">
                    <div class="detail-header">
                        <div class="detail-desc">
                            <h4 class="py-0 my-0" id="sop_detail_title">-</h4>
                            <span class="text-dark fw-semibold fs-7" id="sop_detail_description">-</span>
                            <div class="d-flex align-items-center justify-content-start gap-3">
                                <span class="text-dark fw-semibold fs-8" id="sop_detail_asset_type">-</span>
                                <span class="text-muted fw-semibold badge badge-dot bg-secondary p-0 fs-9"></span>
                                <span class="text-dark fw-semibold fs-8" id="sop_detail_code">-</span>
                                <span class="text-muted fw-semibold badge badge-dot bg-secondary p-0 fs-9"></span>
                                <span class="text-dark fw-semibold fs-8" id="sop_detail_created_by">-</span>
                            </div>
                        </div>
                        <div class="detail-desc">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <span class="badge bg-gray-100 text-black fs-7 border border-gray-700 fw-medium" id="sop_detail_work_category">-</span>
                                <a href="javascript:;" type="button" class="btn btn-sm btn-primary-outline border border-primary text-primary editProcedureBtn"><i class="mdi mdi-pencil-outline"></i>Edit</a>
                            </div>
                            <div>
                                <label class="badge bg-label-success fw-medium fs-7 border border-success rounded">
                                    <i class="mdi mdi-check text-success"></i> Active
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="detail-body">
                        <div class="detail-grid">
                            <div class="accordion mb-3" id="procedureAccordion">
                                <div class="accordion-item border">
                                    <h2 class="accordion-header" id="headingProcedure">
                                        <button class="accordion-button collapsed d-flex align-items-center gap-2" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseProcedure"
                                            aria-expanded="false" aria-controls="collapseProcedure">
                                            <i class="mdi mdi-page-previous-outline text-dark fs-4 me-2"></i>
                                            <span class="fs-5 text-black">Procedure</span>
                                        </button>
                                    </h2>
                                    <div id="collapseProcedure" class="accordion-collapse"
                                        aria-labelledby="headingProcedure" data-bs-parent="#procedureAccordion">
                                        <div class="accordion-body p-2">
                                            <div class="detail-card mb-2" id="sop_detail_steps">
                                                <div class="text-muted text-center py-3">No procedure steps added yet.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion mb-3" id="preChecklistAccordion">
                                <div class="accordion-item border">
                                    <h2 class="accordion-header" id="headingPreChecklist">
                                        <button class="accordion-button collapsed d-flex align-items-center gap-2" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapsePreChecklist"
                                            aria-expanded="false" aria-controls="collapsePreChecklist">
                                            <i class="mdi mdi-page-previous-outline text-dark fs-4 me-2"></i>
                                            <span class="fs-5 text-black">Pre-Checklist</span>
                                        </button>
                                    </h2>
                                    <div id="collapsePreChecklist" class="accordion-collapse collapse"
                                        aria-labelledby="headingPreChecklist" data-bs-parent="#preChecklistAccordion">
                                        <div class="accordion-body p-2">
                                            <div class="detail-card mb-2" id="sop_detail_pre_checklist">
                                                <div class="text-muted text-center py-3">No pre-checklist items.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion mb-3" id="postChecklistAccordion">
                                <div class="accordion-item border">
                                    <h2 class="accordion-header" id="headingPostChecklist">
                                        <button class="accordion-button collapsed d-flex align-items-center gap-2" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapsePostChecklist"
                                            aria-expanded="false" aria-controls="collapsePostChecklist">
                                            <i class="mdi mdi-page-previous-outline text-dark fs-4 me-2"></i>
                                            <span class="fs-5 text-black">Post-Checklist</span>
                                        </button>
                                    </h2>
                                    <div id="collapsePostChecklist" class="accordion-collapse collapse"
                                        aria-labelledby="headingPostChecklist" data-bs-parent="#postChecklistAccordion">
                                        <div class="accordion-body p-2">
                                            <div class="detail-card mb-2" id="sop_detail_post_checklist">
                                                <div class="text-muted text-center py-3">No post-checklist items.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="new-procedure-panel" style="display:none;" class="">
                    <div class="detail-header bg-gray-100">
                        <div class="detail-desc">
                            <h4 class="py-0 my-0">New Procedure</h4>
                        </div>
                        <div class="detail-desc">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <button id="save-sop-btn" class="btn btn-primary btn-sm">Save SOP</button>
                                <button id="cancel-sop-btn" class="btn btn-primary-outline btn-sm border border-primary text-primary">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <div class="detail-body row">
                        <div class="col-lg-4 mb-3">
                            <label class="text-black mb-1 fs-7 fw-semibold">Title<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter Procedure Title" value="" id="procedure-title">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="text-black mb-1 fs-7 fw-semibold">Procedure Code</label>
                            <input type="text" class="form-control" placeholder="e.g. POC/001" value="" id="procedure-code">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="text-black mb-1 fs-7 fw-semibold">Asset Type<span class="text-danger">*</span></label>
                            <select class="form-select select3" id="asset-type">
                                <option value="">Select Asset Type</option>
                                @foreach($assetTypes as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="text-black mb-1 fs-7 fw-semibold">Work Category<span class="text-danger">*</span></label>
                            <select class="form-select select3" id="work-category">
                                <option>Maintenance</option>
                                <option>Calibration</option>
                                <option>Inspection</option>
                            </select>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label class="text-black mb-1 fs-7 fw-semibold">Description<span class="text-danger">*</span></label>
                            <textarea class="form-control mb-3" id="procedure-description"></textarea>
                        </div>
                        <div class="col-lg-12 mb-3 bg-gray-100 rounded border border-gray-300 p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input rounded w-25px h-25px" type="checkbox" id="pre-checklist-toggle">
                                    <label class="form-check-label text-black fw-semibold" for="pre-checklist-toggle">
                                        Pre-Checklist
                                    </label>
                                    <a href="javascript:;" class="" data-bs-toggle="modal" data-bs-target="#kt_modal_require_tools">
                                        <i class="mdi mdi-tools text-primary fw-semibold"></i>
                                    </a>
                                </div>
                                <button type="button" id="addPreChecklist" class="btn btn-sm btn-dark d-none">
                                    <i class="mdi mdi-plus"></i> Add Checklist
                                </button>
                            </div>
                            <div class="accordion mt-3 d-none" id="preAccordian">
                                <div class="accordion-item">
                                    <div class="accordion-collapse collapse show">
                                        <div class="accordion-body p-2">
                                            <div id="preChecklistContainer">
                                                <div class="d-flex align-items-center gap-2 mb-2 checklist-row">
                                                    <input type="text" class="form-control" placeholder="Enter checklist item">
                                                    <button type="button" class="btn btn-sm btn-danger-outline border border-danger deleteRow">
                                                        <i class="mdi mdi-trash-can-outline text-danger"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3 bg-gray-100 rounded border border-gray-300 p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input rounded w-25px h-25px" type="checkbox" id="post-checklist-toggle">
                                    <label class="form-check-label text-black fw-semibold" for="post-checklist-toggle">
                                        Post-Checklist
                                    </label>
                                </div>
                                <button type="button" id="addChecklist" class="btn btn-sm btn-dark d-none">
                                    <i class="mdi mdi-plus"></i> Add Checklist
                                </button>
                            </div>
                            <div class="accordion mt-3 d-none" id="postAccordian">
                                <div class="accordion-item">
                                    <div class="accordion-collapse collapse show">
                                        <div class="accordion-body p-2">
                                            <div id="checklistContainer">
                                                <div class="d-flex align-items-center gap-2 mb-2 checklist-row">
                                                    <input type="text" class="form-control" placeholder="Enter checklist item">
                                                    <button type="button" class="btn btn-sm btn-danger-outline border border-danger deleteRow">
                                                        <i class="mdi mdi-trash-can-outline text-danger"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <label class="text-black fw-semibold">Procedure</label>
                                <button type="button" id="addSection" class="btn btn-sm btn-dark">
                                    <i class="mdi mdi-plus"></i> Add Section
                                </button>
                            </div>
                            <div id="sectionContainer"></div>
                        </div>
                    </div>
                </div>
                <div id="edit-procedure-panel" style="display:none;" class="">
                    <div class="detail-header bg-gray-100">
                        <div class="detail-desc">
                            <h4 class="py-0 my-0">Update Procedure</h4>
                        </div>
                        <div class="detail-desc">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <button id="update-sop-btn" class="btn btn-primary btn-sm">Update SOP</button>
                                <button id="cancel-edit-sop-btn" class="btn btn-primary-outline btn-sm border border-primary text-primary">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <div class="detail-body row">
                        <div class="col-lg-4 mb-3">
                            <label class="text-black mb-1 fs-7 fw-semibold">Title<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter Procedure Title" value="" id="edit-procedure-title">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="text-black mb-1 fs-7 fw-semibold">Procedure Code</label>
                            <input type="text" class="form-control" placeholder="e.g. POC/001" value="" id="edit-procedure-code">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="text-black mb-1 fs-7 fw-semibold">Asset Type<span class="text-danger">*</span></label>
                            <select class="form-select select3" id="edit-asset-type">
                                <option value="">Select Asset Type</option>
                                @foreach($assetTypes as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="text-black mb-1 fs-7 fw-semibold">Work Category<span class="text-danger">*</span></label>
                            <select class="form-select select3" id="edit-work-category">
                                <option>Maintenance</option>
                                <option>Calibration</option>
                                <option>Inspection</option>
                            </select>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label class="text-black mb-1 fs-7 fw-semibold">Description<span class="text-danger">*</span></label>
                            <textarea class="form-control mb-3" id="edit-procedure-description"></textarea>
                        </div>
                        <div class="col-lg-12 mb-3 bg-gray-100 rounded border border-gray-300 p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input rounded w-25px h-25px" type="checkbox" id="edit-pre-checklist-toggle">
                                    <label class="form-check-label text-black fw-semibold" for="edit-pre-checklist-toggle">
                                        Pre-Checklist
                                    </label>
                                    <a href="javascript:;" class="" data-bs-toggle="modal" data-bs-target="#kt_modal_require_tools">
                                        <i class="mdi mdi-tools text-primary fw-semibold"></i>
                                    </a>
                                </div>
                                <button type="button" id="edit-addPreChecklist" class="btn btn-sm btn-dark d-none">
                                    <i class="mdi mdi-plus"></i> Add Checklist
                                </button>
                            </div>
                            <div class="accordion mt-3 d-none" id="edit-preAccordian">
                                <div class="accordion-item">
                                    <div class="accordion-collapse collapse show">
                                        <div class="accordion-body p-2">
                                            <div id="edit-preChecklistContainer">
                                                <div class="d-flex align-items-center gap-2 mb-2 checklist-row">
                                                    <input type="text" class="form-control" placeholder="Enter checklist item">
                                                    <button type="button" class="btn btn-sm btn-danger-outline border border-danger deleteRow">
                                                        <i class="mdi mdi-trash-can-outline text-danger"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3 bg-gray-100 rounded border border-gray-300 p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input rounded w-25px h-25px" type="checkbox" id="edit-post-checklist-toggle">
                                    <label class="form-check-label text-black fw-semibold" for="edit-post-checklist-toggle">
                                        Post-Checklist
                                    </label>
                                </div>
                                <button type="button" id="edit-addChecklist" class="btn btn-sm btn-dark d-none">
                                    <i class="mdi mdi-plus"></i> Add Checklist
                                </button>
                            </div>
                            <div class="accordion mt-3 d-none" id="edit-postAccordian">
                                <div class="accordion-item">
                                    <div class="accordion-collapse collapse show">
                                        <div class="accordion-body p-2">
                                            <div id="edit-checklistContainer">
                                                <div class="d-flex align-items-center gap-2 mb-2 checklist-row">
                                                    <input type="text" class="form-control" placeholder="Enter checklist item">
                                                    <button type="button" class="btn btn-sm btn-danger-outline border border-danger deleteRow">
                                                        <i class="mdi mdi-trash-can-outline text-danger"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <label class="text-black fw-semibold">Procedure</label>
                                <button type="button" id="addSection" class="btn btn-sm btn-dark">
                                    <i class="mdi mdi-plus"></i> Add Section
                                </button>
                            </div>
                            <div id="editSectionContainer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--begin::Modal - Add Tools-->
<div class="modal fade" id="kt_modal_require_tools" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
    data-bs-backdrop="static" data-bs-focus="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-md">
        <!--begin::Modal content-->
      <div class="modal-content rounded">
        <!--begin::Modal header-->
        <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
          <h4 class="text-center text-black">Add Tools</h4>
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
                <div class="col-lg-12 mb-3">
                    <input type="text" placeholder="Search Tools" class="form-control">
                </div>
                <div class="col-lg-12 mb-2 d-flex align-items-center justify-content-end">
                    <div class="detail-spec">
                        <input id="selectAllTools" class="form-check-input rounded w-20px h-20px" type="checkbox" />
                        <span class="text-black fw-medium fs-6">
                            Select All
                        </span>
                    </div>
                </div>
                <div class="col-lg-12 mb-3 d-flex flex-column gap-2px scroll-y max-h-400px">
                    <div class="detail-spec">
                        <input class="form-check-input rounded w-20px h-20px tool-checkbox" type="checkbox" />
                        <span class="text-black fw-medium fs-6">
                            Torque wrenches
                        </span>
                    </div>
                    <div class="detail-spec">
                        <input class="form-check-input rounded w-20px h-20px tool-checkbox" type="checkbox" />
                        <span class="text-black fw-medium fs-6">
                            Spanners and adjustable wrenches
                        </span>
                    </div>
                    <div class="detail-spec">
                        <input class="form-check-input rounded w-20px h-20px tool-checkbox" type="checkbox" />
                        <span class="text-black fw-medium fs-6">
                            Screwdrivers (flathead, Phillips, hex)
                        </span>
                    </div>
                    <div class="detail-spec">
                        <input class="form-check-input rounded w-20px h-20px tool-checkbox" type="checkbox" />
                        <span class="text-black fw-medium fs-6">
                            Hammers and mallets
                        </span>
                    </div>
                    <div class="detail-spec">
                        <input class="form-check-input rounded w-20px h-20px tool-checkbox" type="checkbox" />
                        <span class="text-black fw-medium fs-6">
                            Pliers (needle nose, locking, combination)
                        </span>
                    </div>
                    <div class="detail-spec">
                        <input class="form-check-input rounded w-20px h-20px tool-checkbox" type="checkbox" />
                        <span class="text-black fw-medium fs-6">
                            Valve lapping and grinding tools
                        </span>
                    </div>
                    <div class="detail-spec">
                        <input class="form-check-input rounded w-20px h-20px tool-checkbox" type="checkbox" />
                        <span class="text-black fw-medium fs-6">
                            Pipe wrenches
                        </span>
                    </div>
                    <div class="detail-spec">
                        <input class="form-check-input rounded w-20px h-20px tool-checkbox" type="checkbox" />
                        <span class="text-black fw-medium fs-6">
                            Bearing pullers and alignment tools
                        </span>
                    </div>
                    <div class="detail-spec">
                        <input class="form-check-input rounded w-20px h-20px tool-checkbox" type="checkbox" />
                        <span class="text-black fw-medium fs-6">
                            Electric drills and impact drivers
                        </span>
                    </div>
                    <div class="detail-spec">
                        <input class="form-check-input rounded w-20px h-20px tool-checkbox" type="checkbox" />
                        <span class="text-black fw-medium fs-6">
                            Angle grinders
                        </span>
                    </div>
                    <div class="detail-spec">
                        <input class="form-check-input rounded w-20px h-20px tool-checkbox" type="checkbox" />
                        <span class="text-black fw-medium fs-6">
                            Portable saws and cutters
                        </span>
                    </div>
                    <div class="detail-spec">
                        <input class="form-check-input rounded w-20px h-20px tool-checkbox" type="checkbox" />
                        <span class="text-black fw-medium fs-6">
                            Hydraulic presses for assembly/disassembly
                        </span>
                    </div>
                    <div class="detail-spec">
                        <input class="form-check-input rounded w-20px h-20px tool-checkbox" type="checkbox" />
                        <span class="text-black fw-medium fs-6">
                            Hydraulic jacks
                        </span>
                    </div>
                    <div class="detail-spec">
                        <input class="form-check-input rounded w-20px h-20px tool-checkbox" type="checkbox" />
                        <span class="text-black fw-medium fs-6">
                            Chain hoists and overhead cranes
                        </span>
                    </div>
                    <div class="detail-spec">
                        <input class="form-check-input rounded w-20px h-20px tool-checkbox" type="checkbox" />
                        <span class="text-black fw-medium fs-6">
                            Calipers
                        </span>
                    </div>
                    <div class="detail-spec">
                        <input class="form-check-input rounded w-20px h-20px tool-checkbox" type="checkbox" />
                        <span class="text-black fw-medium fs-6">
                            Dial indicators and micrometers
                        </span>
                    </div>
                </div> 
            </div>
        </div>
        <div class="modal-footer pt-5">
          <div class="d-flex justify-content-end align-items-center">
            <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Add Tools</button>
          </div>
        </div>
        <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Add Tools-->


<script>
$(document).ready(function () {

    /* ========== Toast Helper (toastr fallback) ========== */
    function showToast(type, msg) {
        if (typeof toastr !== 'undefined' && toastr[type]) {
            toastr[type](msg);
        } else {
            alert(type.toUpperCase() + ': ' + msg);
        }
    }

    /* ========== CSRF Token ========== */
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    /* ========== Panel Elements ========== */
    const existingPanel      = document.getElementById('existing-sop-panel');
    const newProcedurePanel  = document.getElementById('new-procedure-panel');
    const editProcedurePanel = document.getElementById('edit-procedure-panel');
    const addProcedureBtn    = document.getElementById('add-procedure-btn');
    const cancelSopBtn       = document.getElementById('cancel-sop-btn');
    const cancelEditSopBtn   = document.getElementById('cancel-edit-sop-btn');
    const saveSopBtn         = document.getElementById('save-sop-btn');
    const updateSopBtn       = document.getElementById('update-sop-btn');

    let currentProcedureId = null;

    /* ========== initChecklist helper ========== */
    function initChecklist(toggleId, accordionId, addBtnId, containerId) {
        const toggle    = document.getElementById(toggleId);
        const accordion = document.getElementById(accordionId);
        const addBtn    = document.getElementById(addBtnId);
        const container = document.getElementById(containerId);
        if (!toggle || !accordion || !addBtn || !container) return;

        toggle.addEventListener("change", function () {
            if (this.checked) {
                accordion.classList.remove("d-none");
                addBtn.classList.remove("d-none");
            } else {
                accordion.classList.add("d-none");
                addBtn.classList.add("d-none");
            }
        });

        addBtn.addEventListener("click", function () {
            let row = document.createElement("div");
            row.className = "d-flex align-items-center gap-2 mb-2 checklist-row";
            row.innerHTML = `
                <input type="text" class="form-control" placeholder="Enter checklist item">
                <button type="button" class="btn btn-sm btn-danger-outline border border-danger deleteRow">
                    <i class="mdi mdi-trash-can-outline text-danger"></i>
                </button>
            `;
            container.appendChild(row);
        });
    }

    initChecklist("pre-checklist-toggle",      "preAccordian",      "addPreChecklist",      "preChecklistContainer");
    initChecklist("post-checklist-toggle",      "postAccordian",     "addChecklist",         "checklistContainer");
    initChecklist("edit-pre-checklist-toggle",  "edit-preAccordian", "edit-addPreChecklist",  "edit-preChecklistContainer");
    initChecklist("edit-post-checklist-toggle", "edit-postAccordian","edit-addChecklist",     "edit-checklistContainer");

    /* ========== Section / Procedure builders (Create) ========== */
    const sectionContainer = document.getElementById("sectionContainer");
    const addSectionBtn    = document.getElementById("addSection");
    if (addSectionBtn) {
        addSectionBtn.addEventListener("click", function () {
            let section = document.createElement("div");
            section.className = "border rounded p-3 mb-3 procedure-section bg-label-secondary";
            section.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <input type="text" class="form-control me-2 section-title"
                        placeholder="Enter Section Title (Example: 5.1 Pre-Repair Inspection)">
                    <button type="button" class="btn btn-sm btn-danger-outline border border-danger deleteSection">
                        <i class="mdi mdi-trash-can-outline text-danger"></i>
                    </button>
                </div>
                <div class="procedure-list"></div>
                <button type="button" class="btn btn-sm btn-primary-outline border border-primary addProcedure text-primary mt-2">
                    <i class="mdi mdi-plus text-primary"></i> Add Procedure
                </button>
            `;
            sectionContainer.appendChild(section);
        });
    }

    /* ========== Section / Procedure builders (Edit) ========== */
    const editSectionContainer = document.getElementById("editSectionContainer");
    const editAddSectionBtns   = editProcedurePanel ? editProcedurePanel.querySelectorAll("#addSection") : [];
    editAddSectionBtns.forEach(btn => {
        btn.addEventListener("click", function () {
            let section = document.createElement("div");
            section.className = "border rounded p-3 mb-3 procedure-section bg-label-secondary";
            section.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <input type="text" class="form-control me-2 section-title" placeholder="Section Title">
                    <button class="btn btn-sm btn-danger-outline border border-danger deleteSection">
                        <i class="mdi mdi-trash-can-outline text-danger"></i>
                    </button>
                </div>
                <div class="procedure-list"></div>
                <button class="btn btn-sm btn-primary-outline border border-primary addProcedure text-primary mt-2">
                    <i class="mdi mdi-plus"></i> Add Procedure
                </button>
            `;
            editSectionContainer.appendChild(section);
        });
    });

    /* ========== Delegated: addProcedure, deleteRow, deleteSection ========== */
    document.addEventListener("click", function (e) {
        if (e.target.closest(".addProcedure")) {
            let section = e.target.closest(".procedure-section");
            let procedureList = section.querySelector(".procedure-list");
            let row = document.createElement("div");
            row.className = "d-flex align-items-center gap-2 mb-2 checklist-row";
            row.innerHTML = `
                <input type="text" class="form-control procedure-input" placeholder="Enter procedure step">
                <button type="button" class="btn btn-sm btn-danger-outline border border-danger deleteRow">
                    <i class="mdi mdi-trash-can-outline text-danger"></i>
                </button>
            `;
            procedureList.appendChild(row);
        }
        if (e.target.closest(".deleteRow")) {
            e.target.closest(".checklist-row").remove();
        }
        if (e.target.closest(".deleteSection")) {
            e.target.closest(".procedure-section").remove();
        }
    });

    /* ========== Tools Modal: Select All ========== */
    const selectAll = document.getElementById("selectAllTools");
    const tools     = document.querySelectorAll(".tool-checkbox");
    if (selectAll) {
        selectAll.addEventListener("change", function () {
            tools.forEach(tool => { tool.checked = selectAll.checked; });
        });
        tools.forEach(tool => {
            tool.addEventListener("change", function () {
                selectAll.checked = document.querySelectorAll(".tool-checkbox:checked").length === tools.length;
            });
        });
    }

    /* ========== Panel Toggling ========== */
    function showPanel(panel) {
        existingPanel.style.display      = 'none';
        newProcedurePanel.style.display   = 'none';
        editProcedurePanel.style.display  = 'none';
        panel.style.display = 'block';
    }

    addProcedureBtn.addEventListener('click', () => showPanel(newProcedurePanel));
    cancelSopBtn.addEventListener('click', () => showPanel(existingPanel));
    cancelEditSopBtn.addEventListener('click', () => showPanel(existingPanel));

    document.addEventListener("click", function(e) {
        if (e.target.closest(".editProcedureBtn")) {
            if (!currentProcedureId) { showToast('warning', "Select a procedure first"); return; }
            // Fetch and pre-fill edit form
            $.ajax({
                url: '/procedures/show/' + currentProcedureId,
                type: 'GET',
                success: function(res) {
                    if (res.status && res.data) {
                        let d = res.data;
                        $('#edit-procedure-title').val(d.title || '');
                        $('#edit-procedure-code').val(d.procedure_code || '');
                        $('#edit-asset-type').val(d.asset_type || '');
                        $('#edit-work-category').val(d.work_category || '');
                        $('#edit-procedure-description').val(d.description || '');

                        // Pre checklist
                        let preContainer = document.getElementById('edit-preChecklistContainer');
                        preContainer.innerHTML = '';
                        if (d.pre_checklist && d.pre_checklist.length > 0) {
                            document.getElementById('edit-pre-checklist-toggle').checked = true;
                            document.getElementById('edit-preAccordian').classList.remove('d-none');
                            document.getElementById('edit-addPreChecklist').classList.remove('d-none');
                            d.pre_checklist.forEach(item => {
                                let row = document.createElement("div");
                                row.className = "d-flex align-items-center gap-2 mb-2 checklist-row";
                                row.innerHTML = `<input type="text" class="form-control" value="${item}">
                                    <button type="button" class="btn btn-sm btn-danger-outline border border-danger deleteRow">
                                        <i class="mdi mdi-trash-can-outline text-danger"></i>
                                    </button>`;
                                preContainer.appendChild(row);
                            });
                        }

                        // Post checklist
                        let postContainer = document.getElementById('edit-checklistContainer');
                        postContainer.innerHTML = '';
                        if (d.post_checklist && d.post_checklist.length > 0) {
                            document.getElementById('edit-post-checklist-toggle').checked = true;
                            document.getElementById('edit-postAccordian').classList.remove('d-none');
                            document.getElementById('edit-addChecklist').classList.remove('d-none');
                            d.post_checklist.forEach(item => {
                                let row = document.createElement("div");
                                row.className = "d-flex align-items-center gap-2 mb-2 checklist-row";
                                row.innerHTML = `<input type="text" class="form-control" value="${item}">
                                    <button type="button" class="btn btn-sm btn-danger-outline border border-danger deleteRow">
                                        <i class="mdi mdi-trash-can-outline text-danger"></i>
                                    </button>`;
                                postContainer.appendChild(row);
                            });
                        }

                        // Procedure sections
                        editSectionContainer.innerHTML = '';
                        if (d.steps && d.steps.length > 0) {
                            d.steps.forEach(section => {
                                let secDiv = document.createElement("div");
                                secDiv.className = "border rounded p-3 mb-3 procedure-section bg-label-secondary";
                                let stepsHtml = '';
                                if (section.items) {
                                    section.items.forEach(item => {
                                        stepsHtml += `<div class="d-flex align-items-center gap-2 mb-2 checklist-row">
                                            <input type="text" class="form-control procedure-input" value="${item}">
                                            <button type="button" class="btn btn-sm btn-danger-outline border border-danger deleteRow">
                                                <i class="mdi mdi-trash-can-outline text-danger"></i>
                                            </button>
                                        </div>`;
                                    });
                                }
                                secDiv.innerHTML = `
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <input type="text" class="form-control me-2 section-title" value="${section.title || ''}">
                                        <button class="btn btn-sm btn-danger-outline border border-danger deleteSection">
                                            <i class="mdi mdi-trash-can-outline text-danger"></i>
                                        </button>
                                    </div>
                                    <div class="procedure-list">${stepsHtml}</div>
                                    <button class="btn btn-sm btn-primary-outline border border-primary addProcedure text-primary mt-2">
                                        <i class="mdi mdi-plus"></i> Add Procedure
                                    </button>
                                `;
                                editSectionContainer.appendChild(secDiv);
                            });
                        }
                        showPanel(editProcedurePanel);
                    }
                }
            });
        }
    });

    /* ========== Sidebar Click → Load Detail ========== */
    document.querySelectorAll('.procedure-sidebar-item').forEach(item => {
        item.addEventListener('click', function () {
            let id = this.getAttribute('data-id');
            loadProcedureDetail(id);
            // highlight
            document.querySelectorAll('.procedure-sidebar-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
        });
    });

    /* ========== Sidebar Search ========== */
    const searchBox = document.querySelector('.panel-header input[type="text"]');
    if (searchBox) {
        searchBox.addEventListener('input', function () {
            let query = this.value.toLowerCase();
            document.querySelectorAll('.procedure-sidebar-item').forEach(item => {
                let text = item.textContent.toLowerCase();
                item.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }

    /* ========== Load Procedure Detail via AJAX ========== */
    function loadProcedureDetail(id) {
        currentProcedureId = id;
        $.ajax({
            url: '/procedures/show/' + id,
            type: 'GET',
            success: function (res) {
                if (res.status && res.data) {
                    let d = res.data;
                    $('#sop_detail_title').text(d.title || '-');
                    $('#sop_detail_description').text(d.description || '-');
                    $('#sop_detail_asset_type').text(d.asset_type || '-');
                    $('#sop_detail_code').text(d.procedure_code || '-');
                    $('#sop_detail_work_category').text(d.work_category || '-');
                    $('#sop_detail_created_by').text(d.created_at ? new Date(d.created_at).toLocaleDateString() : '-');

                    // Render procedure steps
                    let stepsContainer = document.getElementById('sop_detail_steps');
                    stepsContainer.innerHTML = '';
                    if (d.steps && d.steps.length > 0) {
                        d.steps.forEach(section => {
                            stepsContainer.innerHTML += `<div class="detail-spec"><span class="text-dark fw-bold fs-6">${section.title || ''}</span></div>`;
                            if (section.items) {
                                section.items.forEach(item => {
                                    stepsContainer.innerHTML += `<div class="detail-spec">
                                        <input class="form-check-input rounded w-25px h-25px" type="checkbox" disabled/>
                                        <span class="text-black fw-medium fs-6">${item}</span>
                                    </div>`;
                                });
                            }
                            stepsContainer.innerHTML += `<hr class="my-1">`;
                        });
                    } else {
                        stepsContainer.innerHTML = '<div class="text-muted text-center py-3">No procedure steps added yet.</div>';
                    }

                    // Render pre-checklist
                    let preContainer = document.getElementById('sop_detail_pre_checklist');
                    preContainer.innerHTML = '';
                    if (d.pre_checklist && d.pre_checklist.length > 0) {
                        d.pre_checklist.forEach(item => {
                            preContainer.innerHTML += `<div class="detail-spec">
                                <input class="form-check-input rounded w-25px h-25px" type="checkbox" disabled/>
                                <span class="text-black fw-medium fs-6">${item}</span>
                            </div>`;
                        });
                    } else {
                        preContainer.innerHTML = '<div class="text-muted text-center py-3">No pre-checklist items.</div>';
                    }

                    // Render post-checklist
                    let postContainer = document.getElementById('sop_detail_post_checklist');
                    postContainer.innerHTML = '';
                    if (d.post_checklist && d.post_checklist.length > 0) {
                        d.post_checklist.forEach(item => {
                            postContainer.innerHTML += `<div class="detail-spec">
                                <input class="form-check-input rounded w-25px h-25px" type="checkbox" disabled/>
                                <span class="text-black fw-medium fs-6">${item}</span>
                            </div>`;
                        });
                    } else {
                        postContainer.innerHTML = '<div class="text-muted text-center py-3">No post-checklist items.</div>';
                    }

                    showPanel(existingPanel);
                }
            },
            error: function () {
                showToast('error', "Failed to load procedure details");
            }
        });
    }

    /* ========== Collect Form Data Helper ========== */
    function collectFormData(prefix) {
        let isCreate = prefix === '';
        let titleEl    = document.getElementById(prefix + 'procedure-title');
        let codeEl     = document.getElementById(prefix + 'procedure-code');
        let descEl     = document.getElementById(prefix + 'procedure-description');

        let title       = titleEl ? titleEl.value : '';
        let procCode    = codeEl ? codeEl.value : '';
        let description = descEl ? descEl.value : '';

        // Use jQuery for Select2-wrapped selects
        let assetType   = $('#' + prefix + 'asset-type').val() || '';
        let workCat     = $('#' + prefix + 'work-category').val() || '';

        // Procedure sections
        let container = isCreate ? sectionContainer : editSectionContainer;
        let steps = [];
        if (container) {
            container.querySelectorAll('.procedure-section').forEach(sec => {
                let sectionTitle = sec.querySelector('.section-title')?.value || '';
                let items = [];
                sec.querySelectorAll('.procedure-input').forEach(inp => {
                    if (inp.value.trim()) items.push(inp.value.trim());
                });
                steps.push({ title: sectionTitle, items: items });
            });
        }

        // Pre-checklist
        let preChecklistId = isCreate ? 'preChecklistContainer' : 'edit-preChecklistContainer';
        let preChecklist = [];
        document.querySelectorAll('#' + preChecklistId + ' .checklist-row input[type="text"]').forEach(inp => {
            if (inp.value.trim()) preChecklist.push(inp.value.trim());
        });

        // Post-checklist
        let postChecklistId = isCreate ? 'checklistContainer' : 'edit-checklistContainer';
        let postChecklist = [];
        document.querySelectorAll('#' + postChecklistId + ' .checklist-row input[type="text"]').forEach(inp => {
            if (inp.value.trim()) postChecklist.push(inp.value.trim());
        });

        // Required tools
        let requiredTools = [];
        document.querySelectorAll('.tool-checkbox:checked').forEach(cb => {
            let label = cb.parentElement.querySelector('span')?.textContent?.trim();
            if (label) requiredTools.push(label);
        });

        return {
            title: title,
            procedure_code: procCode,
            asset_type: assetType,
            work_category: workCat,
            description: description,
            steps: steps,
            pre_checklist: preChecklist,
            post_checklist: postChecklist,
            required_tools: requiredTools,
        };
    }

    /* ========== Save SOP (Create) ========== */
    if (saveSopBtn) {
        saveSopBtn.addEventListener('click', function () {
            try {
                let data = collectFormData('');

                if (!data.title || data.title.trim() === '') {
                    alert('Please enter a Procedure Title');
                    return;
                }
                if (!data.asset_type || data.asset_type.trim() === '') {
                    alert('Please select an Asset Type');
                    return;
                }

                saveSopBtn.disabled = true;
                saveSopBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Saving...';

                $.ajax({
                    url: '{{ route("procedures.store") }}',
                    type: 'POST',
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    success: function (res) {
                        saveSopBtn.disabled = false;
                        saveSopBtn.innerHTML = 'Save SOP';
                        if (res.status) {
                            alert('Procedure created successfully!');
                            location.reload();
                        } else {
                            alert(res.message || 'Failed to create procedure');
                        }
                    },
                    error: function (xhr) {
                        saveSopBtn.disabled = false;
                        saveSopBtn.innerHTML = 'Save SOP';
                        alert(xhr.responseJSON?.message || 'Error creating procedure');
                    }
                });
            } catch(err) {
                console.error('Save SOP error:', err);
                alert('Error: ' + err.message);
            }
        });
    }

    /* ========== Update SOP (Edit) ========== */
    if (updateSopBtn) {
        updateSopBtn.addEventListener('click', function () {
            try {
                if (!currentProcedureId) { alert('No procedure selected'); return; }
                let data = collectFormData('edit-');

                if (!data.title || data.title.trim() === '') {
                    alert('Please enter a Procedure Title');
                    return;
                }
                if (!data.asset_type || data.asset_type.trim() === '') {
                    alert('Please select an Asset Type');
                    return;
                }

                updateSopBtn.disabled = true;
                updateSopBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Updating...';

                $.ajax({
                    url: '/procedures/update/' + currentProcedureId,
                    type: 'POST',
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    success: function (res) {
                        updateSopBtn.disabled = false;
                        updateSopBtn.innerHTML = 'Update SOP';
                        if (res.status) {
                            alert('Procedure updated successfully!');
                            location.reload();
                        } else {
                            alert(res.message || 'Failed to update procedure');
                        }
                    },
                    error: function (xhr) {
                        updateSopBtn.disabled = false;
                        updateSopBtn.innerHTML = 'Update SOP';
                        alert(xhr.responseJSON?.message || 'Error updating procedure');
                    }
                });
            } catch(err) {
                console.error('Update SOP error:', err);
                alert('Error: ' + err.message);
            }
        });
    }

    /* ========== Load first procedure on page load ========== */
    let firstItem = document.querySelector('.procedure-sidebar-item');
    if (firstItem) {
        loadProcedureDetail(firstItem.getAttribute('data-id'));
    }

});
</script>

@endsection

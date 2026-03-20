@extends('layouts/layoutMaster')

@section('title', 'Manage Customer Assets')

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
'resources/assets/vendor/libs/dropzone/dropzone.js',
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
                <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_asset">
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
                        @foreach($assets as $asset)
                        <tr>
                            <td>
                                <label class="text-black fw-medium fs-7">{{ $asset->name }}</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">{{ $asset->tag_number }}</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">{{ $asset->valve_type ?: '-' }}</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7" title="{{ $asset->description }}">{{ Str::limit($asset->description ?: '-', 20) }}</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">{{ $asset->actual_size ?: '-' }}</label>
                            </td>
                            <td>
                                <div class="d-flex align-items-start flex-column">
                                    <label class="text-black fw-medium fs-7">{{ $asset->plant->name ?? 'N/A' }}</label>
                                    <label class="text-dark fw-medium fs-8">{{ $asset->sector->name ?? 'N/A' }}</label>
                                </div>
                            </td>
                            <td>
                                <span class="text-end">
                                    <a href="#" class="btn btn-icon btn-sm me-2 view-asset-btn" data-id="{{ $asset->id }}">
                                        <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="View">
                                            <i class="mdi mdi-eye fs-3 text-black"></i>
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
                    <input type="text" id="assetSidebarSearch" placeholder="Search Tag, Plant, Size..." class="form-control">
                    <button class="btn btn-sm btn-dark back_to_table">
                        <i class="mdi mdi-arrow-left"></i> Back
                    </button>
                </div>
                <div class="asset-list">
                    @foreach($assets as $asset)
                    <div class="asset-item asset-sidebar-item" data-id="{{ $asset->id }}">
                        <div>
                            <div class="asset-title">
                                <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Asset Tag" class="fs-7 text-black fw-medium">{{ $asset->tag_number }}</span>
                            </div>  
                            <div class="asset-meta">
                                <span class="tag" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Plant">{{ $asset->plant->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="asset-size">
                            <span class="fs-7">{{ $asset->actual_size ?: '-' }} X {{ $asset->pressure_class ?: '-' }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="asset-detail-panel">
                <div class="detail-header">
                    <div class="detail-desc">
                        <h4 id="detail_tag_number">-</h4>
                        <span class="text-dark fw-semibold fs-7" id="detail_description">-</span>
                    </div>
                    <div class="detail-desc">
                        <div class="mb-3">
                            <span class="tag" id="detail_plant_tag">-</span>
                            <a href="javascript:;" type="button" class="btn btn-sm btn-primary-outline border border-primary text-primary" id="edit_asset_btn"><i class="mdi mdi-pencil-outline"></i>Edit</a>
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
                        <div>
                            <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                <span><i class="mdi mdi-ruler text-dark fs-7"></i></span>
                                <label class="fs-5 text-black">Technical Specifications</label>
                            </div>
                            <div class="detail-card">
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">Actual Size</span>
                                    <span class="text-black fw-medium fs-6" id="detail_actual_size">-</span>
                                </div>
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">Estimated Size</span>
                                    <span class="text-black fw-medium fs-6" id="detail_estimated_size">-</span>
                                </div>
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">Pressure Class</span>
                                    <span class="text-black fw-medium fs-6" id="detail_pressure_class">-</span>
                                </div>
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">Valve Type</span>
                                    <span class="text-black fw-medium fs-6" id="detail_valve_type">-</span>
                                </div>
                                <hr class="my-1">
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">Scaffolding / Crane</span>
                                    <span class="text-success fw-medium fs-6" id="detail_scaff_crane">-</span>
                                </div>
                                <hr class="my-1">
                                <div class="d-flex flex-column gap-1">
                                    <span class="text-dark fw-semibold fs-6">
                                        <i class="mdi mdi-wrench-outline me-1"></i>Special Tools & Equipments
                                    </span>
                                    <span class="text-black fw-medium fs-6" id="detail_special_tools">-</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                <span><i class="mdi mdi-map-marker-radius-outline text-dark fs-7"></i></span>
                                <label class="fs-5 text-black">Location & Context</label>
                            </div>
                            <div class="detail-card">
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">Main Plant</span>
                                    <span class="text-black fw-medium fs-6" id="detail_plant">-</span>
                                </div>
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">Sector</span>
                                    <span class="text-black fw-medium fs-6" id="detail_sector">-</span>
                                </div>
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">Room / Sub-Location</span>
                                    <span class="text-black fw-medium fs-6" id="detail_room">-</span>
                                </div>
                                <div class="detail-spec">
                                    <span class="text-dark fw-semibold fs-6">Work Center</span>
                                    <span class="text-black fw-medium fs-6" id="detail_work_center">-</span>
                                </div>
                                <hr class="my-1">
                                <div class="d-flex flex-column gap-1">
                                    <span class="text-dark fw-semibold fs-6">
                                        <i class="mdi mdi-navigation-variant-outline text-primary cursor-pointer"></i>Geo-Location
                                    </span>
                                    <span class="text-black fw-medium fs-6" id="detail_geo">-</span>
                                </div>
                            </div>
                        </div>
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
          <h4 class="text-center text-black">Bulk Upload Assets</h4>
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
                <div class="dropzone needsclick" id="assetBulkDropzone">
                    <div class="dz-message fs-6">
                        <div class="text-center text-black">
                            Drop files here or click to upload
                        </div>
                    </div>
                    <div class="fallback"> 
                        <input type="file" name="file" /> 
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('assets.downloadSample') }}" class="btn btn-label-secondary btn-sm">
                        <i class="ti ti-download me-1"></i> Download Sample Excel
                    </a>
                </div>
            </div>
        </div>
        <div class="modal-footer pt-5">
          <div class="d-flex justify-content-end align-items-center">
            <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="upload_assets_btn">Upload</button>
          </div>
        </div>
        <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Bulk Upload-->


<!--begin::Modal - Add Assets-->
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
                    <label class="text-black mb-1 fs-7 fw-semibold">Asset Type/Tag<span class="text-danger">*</span></label>
                    <input type="text" id="add_tag_number" class="form-control" placeholder="Enter Asset Type/Tag" />
                    <div class="text-danger error-tag_number"></div>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Customer Asset Name<span class="text-danger">*</span></label>
                    <input type="text" id="add_asset_name" class="form-control" placeholder="Enter Asset Name" />
                    <div class="text-danger error-name"></div>
                </div>
                <div class="col-lg-6 mb-3" >
                    <label class="text-black mb-1 fs-7 fw-semibold">Client</label>
                    <select id="add_client_id" class="select3 form-select">
                        <option value="">Select Client</option>
                        @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Description</label>
                    <textarea id="add_description" class="form-control" rows="1" placeholder="Enter Description"></textarea>
                </div>
                <hr class="my-1">
                <div class="col-lg-12 mb-2">
                    <label class="text-dark fw-semibold fs-6">Technical Specification</label>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Valve Type</label>
                    <input type="text" id="add_valve_type" class="form-control" placeholder="Enter Valve Type" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Actual Size</label>
                    <input type="text" id="add_actual_size" class="form-control" placeholder="Enter Actual Size" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Estimated Size</label>
                    <input type="text" id="add_estimated_size" class="form-control" placeholder="Enter Estimated Size" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Pressure Class</label>
                    <input type="text" id="add_pressure_class" class="form-control" placeholder="Enter Pressure Class" />
                </div>
                <hr class="my-1">
                <div class="col-lg-12 mb-2">
                    <label class="text-dark fw-semibold fs-6">Location</label>
                </div>
                <div class="col-lg-6 mb-3" >
                    <label class="text-black mb-1 fs-7 fw-semibold">Sector</label>
                    <select id="add_sector_id" class="select3 form-select">
                        <option value="">Select Sector</option>
                        @foreach($sectors as $sector)
                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 mb-3" >
                    <label class="text-black mb-1 fs-7 fw-semibold">Plant</label>
                    <select id="add_plant_id" class="select3 form-select">
                        <option value="">Select Plant</option>
                        @foreach($plants as $plant)
                        <option value="{{ $plant->id }}">{{ $plant->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 mb-3" >
                    <label class="text-black mb-1 fs-7 fw-semibold">Room</label>
                    <select id="add_room_id" class="select3 form-select">
                        <option value="">Select Room</option>
                        @foreach($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Work Center</label>
                    <input type="text" id="add_work_center" class="form-control" placeholder="Enter Work Center" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Latitude</label>
                    <input type="text" id="add_latitude" class="form-control" placeholder="Enter Latitude" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Longitude</label>
                    <input type="text" id="add_longitude" class="form-control" placeholder="Enter Longitude" />
                </div>
                <hr class="my-1">
                <div class="col-lg-12 mb-2">
                    <label class="text-dark fw-semibold fs-6">Special Tools & Equipments</label>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Special Tools</label>
                    <textarea id="add_special_tools" class="form-control" rows="1" placeholder="Enter Special Tools"></textarea>
                </div>
                <div class="col-lg-12 mb-3" >
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="Scaffolding" name="add_scaff_crane" />
                        <label class="form-check-label" for="">Scaffolding</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="Crane" name="add_scaff_crane" />
                        <label class="form-check-label" for="">Crane</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="Scaffolding + Crane" name="add_scaff_crane" />
                        <label class="form-check-label" for="">Scaffolding + Crane</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pt-5">
          <div class="d-flex justify-content-end align-items-center">
            <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="save_asset_btn">Create Customer Asset</button>
          </div>
        </div>
        <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Add Assets-->


<!--begin::Modal - Update Assets-->
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
          </div>
          <!--end::Close-->
        </div>
        <!--end::Modal header-->
        <!--begin::Modal body-->
        <div class="modal-body py-5 px-10 px-xl-20">
            <input type="hidden" id="edit_asset_id" />
            <div class="row scroll-y" style="max-height: 550px;">
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Asset Type/Tag<span class="text-danger">*</span></label>
                    <input type="text" id="edit_tag_number" class="form-control" placeholder="Enter Asset Type/Tag" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Customer Asset Name<span class="text-danger">*</span></label>
                    <input type="text" id="edit_asset_name" class="form-control" placeholder="Enter Asset Name" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Client</label>
                    <select id="edit_client_id" class="form-select">
                        <option value="">Select Client</option>
                        @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Description</label>
                    <textarea id="edit_description" class="form-control" rows="1" placeholder="Enter Description"></textarea>
                </div>
                <hr class="my-1">
                <div class="col-lg-12 mb-2">
                    <label class="text-dark fw-semibold fs-6">Technical Specification</label>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Valve Type</label>
                    <input type="text" id="edit_valve_type" class="form-control" placeholder="Enter Valve Type" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Actual Size</label>
                    <input type="text" id="edit_actual_size" class="form-control" placeholder="Enter Actual Size" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Estimated Size</label>
                    <input type="text" id="edit_estimated_size" class="form-control" placeholder="Enter Estimated Size" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Pressure Class</label>
                    <input type="text" id="edit_pressure_class" class="form-control" placeholder="Enter Pressure Class" />
                </div>
                <hr class="my-1">
                <div class="col-lg-12 mb-2">
                    <label class="text-dark fw-semibold fs-6">Location</label>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Sector</label>
                    <select id="edit_sector_id" class="form-select">
                        <option value="">Select Sector</option>
                        @foreach($sectors as $sector)
                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Plant</label>
                    <select id="edit_plant_id" class="form-select">
                        <option value="">Select Plant</option>
                        @foreach($plants as $plant)
                        <option value="{{ $plant->id }}">{{ $plant->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Room</label>
                    <select id="edit_room_id" class="form-select">
                        <option value="">Select Room</option>
                        @foreach($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Work Center</label>
                    <input type="text" id="edit_work_center" class="form-control" placeholder="Enter Work Center" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Latitude</label>
                    <input type="text" id="edit_latitude" class="form-control" placeholder="Enter Latitude" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Longitude</label>
                    <input type="text" id="edit_longitude" class="form-control" placeholder="Enter Longitude" />
                </div>
                <hr class="my-1">
                <div class="col-lg-12 mb-2">
                    <label class="text-dark fw-semibold fs-6">Special Tools & Equipments</label>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Special Tools</label>
                    <textarea id="edit_special_tools" class="form-control" rows="1" placeholder="Enter Special Tools"></textarea>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="Scaffolding" name="edit_scaff_crane" />
                        <label class="form-check-label">Scaffolding</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="Crane" name="edit_scaff_crane" />
                        <label class="form-check-label">Crane</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="Scaffolding + Crane" name="edit_scaff_crane" />
                        <label class="form-check-label">Scaffolding + Crane</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pt-5">
          <div class="d-flex justify-content-end align-items-center">
            <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="update_asset_btn">Update Customer Asset</button>
          </div>
        </div>
        <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Update Assets-->


<script>
var currentAssetId = null;

$(document).ready(function(){

    // =============================
    // LOAD ASSET DETAIL (reusable)
    // =============================
    function loadAssetDetail(id) {
        currentAssetId = id;
        $.get("/assets/show/" + id, function(res) {
            if (!res.status) return;
            let a = res.data;

            // Populate detail panel
            $("#detail_tag_number").text(a.tag_number || '-');
            $("#detail_description").text(a.description || a.name || '-');
            $("#detail_plant_tag").text(a.plant ? a.plant.name : 'N/A');
            $("#detail_actual_size").text(a.actual_size || '-');
            $("#detail_estimated_size").text(a.estimated_size || '-');
            $("#detail_pressure_class").text(a.pressure_class || '-');
            $("#detail_valve_type").text(a.valve_type || '-');
            $("#detail_scaff_crane").text(a.scaff_crane || '-');
            $("#detail_special_tools").text(a.special_tools || '-');
            $("#detail_plant").text(a.plant ? a.plant.name : '-');
            $("#detail_sector").text(a.sector ? a.sector.name : '-');
            $("#detail_room").text(a.room ? a.room.name : '-');
            $("#detail_work_center").text(a.work_center || '-');
            let lat = a.latitude || '-';
            let lng = a.longitude || '-';
            $("#detail_geo").text(lat + ', ' + lng);

            // Highlight sidebar item
            $(".asset-sidebar-item").removeClass("active");
            $(".asset-sidebar-item[data-id='" + id + "']").addClass("active");
        });
    }

    // =============================
    // TABLE EYE ICON CLICK → PANEL
    // =============================
    $(document).on("click", ".view-asset-btn", function(e){
        e.preventDefault();
        let id = $(this).data("id");

        $(".asset_table_panel").addClass("hide-table");
        setTimeout(function(){
            $(".asset_table_panel").hide();
            $(".asset-container").addClass("show-panel");
            loadAssetDetail(id);
        }, 300);
    });

    // =============================
    // SIDEBAR ITEM CLICK → DETAIL
    // =============================
    $(document).on("click", ".asset-sidebar-item", function(){
        let id = $(this).data("id");
        loadAssetDetail(id);
    });

    // =============================
    // BACK BUTTON
    // =============================
    $(".back_to_table").click(function(){
        $(".asset-container").removeClass("show-panel");
        setTimeout(function(){
            $(".asset_table_panel").show().removeClass("hide-table");
        }, 300);
    });

    // =============================
    // SIDEBAR SEARCH
    // =============================
    $("#assetSidebarSearch").on("keyup", function(){
        let val = $(this).val().toLowerCase();
        $(".asset-sidebar-item").each(function(){
            let text = $(this).text().toLowerCase();
            $(this).toggle(text.indexOf(val) > -1);
        });
    });

    // =============================
    // EDIT BUTTON → OPEN MODAL
    // =============================
    $(document).on("click", "#edit_asset_btn", function(){
        if (!currentAssetId) return;

        $.get("/assets/show/" + currentAssetId, function(res) {
            if (!res.status) return;
            let a = res.data;

            $("#edit_asset_id").val(a.id);
            $("#edit_tag_number").val(a.tag_number);
            $("#edit_asset_name").val(a.name);
            $("#edit_client_id").val(a.client_id || '');
            $("#edit_description").val(a.description || '');
            $("#edit_valve_type").val(a.valve_type || '');
            $("#edit_actual_size").val(a.actual_size || '');
            $("#edit_estimated_size").val(a.estimated_size || '');
            $("#edit_pressure_class").val(a.pressure_class || '');
            $("#edit_sector_id").val(a.sector_id || '');
            $("#edit_plant_id").val(a.plant_id || '');
            $("#edit_room_id").val(a.room_id || '');
            $("#edit_work_center").val(a.work_center || '');
            $("#edit_latitude").val(a.latitude || '');
            $("#edit_longitude").val(a.longitude || '');
            $("#edit_special_tools").val(a.special_tools || '');

            // Set radio
            $("input[name='edit_scaff_crane']").prop('checked', false);
            if (a.scaff_crane) {
                $("input[name='edit_scaff_crane'][value='" + a.scaff_crane + "']").prop('checked', true);
            }

            $("#kt_modal_update_asset").modal("show");
        });
    });

    // =============================
    // UPDATE ASSET SUBMIT
    // =============================
    $("#update_asset_btn").click(function(){
        let btn = $(this);
        btn.prop('disabled', true).html('Saving...');

        let id = $("#edit_asset_id").val();

        $.ajax({
            url: "/assets/update/" + id,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                name: $("#edit_asset_name").val(),
                tag_number: $("#edit_tag_number").val(),
                client_id: $("#edit_client_id").val(),
                sector_id: $("#edit_sector_id").val(),
                plant_id: $("#edit_plant_id").val(),
                room_id: $("#edit_room_id").val(),
                description: $("#edit_description").val(),
                valve_type: $("#edit_valve_type").val(),
                actual_size: $("#edit_actual_size").val(),
                estimated_size: $("#edit_estimated_size").val(),
                pressure_class: $("#edit_pressure_class").val(),
                work_center: $("#edit_work_center").val(),
                latitude: $("#edit_latitude").val(),
                longitude: $("#edit_longitude").val(),
                special_tools: $("#edit_special_tools").val(),
                scaff_crane: $("input[name='edit_scaff_crane']:checked").val() || ""
            },
            success: function(res) {
                btn.prop('disabled', false).html('Update Customer Asset');
                if (res.status) {
                    toastr.success(res.message);
                    $("#kt_modal_update_asset").modal("hide");
                    loadAssetDetail(id);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    toastr.error(res.message);
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('Update Customer Asset');
                toastr.error("An error occurred");
            }
        });
    });

});

    // Create Customer Asset Submit
    $("#save_asset_btn").click(function(e){
        e.preventDefault();
        
        let btn = $(this);
        btn.prop('disabled', true).html('Saving...');
        $(".text-danger").html(""); // Clear old errors

        let data = {
            _token: "{{ csrf_token() }}",
            tag_number: $("#add_tag_number").val(),
            name: $("#add_asset_name").val(),
            client_id: $("#add_client_id").val(),
            sector_id: $("#add_sector_id").val(),
            plant_id: $("#add_plant_id").val(),
            room_id: $("#add_room_id").val(),
            description: $("#add_description").val(),
            valve_type: $("#add_valve_type").val(),
            actual_size: $("#add_actual_size").val(),
            estimated_size: $("#add_estimated_size").val(),
            pressure_class: $("#add_pressure_class").val(),
            work_center: $("#add_work_center").val(),
            latitude: $("#add_latitude").val(),
            longitude: $("#add_longitude").val(),
            special_tools: $("#add_special_tools").val(),
            scaff_crane: $("input[name='add_scaff_crane']:checked").val() || ""
        };

        $.ajax({
            url: "{{ route('assets.store') }}",
            type: "POST",
            data: data,
            success: function(res) {
                if(res.status) {
                    toastr.success(res.message);
                    $("#kt_modal_add_asset").modal("hide");
                    setTimeout(() => location.reload(), 1000);
                }
                btn.prop('disabled', false).html('Create Customer Asset');
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('Create Customer Asset');
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if(errors.tag_number) $(".error-tag_number").html(errors.tag_number[0]);
                    if(errors.name) $(".error-name").html(errors.name[0]);
                } else {
                    toastr.error("An error occurred");
                }
            }
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

    // Bulk Upload Dropzone
    Dropzone.autoDiscover = false;
    let assetBulkDropzone = new Dropzone("#assetBulkDropzone", {
        url: "{{ route('assets.bulkUpload') }}",
        autoProcessQueue: false,
        paramName: "file",
        maxFiles: 1,
        acceptedFiles: ".xlsx, .xls, .csv",
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        init: function() {
            let myDropzone = this;

            $("#upload_assets_btn").click(function(e) {
                e.preventDefault();
                if (myDropzone.getQueuedFiles().length > 0) {
                    myDropzone.processQueue();
                } else {
                    toastr.error("Please select a file to upload.");
                }
            });

            this.on("sending", function(file, xhr, formData) {
                $("#upload_assets_btn").prop('disabled', true).html('Uploading...');
            });

            this.on("success", function(file, response) {
                if (response.status) {
                    toastr.success(response.message);
                    $("#kt_modal_bulk_upload").modal("hide");
                    setTimeout(() => location.reload(), 1500);
                } else {
                    toastr.error(response.message);
                    $("#upload_assets_btn").prop('disabled', false).html('Upload');
                }
            });

            this.on("error", function(file, message) {
                toastr.error(typeof message === 'string' ? message : (message.message || "An error occurred"));
                $("#upload_assets_btn").prop('disabled', false).html('Upload');
                this.removeFile(file);
            });
        }
    });
</script>
@endsection
@extends('layouts/layoutMaster')

@section('title', 'Manage Client')

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
            <h3 class="card-title mb-1">Manage Client</h3>
        </div>
        <div class="card-action-element">
            <div class="d-flex justify-content-end align-items-center mb-2 gap-2">
                <div class="searchBar" style="position: relative; width: 300px;">
                    <input class="form-control" type="text" name="searchQueryInput"
                        placeholder="Search Client Name" value=""
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
                <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary-outline border border-primary text-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_bulk_upload">
                    <span class="me-2"><i class="mdi mdi-tray-arrow-up"></i></span>Bulk Upload
                </a>
                <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_client">
                    <span class="me-2"><i class="mdi mdi-plus"></i></span>Add Client
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-3">
                <div class="p-3 rounded border d-flex flex-column bg-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="rounded p-3" style="background:#f3e5f5; color:#4a148c; ">
                                <i class="mdi mdi-office-building fs-3"></i>
                            </div>
                            <div class="d-flex flex-column">
                                <label class="text-black fw-semibold fs-6">Qatar Energy</label>
                                <label class="badge bg-label-success fw-semibold fs-8" style="width:fit-content;">Active</label>
                            </div>
                        </div>
                        <a class="btn btn-icon btn-sm p-0 me-2" id="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical fs-3 text-black"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;"  class="dropdown-item" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_client">
                                <span><i class="mdi mdi-pencil-outline fs-3 text-black me-1"></i></span>
                                <span>Edit</span>
                            </a>
                            <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#kt_modal_delete_client">
                                <span><i class="mdi mdi-trash-can-outline fs-3 text-black me-1"></i></span>
                                <span>Delete</span>
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column gap-1">
                        <div class="d-flex align-items-center gap-2">
                            <span class="mdi mdi-email-outline text-secondary"></span>
                            <label class="text-dark fs-7 fw-semibold">ahmed.althani@qatarenergy.qa</label>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="mdi mdi-phone-outline text-secondary"></span>
                            <label class="text-dark fs-7 fw-semibold">+974 4444 1111</label>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="mdi mdi-map-marker-outline text-secondary"></span>
                            <label class="text-dark fs-7 fw-semibold">Doha , Qatar</label>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="mdi mdi-city text-secondary"></span>
                            <label class="text-dark fs-7 fw-semibold">Oil & Gas</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="p-3 rounded border d-flex flex-column bg-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex gap-2 align-items-center">

                            <div class="rounded p-3" style="background:#f3e5f5; color:#4a148c; ">
                                <i class="mdi mdi-office-building fs-3"></i>
                            </div>
                            
                            <div class="d-flex flex-column">
                                <label class="text-black fw-semibold fs-6">Qatar Gas</label>
                                <label class="badge bg-label-success fw-semibold fs-8" style="width:fit-content;">Active</label>
                            </div>

                        </div>
                        <a class="btn btn-icon btn-sm p-0 me-2" id="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical fs-3 text-black"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;"  class="dropdown-item" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_client">
                                <span><i class="mdi mdi-pencil-outline fs-3 text-black me-1"></i></span>
                                <span>Edit</span>
                            </a>
                            <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#kt_modal_delete_client">
                                <span><i class="mdi mdi-trash-can-outline fs-3 text-black me-1"></i></span>
                                <span>Delete</span>
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column gap-1">
                        <div class="d-flex align-items-center gap-2">
                            <span class="mdi mdi-email-outline text-secondary"></span>
                            <label class="text-dark fs-7 fw-semibold">fatima.alkuwari@qatargas.com.qa</label>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="mdi mdi-phone-outline text-secondary"></span>
                            <label class="text-dark fs-7 fw-semibold">+974 4444 2222</label>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="mdi mdi-map-marker-outline text-secondary"></span>
                            <label class="text-dark fs-7 fw-semibold">Ras Laffan ,Qatar</label>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="mdi mdi-city text-secondary"></span>
                            <label class="text-dark fs-7 fw-semibold">Oil & Gas</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="p-3 rounded border d-flex flex-column bg-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="rounded p-3" style="background:#f3e5f5; color:#4a148c; ">
                                <i class="mdi mdi-office-building fs-3"></i>
                            </div>
                            <div class="d-flex flex-column">
                                <label class="text-black fw-semibold fs-6">Oryx GTL</label>
                                <label class="badge bg-label-secondary fw-semibold fs-8" style="width:fit-content;">Inactive</label>
                            </div>
                        </div>
                        <a class="btn btn-icon btn-sm p-0 me-2" id="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical fs-3 text-black"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;"  class="dropdown-item" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_client">
                                <span><i class="mdi mdi-pencil-outline fs-3 text-black me-1"></i></span>
                                <span>Edit</span>
                            </a>
                            <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#kt_modal_delete_client">
                                <span><i class="mdi mdi-trash-can-outline fs-3 text-black me-1"></i></span>
                                <span>Delete</span>
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column gap-1">
                        <div class="d-flex align-items-center gap-2">
                            <span class="mdi mdi-email-outline text-secondary"></span>
                            <label class="text-dark fs-7 fw-semibold">fatima.alkuwari@qatargas.com.qa</label>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="mdi mdi-phone-outline text-secondary"></span>
                            <label class="text-dark fs-7 fw-semibold">+974 4444 3333</label>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="mdi mdi-map-marker-outline text-secondary"></span>
                            <label class="text-dark fs-7 fw-semibold">Ras Laffan ,Qatar</label>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="mdi mdi-city text-secondary"></span>
                            <label class="text-dark fs-7 fw-semibold">Petrochemicals</label>
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


<!--begin::Modal - Add Client-->
<div class="modal fade" id="kt_modal_add_client" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
    data-bs-backdrop="static" data-bs-focus="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-lg">
        <!--begin::Modal content-->
      <div class="modal-content rounded">
        <!--begin::Modal header-->
        <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
          <h4 class="text-center text-black">Create Client</h4>
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

                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Company Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Company Name" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Mobile Number<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Mobile Number" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Email<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Email" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Location URL</label>
                    <input type="text" class="form-control" placeholder="Enter Location URL" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Address</label>
                    <textarea class="form-control" rows="1" placeholder="Enter Address"></textarea>
                </div>
                <div class="col-lg-6 mb-3" >
                    <label class="text-black mb-1 fs-7 fw-semibold">Status<span class="text-danger">*</span></label>
                    <select class="select3 form-select" >
                        <option value="">Select Status</option>
                        <option value="1">Active</option>
                        <option value="2">In Active</option>
                    </select>
                </div>    
                <div class="col-lg-12 d-flex align-items-center justify-content-between gap-5">
                    <label class="text-black mb-1 fs-7 fw-semibold">Clients & Sector</label>
                    <a href="javascript:;" class="btn btn-sm btn-primary-outline text-primary border border-primary" id="add_client">
                        <i class="mdi mdi-plus fs-5 text-primary"></i> Add Client
                    </a>
                </div>
                <div class="client_container scroll-y max-h-400px" style="overflow-x: hidden;">
                    <div class="client-row col-lg-12 mb-2">
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label class="text-black mb-1 fs-7 fw-semibold">Client Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Client Name" />
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-black mb-1 fs-7 fw-semibold">Industry Sector<span class="text-danger">*</span></label>
                                        <select class="select3 form-select">
                                            <option value="">Select Industry Sector</option>
                                            <option value="1">OOD-FHSP</option>
                                            <option value="2">OOG-SHFO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 mb-2 d-flex align-items-center">
                                <button class="btn btn-danger-outline border border-danger text-danger btn-sm delete-row" style="display:none;">
                                    <i class="mdi mdi-trash-can-outline fs-4 text-danger"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
        <div class="modal-footer pt-5">
          <div class="d-flex justify-content-end align-items-center">
            <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Create Client</button>
          </div>
        </div>
        <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Add Client-->



<!--begin::Modal - Update Client-->
<div class="modal fade" id="kt_modal_edit_client" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
    data-bs-backdrop="static" data-bs-focus="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-lg">
        <!--begin::Modal content-->
      <div class="modal-content rounded">
        <!--begin::Modal header-->
        <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
          <h4 class="text-center text-black">Update Client</h4>
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
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Company Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Company Name" value="Qatar Energy"/>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Mobile Number<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Mobile Number" value="+974 4444 1111"/>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Email<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Email" value="ahmed.althani@qatarenergy.qa" />
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Location URL</label>
                    <input type="text" class="form-control" placeholder="Enter Location URL" value="https://maps.google.com/?q=24.8607,67.0011"/>
                </div>
                <div class="col-lg-6 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Address</label>
                    <textarea class="form-control" rows="1" placeholder="Enter Address">Doha , Qatar</textarea>
                </div>
                <div class="col-lg-6 mb-3" >
                    <label class="text-black mb-1 fs-7 fw-semibold">Status<span class="text-danger">*</span></label>
                    <select class="select3 form-select" >
                        <option value="">Select Status</option>
                        <option value="1" selected>Active</option>
                        <option value="2">In Active</option>
                    </select>
                </div>
                <div class="col-lg-12 d-flex align-items-center justify-content-between gap-5">
                    <label class="text-black mb-1 fs-7 fw-semibold">Clients & Sector</label>
                    <a href="javascript:;" class="btn btn-sm btn-primary-outline text-primary border border-primary" id="edit_client">
                        <i class="mdi mdi-plus fs-5 text-primary"></i> Add Client
                    </a>
                </div>
                <div class="client_container scroll-y max-h-400px" style="overflow-x: hidden;">
                    <div class="client-row col-lg-12 mb-2">
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label class="text-black mb-1 fs-7 fw-semibold">Client Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Client Name" />
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="text-black mb-1 fs-7 fw-semibold">Industry Sector<span class="text-danger">*</span></label>
                                        <select class="select3 form-select">
                                            <option value="">Select Industry Sector</option>
                                            <option value="1">OOD-FHSP</option>
                                            <option value="2">OOG-SHFO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 mb-2 d-flex align-items-center">
                                <button class="btn btn-danger-outline border border-danger text-danger btn-sm delete-row" style="display:none;">
                                    <i class="mdi mdi-trash-can-outline fs-4 text-danger"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
        <div class="modal-footer pt-5">
          <div class="d-flex justify-content-end align-items-center">
            <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Update Client</button>
          </div>
        </div>
        <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Update Client-->


<!--begin::Modal - Delete Client-->
<div class="modal fade pt-20" id="kt_modal_delete_client" tabindex="-1" aria-hidden="true" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
  <!--begin::Modal dialog-->
  <div class="modal-dialog modal-m">
    <!--begin::Modal content-->
    <div class="modal-content rounded">
      <div class="swal2-icon swal2-danger swal2-icon-show" style="display: flex;">
        <div class="swal2-icon-content">
          <img src="{{ asset('assets/images/dustbin.ico') }}" alt="Dustbin Icon" class="w-100px h-100px"/>
        </div>
      </div>
      <div class="swal2-html-container" id="swal2-html-container" style="display: block;">Are you sure you want to Delete Client ?
        <div class="d-block fw-bold fs-5 py-2">
          <label class="text-danger">Ahmed AI-Thani (Qatar Energy)</label>
          <!-- <span class="ms-2 me-2">-</span>
          <label>2024/MDU/MU0001</label> -->
        </div>
      </div>
      <div class="d-flex justify-content-center align-items-center gap-3 pt-8">
        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">No,cancel</button>
        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Yes, delete!</button>
      </div><br><br>
    </div>
    <!--end::Modal content-->
  </div>
  <!--end::Modal dialog-->
</div>
<!--end::Modal - Delete Client-->

<script>
    $(document).ready(function(){

        function initSelect2(element){
            element.find(".select3").select2({
                width: "100%",
                dropdownParent: $("#kt_modal_add_client")
            });
        }

        initSelect2($(document));

        $("#add_client").click(function(){

            var clone = $(".client-row:first").clone();

            clone.find("input").val("");
            clone.find("select").val("").removeClass("select2-hidden-accessible").next(".select2").remove();

            clone.find(".delete-row").show();

            clone.appendTo(".client_container");
            initSelect2(clone);
        });

        $(document).on("click",".delete-row",function(){
            $(this).closest(".client-row").remove();
        });

    });
</script>

<script>
    $(document).ready(function(){

        function initSelect2(element){
            element.find(".select3").select2({
                width: "100%",
                dropdownParent: $("#kt_modal_edit_client")
            });
        }

        initSelect2($(document));

        $("#edit_client").click(function(){

            var clone = $(".client-row:first").clone();

            clone.find("input").val("");
            clone.find("select").val("").removeClass("select2-hidden-accessible").next(".select2").remove();

            clone.find(".delete-row").show();

            clone.appendTo(".client_container");
            initSelect2(clone);
        });

        $(document).on("click",".delete-row",function(){
            $(this).closest(".client-row").remove();
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
</script>
@endsection
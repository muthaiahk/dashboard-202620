@extends('layouts/layoutMaster')

@section('title', 'Sector')

@section('vendor-style')
@vite([
'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
'resources/assets/vendor/libs/select2/select2.scss',
'resources/assets/vendor/libs/tagify/tagify.scss'
])
@endsection

@section('vendor-script')
@vite([
'resources/assets/vendor/libs/select2/select2.js',
'resources/assets/vendor/libs/tagify/tagify.js'
])
@endsection

@section('page-script')
@vite('resources/assets/js/forms_tagify.js')
@endsection
@section('content')

@section('content')
<!-- Users List Table -->
<div class="row">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-header pb-1 mb-0 d-flex align-items-start justify-content-between gap-5">
        <div>
          <h3 class="card-title mb-1">Sector</h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{url('/dashboards')}}" class="d-flex align-items-center"><i class="mdi mdi-home-variant-outline text-body fs-4"></i></a>
              </li>
              <span class="text-black opacity-75 me-1 ms-1">
                <i class="mdi mdi-chevron-right fs-4"></i>
              </span>
              <li class="breadcrumb-item">
                <a href="javascript:;" class="d-flex align-items-center">Settings</a>
              </li>
            </ol>
          </nav>
        </div>
        <div class="d-flex justify-content-end align-items-center gap-2">
          <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary-outline border border-primary text-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_bulk_upload">
            <span class="me-2"><i class="mdi mdi-tray-arrow-up"></i></span>Bulk Upload
          </a>
          <a href="javascript:;" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_sector">
            <span class="me-2"><i class="mdi mdi-plus"></i></span>Add Sector
          </a>
        </div>
      </div>
      <div class="card-body py-0">
          <div class="row">
            <div class="col-lg-12">
              <table class="table align-middle table-row-dashed table-striped table-hover gy-0 gs-1 list_page">
                <thead>
                  <tr class="text-start align-top fw-bold fs-6 gs-0 bg-primary">
                    <th class="min-w-150px">Sector</th>
                    <th class="min-w-100px">Status</th>
                    <th class="min-w-100px">Action</th>
                  </tr>
                </thead>
                <tbody class="text-black fw-semibold fs-7">
                  <tr>
                    <td>
                      <label class="text-black fw-medium fs-7">OOD-FHSP</label>  
                      <a href="javascipt:;" data-bs-toggle="tooltip" data-bs-placement="right" title="-"><i class="mdi mdi mdi-help-circle text-dark"></i></a>
                    </td>
                    <td>
                      <label class="switch switch-square">
                        <input type="checkbox" class="switch-input" checked />
                        <span class="switch-toggle-slider">
                          <span class="switch-on"></span>
                          <span class="switch-off"></span>
                        </span>
                      </label>
                    </td>
                    <td>
                      <span class="text-end">
                        <a href="#" class="btn btn-icon btn-sm me-2" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_sector">
                          <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
                            <i class="mdi mdi-pencil-outline fs-3 text-black"></i>
                          </span>
                        </a>
                        <a href="#" class="btn btn-icon btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_delete_sector">
                          <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
                            <i class="mdi mdi-trash-can-outline fs-3 text-black"></i>
                          </span>
                        </a>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label class="text-black fw-medium fs-7">OOG-SHFP</label>  
                      <a href="javascipt:;" data-bs-toggle="tooltip" data-bs-placement="right" title="-"><i class="mdi mdi mdi-help-circle text-dark"></i></a>
                    </td>
                    <td>
                      <label class="switch switch-square">
                        <input type="checkbox" class="switch-input" checked />
                        <span class="switch-toggle-slider">
                          <span class="switch-on"></span>
                          <span class="switch-off"></span>
                        </span>
                      </label>
                    </td>
                    <td>
                      <span class="text-end">
                        <a href="#" class="btn btn-icon btn-sm me-2" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_sector">
                          <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
                            <i class="mdi mdi-pencil-outline fs-3 text-black"></i>
                          </span>
                        </a>
                        <a href="#" class="btn btn-icon btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_delete_sector">
                          <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
                            <i class="mdi mdi-trash-can-outline fs-3 text-black"></i>
                          </span>
                        </a>
                      </span>
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


<!--begin::Modal - Add Sector-->
<div class="modal fade" id="kt_modal_add_sector" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
    data-bs-backdrop="static" data-bs-focus="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-md">
        <!--begin::Modal content-->
      <div class="modal-content rounded">
        <!--begin::Modal header-->
        <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
          <h4 class="text-center text-black">Create Sector</h4>
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
                    <label class="text-black mb-1 fs-7 fw-semibold">Sector Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Sector Name" />
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Description</label>
                    <textarea class="form-control" rows="1" placeholder="Enter Description"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer pt-5">
          <div class="d-flex justify-content-end align-items-center">
            <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Create Sector</button>
          </div>
        </div>
        <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Add Sector-->

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

<!--begin::Modal - Edit Sector-->
<div class="modal fade" id="kt_modal_edit_sector" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
    data-bs-backdrop="static" data-bs-focus="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-md">
        <!--begin::Modal content-->
      <div class="modal-content rounded">
        <!--begin::Modal header-->
        <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
          <h4 class="text-center text-black">Update Sector</h4>
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
                    <label class="text-black mb-1 fs-7 fw-semibold">Sector Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter Sector Name" value="OOD-FHSP"/>
                </div>
                <div class="col-lg-12 mb-3">
                    <label class="text-black mb-1 fs-7 fw-semibold">Description</label>
                    <textarea class="form-control" rows="1" placeholder="Enter Description">-</textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer pt-5">
          <div class="d-flex justify-content-end align-items-center">
            <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Update Sector</button>
          </div>
        </div>
        <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Edit Sector-->


<!--begin::Modal - Delete Sector-->
<div class="modal fade pt-20" id="kt_modal_delete_sector" tabindex="-1" aria-hidden="true" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
  <!--begin::Modal dialog-->
  <div class="modal-dialog modal-m">
    <!--begin::Modal content-->
    <div class="modal-content rounded">
      <div class="swal2-icon swal2-danger swal2-icon-show" style="display: flex;">
        <div class="swal2-icon-content">
          <img src="{{ asset('assets/images/dustbin.ico') }}" alt="Dustbin Icon" class="w-100px h-100px"/>
        </div>
      </div>
      <div class="swal2-html-container" id="swal2-html-container" style="display: block;">Are you sure you want to delete Sector ?
        <div class="d-block fw-bold fs-5 py-2">
          <label class="text-danger">OOD-FHSP</label>
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
<!--end::Modal - Delete Sector-->

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
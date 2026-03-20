@extends('layouts/layoutMaster')
@section('style')
@section('title', 'General Settings')

@section('vendor-style')
@vite([
'resources/assets/vendor/libs/select2/select2.scss'
])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
'resources/assets/vendor/libs/select2/select2.js'
])
@endsection


@section('content')


<!-- Users List Table -->
<div class="card">
  <div class="card-header pb-1 mb-0 d-flex align-items-start justify-content-between gap-5">
    <div>
      <h3 class="card-title mb-1">General Settings</h3>
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
    <div class="d-flex justify-content-end align-items-center">
      <button type="submit" class="btn btn-primary">Update</button>
    </div>
  </div>
  <div class="card-body mx-1 my-0 py-0">
    <div class="container">
      <div class="row d-flex" style="column-gap: 20px;">
        <div class="col-lg-3 px-1 py-1 border border-gray-200 rounded">
          <div class="card px-0 py-0">
            <div class="card-header px-2 py-2 my-0 bg-gray-100">
              <label class="text-black fw-semibold fs-5">Brands</label>
            </div>
            <div class="card-body py-2 px-2">
              <div class="row">
                <div class="col-lg-12 mb-3">
                  <div class="row">
                    <label class="col-lg-12 text-black fs-6 fw-medium">Logo<span class="text-danger">*</span></label>
                    <div class="col-lg-12 text-center">
                      <div class="align-items-center gap-4">
                        <img src="{{asset('assets/images/logo/logo.png')}}" alt="user-avatar" class="w-px-120 h-px-120 rounded border border-gray-600 border-solid" id="uploadedlogo" />
                        <div class="button-wrapper">
                          <div class="d-flex align-items-center justify-content-center mt-2 mb-2">
                            <label for="upload" class="btn btn-sm btn-primary me-2" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Logo">
                              <i class="mdi mdi-tray-arrow-up"></i>
                              <input type="file" id="upload" class="file-in" hidden accept="image/png, image/jpeg" />
                            </label>
                            <button type="button" class="btn btn-sm btn-outline-danger file-reset" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Logo">
                              <i class="mdi mdi-reload"></i>
                            </button>
                          </div>
                          <div class="small">Allowed JPG, PNG. Max size of 800K</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="col-lg-12 mb-3">
                  <div class="row">
                    <label class="col-lg-12 text-black fs-6 fw-medium">Fav Icon<span class="text-danger">*</span></label>
                    <div class="col-lg-12 text-center">
                      <div class="align-items-center justify-content-center gap-4">
                        <img src="{{asset('assets/images/logo/logo.png')}}" alt="Fav Icon" class="w-px-120 h-px-120 rounded border border-gray-600 border-solid" id="fav_uploadedlogo" />
                        <div class="button-wrapper">
                          <div class="d-flex align-items-center justify-content-center mt-2 mb-2">
                            <label for="fav_upload" class="btn btn-sm btn-primary me-2" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Fav Icon">
                              <i class="mdi mdi-tray-arrow-up"></i>
                              <input type="file" id="fav_upload" class="fav_file-in" hidden accept="image/png, image/jpeg" />
                            </label>
                            <button type="button" class="btn btn-sm btn-outline-danger fav_file-reset" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Fav Icon">
                              <i class="mdi mdi-reload"></i>
                            </button>
                          </div>
                          <div class="small">Allowed JPG, PNG. Max size of 800K</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>  
          </div>
        </div>
        <div class="col-lg-8 px-1 py-1 border border-gray-200 rounded">
          <div class="card px-0 py-0">
            <div class="card-header px-2 py-2 my-0 bg-gray-100">
              <label class="text-black fw-semibold fs-5">Company</label>
            </div>
            <div class="card-body py-2 px-2">
              <div class="row mb-2">
                <div class="col-lg-6 mb-3">
                  <label class="text-black mb-1 fs-6 fw-medium">Title<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter Title" value="Walco Middle East" />
                </div>
                <div class="col-lg-6 mb-3">
                  <label class="text-black mb-1 fs-6 fw-medium">Mobile No<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter Mobile No" value="97455574404" />
                </div>
                <div class="col-lg-6 mb-3">
                  <label class="text-black mb-1 fs-6 fw-medium">Email ID</label>
                  <input type="text" class="form-control" placeholder="Enter Email ID" value="walco@walco.qa" />
                </div>
                <div class="col-lg-6 mb-3">
                  <label class="text-black mb-1 fs-6 fw-medium">Website (URL)<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter Website (URL)" value="https://walcomech.com/" />
                </div>
                <div class="col-lg-6 mb-2">
                  <label class="text-black mb-1 fs-6 fw-medium">Country<span class="text-danger">*</span></label>
                  <select class="select3 form-select">
                    <option value="">Select Country</option>
                    <option value="1">India</option>
                    <option value="2" selected>Qatar</option>
                    <option value="3">USA</option>
                    <option value="4">South Africa</option>
                  </select>
                </div>
                <div class="col-lg-6 mb-2">
                  <label class="text-black mb-1 fs-6 fw-medium">City<span class="text-danger">*</span></label>
                  <select class="select3 form-select">
                    <option value="">Select City</option>
                    <option value="1" selected>Doha</option>
                    <option value="2">Al Rayyan</option>
                    <option value="3">Umm Salal</option>
                    <option value="4">Al Daayen</option>
                    <option value="5">Lusail</option>
                  </select>
                </div>
              </div>
            </div>  
          </div> 
          <div class="card px-0 py-0">
            <div class="card-header px-2 py-2 my-0 bg-gray-100">
              <label class="text-black fw-semibold fs-5">Social Media Links</label>
            </div>
            <div class="card-body py-2 px-2">
              <div class="row mb-3">
                <div class="col-lg-6 mb-3">
                  <label class="text-black mb-1 fs-6 fw-medium">Instagram<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter Instagram" value="https://www.instagram.com/walcomiddleeastwll/" />
                </div>
                <div class="col-lg-6 mb-3">
                  <label class="text-black mb-1 fs-6 fw-medium">Facebook<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter Facebook" value="https://www.facebook.com/people/Walco-Middleeast-WLL/61584795872358/?mibextid=wwXIfr&rdid=E0ucwZobyRbYEc7v&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F17xX3jmJf4%2F%3Fmibextid%3DwwXIfr" />
                </div>
                <div class="col-lg-6 mb-3">
                  <label class="text-black mb-1 fs-6 fw-medium">LinkedIn<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter LinkedIn" value="https://www.linkedin.com/company/walcoqatar/" />
                </div>
                <div class="col-lg-6 mb-3">
                  <label class="text-black mb-1 fs-6 fw-medium">Youtube<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter Hot Lead Hold Days" value="https://www.youtube.com/@walcomiddleeastwll" />
                </div>
              </div>
            </div>  
          </div> 
        </div> 
      </div>
    </div>
  </div>
</div>
<!-- Logo File Upload Start -->
<script>
  let logofile = document.getElementById('uploadedlogo');
  const fileInput = document.querySelector('.file-in'),
    resetFileInput = document.querySelector('.file-reset');

  if (logofile) {
    const resetImage = logofile.src;
    fileInput.onchange = () => {
      if (fileInput.files[0]) {
        logofile.src = window.URL.createObjectURL(fileInput.files[0]);
      }
    };
    resetFileInput.onclick = () => {
      fileInput.value = '';
      logofile.src = resetImage;
    };
  }
</script>
<!-- Logo File Upload End -->
<!-- Fav Icon File Upload Start -->
<script>
  let faviconfile = document.getElementById('fav_uploadedlogo');
  const fav_fileInput = document.querySelector('.fav_file-in'),
    fav_resetFileInput = document.querySelector('.fav_file-reset');

  if (faviconfile) {
    const fav_resetImage = faviconfile.src;
    fav_fileInput.onchange = () => {
      if (fav_fileInput.files[0]) {
        faviconfile.src = window.URL.createObjectURL(fav_fileInput.files[0]);
      }
    };
    fav_resetFileInput.onclick = () => {
      fav_fileInput.value = '';
      faviconfile.src = fav_resetImage;
    };
  }
</script>


<!-- Fav Icon File Upload End -->

@endsection
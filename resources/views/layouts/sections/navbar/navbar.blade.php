@php
$containerNav = $containerNav ?? 'container-fluid';
$navbarDetached = ($navbarDetached ?? '');
@endphp

<style>
  .notify-header{
      position: relative;
      overflow: hidden;
      min-height: 100px;
  }

  .notify-header::before{
      content: "";
      position: absolute;
      top:0;
      left:0;
      width:100%;
      height:100%;
      background-image: url("{{ asset('assets/images/notify_bg.jpg') }}");
      background-size: cover;
      background-position: center;
      /* filter: blur(2px); */
      transform: scale(1.1);

      z-index:0;
  }

  .notify-header .dropdown-header{
      position: relative;
      z-index:1;
  }
</style>

<!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme" id="layout-navbar">
  @endif
  @if(isset($navbarDetached) && $navbarDetached == '')
  <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="{{$containerNav}}">
      @endif

      <!--  Brand demo (display only for navbar-full and hide on below xl) -->
      @if(isset($navbarFull))
      <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a href="{{url('/')}}" class="app-brand-link gap-2">
          <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'var(--bs-primary)'])</span>
          <span class="app-brand-text demo menu-text fw-bold">{{config('variables.templateName')}}</span>
        </a>
        @if(isset($menuHorizontal))
        <a href="javascript:;" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
          <i class="mdi mdi-close align-middle"></i>
        </a>
        @endif
      </div>
      @endif

      <!-- ! Not required for layout-without-menu -->
      @if(!isset($navbarHideToggle))
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
          <i class="mdi mdi-menu mdi-24px"></i>
        </a>
      </div>
      @endif

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        @if(!isset($menuHorizontal))
        <!-- Search -->
        <!-- <div class="navbar-nav align-items-center">
          <div class="nav-item navbar-search-wrapper mb-0">
            <a class="nav-item nav-link search-toggler fw-normal px-0" href="javascript:;">
              <i class="mdi mdi-magnify mdi-24px scaleX-n1-rtl"></i>
              <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
            </a>
          </div>
        </div> -->
        <!-- /Search -->
        @endif

        <ul class="navbar-nav flex-row align-items-center ms-auto">
          @if(isset($menuHorizontal))
          @endif
          @if($configData['hasCustomizer'] == true)
          
          @endif

          <!-- Notification -->
          <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-2 me-xl-1">
            <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow bg-gray-200"  href="javascript:;" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
              <i class="mdi mdi-bell-ring-outline mdi-24px"></i>
              <span class="position-absolute top-0 start-50 translate-middle-y badge badge-dot bg-danger mt-2 border"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end py-0">
              <li class="dropdown-menu-header border-bottom py-6 notify-header">
                <div class="dropdown-header d-flex align-items-end flex-column gap-2 py-3">
                    <h6 class="mb-0 text-white fs-4">Notification</h6>
                    <span class="badge rounded-pill bg-label-danger">8 New</span>
                </div>
              </li>
              
              <li class="dropdown-notifications-list scrollable-container">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item list-group-item-action dropdown-notifications-item">
                    <div class="d-flex gap-2">
                      <div class="flex-shrink-0">
                        <div class="avatar me-1">
                          <span class="avatar-initial rounded-circle bg-label-danger">
                            <i class="mdi mdi-alert-circle-outline"></i>
                          </span>
                        </div>
                      </div>
                      <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                        <h6 class="mb-1 text-truncate">Work Order Overdue</h6>
                        <small class="text-truncate text-body">
                          WO#13811979 – SRV Valve Overhaul is overdue. Assigned to Mohammed Fazil.
                        </small>
                      </div>
                      <div class="flex-shrink-0 dropdown-notifications-actions">
                        <small class="text-muted">10 min ago</small>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item list-group-item-action dropdown-notifications-item">
                    <div class="d-flex gap-2">
                      <div class="flex-shrink-0">
                        <div class="avatar me-1">
                          <span class="avatar-initial rounded-circle bg-label-warning">
                            <i class="mdi mdi-file-certificate-outline"></i>
                          </span>
                        </div>
                      </div>
                      <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                        <h6 class="mb-1 text-truncate">Permit Expiry Reminder</h6>
                        <small class="text-truncate text-body">
                          Hot Work Permit for Valve 11-SRV-1 will expire in 2 days.
                        </small>
                      </div>
                      <div class="flex-shrink-0 dropdown-notifications-actions">
                        <small class="text-muted">1 hr ago</small>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item list-group-item-action dropdown-notifications-item">
                    <div class="d-flex gap-2">
                      <div class="flex-shrink-0">
                        <div class="avatar me-1">
                          <span class="avatar-initial rounded-circle bg-label-info">
                            <i class="mdi mdi-account-alert-outline"></i>
                          </span>
                        </div>
                      </div>
                      <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                        <h6 class="mb-1 text-truncate">Resource Unavailable</h6>
                        <small class="text-truncate text-body">
                          Assigned technician Andrew is unavailable for WO#13811981.
                        </small>
                      </div>
                      <div class="flex-shrink-0 dropdown-notifications-actions">
                        <small class="text-muted">2 hrs ago</small>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item list-group-item-action dropdown-notifications-item">
                    <div class="d-flex gap-2">
                      <div class="flex-shrink-0">
                        <div class="avatar me-1">
                          <span class="avatar-initial rounded-circle bg-label-danger">
                            <i class="mdi mdi-shield-alert-outline"></i>
                          </span>
                        </div>
                      </div>
                      <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                        <h6 class="mb-1 text-truncate">Safety Non-Conformity</h6>
                        <small class="text-truncate text-body">
                          PPE non-compliance reported during SRV testing at FHSP plant.
                        </small>
                      </div>
                      <div class="flex-shrink-0 dropdown-notifications-actions">
                        <small class="text-muted">4 hrs ago</small>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item list-group-item-action dropdown-notifications-item">
                    <div class="d-flex gap-2">
                      <div class="flex-shrink-0">
                        <div class="avatar me-1">
                          <span class="avatar-initial rounded-circle bg-label-warning">
                            <i class="mdi mdi-package-variant"></i>
                          </span>
                        </div>
                      </div>
                      <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                        <h6 class="mb-1 text-truncate">Low Spare Stock</h6>
                        <small class="text-truncate text-body">
                          Relief Valve Spring (Part# RV-SPR-22) stock below threshold.
                        </small>
                      </div>
                      <div class="flex-shrink-0 dropdown-notifications-actions">
                        <small class="text-muted">1 day ago</small>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item list-group-item-action dropdown-notifications-item">
                    <div class="d-flex gap-2">
                      <div class="flex-shrink-0">
                        <div class="avatar me-1">
                          <span class="avatar-initial rounded-circle bg-label-primary">
                            <i class="mdi mdi-calendar-clock-outline"></i>
                          </span>
                        </div>
                      </div>
                      <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                        <h6 class="mb-1 text-truncate">Certificate Expiry</h6>
                        <small class="text-truncate text-body">
                          Calibration certificate for Pressure Gauge PG-22 expires in 5 days.
                        </small>
                      </div>
                      <div class="flex-shrink-0 dropdown-notifications-actions">
                        <small class="text-muted">2 days ago</small>
                      </div>
                    </div>
                  </li>
                </ul>
              </li>
              <li class="dropdown-menu-footer border-top px-2 py-5 bg-gray-200 d-flex align-items-center justify-content-between gap-1">
                <a href="javascript:;" class="btn btn-danger-outline text-danger border border-danger d-flex justify-content-center">
                  <i class="mdi mdi-delete-outline me-2 fs-5"></i>
                  Clear All
                </a>
                <a href="javascript:;" class="btn btn-primary d-flex justify-content-center">
                  <i class="mdi mdi-check-all me-2 fs-6"></i>
                  Mark As Read
                </a>
              </li>
            </ul>
          </li>
          <!-- <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-1 me-xl-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Notification">
            <a class="nav-link btn btn-text-secondary rounded-pill bg-gray-200 btn-icon dropdown-toggle hide-arrow" href="javascript:;" data-bs-toggle="offcanvas" data-bs-target="#notification_tab">
              <i class="mdi mdi-bell-ring-outline mdi-24px"></i>
              <span class="position-absolute top-0 start-50 translate-middle-y badge badge-dot bg-danger mt-2 border"></span>
            </a>
          </li> -->
          <!--/ Notification -->

          <!-- User -->
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:;" data-bs-toggle="dropdown">
              <div class="avatar avatar-online">
                <img src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('assets/images/auth/user_1.png') }}" alt class="w-px-40 h-px-40 rounded-circle border border-gray-400">
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="{{ Route::has('profile.show') ? route('profile.show') : url('pages/profile-user') }}">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-2">
                      <div class="avatar avatar-online">
                        <img src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('assets/images/auth/user_1.png') }}" alt class="w-px-40 h-px-40 rounded-circle">
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <span class="fw-medium d-block">Christopher</span>
                      <small class="text-muted">Super Admin</small>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#kt_modal_profile_update">
                  <span class="badge bg-label-primary rounded">
                    <i class="mdi mdi-account-outline"></i>
                  </span>
                  <span class="align-middle ms-2">My Profile</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{url('/')}}">
                  <span class="badge bg-label-primary rounded">
                    <i class='mdi mdi-logout'></i>
                  </span>
                  <span class="align-middle ms-2">Logout</span>
                </a>
              </li>
            </ul>
          </li>
          <!--/ User -->
        </ul>
      </div>

      <!-- Search Small Screens -->
      <div class="navbar-search-wrapper search-input-wrapper {{ isset($menuHorizontal) ? $containerNav : '' }} d-none">
        <input type="text" class="form-control search-input {{ isset($menuHorizontal) ? '' : $containerNav }} border-0" placeholder="Search..." aria-label="Search...">
        <i class="mdi mdi-close search-toggler cursor-pointer"></i>
      </div>
      @if(!isset($navbarDetached))
    </div>
    @endif
  </nav>
  <!-- / Navbar -->
<!--begin::Modal - Update My Profile-->
<div class="modal fade" id="kt_modal_profile_update" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
    data-bs-backdrop="static" data-bs-focus="false">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-md">
        <!--begin::Modal content-->
      <div class="modal-content rounded">
        <!--begin::Modal header-->
        <div class="modal-header d-flex align-items-center justify-content-between pb-0 border-bottom">
          <h4 class="text-center text-black">Update My Profile</h4>
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
                <div class="col-lg-6 mb-3 d-flex align-items-center justify-content-start gap-2">
                    <img src="{{ asset('assets/images/auth/user_1.png') }}" alt class="w-px-75 h-px-75 rounded-circle border border-gray-300">
                  <div class="d-flex align-items-start flex-column gap-1">
                    <label class="text-black fs-5 fw-semibold">Christopher</label>
                    <label class="text-dark fs-7 fw-semibold">Super Admin</label>
                  </div>
                </div>
                <div class="col-lg-6 mb-3 d-flex align-items-center justify-content-end">
                  <label for="upload" class="btn btn-sm btn-primary-outline border border-primary text-primary" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Logo">
                    <i class="mdi mdi-tray-arrow-up me-2"></i>
                    Change Profile
                    <input type="file" id="upload" class="file-in" hidden accept="image/png, image/jpeg" />
                  </label>
                </div>
                <div class="col-lg-12 mb-3">
                  <label class="text-black mb-1 fs-6 fw-medium">User Name<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter User Name" value="Christopher" />
                </div>
                <div class="col-lg-12 mb-3">
                  <label class="text-black mb-1 fs-6 fw-medium">Mobile No<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter Mobile No" value="97455574404" readonly/>
                </div>
            </div>
        </div>
        <div class="modal-footer pt-5">
          <div class="d-flex justify-content-end align-items-center">
            <button type="reset" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Update</button>
          </div>
        </div>
        <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Update My Profile-->
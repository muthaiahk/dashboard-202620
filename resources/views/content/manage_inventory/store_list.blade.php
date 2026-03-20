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
            <div class="d-flex align-items-center  justify-content-between">
                <h3 class="card-title mb-1">Manage Inventory</h3>
                <div class="searchBar" style="position: relative; width: 300px;">
                    <input class="form-control" type="text" name="searchQueryInput"
                        placeholder="Search Parts" value=""
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
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-lg-12">
                <div class="d-flex gap-4 align-items-center border-bottom ">
                    <a href="{{ url('/manage_inventory') }}">
                        <label class="fw-medium text-black fs-6  pb-2 cursor-pointer"  >Dashboard</label>
                    </a>
                    <a href="{{ url('/manage_inventory_valve') }}">
                        <label class="fw-medium text-black fs-6 pb-2 cursor-pointer" >Valves</label>
                    </a>
                    <a href="{{ url('/manage_inventory_spare_parts') }}">
                        <label class="fw-medium text-black fs-6 pb-2 cursor-pointer">Spare Parts</label>
                    </a>
                    <a href="{{ url('/manage_inventory_calibration') }}">
                        <label class="fw-medium text-black fs-6 pb-2 cursor-pointer">Calibration Queue</label>
                    </a>
                    <a href="{{ url('/store_management') }}">
                        <label class="fw-medium text-primary fs-6 pb-2 cursor-pointer" style="border-bottom:2px solid #4496C5;">Store Management</label>
                    </a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card rounded border d-flex flex-column bg-white">
                            <div class="card-header border-bottom d-flex justify-content-between align-items-start">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="rounded p-3" style="background:#e3f2fd; color:#0d47a1; ">
                                        <i class="mdi mdi-package-variant-closed fs-3"></i>
                                    </div>
                                    <label class="text-black fw-semibold fs-6">Spare Valve Vault</label>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <div class="card bg-gray-100 rounded mb-2 p-2">
                                    <div class="d-flex align-items-center justify-content-between gap-5">
                                        <div class="d-flex align-items-start flex-column">
                                            <label class="text-black fw-medium fs-7">SN-1001</label>
                                            <label class="text-dark fw-medium fs-7">Safety Relief Valve - 4"</label>
                                        </div>
                                        <span data-bs-toggle="modal" data-bs-target="#kt_modal_view_details">
                                            <i class="mdi mdi-eye fs-4 text-black"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                        
                    <div class="col-lg-6">
                        <div class="card rounded border d-flex flex-column bg-white">
                            <div class="card-header border-bottom d-flex justify-content-between align-items-start">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="rounded p-3" style="background:#e3f2fd; color:#0d47a1; ">
                                        <i class="mdi mdi-wrench-outline fs-3"></i>
                                    </div>
                                    <label class="text-black fw-semibold fs-6">Calibration Vault</label>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <div class="card bg-gray-100 rounded mb-2 p-2">
                                    <div class="d-flex align-items-center justify-content-between gap-5">
                                        <div class="d-flex align-items-start flex-column">
                                            <label class="text-black fw-medium fs-7">SN-1002</label>
                                            <label class="badge bg-label-warning fw-medium fs-7">Under Calibration</label>
                                        </div>
                                        <span data-bs-toggle="modal" data-bs-target="#kt_modal_view_details">
                                            <i class="mdi mdi-eye fs-4 text-black"></i>
                                        </span>
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


<script>

    function Add(btn){

        let counter =  btn.closest(".counter-box").querySelector(".counter-value");
        let count = parseInt(counter.innerText ,10);

        count++;
        counter.innerText = count.toString().padStart(2, '0');
        
    }

    function sub(btn){
        let counter = btn.closest(".counter-box").querySelector(".counter-value");
        let count = parseInt(counter.innerText , 10);

        if(count > 0){
            count--;
             counter.innerText = count.toString().padStart(2,'0');
        }
    }

</script>




@endsection
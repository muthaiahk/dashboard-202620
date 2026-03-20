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
                        <label class="fw-medium text-primary fs-6 pb-2 cursor-pointer" style="border-bottom:2px solid #4496C5;">Spare Parts</label>
                    </a>

                    <a href="{{ url('/manage_inventory_calibration') }}">
                        <label class="fw-medium text-black fs-6 pb-2 cursor-pointer">Calibration Queue</label>
                    </a>
                    <a href="{{ url('/store_management') }}">
                        <label class="fw-medium text-black fs-6 pb-2 cursor-pointer">Store Management</label>
                    </a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="p-3 rounded border d-flex flex-column bg-white">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="rounded p-3" style="background:#e3f2fd; color:#0d47a1; ">
                                        <i class="mdi mdi-package-variant-closed fs-3"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <label class="text-black fw-semibold fs-6">Gasket Kit 4"</label>
                                        <label class="text-secondary fw-semibold fs-8" >GK-400-J</label>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mdi mdi-map-marker text-secondary"></span>
                                        <label class="text-secondary fs-7 fw-semibold">Location</label>
                                    </div>
                                    <label class="text-black fs-7 fw-semibold">Bin A-12</label>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mdi mdi-cogs text-secondary"></span>
                                        <label class="text-secondary fs-7 fw-semibold">Compatible</label>
                                    </div>
                                    <label class="text-black fs-7 fw-semibold">Safety Relief Valve</label>
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex align-items-center justify-content-between counter-box">
                                <div class="d-flex flex-column">
                                    <label class="text-secondary fw-medium fs-8">In Stock</label>
                                    <label class="text-black fw-semibold fs-4 counter-value">01</label>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button class="btn btn-xs  py-1 btn-outline-secondary fs-4 text-nowrap" onclick="sub(this)">-</button>
                                    <button class="btn btn-xs  py-1 btn-primary fs-4" onclick="Add(this)">+</button>
                                </div>
                            </div>
                        </div>
                    </div>                        
                    <div class="col-lg-3">
                        <div class="p-3 rounded border d-flex flex-column bg-white">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="rounded p-3" style="background:#e3f2fd; color:#0d47a1; ">
                                        <i class="mdi mdi-package-variant-closed fs-3"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <label class="text-black fw-semibold fs-6">Stem 12" SS316</label>
                                        <label class="text-secondary fw-semibold fs-8" >ST-12-SS</label>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mdi mdi-map-marker text-secondary"></span>
                                        <label class="text-secondary fs-7 fw-semibold">Location</label>
                                    </div>
                                    <label class="text-black fs-7 fw-semibold">Rack B-04</label>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mdi mdi-cogs text-secondary"></span>
                                        <label class="text-secondary fs-7 fw-semibold">Compatible</label>
                                    </div>
                                    <label class="text-black fs-7 fw-semibold">Gate Valve</label>
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex align-items-center justify-content-between counter-box">
                                <div class="d-flex flex-column">
                                    <label class="text-secondary fw-medium fs-8">In Stock</label>
                                    <label class="text-black fw-semibold fs-4 counter-value" >02</label>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button class="btn btn-xs  py-1 btn-outline-secondary fs-4 text-nowrap" onclick="sub(this)" >-</button>
                                    <button class="btn btn-xs  py-1 btn-primary fs-4" onclick="Add(this)" >+</button>
                                </div>
                            </div>
                        </div>
                    </div>                        
                    <div class="col-lg-3">
                        <div class="p-3 rounded border d-flex flex-column bg-white">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="rounded p-3" style="background:#e3f2fd; color:#0d47a1; ">
                                        <i class="mdi mdi-package-variant-closed fs-3"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <label class="text-black fw-semibold fs-6">Graphite Packing 1/2"</label>
                                        <label class="text-secondary fw-semibold fs-8" >PKG-GR-05</label>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mdi mdi-map-marker text-secondary"></span>
                                        <label class="text-secondary fs-7 fw-semibold">Location</label>
                                    </div>
                                    <label class="text-black fs-7 fw-semibold">Bin C-01</label>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mdi mdi-cogs text-secondary"></span>
                                        <label class="text-secondary fs-7 fw-semibold">Compatible</label>
                                    </div>
                                    <label class="text-black fs-7 fw-semibold text-truncate" style="max-width:200px;"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Gate Valve, Globe Valve , Safety Relief Valve">Gate Valve, Globe Valve , Safety Relief Valve</label>
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex align-items-center justify-content-between counter-box">
                                <div class="d-flex flex-column">
                                    <label class="text-secondary fw-medium fs-8">In Stock</label>
                                    <label class="text-black fw-semibold fs-4 counter-value">52</label>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button class="btn btn-xs  py-1 btn-outline-secondary fs-4 text-nowrap" onclick="sub(this)" >-</button>
                                    <button class="btn btn-xs  py-1 btn-primary fs-4"  onclick="Add(this)">+</button>
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
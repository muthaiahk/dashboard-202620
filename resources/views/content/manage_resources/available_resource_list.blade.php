@extends('layouts/layoutMaster')

@section('title', 'Resource Availablity')

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
    .resource-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
    padding: 0rem;
    overflow-x: auto; 
}

.resource-card {
    background: #fff;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    display: flex;
    flex-direction: column;
    padding: 1rem 0rem;
    position: relative;
}

.avatar-status {
    display: flex;
    justify-content: space-between;
    align-items: start;
}

.avatar {
    width: 75px;
    height: 75px;
    background: #f0f0f0;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 24px;
}


.expired-badge{
    position:absolute;
    top:0px;
    right:0px;
    background: #ffcccc;
    color: #c00;
    font-size:0.7rem;
    padding:3px 8px;
    border-radius:4px;
    font-weight:600;
    z-index:2;
}

.name-role {
    display: flex;
    flex-direction: column;
    gap: 4px;
    align-items: center;
}

.name-role h6 {
    margin: 0;
    font-size: 1rem;
    font-weight: 500;
}

.role {
    font-size: 0.75rem;
    color: #000;
    border-radius: 50px;
    padding: 2px 4px;
    display: inline-block;
    margin-right: 0.5rem;
    background-color: #dbdbdb;
}

.status {
    font-size: 0.7rem;
    padding: 2px 4px;
    border-radius: 50px;
    font-weight: bold;
}

.status.active { background: #d4edda; color: #155724; }
.status.on-leave { background: #fff3cd; color: #856404; }

.card-body {
    margin-top: 0.5rem;
    font-size: 0.75rem;
}

.certifications, .permits {
    margin-top: 0.5rem;
}

.permit {
    background: #e8eaf6;
    color: #3f51b5;
    border: 1px solid #3f51b5;
    font-size: 0.65rem;
    padding:4px;
    border-radius: 4px;
    margin-right: 2px;
}

.expired {
    color: red;
    font-weight: bold;
    margin-left: 4px;
}

.card-footer {
    margin-top: none;
    padding: 0px;
    padding-top: 8px;
    text-align: center;
}

.btn-manage {
    background: transparent;
    border: none;
    padding: 2px 8px;
    font-size: 0.75rem;
    cursor: pointer;
}
</style>
<!-- Lead List Table -->
<div class="card card-action">
    <div class="card-header pb-1">
        <div class="card-action-title">
            <h3 class="card-title mb-1">Resource Availablity</h3>
            <div class="nav-align-top nav-tabs-shadow" >
                <ul class="nav nav-tabs" role="tablist" style="overflow-x:hidden !important;">
                    <li class="nav-item">
                        <a
                        href="{{ url('/manage_resources') }}"
                        type="button"
                        class="nav-link">
                        <span class="d-none d-sm-inline-flex align-items-center">
                            <i class="mdi mdi-account-outline me-2"></i>
                            Resources
                        </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                        href="{{ url('/manage_team') }}"
                        type="button"
                        class="nav-link">
                        <span class="d-none d-sm-inline-flex align-items-center">
                            <i class="mdi mdi-account-group-outline me-2"></i>
                            Team
                        </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                        href="{{ url('/resource_availability') }}"
                        type="button"
                        class="nav-link active">
                        <span class="d-none d-sm-inline-flex align-items-center">
                            <i class="mdi mdi-calendar-check-outline me-2"></i>
                            Resource Availability
                        </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-action-element">
            <div class="d-flex justify-content-end align-items-center mb-2 gap-2 flex-wrap">
                <div class="searchBar" style="position: relative; width: 300px;">
                    <input class="form-control" type="text" name="searchQueryInput" id="customSearchInput"
                        placeholder="Search Resources Name" value=""
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
                <a href="javascript:;" class="btn btn-sm fw-bold text-white btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_resources">
                    <span class="me-2"><i class="mdi mdi-plus"></i></span>Add Resources
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-2">
            <div class="col-lg-3">
                <div class="input-group input-group-merge">
                    <span class="input-group-text">
                        <i class="mdi mdi-calendar-month-outline fs-4"></i>
                    </span>
                    <input type="text" class="form-control common_datepicker" placeholder="Select Date" value="<?php echo date('d-M-Y')?>">
                </div>
            </div>
            <div class="col-lg-12">
                <table class="table align-middle table-row-dashed table-hover gy-0 gs-1 list_page">
                    <thead>
                        <tr class="text-center align-top fw-bold fs-6 gs-0 bg-gray-200">
                            <th class="min-w-100px text-black text-start">Resource Name</th>
                            <th class="min-w-100px text-black">Role</th>
                            <th class="min-w-100px text-black">Order ID</th>
                            <th class="min-w-100px text-black">Client</th>
                            <th class="min-w-100px text-black">Login Time</th>
                            <th class="min-w-100px text-black">Logout Time</th>
                            <th class="min-w-100px text-black">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-black fw-semibold fs-7 text-center">
                        @forelse($resources as $resource)
                        <tr>
                            <td class="text-start">
                                <div class="d-flex align-items-center gap-2">
                                    <img class="rounded-circle w-45px h-45px" src="{{ asset('assets/images/auth/user_1.png') }}" alt="Avatar">
                                    <div class="d-flex flex-column">
                                        <label class="text-black fw-medium fs-7">{{ $resource->name }}</label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <label class="badge bg-linkedin fs-8">{{ $resource->role->name ?? '--' }}</label>
                            </td>
                            <td>
                                <label class="text-dark fw-medium fs-7">--</label>
                            </td>
                            <td>
                                <label class="text-dark fw-medium fs-7">--</label>
                            </td>
                            <td>
                                <label class="text-success fw-medium fs-7">--</label>
                            </td>
                            <td>
                                <label class="text-danger fw-medium fs-7">--</label>
                            </td>
                            <td>
                                @if($resource->status == 1)
                                    <span class="badge rounded fs-8 fw-medium" style="border:1px solid #1d6103;color:#1d6103;background:#1e610318;">Active</span>
                                @elseif($resource->status == 2)
                                    <span class="badge rounded fs-8 fw-medium" style="border:1px solid #ff3232;color: #ff3232;background: #ff32322d;">Inactive</span>
                                @elseif($resource->status == 3)
                                    <span class="badge fs-8 fw-medium rounded" style="color: #3700ff; border: 1px solid #3700ff; background-color: #3700ff1a;">In Work</span>
                                @else
                                    <span class="badge bg-secondary fs-8">Unknown</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No specific availability records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    let table = $(".list_page").DataTable({
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

    $('#customSearchInput').on('keyup', function () {
        table.search(this.value).draw();
    });
</script>
@endsection
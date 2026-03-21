@extends('layouts/layoutMaster')
@section('style')
@section('title', 'General Settings')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js'])
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
                            <a href="{{ url('/dashboards') }}" class="d-flex align-items-center"><i
                                    class="mdi mdi-home-variant-outline text-body fs-4"></i></a>
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
                <button type="button" class="btn btn-primary" onclick="AddvalidateForm_topics()">Update</button>
            </div>
        </div>
        <div class="card-body mx-1 my-0 py-0">
            <div class="container">
                <form method="POST" id="add_gen_settings_form" action="{{ route('general_settings_add') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="update_sno"
                        value="{{ isset($general_data->id) && !empty($general_data->id) ? $general_data->id : '' }}">
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
                                                <label class="col-lg-12 text-black fs-6 fw-medium">Logo<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-12 text-center">
                                                    <div class="align-items-center gap-4">
                                                        <img src="{{ isset($general_data->logo) && !empty($general_data->logo) ? asset('assets/images/logo/' . $general_data->logo) : asset('assets/images/def_img.png') }}"
                                                            alt="Logo"
                                                            class="w-px-120 h-px-120 rounded border border-gray-600 border-solid update_lib-topic-icon_img"
                                                            id="update_lib_topic_icon_img" />
                                                        <div class="button-wrapper">
                                                            <input type="hidden" id="update_staff_file_add"
                                                                value="{{ isset($general_data->logo) && !empty($general_data->logo) ? $general_data->logo : '' }}">
                                                            <div
                                                                class="d-flex align-items-center justify-content-center mt-2 mb-2">
                                                                <label class="btn btn-sm btn-primary me-2" tabindex="0"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Upload File">
                                                                    <i class="mdi mdi-tray-arrow-up"></i>
                                                                    <input type="file" name='lib_topic_icon'
                                                                        id="update_lib_topic_icon"
                                                                        class="file-in update_lib_topic_icon_cls lib-topic-icon"
                                                                        hidden accept="image/png, image/jpeg" />
                                                                </label>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-danger update_staff-add-reset"
                                                                    data-bs-toggle="tooltip" id="update_staff-add-reset"
                                                                    data-bs-placement="top" title="Reset Logo">
                                                                    <i class="mdi mdi-reload"></i>
                                                                </button>
                                                            </div>
                                                            <div class="small">Allowed JPG, PNG. Max size of 800K</div>
                                                        </div>
                                                    </div>
                                                    <div class="text-danger" id="update_topic_icon_err"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-lg-12 mb-3">
                                            <div class="row">
                                                <label class="col-lg-12 text-black fs-6 fw-medium">Fav Icon<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-12 text-center">
                                                    <div class="align-items-center gap-4">
                                                        <img src="{{ isset($general_data->fav_icon) && !empty($general_data->fav_icon) ? asset('assets/images/logo/' . $general_data->fav_icon) : asset('assets/images/def_img.png') }}"
                                                            alt="Fav Icon"
                                                            class="w-px-120 h-px-120 rounded border border-gray-600 border-solid update_lib-topic-icon_img"
                                                            id="update_fav_icon_img" />
                                                        <div class="button-wrapper">
                                                            <input type="hidden" id="update_fav_icon_file_add"
                                                                value="{{ isset($general_data->fav_icon) && !empty($general_data->fav_icon) ? $general_data->fav_icon : '' }}">
                                                            <div
                                                                class="d-flex align-items-center justify-content-center mt-2 mb-2">
                                                                <label class="btn btn-sm btn-primary me-2" tabindex="0"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Upload File">
                                                                    <i class="mdi mdi-tray-arrow-up"></i>
                                                                    <input type="file" name='lib_fav_topic_icon'
                                                                        id="update_fav_icon"
                                                                        class="file-in update_lib_topic_icon_cls lib-topic-icon"
                                                                        hidden accept="image/png, image/jpeg" />
                                                                </label>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-danger update_fav_icon-add-reset"
                                                                    data-bs-toggle="tooltip" id="update_fav_icon-add-reset"
                                                                    data-bs-placement="top" title="Reset Logo">
                                                                    <i class="mdi mdi-reload"></i>
                                                                </button>
                                                            </div>
                                                            <div class="small">Allowed JPG, PNG. Max size of 800K</div>
                                                        </div>
                                                    </div>
                                                    <div class="text-danger" id="update_fav_icon_err"></div>
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
                                            <label class="text-black mb-1 fs-6 fw-medium">Title<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="add_title"
                                                placeholder="Enter Title" id="add_title"
                                                value="{{ isset($general_data->title) && !empty($general_data->title) ? $general_data->title : '' }}" />
                                            <div id="add_title_error"></div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-6 fw-medium">Mobile No<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="add_mob_no"
                                                placeholder="Enter Mobile No" id="add_mob_no"
                                                value="{{ isset($general_data->mobile_number) && !empty($general_data->mobile_number) ? $general_data->mobile_number : '' }}" />
                                            <div id="add_mob_no_error"></div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-6 fw-medium">Email ID</label>
                                            <input type="text" class="form-control" name="add_email"
                                                placeholder="Enter Email ID" id="add_email"
                                                value="{{ isset($general_data->email_id) && !empty($general_data->email_id) ? $general_data->email_id : '' }}" />
                                            <div id="add_email_error"></div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-6 fw-medium">Website (URL)<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="add_website"
                                                placeholder="Enter Website (URL)" id="add_website"
                                                value="{{ isset($general_data->website_link) && !empty($general_data->website_link) ? $general_data->website_link : '' }}" />
                                            <div id="add_website_error"></div>
                                        </div>
                                        <div class="col-lg-6 mb-2">
                                            <label class="text-black mb-1 fs-6 fw-medium">Country<span
                                                    class="text-danger">*</span></label>
                                            <select class="select3 form-select" name="add_country" id="add_country"
                                                onchange="get_state_list('add_state','{{ isset($general_data->state_id) && !empty($general_data->state_id) ? $general_data->state_id : '' }}')">
                                                <option value="">Select Country</option>
                                            </select>
                                            <div id="add_country_error"></div>
                                        </div>
                                        <div class="col-lg-6 mb-2">
                                            <label class="text-black mb-1 fs-6 fw-medium">State<span
                                                    class="text-danger">*</span></label>
                                            <select class="select3 form-select" name="add_state" id="add_state"
                                                onchange="get_city_list('add_city','{{ isset($general_data->city_id) && !empty($general_data->city_id) ? $general_data->city_id : '' }}')">
                                                <option value="">Select State</option>
                                            </select>
                                            <div id="add_state_error"></div>
                                        </div>
                                        <div class="col-lg-6 mb-2">
                                            <label class="text-black mb-1 fs-6 fw-medium">City<span
                                                    class="text-danger">*</span></label>
                                            <select class="select3 form-select" name="add_city"id="add_city">
                                                <option value="">Select City</option>
                                            </select>
                                            <div id="add_city_error"></div>
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
                                            <label class="text-black mb-1 fs-6 fw-medium">Instagram<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="add_intagram_url"
                                                placeholder="Enter Instagram" id="add_intagram_url"
                                                value="{{ isset($general_data->instagram_link) && !empty($general_data->instagram_link) ? $general_data->instagram_link : '' }}" />
                                            <div id="add_intagram_url_error"></div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-6 fw-medium">Facebook<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="add_fb_url"
                                                placeholder="Enter Facebook" id="add_fb_url"
                                                value="{{ isset($general_data->facebook_link) && !empty($general_data->facebook_link) ? $general_data->facebook_link : '' }}" />
                                            <div id="add_fb_url_error"></div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-6 fw-medium">LinkedIn<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                name="add_linkedin_url"placeholder="Enter LinkedIn" id="add_linkedin_url"
                                                value="{{ isset($general_data->linkedin_link) && !empty($general_data->linkedin_link) ? $general_data->linkedin_link : '' }}" />
                                            <div id="add_linkedin_url_error"></div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-black mb-1 fs-6 fw-medium">Youtube<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="add_youtube_url"
                                                placeholder="Enter Youtube" id="add_youtube_url"
                                                value="{{ isset($general_data->youtube_link) && !empty($general_data->youtube_link) ? $general_data->youtube_link : '' }}" />
                                            <div id="add_youtube_url_error"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!-- Logo File Upload Start -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <style>
        /* Customize Toastr container */
        .toast {
            background-color: #39484f;
        }

        /* Customize Toastr notification */
        .toast-success {
            background-color: green;
        }

        /* Customize Toastr notification */
        .toast-error {
            background-color: red;
        }
    </style>

    <script>
        // Display Toastr messages
        @if (Session::has('toastr'))
            var type = "{{ Session::get('toastr')['type'] }}";
            var message = "{{ Session::get('toastr')['message'] }}";
            toastr[type](message);
        @endif
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('input', '[id^="add_mob_no"]', function() {
                this.value = this.value.replace(/\D/g, '');
            });
        });

        get_country_list('add_country',
            '{{ isset($general_data->country_id) && !empty($general_data->country_id) ? $general_data->country_id : '' }}'
            );

        // Edit Options
        const UpdatestaffDefault = "{{ asset('assets/images/def_img.png') }}";
        $("#update_lib_topic_icon").on("change", function() {
            const file = this.files[0];
            if (file) {
                $("#update_lib_topic_icon_img").attr("src", URL.createObjectURL(file));
                $("#update_staff_file_add").val(file.name);
            }
        });

        $(".update_staff-add-reset").on("click", function() {
            $("#update_lib_topic_icon").val("");
            $("#update_lib_topic_icon_img").attr("src", UpdatestaffDefault);
            $("#update_staff_file_add").val("");
        });

        $("#update_fav_icon").on("change", function() {
            const file = this.files[0];
            if (file) {
                $("#update_fav_icon_img").attr("src", URL.createObjectURL(file));
                $("#update_fav_icon_file_add").val(file.name);
            }
        });

        $(".update_fav_icon-add-reset").on("click", function() {
            $("#update_fav_icon").val("");
            $("#update_fav_icon_img").attr("src", UpdatestaffDefault);
            $("#update_fav_icon_file_add").val("");
        });

        function AddvalidateForm_topics() {

            var errorMessage = 0;
            $('.errorMessage').remove();

            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            var urlPattern = /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([\/\w .-]*)*\/?$/i;
            var facebookPattern = /^(https?:\/\/)?(www\.)?facebook\.com\/[A-Za-z0-9._%-]+\/?$/i;
            var instagramPattern = /^(https?:\/\/)?(www\.)?instagram\.com\/[A-Za-z0-9._%-]+\/?$/i;
            var linkedinPattern = /^(https?:\/\/)?(www\.)?linkedin\.com\/(in|company)\/[A-Za-z0-9_-]+\/?$/i;
            var youtubePattern =
                /^(https?:\/\/)?(www\.)?(youtube\.com\/(channel|c|user)\/[A-Za-z0-9_-]+|youtu\.be\/[A-Za-z0-9_-]+)\/?$/i;

            var add_title = document.getElementById('add_title').value.trim();
            var add_mob_no = document.getElementById('add_mob_no').value.trim();
            var add_email = document.getElementById('add_email').value.trim();
            var add_website = document.getElementById('add_website').value.trim();
            var add_country = document.getElementById('add_country').value.trim();
            var add_state = document.getElementById('add_state').value.trim();
            var add_city = document.getElementById('add_city').value.trim();
            var add_intagram_url = document.getElementById('add_intagram_url').value.trim();
            var add_fb_url = document.getElementById('add_fb_url').value.trim();
            var add_linkedin_url = document.getElementById('add_linkedin_url').value.trim();
            var add_youtube_url = document.getElementById('add_youtube_url').value.trim();

            if (add_title === '') {
                $('#add_title_error').after('<div class="text-danger errorMessage mt-1">Title is Required..!</div>');
                errorMessage = 1;
            }

            if (add_mob_no === '') {
                $('#add_mob_no_error').after('<div class="text-danger errorMessage mt-1">Mobile No is Required..!</div>');
                errorMessage = 1;
            }

            if (add_email === '') {
                // $('#add_email_error').after('<div class="text-danger errorMessage mt-1">Email ID is Required..!</div>');
                // errorMessage = 1;
            } else if (!emailPattern.test(add_email)) {
                $('#add_email_error').after(
                    `<div class="text-danger errorMessage mt-1">Please Enter valid Email ID..!</div>`);
                errorMessage = 1;
            }

            if (add_website === '') {
                $('#add_website_error').after(
                '<div class="text-danger errorMessage mt-1">Website URL is Required..!</div>');
                errorMessage = 1;
            } else if (!urlPattern.test(add_website)) {
                $('#add_website_error').after(
                    `<div class="text-danger errorMessage mt-1">Please Enter valid Website URL..!</div>`);
                errorMessage = 1;
            }

            if (add_country === '') {
                $('#add_country_error').after('<div class="text-danger errorMessage mt-1">Country is Required..!</div>');
                errorMessage = 1;
            }

            if (add_state === '') {
                $('#add_state_error').after('<div class="text-danger errorMessage mt-1">State is Required..!</div>');
                errorMessage = 1;
            }

            if (add_city === '') {
                $('#add_city_error').after('<div class="text-danger errorMessage mt-1">City is Required..!</div>');
                errorMessage = 1;
            }

            if (add_intagram_url === '') {
                // $('#add_intagram_url_error').after('<div class="text-danger errorMessage mt-1">Email ID is Required..!</div>');
                // errorMessage = 1;
            } else if (!instagramPattern.test(add_intagram_url)) {
                $('#add_intagram_url_error').after(
                    `<div class="text-danger errorMessage mt-1">Please Enter valid Instagram URL..!</div>`);
                errorMessage = 1;
            }

            if (add_fb_url === '') {
                // $('#add_fb_url_error').after('<div class="text-danger errorMessage mt-1">Email ID is Required..!</div>');
                // errorMessage = 1;
            } else if (!facebookPattern.test(add_fb_url)) {
                $('#add_fb_url_error').after(
                    `<div class="text-danger errorMessage mt-1">Please Enter valid Facebook URL..!</div>`);
                errorMessage = 1;
            }

            if (add_linkedin_url === '') {
                // $('#add_linkedin_url_error').after('<div class="text-danger errorMessage mt-1">Email ID is Required..!</div>');
                // errorMessage = 1;
            } else if (!linkedinPattern.test(add_linkedin_url)) {
                $('#add_linkedin_url_error').after(
                    `<div class="text-danger errorMessage mt-1">Please Enter valid Linkedin URL..!</div>`);
                errorMessage = 1;
            }

            if (add_youtube_url === '') {
                // $('#add_youtube_url_error').after('<div class="text-danger errorMessage mt-1">Email ID is Required..!</div>');
                // errorMessage = 1;
            } else if (!youtubePattern.test(add_youtube_url)) {
                $('#add_youtube_url_error').after(
                    `<div class="text-danger errorMessage mt-1">Please Enter valid Youtube URL..!</div>`);
                errorMessage = 1;
            }

            if (!validateFile('update_lib_topic_icon', 'update_topic_icon_err', ['image/jpeg', 'image/png'], ['jpg', 'jpeg',
                    'png'
                ], 'update_staff_file_add', true)) errorMessage = 1;

            if (!validateFile('update_fav_icon', 'update_fav_icon_err', ['image/jpeg', 'image/png'], ['jpg', 'jpeg', 'png'],
                    'update_fav_icon_file_add', true)) errorMessage = 1;

            if (errorMessage == 0) {
                $('#add_gen_settings_form').submit();
            } else {
                return false;
            }
        }

        function validateFile(
            inputId,
            errorId,
            allowedTypes,
            allowedExt,
            hiddenId = null,
            required = false,
            maxSizeMB = 1
        ) {
            const input = document.getElementById(inputId);
            const error = document.getElementById(errorId);
            const hiddenVal = hiddenId ? document.getElementById(hiddenId)?.value : '';

            if (!input || !error) return false;

            error.innerText = '';

            // ✅ Required check (for create & update)
            if (required && input.files.length === 0 && !hiddenVal) {
                error.innerText = 'File is required';
                return false;
            }

            // ✅ If no file selected, skip further validation
            if (input.files.length === 0) {
                return true;
            }

            const file = input.files[0];
            const mime = file.type;
            const ext = file.name.split('.').pop().toLowerCase();

            // ✅ Type check
            if (!allowedTypes.includes(mime) || !allowedExt.includes(ext)) {
                error.innerText = `Invalid file type. Allowed: ${allowedExt.join(', ').toUpperCase()}`;
                // input.value = '';
                return false;
            }

            // ✅ Size check
            const maxSizeBytes = maxSizeMB * 1024 * 1024;
            if (file.size > maxSizeBytes) {
                error.innerText = `File size must be less than ${maxSizeMB} MB`;
                // input.value = '';
                return false;
            }

            return true;
        }

        function get_country_list(field_id = 'add_country', select_val = '') {
            $.ajax({
                url: "{{ url('/settings/country/list') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status === 200 && response.data) {
                        var selectDropdown = $(`#${field_id}`);
                        selectDropdown.empty();
                        selectDropdown.append($(
                            '<option value="">Select Country</option>'));
                        response.data.forEach(function(dept) {
                            selectDropdown.append($('<option></option>').attr('value', dept.id).text(
                                dept.name));
                        });
                        selectDropdown.val(select_val).change();
                    }
                },
                error: function(error) {
                    selectDropdown.append($('<option value="">Select Country</option>'));
                }
            });
        }

        function get_state_list(field_id = 'add_state', select_val = '') {

            var country_id = $('#add_country').val();

            $.ajax({
                url: "{{ url('/settings/state/list') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'country_id': country_id
                },
                success: function(response) {
                    if (response.status === 200 && response.data) {
                        var selectDropdown = $(`#${field_id}`);
                        selectDropdown.empty();
                        selectDropdown.append($(
                            '<option value="">Select State</option>'));
                        response.data.forEach(function(dept) {
                            selectDropdown.append($('<option></option>').attr('value', dept.id).text(
                                dept.name));
                        });
                        selectDropdown.val(select_val).change();
                    }
                },
                error: function(error) {
                    selectDropdown.append($('<option value="">Select State</option>'));
                }
            });
        }

        function get_city_list(field_id = 'add_city', select_val = '') {

            var state_id = $('#add_state').val();

            $.ajax({
                url: "{{ url('/settings/city/list') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'state_id': state_id
                },
                success: function(response) {
                    if (response.status === 200 && response.data) {
                        var selectDropdown = $(`#${field_id}`);
                        selectDropdown.empty();
                        selectDropdown.append($(
                            '<option value="">Select City</option>'));
                        response.data.forEach(function(dept) {
                            selectDropdown.append($('<option></option>').attr('value', dept.id).text(
                                dept.name));
                        });
                        selectDropdown.val(select_val).change();
                    }
                },
                error: function(error) {
                    selectDropdown.append($('<option value="">Select City</option>'));
                }
            });
        }
    </script>
    <!-- Fav Icon File Upload End -->
@endsection

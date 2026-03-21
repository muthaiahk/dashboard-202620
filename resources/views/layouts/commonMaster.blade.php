<!DOCTYPE html>
@php
    $menuFixed =
        $configData['layout'] === 'vertical'
            ? $menuFixed ?? ''
            : ($configData['layout'] === 'front'
                ? ''
                : $configData['headerType']);
    $navbarType =
        $configData['layout'] === 'vertical'
            ? $configData['navbarType']
            : ($configData['layout'] === 'front'
                ? 'layout-navbar-fixed'
                : '');
    $isFront = ($isFront ?? '') == true ? 'Front' : '';
    $contentLayout = isset($container) ? ($container === 'container-xxl' ? 'layout-compact' : 'layout-wide') : '';
@endphp

<html id="project_tag" lang="{{ session()->get('locale') ?? app()->getLocale() }}"
    class="{{ $configData['style'] }}-style {{ $contentLayout ?? '' }} {{ $navbarType ?? '' }} {{ $menuFixed ?? '' }} {{ $menuCollapsed ?? '' }} {{ $menuFlipped ?? '' }} {{ $menuOffcanvas ?? '' }} {{ $footerFixed ?? '' }} {{ $customizerHidden ?? '' }}"
    dir="{{ $configData['textDirection'] }}" data-theme="{{ $configData['theme'] }}"
    data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{ url('/') }}" data-framework="laravel"
    data-template="{{ $configData['layout'] . '-menu-' . $configData['themeOpt'] . '-' . $configData['styleOpt'] }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>SRV | @yield('title')</title>
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <!-- laravel CRUD token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Canonical SEO -->
    <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo/fav_logo.png') }}" />
    <link href="{{ url('assets/custom_file/swal2.css') }}" rel="stylesheet" type="text/css" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- jQuery FIRST -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Include Styles -->
    <!-- $isFront is used to append the front layout styles only on the front layout otherwise the variable will be blank -->
    @include('layouts/sections/styles' . $isFront)

    <!-- Include Scripts for customizer, helper, analytics, config -->
    <!-- $isFront is used to append the front layout scriptsIncludes only on the front layout otherwise the variable will be blank -->
    @include('layouts/sections/scriptsIncludes' . $isFront)

</head>
<style>
    .empty-state {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 60vh;
        background: #f8f9fa;
        border-radius: 12px;
        text-align: center;
    }

    .empty-box {
        padding: 40px;
    }

    .empty-icon {
        font-size: 70px;
        color: #dee2e6;
        margin-bottom: 20px;
    }

    .empty-title {
        font-size: 28px;
        font-weight: 600;
        color: #343a40;
        margin-bottom: 10px;
    }

    .empty-text {
        font-size: 16px;
        color: #6c757d;
        margin-bottom: 20px;
    }

    .empty-btn {
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 6px;
        background: #007bff;
        color: #fff;
        border: none;
        transition: 0.3s;
    }

    .empty-btn:hover {
        background: #0056b3;
    }
</style>
<style>
    .txt_vertical {
        writing-mode: vertical-lr;
    }

    .overlay-wrapper {
        position: relative;
        overflow: hidden;
        display: block;
        text-align: center;
    }

    .overlay-layer {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .overlay-layer:hover {
        opacity: 1;
    }

    .overlay-layer i {
        color: rgb(37, 33, 33);
        font-size: 24px;
    }

    .download-image {
        /* background-image:url('{{ asset('/assets/eapl_images/def_pdf.png') }}'); */
        position: relative;
        background-size: cover;
        background-position: center;
    }

    .dataTables_scroll {
        position: relative;
        overflow: auto;
        /* max-height: 218px; */
        /*the maximum height you want to achieve*/
        width: 100%;
    }

    .dataTables_scroll thead {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        /* background-color: #ec9629 !important; */
        z-index: 2;
    }

    .text-justify {
        text-align: justify !important;
    }

    .chse_me_card_btt {
        /* position: relative;
    overflow: hidden; */
        transition: height 0.4s ease;
    }

    .chse_me_btt {
        overflow: hidden;
        max-height: 0;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
    }

    .chse_me_card_btt:hover {
        height: auto;
        background-color: rgb(240, 240, 240) !important;
    }

    .chse_me_card_btt:hover .chse_me_btt {
        max-height: 100% !important;
        opacity: 1;
        transform: translateY(0);
    }

    .cal_btt:hover {
        background-color: #ebebeb !important;
    }

    .svg-hover:hover .svgShape {
        stroke: #888888;
        fill: rgb(230, 230, 230);
    }

    .svgShape {
        transition: stroke 0.3s ease;
    }

    .status-toggle {
        transition: all 0.3s ease;
    }
</style>
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

    .error_msg {
        border: solid 2px red !important;
        border-color: red !important;
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
<script src="{{ url('assets/custom_file/dataTables.js') }}"></script>
<script src="{{ url('assets/custom_file/dataTables.bootstrap5.js') }}"></script>
<!-- <script src="{{ url('assets/custom_file/fslightbox.bundle.js') }}"></script> -->
<script src="{{ url('assets/custom_file/chart/apex_chart.js') }}"></script>


<body>

    <!-- Layout Content -->
    @yield('layoutContent')
    <!--/ Layout Content -->



    <!-- Include Scripts -->
    <!-- $isFront is used to append the front layout scripts only on the front layout otherwise the variable will be blank -->
    @include('layouts/sections/scripts' . $isFront)
    <!-- <script>
        const textarea = document.querySelector("txt_area");
        autosize(textarea);
    </script> -->
    <!-- Modal Dropdown box start -->
    <script>
        'use strict';
        $(function() {
            const select2 = $('.select3');
            if (select2.length) {
                select2.each(function() {
                    var $this = $(this);
                    select2Focus($this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        // placeholder: 'Select value',
                        dropdownParent: $this.parent()
                    });
                });
            }
        });
    </script>
    <!-- Modal Dropdown box end -->
    <!-- Modal Dropdown box(Multi Select) start -->
    <script>
        'use strict';
        $(function() {
            const select2 = $('.select4');
            if (select2.length) {
                select2.each(function() {
                    var $this = $(this);
                    select2Focus($this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: 'Select',
                        dropdownParent: $this.parent()
                    });
                });
            }
        });
    </script>


    <script>
        // $(document).ready(function () {
        //     $('.common_datepicker').datepicker({
        //         todayHighlight: true,
        //         autoclose: true,  
        //         format: 'dd-M-yyyy' // Match the 'd-M-yyyy' format from Flatpickr
        //     });
        // });

        document.addEventListener("DOMContentLoaded", function() {
            flatpickr(".common_datepicker", {
                dateFormat: "d-M-Y"
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            flatpickr(".common_datetime_picker", {
                enableTime: true,
                dateFormat: "d-M-Y h:i K", // e.g. 17-Jul-2025 03:45 PM
                time_24hr: false,
                altInput: true,
                altFormat: "d-M-Y h:i K",
                defaultHour: 12,
                defaultMinute: 0
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr(".common_timepicker", {
                enableTime: true,
                noCalendar: true, // Time picker only
                dateFormat: "h:i K", // Format like 01:30 PM
                defaultHour: 12,
                defaultMinute: 0,
                minuteIncrement: 5 // Optional: change increment
            });
        });
    </script>

    <script>
        document.querySelectorAll(".modern-dropzone").forEach(dropzone => {
            const fileInput = dropzone.querySelector(".file-input");
            const preview = dropzone.querySelector(".file-preview-list");

            let uploadedFiles = [];

            // Click
            dropzone.querySelector(".upload-area").addEventListener("click", () => {
                fileInput.click();
            });

            // File select
            fileInput.addEventListener("change", (e) => {
                handleFiles(e.target.files);
                fileInput.value = "";
            });

            // Drag
            dropzone.addEventListener("dragover", (e) => {
                e.preventDefault();
                dropzone.style.borderColor = "#0d6efd";
            });

            dropzone.addEventListener("dragleave", () => {
                dropzone.style.borderColor = "#d1d5db";
            });

            dropzone.addEventListener("drop", (e) => {
                e.preventDefault();
                dropzone.style.borderColor = "#d1d5db";
                handleFiles(e.dataTransfer.files);
            });

            function handleFiles(files) {
                Array.from(files).forEach(file => {

                    if (uploadedFiles.find(f => f.name === file.name)) return;

                    uploadedFiles.push(file);
                    createFileCard(file);
                });
            }

            function createFileCard(file) {

                const card = document.createElement("div");
                card.className = "file-card";

                card.innerHTML = `
            <div style="width:100%">
                <div class="file-left">
                    <i class="mdi mdi-file file-icon"></i>
                    <div>
                        <div class="file-name">${file.name}</div>
                        <div class="file-status">Uploading...</div>
                    </div>
                </div>

                <div class="progress-bar-container">
                    <div class="progress-bar"></div>
                </div>
            </div>

            <div class="remove-btn">✕</div>
        `;

                preview.appendChild(card);

                const progressBar = card.querySelector(".progress-bar");
                const statusText = card.querySelector(".file-status");

                let progress = 0;

                const interval = setInterval(() => {
                    progress += 10;
                    progressBar.style.width = progress + "%";

                    if (progress >= 100) {
                        clearInterval(interval);
                        statusText.innerText = "Uploaded";
                        progressBar.style.background = "#22c55e";
                    }
                }, 200);

                // Remove
                card.querySelector(".remove-btn").addEventListener("click", (e) => {
                    e.stopPropagation();
                    card.remove();
                    uploadedFiles = uploadedFiles.filter(f => f.name !== file.name);
                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {

            $("#status_badge").click(function() {

                $(this).fadeOut(150, function() {

                    if ($(this).hasClass("bg-label-success")) {

                        $(this)
                            .removeClass("bg-label-success border-success")
                            .addClass("bg-label-danger border-danger")
                            .html('<i class="mdi mdi-alpha-x text-danger"></i> Inactive');

                    } else {

                        $(this)
                            .removeClass("bg-label-danger border-danger")
                            .addClass("bg-label-success border-success")
                            .html('<i class="mdi mdi-check text-success"></i> Active');

                    }

                    $(this).fadeIn(150);

                });

            });

        });
    </script>
    <script>
        $('[data-bs-toggle="tooltip"]').on("mouseleave", function() {
            $(this).tooltip("hide");
        })
    </script>


</body>

</html>

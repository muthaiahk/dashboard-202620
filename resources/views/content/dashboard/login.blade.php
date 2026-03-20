@extends('layouts/blankLayout')

@section('title', 'Login')

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
    @vite(['resources/js/app.js'])
@endsection


@section('content')
    <style>
        .log_bg_img {
            background-image: url('{{ asset('assets/images/logo/login_img_1.jpg') }}');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        .error-text {
            color: red;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>

    <div class="authentication-wrapper authentication-cover log_bg_img">
        <div class="authentication-inner row m-0">
            <div class="d-none d-lg-flex col-lg-6 align-items-center justify-content-center p-5"></div>

            <div class="d-flex col-12 col-lg-6 align-items-center px-4">
                <div class="w-px-400 mx-auto">
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/images/logo/logo_2.png') }}" class="w-250px mb-3" />
                        <h5 class="fw-semibold">Precision • Reliability • Safety</h5>
                    </div>

                    <div class="mb-3">
                        <label class="text-black mb-1 fs-6 fw-semibold">
                            Mobile Number <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="mobile_number" class="form-control" placeholder="Enter Mobile Number"
                            autofocus />
                        <div id="mobile_error" class="error-text"></div>
                    </div>

                    <button id="sendOtpBtn" class="btn btn-primary w-100">
                        <span id="btn-text">Continue</span>
                        <span id="btn-spinner" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                        <i class="mdi mdi-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#sendOtpBtn').click(function() {
                let mobile = $('#mobile_number').val().trim();
                $('#mobile_error').text('');

                if (mobile === '') {
                    $('#mobile_error').text('Please enter your mobile number');
                    return;
                }

                $('#btn-text').addClass('d-none');
                $('#btn-spinner').removeClass('d-none');
                $('#sendOtpBtn').prop('disabled', true);

                $.ajax({
                    url: "{{ url('/send-otp') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        mobile_number: mobile
                    },
                    success: function(res) {
                        if (res.status) {
                            toastr.success(res.message);
                            setTimeout(() => {
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = '/otp_screen';

                                const csrfInput = document.createElement('input');
                                csrfInput.type = 'hidden';
                                csrfInput.name = '_token';
                                csrfInput.value =
                                    '{{ csrf_token() }}'; // Make sure this is rendered in Blade

                                const mobileInput = document.createElement('input');
                                mobileInput.type = 'hidden';
                                mobileInput.name = 'mobile';
                                mobileInput.value = mobile;

                                form.appendChild(csrfInput);
                                form.appendChild(mobileInput);

                                document.body.appendChild(form);
                                form.submit();
                            }, 1000);
                        } else {
                            toastr.error(res.message);
                        }
                    },
                    error: function() {
                        toastr.error("Error sending OTP. Try again.");
                    },
                    complete: function() {
                        $('#btn-text').removeClass('d-none');
                        $('#btn-spinner').addClass('d-none');
                        $('#sendOtpBtn').prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection

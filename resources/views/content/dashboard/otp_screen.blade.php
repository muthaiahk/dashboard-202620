@extends('layouts/blankLayout')
@section('title', 'OTP Verification')

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('content')
    <style>
        .log_bg_img {
            background-image: url('{{ asset('assets/images/logo/login_img_1.jpg') }}');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        .otp-input {
            width: 45px;
            height: 50px;
            text-align: center;
            font-size: 20px;
            margin: 0 5px;
            border-radius: 8px;
            border: 1px solid #ced4da;
            transition: all 0.2s ease-in-out;
        }

        .otp-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 8px rgba(59, 130, 246, 0.5);
            outline: none;
            transform: scale(1.1);
        }

        .otp-timer {
            font-size: 13px;
            color: #414446;
        }

        .error-text {
            color: red;
            font-size: 13px;
            margin-top: 5px;
        }
    </style>

    <div class="authentication-wrapper authentication-cover log_bg_img position-relative">
        <div class="authentication-inner row m-0">
            <div class="d-none d-lg-flex col-lg-6 align-items-center justify-content-center p-5">
            </div>
            <div class="d-flex col-12 col-lg-6 align-items-center px-4">
                <div class="w-px-400 mx-auto">
                    <a href="{{ url('/') }}"
                        class="position-absolute mt-2 me-2 text-decoration-none text-dark fw-semibold fs-5"
                        style="right: 750px;top: 100px;">
                        <i class="mdi mdi-arrow-left text-dark fs-4"></i> Back
                    </a>
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/images/logo/logo_2.png') }}" class="w-250px mb-3" />
                        <h5 class="fw-semibold">Precision • Reliability • Safety</h5>
                    </div>
                    <div class="mb-3 text-center">
                        <h5 class="fw-semibold">Check your phone</h5>
                        <p class="text-dark">We've sent a 6-digit code to <strong>{{ $mobile }}</strong></p>
                    </div>

                    <form id="otpForm" class="d-flex justify-content-center gap-2 mb-3">
                        <input type="text" maxlength="1" class="otp-input" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" name="otp[]" />
                        <input type="text" maxlength="1" class="otp-input" name="otp[]" />
                    </form>

                    <div class="error-text text-center" id="otpError"></div>

                    <button id="verifyBtn" class="btn btn-primary w-100 mb-2">Verify & Login</button>

                    <div class="text-center otp-timer">
                        Resend code in <span id="otpCountdown">00:30</span>
                    </div>
                    <p class="text-center mt-3">Your Code is : <b> {{ $otp }} </b></p>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('.otp-input');
            const otpForm = document.getElementById('otpForm');
            const verifyBtn = document.getElementById('verifyBtn');
            const otpError = document.getElementById('otpError');

            // Input focus animation
            inputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    if (input.value.length > 0 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });
                input.addEventListener('keydown', (e) => {
                    if (e.key === "Backspace" && index > 0 && !input.value) {
                        inputs[index - 1].focus();
                    }
                });
            });

            // Countdown timer
            let timer = 30;
            const countdownEl = document.getElementById('otpCountdown');
            const interval = setInterval(() => {
                if (timer > 0) {
                    timer--;
                    countdownEl.textContent = `00:${timer < 10 ? '0'+timer : timer}`;
                }
            }, 1000);

            // AJAX submit
            verifyBtn.addEventListener('click', function(e) {
                e.preventDefault();
                otpError.textContent = '';

                let otp = '';
                inputs.forEach(input => {
                    otp += input.value;
                });

                if (otp.length !== 6) {
                    otpError.textContent = 'Please enter a valid 6-digit OTP';
                    return;
                }

                fetch('{{ url('/verify-otp') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            mobile_number: '{{ $mobile }}',
                            otp: otp
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status) {
                            window.location.href = data.redirect;
                        } else {
                            otpError.textContent = data.message;
                        }
                    })
                    .catch(err => {
                        otpError.textContent = 'Something went wrong. Try again.';
                    });
            });
        });
    </script>
@endsection

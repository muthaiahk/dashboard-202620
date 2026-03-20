<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Login extends Controller
{
  public function index()
  {
    return view('content.dashboard.login');
  }

  public function get_otp(Request $request)
  {
    $request->validate([
      'mobile' => 'required|digits:10'
    ]);

    $mobile = $request->mobile;

    $UserOtp = User::where('mobile_number', $mobile)->first();
    $otp = $UserOtp->otp;
    return view('content.dashboard.otp_screen', compact('mobile', 'otp'));
  }
  public function sendOtp(Request $request)
  {
    $mobile = $request->mobile_number;

    if (empty($mobile)) {
      return response()->json([
        'status' => false,
        'message' => 'Please enter your mobile number'
      ]);
    }

    if (!preg_match('/^\d{10}$/', $mobile)) {
      return response()->json([
        'status' => false,
        'message' => 'Mobile number must be 10 digits'
      ]);
    }

    $user = User::where('mobile_number', $mobile)->first();
    if (!$user) {
      return response()->json([
        'status' => false,
        'message' => 'Mobile number not registered'
      ]);
    }

    $otp = rand(100000, 999999);

    $user->update([
      'otp' => $otp,
      'otp_expires_at' => Carbon::now()->addMinutes(5)
    ]);


    return response()->json([
      'status' => true,
      'message' => 'OTP sent successfully'
    ]);
  }

  public function verifyOtp(Request $request)
  {
    $mobile = $request->mobile_number;
    $otp = $request->otp;

    if (empty($mobile) || !preg_match('/^\d{10}$/', $mobile)) {
      return response()->json(['status' => false, 'message' => 'Invalid mobile number']);
    }

    if (empty($otp) || !preg_match('/^\d{6}$/', $otp)) {
      return response()->json(['status' => false, 'message' => 'Invalid OTP']);
    }

    $user = User::where('mobile_number', $mobile)->first();

    if (!$user) {
      return response()->json(['status' => false, 'message' => 'User not found']);
    }

    if ($user->otp != $otp) {
      return response()->json(['status' => false, 'message' => 'Invalid OTP']);
    }

    if (Carbon::now()->gt($user->otp_expires_at)) {
      return response()->json(['status' => false, 'message' => 'OTP expired']);
    }

    Auth::login($user);

    $user->update([
      'otp' => null,
      'otp_expires_at' => null
    ]);

    return response()->json([
      'status' => true,
      'message' => 'Login successful',
      'redirect' => url('/dashboards')
    ]);
  }

  public function dashboards()
  {
    return view('content.dashboard.dashboards-analytics');
  }

  public function client_dashboard()
  {
    return view('content.dashboard.dashboards-crm');
  }
}
<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Room extends Controller
{
  public function index()
  {
    return view('content.settings.room_settings');
  }
}

<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralSettings extends Controller
{
  public function index()
  {
    return view('content.settings.general_settings');
  }
}

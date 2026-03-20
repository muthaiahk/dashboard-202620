<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageWorkOrder extends Controller
{
  public function index()
  {
    return view('content.manage_workorder.workorder_panel_list');
  }

  public function calendar_list()
  {
    return view('content.manage_workorder.workorder_calendar_view');
  }
}

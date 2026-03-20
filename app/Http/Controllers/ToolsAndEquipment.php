<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToolsAndEquipment extends Controller
{
  public function index()
  {
    return view('content.tools_and_equipment.list');
  }

  public function vehicle_list()
  {
    return view('content.tools_and_equipment.vehicle_list');
  }
}

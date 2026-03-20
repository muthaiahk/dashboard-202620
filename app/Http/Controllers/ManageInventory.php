<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageInventory extends Controller
{

  public function index()
  {
    return view('content.manage_inventory.list');
  }

  public function valve()
  {
    return view('content.manage_inventory.valve');
  }

  public function spare_part()
  {
    return view('content.manage_inventory.spare_parts');
  }

  public function calibration()
  {
    return view('content.manage_inventory.calibration');
  }

  public function store()
  {
    return view('content.manage_inventory.store_list');
  }

}

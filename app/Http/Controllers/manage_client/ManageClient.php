<?php

namespace App\Http\Controllers\manage_client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageClient extends Controller
{
  public function index()
  {
    return view('content.manage_client.list');
  }
}

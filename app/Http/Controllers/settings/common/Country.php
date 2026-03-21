<?php

namespace App\Http\Controllers\settings\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CountryModel;
use App\Models\User;

class Country extends Controller
{
  public function List(Request $request)
  {
    $results = CountryModel::where('status', 0)->get();
    if(!$results){
      return response()->json([
          'status'  => 400,
          'message' => 'Country Not Found..!',
          'data'    => null
      ]);
    }else{
      return response()->json([
        'status'  => 200,
        'message' => 'Country is Found..!',
        'data'    => $results
      ]);
    }
  }
}

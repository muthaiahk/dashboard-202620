<?php

namespace App\Http\Controllers\settings\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CountryModel;
use App\Models\StateModel;


class State extends Controller
{
  public function List(Request $request)
  {
    $country_id = $request->country_id ?? null;

    if(!$country_id){
      return response()->json([
          'status'  => 400,
          'message' => 'Country ID Not Found..!',
          'data'    => null
      ]);
    }

    $results = StateModel::where('status', 0)->where('country_id',$country_id)->get();
    if(!$results){
      return response()->json([
          'status'  => 400,
          'message' => 'States Not Found..!',
          'data'    => null
      ]);
    }else{
      return response()->json([
        'status'  => 200,
        'message' => 'States is Found..!',
        'data'    => $results
      ]);
    }
  }
}
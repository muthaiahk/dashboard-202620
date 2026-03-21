<?php

namespace App\Http\Controllers\settings\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\CityModel;



class City extends Controller
{
  public function List(Request $request)
  {
    $state_id = $request->state_id ?? null;

    if(!$state_id){
      return response()->json([
          'status'  => 400,
          'message' => 'State ID Not Found..!',
          'data'    => null
      ]);
    }

    $results = CityModel::where('status', 0)->where('state_id',$state_id)->get();
    if(!$results){
      return response()->json([
          'status'  => 400,
          'message' => 'Cities Not Found..!',
          'data'    => null
      ]);
    }else{
      return response()->json([
        'status'  => 200,
        'message' => 'Cities is Found..!',
        'data'    => $results
      ]);
    }
  }  
}
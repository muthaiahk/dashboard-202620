<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlantModel;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Plant extends Controller
{
  public function index()
  {
    $lists = PlantModel::with('sector')->where('status', '!=', 2)->orderBy('id', 'desc')->get();
    return view('content.settings.plant_settings',['lists' => $lists]);
  }


  public function add(Request $request) {
    try {
        $validator = Validator::make($request->all(), [
        'sector_id' => 'required',
        'plant_name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
                'data' => null
            ], 422);
        }

        $sector_id = $request->sector_id;
        $plant_name = $request->plant_name;
        $plant_desc = $request->plant_desc;
        // $user_id = $request->user()->user_id;

        $exists = PlantModel::where('status', '!=', 2)
            ->where('name', $plant_name)
            ->where('sector_id', $sector_id)
            ->first();

        if ($exists) {
            return response()->json([
            'status' => 409,
            'message' => 'Plant is already exists!',
            'data' => null
            ], 409);
        }
        
        $CampusDropReason = new PlantModel();
        $CampusDropReason->sector_id = $sector_id;
        $CampusDropReason->name = $plant_name;
        $CampusDropReason->description = $plant_desc;

        $CampusDropReason->save();

        return response()->json([
            'status' => 201,
            'message' => 'Plant added successfully!',
            'data' => $CampusDropReason
        ], 201);

    } catch (\Exception $e) {
        
        return response()->json([
            'status' => 500,
            'message' => 'Server error occurred while creating plant.',
            'data' => null
        ], 500);
    }
  }

  public function edit($id) {

        $data = PlantModel::where('status', '!=', 2)->where('id', $id)->first();

        if ($data) {
            return response([
                'status' => 200,
                'message' => "Data fetched successfully!",
                'error_msg' => null,
                'data' => $data
            ], 200);
        }
    }

    public function update(Request $request) {

        try {
            
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'sector_id' => 'required',
                'plant_name' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                    'data' => null
                ], 422);
            }
            
            $id = $request->id;
            $sector_id = $request->sector_id ?? NULL;
            $plant_name = $request->plant_name ?? NULL;
            $plant_desc = $request->plant_desc ?? NULL;
            // $user_id = $request->user()->user_id;

            $exists = PlantModel::where('status', '!=', 2)
                ->where('id', '!=', $id)
                ->where('name', $plant_name)
                ->where('sector_id', $sector_id)
                ->first();

            if ($exists) {
                return response()->json([
                  'status' => 409,
                  'message' => 'Plant already exists!',
                  'data' => null
                ], 409);
            }
            
            $CampusDropReason = PlantModel::where('id', $id)->where('status', '!=', 2)->first();
            $CampusDropReason->sector_id = $sector_id;
            $CampusDropReason->name = $plant_name;
            $CampusDropReason->description = $plant_desc;
            $CampusDropReason->save();

            return response()->json([
                'status' => 201,
                'message' => 'Plant updated successfully!',
                'data' => $CampusDropReason
            ], 201);

        } catch (\Exception $e) {
            
            return response()->json([
                'status' => 500,
                'message' => 'Server error occurred while updating Plant.',
                'data' => null
            ], 500);
        }
    }

    public function status($id, Request $request) {

        $status = PlantModel::where('status', '!=', 2)->where('id', $id)->first();
        $status->status = $request->input('status', 0);
        $status->update();

        return response([
            'status' => 200,
            'message' => 'Status Changed Successfully!',
            'error_msg' => null,
            'data' => null
        ], 200);
    }

    public function delete($id) {
        $delete = PlantModel::where('id', $id)
            ->where('status', '!=', 2)
            ->first();

        $delete->status = 2;
        $delete->update();

        return response([
            'status' => 200,
            'message' => 'Plant deleted successfully!',
            'error_msg' => null,
            'data' => null
        ], 200);
    }

    public function List(Request $request)
    {
        $sector_id = $request->sector_id ?? null;
        $results = PlantModel::where('status', 0)->where('sector_id',$sector_id)->get();
        if(!$results){
        return response()->json([
            'status'  => 400,
            'message' => 'Plant Not Found..!',
            'data'    => null
        ]);
        }else{
        return response()->json([
            'status'  => 200,
            'message' => 'Plant is Found..!',
            'data'    => $results
        ]);
        }
    }
}

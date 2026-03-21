<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomModel;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Room extends Controller
{
  public function index()
  {
    $lists = RoomModel::with(['sector','plants'])->where('status', '!=', 2)->orderBy('id', 'desc')->get();
    return view('content.settings.room_settings',['lists'=>$lists]);
  }

  public function add(Request $request) {
    try {
        $validator = Validator::make($request->all(), [
        'sector_id' => 'required',
        'plant_id' => 'required',
        'room_name' => 'required'
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
        $plant_id = $request->plant_id;
        $room_name = $request->room_name;
        $room_desc = $request->room_desc;

        // $user_id = $request->user()->user_id;

        $exists = RoomModel::where('status', '!=', 2)
            ->where('name', $room_name)
            ->where('sector_id', $sector_id)
            ->where('plant_id', $plant_id)
            ->first();

        if ($exists) {
          return response()->json([
          'status' => 409,
          'message' => 'Room is already exists!',
          'data' => null
          ], 409);
        }
        
        $CampusDropReason = new RoomModel();
        $CampusDropReason->sector_id = $sector_id;
        $CampusDropReason->plant_id = $plant_id;
        $CampusDropReason->name = $room_name;
        $CampusDropReason->description = $room_desc;
        $CampusDropReason->save();

        return response()->json([
            'status' => 201,
            'message' => 'Room added successfully!',
            'data' => $CampusDropReason
        ], 201);

    } catch (\Exception $e) {
        
        return response()->json([
            'status' => 500,
            'message' => 'Server error occurred while creating room.',
            'data' => null
        ], 500);
    }
  }

  public function edit($id) {

    $data = RoomModel::where('status', '!=', 2)->where('id', $id)->first();

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
              'plant_id' => 'required',
              'room_name' => 'required'
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
          $plant_id = $request->plant_id ?? NULL;
          $room_name = $request->room_name ?? NULL;
          $room_desc = $request->room_desc ?? NULL;
          // $user_id = $request->user()->user_id;

          $exists = RoomModel::where('status', '!=', 2)
              ->where('id', '!=', $id)
              ->where('name', $room_name)
              ->where('sector_id', $sector_id)
              ->where('plant_id', $plant_id)
              ->first();

          if ($exists) {
              return response()->json([
                'status' => 409,
                'message' => 'Room already exists!',
                'data' => null
              ], 409);
          }
          
          $CampusDropReason = RoomModel::where('id', $id)->where('status', '!=', 2)->first();
          $CampusDropReason->sector_id = $sector_id;
          $CampusDropReason->plant_id = $plant_id;
          $CampusDropReason->name = $room_name;
          $CampusDropReason->description = $room_desc;
          $CampusDropReason->save();

          return response()->json([
              'status' => 201,
              'message' => 'Room updated successfully!',
              'data' => $CampusDropReason
          ], 201);

      } catch (\Exception $e) {
          
          return response()->json([
              'status' => 500,
              'message' => 'Server error occurred while updating Room.',
              'data' => null
          ], 500);
      }
  }

  public function status($id, Request $request) {

      $status = RoomModel::where('status', '!=', 2)->where('id', $id)->first();
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
      $delete = RoomModel::where('id', $id)
          ->where('status', '!=', 2)
          ->first();

      $delete->status = 2;
      $delete->update();

      return response([
          'status' => 200,
          'message' => 'Room deleted successfully!',
          'error_msg' => null,
          'data' => null
      ], 200);
  }

  public function List(Request $request)
  {
    $sector_id = $request->sector_id ?? null;
    $results = RoomModel::where('status', 0)->where('sector_id',$sector_id)->where('plant_id',$plant_id)->get();
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

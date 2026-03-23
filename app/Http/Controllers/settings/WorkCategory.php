<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkCategoryModel;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class WorkCategory extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Work Category,is_read')->only(['index', 'edit', 'List']);
        $this->middleware('permission:Work Category,is_create')->only('add');
        $this->middleware('permission:Work Category,is_update')->only(['update', 'status']);
        $this->middleware('permission:Work Category,is_delete')->only('delete');
    }

    public function index()
  {
      $lists = WorkCategoryModel::where('status', '!=', 2) ->orderBy('id', 'desc')->get();
      return view('content.settings.work_category', [
        'lists' => $lists
      ]);
  }

  public function add(Request $request) {
      try {
          $validator = Validator::make($request->all(), [
            'sector_name' => 'required'
          ]);

          if ($validator->fails()) {
              return response()->json([
                  'status' => 422,
                  'message' => 'Validation failed',
                  'errors' => $validator->errors(),
                  'data' => null
              ], 422);
          }

          $reason = $request->sector_name;
          $reasonDesc = $request->sector_desc;
          // $user_id = $request->user()->user_id;

          $exists = WorkCategoryModel::where('status', '!=', 2)
              ->where('name', $reason)
              ->first();

          if ($exists) {
              return response()->json([
              'status' => 409,
              'message' => 'Work Category already exists!',
              'data' => null
              ], 409);
          }
          
          $CampusDropReason = new WorkCategoryModel();
          $CampusDropReason->name = $reason;
          $CampusDropReason->description = $reasonDesc;
          $CampusDropReason->save();

          return response()->json([
              'status' => 201,
              'message' => 'Work Category added successfully!',
              'data' => $CampusDropReason
          ], 201);

      } catch (\Exception $e) {
          
          return response()->json([
              'status' => 500,
              'message' => 'Server error occurred while creating Work Category.',
              'data' => null
          ], 500);
      }
  }

  public function edit($id) {

      $data = WorkCategoryModel::where('status', '!=', 2)->where('id', $id)->first();

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
            'sector_name' => 'required'
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
          $reason = $request->sector_name ?? NULL;
          $reasonDesc = $request->sector_desc ?? NULL;
          // $user_id = $request->user()->user_id;

          $exists = WorkCategoryModel::where('status', '!=', 2)
              ->where('id', '!=', $id)
              ->where('name', $reason)
              ->first();

          if ($exists) {
              return response()->json([
                  'status' => 409,
                  'message' => 'Work Category already exists!',
                  'data' => null
              ], 409);
          }
          
          $CampusDropReason = WorkCategoryModel::where('id', $id)->where('status', '!=', 2)->first();
          $CampusDropReason->name = $reason;
          $CampusDropReason->description = $reasonDesc;
          $CampusDropReason->save();

          return response()->json([
              'status' => 201,
              'message' => 'Work Category updated successfully!',
              'data' => $CampusDropReason
          ], 201);

      } catch (\Exception $e) {
          
          return response()->json([
              'status' => 500,
              'message' => 'Server error occurred while updating Work Category.',
              'data' => null
          ], 500);
      }
  }

  public function status($id, Request $request) {

      $status = WorkCategoryModel::where('status', '!=', 2)->where('id', $id)->first();
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
      $delete = WorkCategoryModel::where('id', $id)
          ->where('status', '!=', 2)
          ->first();

      $delete->status = 2;
      $delete->update();

      return response([
          'status' => 200,
          'message' => 'Work Category deleted successfully!',
          'error_msg' => null,
          'data' => null
      ], 200);
  }

  public function List(Request $request)
  {
      $results = WorkCategoryModel::where('status', 0)->get();
      if(!$results){
      return response()->json([
          'status'  => 400,
          'message' => 'Work Category Not Found..!',
          'data'    => null
      ]);
      }else{
      return response()->json([
          'status'  => 200,
          'message' => 'Work Category is Found..!',
          'data'    => $results
      ]);
      }
  }
}

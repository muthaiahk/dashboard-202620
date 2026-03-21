<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SectorModel;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Sector extends Controller
{
    public function index()
    {
        $lists = SectorModel::where('status', '!=', 2)
                ->orderBy('id', 'desc')
                ->get();
        return view('content.settings.sector_settings', [
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

            $exists = SectorModel::where('status', '!=', 2)
                ->where('name', $reason)
                ->first();

            if ($exists) {
                return response()->json([
                'status' => 409,
                'message' => 'Sector already exists!',
                'data' => null
                ], 409);
            }
            
            $CampusDropReason = new SectorModel();
            $CampusDropReason->name = $reason;
            $CampusDropReason->description = $reasonDesc;
            $CampusDropReason->save();

            return response()->json([
                'status' => 201,
                'message' => 'Sector added successfully!',
                'data' => $CampusDropReason
            ], 201);

        } catch (\Exception $e) {
            
            return response()->json([
                'status' => 500,
                'message' => 'Server error occurred while creating Sector.',
                'data' => null
            ], 500);
        }
    }

    public function edit($id) {

        $data = SectorModel::where('status', '!=', 2)->where('id', $id)->first();

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

            $exists = SectorModel::where('status', '!=', 2)
                ->where('id', '!=', $id)
                ->where('name', $reason)
                ->first();

            if ($exists) {
                return response()->json([
                    'status' => 409,
                    'message' => 'Sector already exists!',
                    'data' => null
                ], 409);
            }
            
            $CampusDropReason = SectorModel::where('id', $id)->where('status', '!=', 2)->first();
            $CampusDropReason->name = $reason;
            $CampusDropReason->description = $reasonDesc;
            $CampusDropReason->save();

            return response()->json([
                'status' => 201,
                'message' => 'Sector updated successfully!',
                'data' => $CampusDropReason
            ], 201);

        } catch (\Exception $e) {
            
            return response()->json([
                'status' => 500,
                'message' => 'Server error occurred while updating Sector.',
                'data' => null
            ], 500);
        }
    }

    public function status($id, Request $request) {

        $status = SectorModel::where('status', '!=', 2)->where('id', $id)->first();
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
        $delete = SectorModel::where('id', $id)
            ->where('status', '!=', 2)
            ->first();

        $delete->status = 2;
        $delete->update();

        return response([
            'status' => 200,
            'message' => 'Sector deleted successfully!',
            'error_msg' => null,
            'data' => null
        ], 200);
    }

    public function List(Request $request)
    {
        $results = SectorModel::where('status', 0)->get();
        if(!$results){
        return response()->json([
            'status'  => 400,
            'message' => 'Sector Not Found..!',
            'data'    => null
        ]);
        }else{
        return response()->json([
            'status'  => 200,
            'message' => 'Sector is Found..!',
            'data'    => $results
        ]);
        }
    }
}

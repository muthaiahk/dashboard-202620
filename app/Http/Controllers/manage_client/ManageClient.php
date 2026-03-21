<?php

namespace App\Http\Controllers\manage_client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SectorModel;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ManageClient extends Controller
{
  public function index()
  {
    $lists = Client::where('status', '!=', 2)
      ->orderBy('id', 'desc')
      ->get();

    // Get all sectors once
    $sectors = SectorModel::pluck('name', 'id');

    foreach ($lists as $client) {

      $CorporateListOptions = isset($client->sector_details) && !empty($client->sector_details)
        ? json_decode($client->sector_details, true)
        : [];

      $options_list = [];

      if (!empty($CorporateListOptions)) {
        foreach ($CorporateListOptions as $item) {
          foreach ($item as $key => $details) {

            $options_list[] = [
              'client_name' => $details['client_name'] ?? '',
              'industry_id' => $details['industry_id'] ?? '',
              'sector_name' => isset($details['industry_id'])
                ? ($sectors[$details['industry_id']] ?? '')
                : ''
            ];
          }
        }
      }

      $client->sector_data = $options_list;
    }

    return view('content.manage_client.list', ['lists' => $lists]);
  }

  public function Add(Request $request)
  {
    // return $request;

    /* =======================
        VALIDATION
      ======================= */
    $rules = [
      'company_name' => 'required',
      'mob_no' => 'required',
      'location' => 'required',
      'address' => 'required',
      'sector_details' => 'required|array',
      'sector_details.*.industry_id' => 'required',
      'sector_details.*.client_name' => 'required',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return response()->json([
        'status' => 'error',
        'errors' => $validator->errors(),
      ], 422);
    }

    DB::beginTransaction();

    try {

      $sector_details = $request->sector_details ?? null;
      /* =======================
            SAVE DATA
          ======================= */

      // Process HR details
      $sector_data_json = null;

      if (is_array($sector_details)) {
        $indexed_options = [];
        foreach ($sector_details as $index => $value) {
          if ($value !== '') {
            $indexed_options[] = [
              (string)((int)$index) => $value
            ];
          }
        }
        $sector_data_json = json_encode($indexed_options);
      }

      $general_settings_model = new Client();

      $general_settings_model->company_name = $request->company_name ?? null;
      $general_settings_model->mobile_no = $request->mob_no ?? null;
      $general_settings_model->email_id = $request->email_id ?? null;
      $general_settings_model->location = $request->location ?? null;
      $general_settings_model->address = $request->address ?? null;
      $general_settings_model->sector_details = $sector_data_json;
      $saved = $general_settings_model->save();

      DB::commit(); // ✅ correct place

      if ($saved) {
        session()->flash('toastr', [
          'type' => 'success',
          'message' => 'Client added Successfully!'
        ]);
      } else {
        session()->flash('toastr', [
          'type' => 'error',
          'message' => 'Could not add the Client!'
        ]);
      }

      return redirect()->back();
    } catch (\Exception $e) {

      DB::rollBack();

      session()->flash('toastr', [
        'type' => 'error',
        'message' => 'Error: ' . $e->getMessage() // helpful for debugging
      ]);

      return redirect()->back();
    }
  }

  public function Edit($id)
  {
    $TrainingDatabase = Client::where('id', $id)
      ->where('status', '!=', 2)
      ->first();

    if ($TrainingDatabase) {

      $CorporateListOptions = isset($TrainingDatabase->sector_details) && !empty($TrainingDatabase->sector_details) ? json_decode($TrainingDatabase->sector_details, true) : [];
      // $prefer_time = isset($TrainingDatabase->prefer_time) && !empty($TrainingDatabase->prefer_time) ? json_decode($TrainingDatabase->prefer_time, true) : [];
      // // $exp_work_type = isset($TrainingDatabase->work_type) && !empty($TrainingDatabase->work_type) ? (int)$TrainingDatabase->work_type : 1;

      $options_list = [];
      if (!empty($CorporateListOptions)) {
        foreach ($CorporateListOptions as $item) {
          foreach ($item as $key => $details) {
            $options_list[$key] = $details;  // append inner arrays
          }
        }
      }

      // $TrainingDatabase->prefer_time = $prefer_time;

      return response()->json([
        'status' => 200,
        'data' => $TrainingDatabase,
        'sector_details' => $options_list,
      ]);
    } else {
      return response()->json([
        'status' => 404,
        'message' => 'Client Details not found',
      ]);
    }
  }

  public function Update(Request $request)
  {
    // return $request;

    /* =======================
        VALIDATION
      ======================= */
    $rules = [
      'update_sno' => 'required',
      'company_name' => 'required',
      'mob_no' => 'required',
      'location' => 'required',
      'address' => 'required',
      'sector_details' => 'required|array',
      'sector_details.*.industry_id' => 'required',
      'sector_details.*.client_name' => 'required',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return response()->json([
        'status' => 'error',
        'errors' => $validator->errors(),
      ], 422);
    }

    DB::beginTransaction();

    try {

      $update_sno = $request->update_sno ?? null;
      $sector_details = $request->sector_details ?? null;
      $status = $request->status ?? 0;
      /* =======================
            SAVE DATA
          ======================= */

      // Process HR details
      $sector_data_json = null;

      if (is_array($sector_details)) {
        $indexed_options = [];
        foreach ($sector_details as $index => $value) {
          if ($value !== '') {
            $indexed_options[] = [
              (string)((int)$index) => $value
            ];
          }
        }
        $sector_data_json = json_encode($indexed_options);
      }

      $general_settings_model = Client::where('id', $update_sno)
        ->where('status', '!=', 2)
        ->first();

      $general_settings_model->company_name = $request->company_name ?? null;
      $general_settings_model->mobile_no = $request->mob_no ?? null;
      $general_settings_model->email_id = $request->email_id ?? null;
      $general_settings_model->location = $request->location ?? null;
      $general_settings_model->address = $request->address ?? null;
      $general_settings_model->sector_details = $sector_data_json;
      $general_settings_model->status = $status;
      $saved = $general_settings_model->save();

      DB::commit(); // ✅ correct place

      if ($saved) {
        session()->flash('toastr', [
          'type' => 'success',
          'message' => 'Client Updated Successfully!'
        ]);
      } else {
        session()->flash('toastr', [
          'type' => 'error',
          'message' => 'Could not update the Client!'
        ]);
      }

      return redirect()->back();
    } catch (\Exception $e) {

      DB::rollBack();

      session()->flash('toastr', [
        'type' => 'error',
        'message' => 'Error: ' . $e->getMessage() // helpful for debugging
      ]);

      return redirect()->back();
    }
  }

  public function delete($id)
  {

    $delete = Client::where('id', $id)
      ->where('status', '!=', 2)
      ->first();

    $delete->status = 2;
    $delete->update();

    return response([
      'status' => 200,
      'message' => 'Client deleted successfully!',
      'error_msg' => null,
      'data' => null
    ], 200);
  }
}
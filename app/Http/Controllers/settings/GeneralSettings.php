<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralSettingsModel;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class GeneralSettings extends Controller
{
  public function index()
  {
    $general_data = GeneralSettingsModel::where('status', 0)->first();
    // return $general_data;
    return view('content.settings.general_settings',['general_data'=>$general_data]);
  }

  public function Add(Request $request)
  {
      /* =======================
        VALIDATION
      ======================= */
      $rules = [
          'add_title' => 'required',
          'add_mob_no' => 'required',
          'add_website' => 'required',
          'add_country' => 'required',
          'add_state' => 'required',
          'add_city' => 'required'
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

          /* =======================
            FILE UPLOAD
          ======================= */
          $LogoImagePath = '';
          if ($request->hasFile('lib_topic_icon')) {
              $LogoImagePath = 'logo'.'.'.$request->file('lib_topic_icon')->extension();
              $request->file('lib_topic_icon')->move(public_path('assets/images/logo/'), $LogoImagePath);
          }

          $favIconImagePath = '';
          if ($request->hasFile('lib_fav_topic_icon')) {
              $favIconImagePath = 'fav_logo'.'.'.$request->file('lib_fav_topic_icon')->extension();
              $request->file('lib_fav_topic_icon')->move(public_path('assets/images/logo/'), $favIconImagePath);
          }

          /* =======================
            SAVE DATA
          ======================= */

          if(isset($request->update_sno) && !empty($request->update_sno)){
            $general_settings_model = GeneralSettingsModel::where('status', 0)->where('id', $request->update_sno)->first();
          }else{
            $general_settings_model = new GeneralSettingsModel();
          }

          $general_settings_model->title = $request->add_title;
          if(!empty($LogoImagePath)){
            $general_settings_model->logo = $LogoImagePath;
          }
          if(!empty($favIconImagePath)){
            $general_settings_model->fav_icon = $favIconImagePath;
          }
          $general_settings_model->url = $request->add_website;
          $general_settings_model->email_id = $request->add_email;
          $general_settings_model->mobile_number = $request->add_mob_no;
          $general_settings_model->registered_name = $request->add_title;
          $general_settings_model->country_id = (int) $request->add_country;
          $general_settings_model->state_id = (int) $request->add_state;
          $general_settings_model->city_id = (int) $request->add_city;

          $general_settings_model->instagram_link = $request->add_intagram_url;
          $general_settings_model->linkedin_link = $request->add_linkedin_url;
          $general_settings_model->facebook_link = $request->add_fb_url;
          $general_settings_model->youtube_link = $request->add_youtube_url;
          $general_settings_model->website_link = $request->add_website;

          $saved = $general_settings_model->save();

          DB::commit(); // ✅ correct place

          if ($saved) {
              session()->flash('toastr', [
                  'type' => 'success',
                  'message' => 'General Settings added Successfully!'
              ]);
          } else {
              session()->flash('toastr', [
                  'type' => 'error',
                  'message' => 'Could not add the General Settings!'
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
}

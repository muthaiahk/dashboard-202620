<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Client;
use App\Models\Sector;
use App\Models\Plant;
use App\Models\Room;

class ManageAssets extends Controller
{
  public function index()
  {
    $assets = Asset::with(['client', 'sector', 'plant', 'room'])->orderBy('id', 'desc')->get();
    $clients = Client::where('status', 1)->get();
    $sectors = Sector::where('status', 1)->get();
    $plants = Plant::where('status', 1)->get();
    $rooms = Room::where('status', 1)->get();

    return view('content.manage_asset.asset_panel_list', compact('assets', 'clients', 'sectors', 'plants', 'rooms'));
  }

  public function store(Request $request)
  {
      $request->validate([
          'name' => 'required',
          'tag_number' => 'required|unique:assets',
      ]);

      Asset::create([
          'name' => $request->name,
          'tag_number' => $request->tag_number,
          'client_id' => $request->client_id ?: null,
          'sector_id' => $request->sector_id ?: null,
          'plant_id' => $request->plant_id ?: null,
          'room_id' => $request->room_id ?: null,
          'description' => $request->description,
          'valve_type' => $request->valve_type,
          'actual_size' => $request->actual_size,
          'estimated_size' => $request->estimated_size,
          'pressure_class' => $request->pressure_class,
          'work_center' => $request->work_center,
          'latitude' => $request->latitude,
          'longitude' => $request->longitude,
          'special_tools' => $request->special_tools,
          'scaff_crane' => $request->scaff_crane,
          'status' => 1
      ]);

      return response()->json([
          'status' => true,
          'message' => 'Customer Asset created successfully'
      ]);
  }

  public function downloadSample()
  {
      $filePath = resource_path('sample/asset_bulk_sample.xlsx');
      if (!file_exists($filePath)) {
          return response()->json(['status' => false, 'message' => 'Sample file not found.'], 404);
      }
      return response()->download($filePath);
  }

  public function show($id)
  {
      $asset = Asset::with(['client', 'sector', 'plant', 'room'])->find($id);
      if (!$asset) {
          return response()->json(['status' => false, 'message' => 'Asset not found'], 404);
      }
      return response()->json(['status' => true, 'data' => $asset]);
  }

  public function update(Request $request, $id)
  {
      $asset = Asset::find($id);
      if (!$asset) {
          return response()->json(['status' => false, 'message' => 'Asset not found'], 404);
      }

      $asset->update([
          'name'           => $request->name,
          'tag_number'     => $request->tag_number,
          'client_id'      => $request->client_id ?: null,
          'sector_id'      => $request->sector_id ?: null,
          'plant_id'       => $request->plant_id ?: null,
          'room_id'        => $request->room_id ?: null,
          'description'    => $request->description,
          'valve_type'     => $request->valve_type,
          'actual_size'    => $request->actual_size,
          'estimated_size' => $request->estimated_size,
          'pressure_class' => $request->pressure_class,
          'work_center'    => $request->work_center,
          'latitude'       => $request->latitude,
          'longitude'      => $request->longitude,
          'special_tools'  => $request->special_tools,
          'scaff_crane'    => $request->scaff_crane,
      ]);

      return response()->json(['status' => true, 'message' => 'Customer Asset updated successfully']);
  }

  public function bulkUpload(\Illuminate\Http\Request $request)
  {
      try {
          $file = $request->file('file');
          if (!$file) {
              return response()->json(['status' => false, 'message' => 'No file uploaded.'], 400);
          }

          $rows = \Maatwebsite\Excel\Facades\Excel::toArray([], $file)[0];
          $created = 0;

          foreach ($rows as $index => $row) {
              if ($index == 0) continue; // Skip header

              // Column mapping based on generate_asset_excel.php:
              // 0: name, 1: tag_number, 2: client_id, 3: description, 4: valve_type, 5: actual_size, 
              // 6: estimated_size, 7: pressure_class, 8: sector_id, 9: plant_id, 10: room_id, 
              // 11: work_center, 12: latitude, 13: longitude, 14: special_tools, 15: scaff_crane

              \App\Models\Asset::create([
                  'name'           => $row[0] ?? '-',
                  'tag_number'     => $row[1] ?? '-',
                  'client_id'      => !empty($row[2]) ? $row[2] : null,
                  'description'    => $row[3] ?? null,
                  'valve_type'     => $row[4] ?? null,
                  'actual_size'    => $row[5] ?? null,
                  'estimated_size' => $row[6] ?? null,
                  'pressure_class' => $row[7] ?? null,
                  'sector_id'      => !empty($row[8]) ? $row[8] : null,
                  'plant_id'       => !empty($row[9]) ? $row[9] : null,
                  'room_id'        => !empty($row[10]) ? $row[10] : null,
                  'work_center'    => $row[11] ?? null,
                  'latitude'       => $row[12] ?? null,
                  'longitude'      => $row[13] ?? null,
                  'special_tools'  => $row[14] ?? null,
                  'scaff_crane'    => $row[15] ?? null,
                  'status'         => 1
              ]);
              $created++;
          }

          return response()->json([
              'status' => true,
              'message' => "Bulk upload successful. $created assets created."
          ]);
      } catch (\Exception $e) {
          return response()->json([
              'status' => false,
              'message' => $this->cleanSqlError($e->getMessage())
          ], 500);
      }
  }

  private function cleanSqlError($message)
  {
      if (\Illuminate\Support\Str::contains($message, 'Duplicate entry')) {
          preg_match("/Duplicate entry '(.*?)'/", $message, $matches);
          return isset($matches[1]) ? "Duplicate entry '{$matches[1]}'" : "Duplicate entry error";
      }
      return $message;
  }
}

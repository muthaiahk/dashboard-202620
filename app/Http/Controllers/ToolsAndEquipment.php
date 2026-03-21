<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\Vehicle;

class ToolsAndEquipment extends Controller
{
  public function index()
  {
    // Fetch all equipments
    $equipments = Equipment::all();

    // Pass to the view
    return view('content.tools_and_equipment.list', compact('equipments'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'equipment_name' => 'required|string|max:255',
      'category' => 'required|string|max:255',
      'serial_number' => 'required|string|unique:equipments,serial_number',
      'manufacturer' => 'required|string|max:255',
      'model' => 'required|string|max:255',
      'ownership' => 'required|string|max:255',
      'current_status' => 'required|string|max:255',
      'current_location' => 'required|string|max:255',
      'certificate' => 'required|string|max:255',
      'expiry_date' => 'required|date',
    ]);

    Equipment::create($request->all());

    return response()->json(['success' => true]);
  }
  public function update(Request $request)
  {
    $request->validate([
      'id' => 'required|exists:equipments,id',
      'equipment_name' => 'required|string|max:255',
      'category' => 'required|string|max:255',
      'serial_number' => 'required|string|unique:equipments,serial_number,' . $request->id,
      'manufacturer' => 'required|string|max:255',
      'model' => 'required|string|max:255',
      'ownership' => 'required|string|max:255',
      'current_status' => 'required|string|max:255',
      'current_location' => 'required|string|max:255',
      'certificate' => 'required|string|max:255',
      'expiry_date' => 'required|date',
    ]);

    $equipment = Equipment::findOrFail($request->id);

    $equipment->update([
      'equipment_name'   => $request->equipment_name,
      'category'         => $request->category,
      'serial_number'    => $request->serial_number,
      'manufacturer'     => $request->manufacturer,
      'model'            => $request->model,
      'ownership'        => $request->ownership,
      'current_status'   => $request->current_status,
      'current_location' => $request->current_location,
      'certificate'      => $request->certificate,
      'expiry_date'      => $request->expiry_date,
    ]);

    return response()->json([
      'success' => true,
      'message' => 'Equipment updated successfully'
    ]);
  }

  public function vehicle_list()
  {
    $vehicles = Vehicle::all();
    return view('content.tools_and_equipment.vehicle_list', compact('vehicles'));
  }

  // Store new vehicle
  public function store_vehicle(Request $request)
  {
    $request->validate([
      'vehicle_name' => 'required|string|max:255',
      'brand' => 'required|string|max:255',
      'manufacturer' => 'required|string|max:255',
      'model' => 'required|string|max:255',
      'registered_number' => 'required|string|max:255|unique:vehicles,registered_number',
      'engine_number' => 'required|string|max:255',
      'chasis_number' => 'required|string|max:255',
      'current_location' => 'required|string|max:255',
      'capacity' => 'nullable|string|max:255',
      'length' => 'nullable|string|max:255',
    ]);

    $vehicle = Vehicle::create($request->all());

    return response()->json([
      'success' => true,
      'message' => 'Vehicle created successfully!',
      'data' => $vehicle
    ]);
  }
  public function update_vehicle(Request $request, $id)
  {
    $request->validate([
      'vehicle_name' => 'required',
      'brand' => 'required',
      'manufacturer' => 'required',
      'model' => 'required',
      'registered_number' => 'required',
      'engine_number' => 'required',
      'chasis_number' => 'required',
      'current_location' => 'required',
    ]);

    $vehicle = Vehicle::findOrFail($id);
    $vehicle->update($request->all());

    return response()->json([
      'success' => true,
      'message' => 'Vehicle updated successfully!'
    ]);
  }
}
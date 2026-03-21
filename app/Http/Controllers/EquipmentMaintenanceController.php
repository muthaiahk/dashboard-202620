<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EquipmentMaintenance;
use App\Models\Equipment;
use App\Models\VehicleMaintenanceLog;
use Carbon\Carbon;

class EquipmentMaintenanceController extends Controller
{
    // Store new maintenance record
    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'purpose' => 'required|string|max:255',
            'date' => 'required|date',
            'ownership' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $maintenance = EquipmentMaintenance::create([
            'equipment_id' => $request->equipment_id,
            'purpose' => $request->purpose,
            'date' => $request->date,
            'ownership' => $request->ownership,
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'maintenance' => $maintenance]);
    }

    // Get maintenance records for equipment
    public function list(Equipment $equipment)
    {
        $maintenances = $equipment->maintenances()->orderBy('date', 'desc')->get();
        return response()->json($maintenances);
    }

    public function addMaintenance(Request $request)
    {
        $formattedDate = Carbon::createFromFormat('d-M-Y', $request->date)
            ->format('Y-m-d');

        VehicleMaintenanceLog::create([
            'vehicle_id' => $request->vehicle_id,
            'purpose' => $request->purpose,
            'date' => $formattedDate, // ✅ fixed
            'ownership' => $request->ownership,
            'description' => $request->description,
        ]);

        return response()->json(['success' => true]);
    }
    public function getMaintenance($vehicleId)
    {
        return VehicleMaintenanceLog::where('vehicle_id', $vehicleId)
            ->orderBy('date', 'desc')
            ->get();
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\ResourceModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ResourceImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Team;
use Illuminate\Support\Facades\Validator;

class ManageResources extends Controller
{
  public function index()
  {
    $roles = Role::where('status', 1)->get();

    $resources = ResourceModel::with('role')->latest()->get();

    return view('content.manage_resources.resource_list', compact('roles', 'resources'));
  }
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required',
      'mobile_number' => 'required',
      'email' => 'required',
      'role_id' => 'required',
      'status' => 'required',
    ]);

    // =========================
    // 1. CREATE RESOURCE
    // =========================
    $resource = new ResourceModel();

    $resource->name = $request->name;
    $resource->mobile_number = $request->mobile_number;
    $resource->email = $request->email;
    $resource->role_id = $request->role_id;
    $resource->status = $request->status;
    $resource->address = $request->address;

    // =========================
    // 2. DOCUMENTS (ARRAY STORE)
    // =========================
    $certificates = [];
    $permits = [];

    if ($request->has('doc_name')) {

      foreach ($request->doc_name as $key => $docName) {

        $filePath = null;

        if ($request->file('doc_file')[$key] ?? false) {
          $file = $request->file('doc_file')[$key];
          $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
          $file->move(public_path('resources/docs'), $fileName);
          $filePath = 'resources/docs/' . $fileName;
        }

        $certificates[] = [
          'name' => $docName,
          'validity_date' => $request->doc_date[$key] ?? null,
          'file' => $filePath,
        ];
      }
    }

    $resource->certificates = $certificates;

    // OPTIONAL (if you want permits separately later)
    $resource->permits = $permits;

    // =========================
    // 3. SAVE RESOURCE
    // =========================
    $resource->save();

    return response()->json([
      'status' => true,
      'message' => 'Resource created successfully',
      'data' => $resource
    ]);
  }
  public function show($id)
  {
    $resource = ResourceModel::find($id);

    if (!$resource) {
      return response()->json([
        'status' => false,
        'message' => 'Resource not found'
      ]);
    }

    return response()->json([
      'status' => true,
      'data' => $resource
    ]);
  }
  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required',
      'mobile_number' => 'required',
      'email' => 'required',
      'role_id' => 'required',
      'status' => 'required',
    ]);

    $resource = ResourceModel::find($id);

    if (!$resource) {
      return response()->json([
        'status' => false,
        'message' => 'Resource not found'
      ]);
    }

    // ======================
    // UPDATE BASIC DETAILS
    // ======================
    $resource->name = $request->name;
    $resource->mobile_number = $request->mobile_number;
    $resource->email = $request->email;
    $resource->role_id = $request->role_id;
    $resource->status = $request->status;
    $resource->address = $request->address;

    // ======================
    // UPDATE CERTIFICATES
    // ======================
    $certificates = [];

    if ($request->has('doc_name')) {
      foreach ($request->doc_name as $key => $docName) {

        $filePath = $request->old_doc_file[$key] ?? null;

        if ($request->file('doc_file')[$key] ?? false) {
          $file = $request->file('doc_file')[$key];
          $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
          $file->move(public_path('resources/docs'), $fileName);
          $filePath = 'resources/docs/' . $fileName;
        }

        $certificates[] = [
          'name' => $docName,
          'validity_date' => $request->doc_date[$key] ?? null,
          'file' => $filePath,
        ];
      }
    }

    $resource->certificates = $certificates;

    $resource->save();

    return response()->json([
      'status' => true,
      'message' => 'Resource updated successfully',
      'data' => $resource
    ]);
  }

  public function bulkUpload(Request $request)
  {
    try {

      $rows = \Maatwebsite\Excel\Facades\Excel::toArray([], $request->file('file'))[0];

      $created = 0;

      foreach ($rows as $index => $row) {

        if ($index == 0) continue;

        // ❌ ROLE VALIDATION (STOP ERROR)
        if (!\App\Models\Role::find($row[3])) {
          return response()->json([
            'status' => false,
            'message' => "Invalid role_id '{$row[3]}' at row " . ($index + 1)
          ]);
        }

        try {

          \App\Models\ResourceModel::create([
            'name' => $row[0],
            'mobile_number' => $row[1],
            'email' => $row[2],
            'role_id' => $row[3],
            'status' => $row[4],
            'address' => $row[5],
          ]);

          $created++;
        } catch (\Exception $e) {

          return response()->json([
            'status' => false,
            'message' => $this->cleanSqlError($e->getMessage()) .
              " at row " . ($index + 1)
          ]);
        }
      }

      return response()->json([
        'status' => true,
        'message' => "Upload completed. Created: $created"
      ]);
    } catch (\Exception $e) {

      return response()->json([
        'status' => false,
        'message' => $this->cleanSqlError($e->getMessage())
      ]);
    }
  }
  private function cleanSqlError($message)
  {
    if (Str::contains($message, 'Duplicate entry')) {

      preg_match("/Duplicate entry '(.*?)'/", $message, $matches);

      return isset($matches[1])
        ? "Duplicate entry '{$matches[1]}'"
        : "Duplicate entry error";
    }

    if (Str::contains($message, 'foreign key constraint')) {
      return "Invalid role_id or foreign key mismatch";
    }

    return "Something went wrong";
  }


  /*
    |---------------------------------------
    | TEAM LIST PAGE
    |---------------------------------------
    */
  public function team_list()
  {
    $teams = Team::with(['supervisor', 'technician', 'driver'])->latest()->get();

    $users = ResourceModel::select('id', 'name')->get();

    return view('content.manage_resources.resource_team_list', compact('teams', 'users'));
  }
  public function getUsers(Request $request)
  {
    $search = trim($request->input('search') ?? $request->input('term') ?? '');

    $query = ResourceModel::select('id', 'name')->orderBy('name');

    if ($search !== '') {
      $query->where('name', 'like', "%{$search}%");
    }

    $exclude = $request->input('exclude', []);
    if (!empty($exclude)) {
        if (!is_array($exclude)) {
             $exclude = [$exclude];
        }
        $query->whereNotIn('id', $exclude);
    }

    // Optional: limit results to prevent overload
    $users = $query->limit(50)->get();

    // Format for Select2 (expects id + text)
    $formatted = $users->map(function ($user) {
      return [
        'id'   => $user->id,
        'text' => $user->name . ($user->role ? " ({$user->role})" : ''),
      ];
    });

    return response()->json($formatted);
  }

  public function storeTeam(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'team_name'       => 'required|string|max:100',
      'supervisor_id'   => 'required',
      'technician_ids'  => 'required', // can be array or single from frontend
      'driver_id'       => 'required',
      'other_staff_ids' => 'nullable|array',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'message' => 'Validation failed',
        'errors'  => $validator->errors(),
      ], 422);
    }

    $techId = is_array($request->technician_ids) ? $request->technician_ids[0] : $request->technician_ids;
    
    // Create team
    try {
        $team = Team::create([
            'team_name'       => $request->team_name,
            'supervisor_id'   => $request->supervisor_id,
            'technician_id'   => $techId,
            'driver_id'       => $request->driver_id,
            'other_staff_ids' => $request->other_staff_ids,
        ]);

        return response()->json([
          'success' => true,
          'message' => 'Team created successfully!',
          'team'    => array_merge($team->toArray(), [
                'supervisor_name' => ResourceModel::find($team->supervisor_id)->name ?? '',
                'technician_name' => ResourceModel::find($team->technician_id)->name ?? '',
                'driver_name' => ResourceModel::find($team->driver_id)->name ?? ''
            ])
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ], 500);
    }
  }
  /*
    |---------------------------------------
    | SHOW SINGLE TEAM (EDIT)
    |---------------------------------------
    */
  public function team_show($id)
  {
    $team = Team::with(['supervisor', 'technician', 'driver'])->find($id);

    if (!$team) {
      return response()->json([
        'status' => false,
        'message' => 'Team not found'
      ]);
    }

    return response()->json([
      'status' => true,
      'data' => $team
    ]);
  }

  /*
    |---------------------------------------
    | UPDATE TEAM
    |---------------------------------------
    */
  public function team_update(Request $request, $id)
  {
    $team = Team::find($id);

    if (!$team) {
      return response()->json([
        'status' => false,
        'message' => 'Team not found'
      ]);
    }

    $techId = is_array($request->technician_ids) ? $request->technician_ids[0] : ($request->technician_ids ?? $request->technician_id);

    $team->update([
      'team_name' => $request->team_name,
      'supervisor_id' => $request->supervisor_id,
      'technician_id' => $techId,
      'driver_id' => $request->driver_id,
      'other_staff_ids' => $this->normalizeStaff($request->other_staff_ids),
    ]);

    return response()->json([
      'success' => true,
      'status' => true,
      'message' => 'Team updated successfully',
      'data' => array_merge($team->toArray(), [
          'supervisor_name' => ResourceModel::find($team->supervisor_id)->name ?? '',
          'technician_name' => ResourceModel::find($team->technician_id)->name ?? '',
          'driver_name' => ResourceModel::find($team->driver_id)->name ?? ''
      ])
    ]);
  }

  /*
    |---------------------------------------
    | DELETE TEAM
    |---------------------------------------
    */
  public function team_delete($id)
  {
    $team = Team::find($id);

    if (!$team) {
      return response()->json([
        'status' => false,
        'message' => 'Team not found'
      ]);
    }

    $team->delete();

    return response()->json([
      'status' => true,
      'message' => 'Team deleted successfully'
    ]);
  }

  /*
    |---------------------------------------
    | HELPER: Normalize staff IDs
    |---------------------------------------
    */
  private function normalizeStaff($data)
  {
    if (empty($data)) {
      return [];
    }

    if (is_array($data)) {
      return $data;
    }

    $decoded = json_decode($data, true);

    return is_array($decoded) ? $decoded : [];
  }
  public function availability_list()
  {
    $resources = ResourceModel::with('role')->get();
    return view('content.manage_resources.available_resource_list', compact('resources'));
  }
}
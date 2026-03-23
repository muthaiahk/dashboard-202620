<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditTrail;

class RolePermission extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Roles & Permissions,is_read')->only('index');
        $this->middleware('permission:Roles & Permissions,is_create')->only('store');
        $this->middleware('permission:Roles & Permissions,is_update')->only(['update', 'Roleupdate']);
        $this->middleware('permission:Roles & Permissions,is_delete')->only('destroy');
    }

    public function index()
  {
    // Load roles with permissions + users
    $roles = Role::with(['permissions', 'users'])->get();

    // Get modules from permissions table
    $modules = Permission::pluck('module');

    // Fallback modules (if empty)
    if ($modules->isEmpty()) {
      $modules = collect([
        'Dashboard',
        'Manage Customer Asset',
        'Manage Work Order',
        'Manage Inventory',
        'Manage Procedure',
        'Manage Resources',
        'Tools & Equipment',
        'Roles & Permissions',
        'Manage Client',
      ]);
    }

    $trails = AuditTrail::with('user')
      ->orderBy('created_at', 'desc')
      ->get();

    return view('content.role_permission.role_list', compact('roles', 'modules', 'trails'));
  }

  public function update(Request $request)
  {
    $role = Role::findOrFail($request->role_id);
    $permission = Permission::where('module', $request->module)->firstOrFail();

    $existing = $role->permissions()->where('permission_id', $permission->id)->first();

    $oldData = [
      'is_create' => $existing->pivot->is_create ?? 0,
      'is_read' => $existing->pivot->is_read ?? 0,
      'is_update' => $existing->pivot->is_update ?? 0,
      'is_delete' => $existing->pivot->is_delete ?? 0,
      'is_approve' => $existing->pivot->is_approve ?? 0,
    ];

    $newData = $oldData;
    $newData[$request->type] = $request->value;

    // Update permission
    $role->permissions()->syncWithoutDetaching([
      $permission->id => $newData
    ]);

    // Helper inside your update() method when creating AuditTrail:
    $actionWord = $request->value
      ? (in_array($request->type, ['is_create', 'is_read', 'is_update', 'is_delete', 'is_approve']) ? 'added' : 'granted')
      : 'removed';

    // Clean up the type to a readable word without prefix 'is_'
    $permissionName = strtolower(str_replace('is_', '', $request->type));

    // Compose details
    $details = "{$request->module} {$permissionName} permission {$actionWord}";

    // 🔥 Store Audit Log
    AuditTrail::create([
      'role' => $role->name,
      'module' => $request->module,
      'action' => 'permission_update',
      'model' => 'RolePermission',
      'model_id' => $role->id,
      'old_values' => $oldData,
      'new_values' => $newData,
      'details' => $details,
      'updated_by' => Auth::id(),
    ]);

    return response()->json([
      'success' => true,
      'message' => 'Permission updated'
    ]);
  }
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255|unique:roles,name',
      'description' => 'nullable|string|max:500',
    ]);

    $role = Role::create([
      'name' => $request->name,
      'status' => 1
    ]);

    return response()->json([
      'success' => true,
      'message' => 'Role created successfully',
      'data' => $role
    ]);
  }

  public function Roleupdate(Request $request)
  {
    $role = Role::findOrFail($request->id);

    $request->validate([
      'name' => 'required|unique:roles,name,' . $role->id,
    ]);

    $role->update([
      'name' => $request->name,
    ]);

    return response()->json([
      'success' => true,
      'message' => 'Role updated successfully'
    ]);
  }
  public function destroy(Request $request)
  {
    $role = Role::findOrFail($request->id);
    $role->delete(); // soft delete

    return response()->json([
      'success' => true,
      'message' => 'Role deleted successfully'
    ]);
  }
}
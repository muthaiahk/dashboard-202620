<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RolePermission extends Controller
{
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

    return view('content.role_permission.role_list', compact('roles', 'modules'));
  }

  public function update(Request $request)
  {
    $role = Role::findOrFail($request->role_id);
    $permission = Permission::where('module', $request->module)->firstOrFail();

    $existing = $role->permissions()->where('permission_id', $permission->id)->first();

    $data = [
      'is_create' => $existing->pivot->is_create ?? 0,
      'is_read' => $existing->pivot->is_read ?? 0,
      'is_update' => $existing->pivot->is_update ?? 0,
      'is_delete' => $existing->pivot->is_delete ?? 0,
      'is_approve' => $existing->pivot->is_approve ?? 0,
    ];

    $data[$request->type] = $request->value;

    $role->permissions()->syncWithoutDetaching([
      $permission->id => $data
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
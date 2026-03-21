<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\Client;
use App\Models\Asset;
use App\Models\Procedure;
use App\Models\ResourceModel;
use App\Models\ToolsEquipment;
use Illuminate\Support\Facades\Validator;

class ManageWorkOrder extends Controller
{
    public function index()
    {
        $workOrders = WorkOrder::with(['client', 'asset', 'procedure', 'resources', 'tools'])->orderBy('id', 'desc')->get();
        $clients = Client::get();
        $assets = Asset::all();
        $procedures = Procedure::all();
        $resources = ResourceModel::all();
        $tools = ToolsEquipment::all();

        return view('content.manage_workorder.workorder_panel_list', compact(
            'workOrders',
            'clients',
            'assets',
            'procedures',
            'resources',
            'tools'
        ));
    }

    public function calendar_list()
    {
        return view('content.manage_workorder.workorder_calendar_view');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'asset_id' => 'required|exists:assets,id',
            'procedure_id' => 'required|exists:procedures,id',
            'title' => 'nullable|string|max:255',
            'order_type' => 'required|string',
            'priority' => 'required|string',
            'compliance_date' => 'required|date',
            'assigned_date' => 'required|date',
            'tentative_removal_date' => 'required|date',
            'description' => 'nullable|string',
            'recurrence' => 'nullable|string',
            'scaff_crane' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        $data = $request->only([
            'client_id', 'asset_id', 'procedure_id', 'title', 'order_type', 'priority', 
            'description', 'abc_ind', 'scheduling_grp', 'haz_area', 'act_type', 'cnfn_no', 
            'no_men', 'dur_hrs', 'st_txt_key', 'oper_no', 'catalog_profile', 'om_manual_doc_no',
            'material_no_desc', 'recurrence', 'scaff_crane'
        ]);

        $data['compliance_date'] = \Carbon\Carbon::parse($request->compliance_date)->format('Y-m-d');
        $data['assigned_date'] = \Carbon\Carbon::parse($request->assigned_date)->format('Y-m-d');
        $data['tentative_removal_date'] = \Carbon\Carbon::parse($request->tentative_removal_date)->format('Y-m-d');

        $workOrder = WorkOrder::create($data);

        if ($request->has('tools')) {
            $workOrder->tools()->attach($request->tools);
        }

        return response()->json(['success' => true, 'message' => 'Work Order created successfully.']);
    }

    public function show($id)
    {
        $workOrder = WorkOrder::with(['client', 'asset', 'procedure', 'resources', 'tools'])->find($id);

        if (!$workOrder) {
            return response()->json(['success' => false, 'message' => 'Work Order not found.']);
        }

        return response()->json(['success' => true, 'data' => $workOrder]);
    }

    public function update(Request $request, $id)
    {
        $workOrder = WorkOrder::find($id);

        if (!$workOrder) {
            return response()->json(['success' => false, 'message' => 'Work Order not found.']);
        }

        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'asset_id' => 'required|exists:assets,id',
            'procedure_id' => 'required|exists:procedures,id',
            'title' => 'nullable|string|max:255',
            'order_type' => 'required|string',
            'priority' => 'required|string',
            'compliance_date' => 'required|date',
            'assigned_date' => 'required|date',
            'tentative_removal_date' => 'required|date',
            'description' => 'nullable|string',
            'recurrence' => 'nullable|string',
            'scaff_crane' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        $data = $request->only([
            'client_id', 'asset_id', 'procedure_id', 'title', 'order_type', 'priority', 
            'description', 'abc_ind', 'scheduling_grp', 'haz_area', 'act_type', 'cnfn_no', 
            'no_men', 'dur_hrs', 'st_txt_key', 'oper_no', 'catalog_profile', 'om_manual_doc_no',
            'material_no_desc', 'recurrence', 'scaff_crane'
        ]);

        $data['compliance_date'] = \Carbon\Carbon::parse($request->compliance_date)->format('Y-m-d');
        $data['assigned_date'] = \Carbon\Carbon::parse($request->assigned_date)->format('Y-m-d');
        $data['tentative_removal_date'] = \Carbon\Carbon::parse($request->tentative_removal_date)->format('Y-m-d');

        $workOrder->update($data);

        if ($request->has('tools')) {
            $workOrder->tools()->sync($request->tools);
        } else {
            $workOrder->tools()->detach();
        }

        return response()->json(['success' => true, 'message' => 'Work Order updated successfully.']);
    }

    public function destroy($id)
    {
        $workOrder = WorkOrder::find($id);

        if (!$workOrder) {
            return response()->json(['success' => false, 'message' => 'Work Order not found.']);
        }

        $workOrder->delete();

        return response()->json(['success' => true, 'message' => 'Work Order deleted successfully.']);
    }

    public function updateWizard(Request $request, $id)
    {
        $workOrder = WorkOrder::find($id);

        if (!$workOrder) {
            return response()->json(['success' => false, 'message' => 'Work Order not found.']);
        }

        $wizardData = $request->except(['_token', 'work_order_id', '_method']);

        $existingData = is_string($workOrder->wizard_data) ? json_decode($workOrder->wizard_data, true) : ($workOrder->wizard_data ?? []);

        $imageFields = ['before_images', 'during_images', 'after_images'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $paths = [];
                foreach ($request->file($field) as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/work_orders'), $filename);
                    $paths[] = 'uploads/work_orders/' . $filename;
                }
                
                // Append or replace? Let's replace for now, or merge with existing
                if (isset($existingData[$field]) && is_array($existingData[$field])) {
                    $wizardData[$field] = array_merge($existingData[$field], $paths);
                } else {
                    $wizardData[$field] = $paths;
                }
            } elseif (isset($existingData[$field])) {
                $wizardData[$field] = $existingData[$field];
            } else {
                unset($wizardData[$field]); // Ensure we don't save empty file inputs
            }
        }
        
        // Remove raw UploadedFile objects to prevent JSON serialization errors
        foreach ($wizardData as $key => $value) {
            if ($value instanceof \Illuminate\Http\UploadedFile || (is_array($value) && isset($value[0]) && $value[0] instanceof \Illuminate\Http\UploadedFile)) {
                unset($wizardData[$key]);
            }
        }

        $workOrder->update(['wizard_data' => $wizardData]);

        return response()->json(['success' => true, 'message' => 'Wizard saved successfully.']);
    }
}

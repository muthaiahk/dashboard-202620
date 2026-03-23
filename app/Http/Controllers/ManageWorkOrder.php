<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\WorkOrderHistory;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WorkOrderImport;
use App\Models\Client;
use App\Models\Team;
use App\Models\Asset;
use App\Models\User;
use App\Models\Procedure;
use App\Models\ResourceModel;
use App\Models\ToolsEquipment;
use App\Models\WoInspection;
use App\Models\Validation;
use App\Models\WoPreparation;
use App\Models\WoApproval;
use App\Models\WoExecution;
use App\Models\WorkorderClosure;
use Illuminate\Support\Facades\Validator;

class ManageWorkOrder extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Manage Work Order,is_read')->only(['index', 'calendar_list', 'show', 'getHistory', 'downloadSample']);
        $this->middleware('permission:Manage Work Order,is_create')->only(['store', 'bulkUpload']);
        $this->middleware('permission:Manage Work Order,is_update')->only(['update', 'saveWizardStep', 'addComment']);
        $this->middleware('permission:Manage Work Order,is_delete')->only('destroy');
    }

    public function index()
    {
        $workOrders = WorkOrder::with(['client', 'asset', 'procedure', 'resources', 'tools'])->orderBy('id', 'desc')->get();
        $clients = Client::get();
        $users = User::get();
        $assets = Asset::all();
        $teams = Team::with(['supervisor', 'technician', 'driver'])->get();
        $procedures = Procedure::all();
        $resources = ResourceModel::all();
        $tools = ToolsEquipment::all();

        return view('content.manage_workorder.workorder_panel_list', compact(
            'workOrders',
            'clients',
            'users',
            'assets',
            'teams',
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
        $workOrder = WorkOrder::with([
            'client', 'asset', 'procedure', 'resources', 'tools',
            'inspection', 'validation', 'preparation', 'approval', 'execution', 'closure'
        ])->find($id);

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

    /**
     * Save a single wizard step.
     * Expects: step (0-5) + step-specific form fields.
     */
    public function saveWizardStep(Request $request, $id)
    {
        $workOrder = WorkOrder::find($id);

        if (!$workOrder) {
            return response()->json(['success' => false, 'message' => 'Work Order not found.']);
        }

        $step = (int) $request->input('step', 0);

        if ($step < 0 || $step > 5) {
            return response()->json(['success' => false, 'message' => 'Invalid wizard step.']);
        }

        $stepNames = [
            0 => 'Inspection & Permit',
            1 => 'Validation',
            2 => 'Preparation',
            3 => 'Approval',
            4 => 'Execution',
            5 => 'Closure',
        ];

        try {
            if ($step === 3 && !$request->user()->hasPermission('Manage Work Order', 'is_approve')) {
                return response()->json(['success' => false, 'message' => 'Unauthorized for approval step.'], 403);
            }

            switch ($step) {
                case 0:
                    $this->saveStepInspection($request, $workOrder);
                    break;
                case 1:
                    $this->saveStepValidation($request, $workOrder);
                    break;
                case 2:
                    $this->saveStepPreparation($request, $workOrder);
                    break;
                case 3:
                    $this->saveStepApproval($request, $workOrder);
                    break;
                case 4:
                    $this->saveStepExecution($request, $workOrder);
                    break;
                case 5:
                    $this->saveStepClosure($request, $workOrder);
                    break;
            }

            // Update wizard progress
            $newStep = $step + 1;
            $updateData = [];

            if ($newStep > $workOrder->wizard_current_step) {
                $updateData['wizard_current_step'] = $newStep;
            }

            if ($step === 5) {
                $updateData['wizard_status'] = 'completed';
                $updateData['wizard_current_step'] = 6; // All done
                $updateData['status'] = 'Closed'; 
            } elseif ($workOrder->wizard_status === 'pending') {
                $updateData['wizard_status'] = 'in_progress';
            }

            if (!empty($updateData)) {
                $workOrder->update($updateData);
            }

            // Log history
            $this->logHistory($workOrder->id, $stepNames[$step] . " saved");

            return response()->json([
                'success' => true,
                'message' => $stepNames[$step] . ' saved successfully.',
                'wizard_current_step' => $workOrder->fresh()->wizard_current_step,
                'wizard_status' => $workOrder->fresh()->wizard_status,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving step: ' . $e->getMessage(),
            ]);
        }
    }

    // ─── STEP 0: Inspection & Permit ─────────────────────────
    private function saveStepInspection(Request $request, WorkOrder $workOrder)
    {
        $data = $request->only([
            'site_condition_notes', 'obstruction_notes', 'special_tools_required',
            'access_issues', 'safety_concerns', 'permit_number',
            'permit_transferred_by', 'staff_mobile_no', 'staff_email_id',
        ]);

        $data['assigned_team_id'] = $request->input('assign_team') ?: null;

        // Handle file upload
        if ($request->hasFile('permit_files')) {
            $paths = [];
            foreach ($request->file('permit_files') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/work_orders'), $filename);
                $paths[] = 'uploads/work_orders/' . $filename;
            }
            $data['permit_upload'] = json_encode($paths);
        }

        WoInspection::updateOrCreate(
            ['workorder_id' => $workOrder->id],
            $data
        );
    }

    // ─── STEP 1: Validation ──────────────────────────────────
    private function saveStepValidation(Request $request, WorkOrder $workOrder)
    {
        $checkboxFields = [
            'tbt_100_percent_checked', 'assigned_members_checked',
            'obstruction_notes_checked', 'special_tools_checked',
            'access_issues_checked', 'safety_concerns_checked',
            'site_condition_checked', 'documents_permits_checked',
        ];

        // Map form checkbox names to DB column names
        $columnMap = [
            'tbt_100_percent_checked' => 'tools',
            'assigned_members_checked' => 'assigned_members',
            'obstruction_notes_checked' => 'obstruction_notes',
            'special_tools_checked' => 'special_tools',
            'access_issues_checked' => 'access_issues',
            'safety_concerns_checked' => 'safety_concerns',
            'site_condition_checked' => 'site_condition_notes',
            'documents_permits_checked' => 'documents_permits',
        ];

        $data = [];
        foreach ($checkboxFields as $field) {
            $dbCol = $columnMap[$field];
            $data[$dbCol] = $request->has($field) ? true : false;
        }

        Validation::updateOrCreate(
            ['workorder_id' => $workOrder->id],
            $data
        );
    }

    // ─── STEP 2: Preparation ─────────────────────────────────
    private function saveStepPreparation(Request $request, WorkOrder $workOrder)
    {
        $boolFields = [
            'pre_ptw_approved', 'pre_gate_pass_valid', 'pre_weather_verified',
            'pre_equipment_readiness', 'pre_team_certs_valid', 'pre_loto_applied',
        ];

        $data = [];
        foreach ($boolFields as $field) {
            $data[$field] = $request->has($field) ? true : false;
        }

        $data['escalate'] = $request->has('escalate_prep') ? true : false;
        $data['tech_notes'] = $request->input('tech_notes_prep');
        $data['pre_checklist'] = $request->input('pre_checklist', []);

        WoPreparation::updateOrCreate(
            ['workorder_id' => $workOrder->id],
            $data
        );
    }

    // ─── STEP 3: Approval ────────────────────────────────────
    private function saveStepApproval(Request $request, WorkOrder $workOrder)
    {
        $data = [
            'escalate' => $request->has('escalate_approval') ? true : false,
            'tech_notes' => $request->input('tech_notes_approval'),
        ];

        WoApproval::updateOrCreate(
            ['workorder_id' => $workOrder->id],
            $data
        );
    }

    // ─── STEP 4: Execution ───────────────────────────────────
    private function saveStepExecution(Request $request, WorkOrder $workOrder)
    {
        $safetyFields = [
            'exec_safety_loto', 'exec_safety_depressurized', 'exec_safety_lifting',
            'exec_safety_ventilation', 'exec_safety_ppe',
        ];

        $safety = [];
        foreach ($safetyFields as $f) {
            $safety[$f] = $request->has($f) ? true : false;
        }

        // The procedure checklist is now dynamically generated from the Procedure model.
        // It returns an array of checked step values (strings).
        $procedure = $request->input('procedure_checklist', []);

        WoExecution::updateOrCreate(
            ['workorder_id' => $workOrder->id],
            [
                'safety_checklist' => $safety,
                'procedure_checklist' => $procedure,
                'remarks' => $request->input('exec_remarks'),
            ]
        );
    }

    // ─── STEP 5: Closure ─────────────────────────────────────
    private function saveStepClosure(Request $request, WorkOrder $workOrder)
    {
        $data = [
            'workflow_status' => $request->input('workflow'),
            'final_status' => 'closed',
        ];

        $imageFields = ['before_images', 'during_images', 'after_images'];
        $dbFields = ['before_image', 'during_image', 'after_image'];

        foreach ($imageFields as $i => $field) {
            if ($request->hasFile($field)) {
                $paths = [];
                foreach ($request->file($field) as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/work_orders'), $filename);
                    $paths[] = 'uploads/work_orders/' . $filename;
                }
                $data[$dbFields[$i]] = json_encode($paths);
            }
        }

        WorkorderClosure::updateOrCreate(
            ['workorder_id' => $workOrder->id],
            $data
        );
    }

    public function getHistory($id)
    {
        $history = WorkOrderHistory::with('user')
            ->where('work_order_id', $id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'user_name' => $item->user ? $item->user->name : 'System',
                    'action' => $item->action,
                    'description' => $item->description,
                    'time' => $item->created_at->format('d-M-Y h:i A'),
                    'type' => $item->type
                ];
            });
            
        return response()->json(['success' => true, 'data' => $history]);
    }

    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);
        
        $this->logHistory($id, 'Comment Added', $request->comment, 'manual');
        
        return response()->json(['success' => true, 'message' => 'Comment added successfully.']);
    }

    private function logHistory($workOrderId, $action, $description = null, $type = 'system')
    {
        WorkOrderHistory::create([
            'work_order_id' => $workOrderId,
            'user_id' => auth()->id(),
            'type' => $type,
            'action' => $action,
            'description' => $description,
        ]);
    }

    public function bulkUpload(Request $request)
    {
        try {
            if (!$request->hasFile('file')) {
                return response()->json(['status' => false, 'message' => 'Please upload a file.']);
            }

            $import = new WorkOrderImport();
            Excel::import($import, $request->file('file'));

            $errors = $import->getErrors();
            $message = "Upload completed. Created: " . $import->getCreatedCount();
            
            if (count($errors) > 0) {
                $message .= ". Errors found in some rows: " . implode(', ', array_slice($errors, 0, 3));
                if (count($errors) > 3) $message .= "... and " . (count($errors) - 3) . " more errors.";
            }

            return response()->json([
                'status' => true,
                'message' => $message,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function downloadSample()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=work_order_bulk_sample.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'Title', 'Asset Tag', 'Client Name', 'Procedure Title', 'Status', 
            'Order Type', 'Priority', 'Scheduled Date', 'Compliance Date', 
            'Assigned Date', 'Tentative Removal Date', 'Description', 
            'ABC Indicator', 'Scheduling Group', 'Hazard Area', 'Activity Type', 
            'Confinement No', 'Number of Men', 'Duration Hours', 
            'Standard Text Key', 'Operation No', 'Catalog Profile', 
            'OM Manual No', 'Material Description', 'Recurrence', 'Scaff Crane'
        ];

        $callback = function() use($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            // Add a sample row (matching Asset Tag, Client Company Name, Procedure Title)
            fputcsv($file, [
                'Annual Valve Inspection', 'VLV-001', 'Aramco', 'Valve Maintenance Procedure', 'pending',
                'Preventive', 'High', '2026-04-01', '2026-04-15', 
                '2026-03-25', '2026-04-10', 'Routine annual inspection of main isolation valve.',
                'A', 'G01', 'AREA-A', 'INSP', 
                'C-101', '2', '8', 
                'KEY-01', 'OP-02', 'PROF-01', 
                'MAN-99', 'High Pressure Isolation Valve', 'Yearly', 'Crane Required'
            ]);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}


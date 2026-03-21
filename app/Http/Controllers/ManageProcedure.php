<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Procedure;
use App\Models\Asset;

class ManageProcedure extends Controller
{
    public function index()
    {
        $procedures = Procedure::orderBy('id', 'desc')->get();

        // Get distinct asset types from assets table + procedures table
        $assetTypes = Asset::whereNotNull('tag_number')
            ->distinct()
            ->pluck('tag_number')
            ->merge(
                Procedure::whereNotNull('asset_type')
                    ->distinct()
                    ->pluck('asset_type')
            )
            ->unique()
            ->filter()
            ->values();

        // If no asset types in DB, provide defaults
        if ($assetTypes->isEmpty()) {
            $assetTypes = collect(['Safety Relief Valve', 'Gate Valve', 'Check Valve', 'Ball Valve', 'Butterfly Valve', 'Globe Valve', 'Plug Valve', 'Needle Valve', 'Pressure Relief Valve', 'Control Valve']);
        }

        return view('content.manage_procedure.procedure_panel_list', compact('procedures', 'assetTypes'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title'      => 'required|string|max:255',
                'asset_type' => 'required|string|max:255',
            ]);

            $procedure = Procedure::create([
                'title'          => $request->title,
                'procedure_code' => $request->procedure_code,
                'description'    => $request->description,
                'asset_type'     => $request->asset_type,
                'work_category'  => $request->work_category,
                'steps'          => $request->steps,
                'pre_checklist'  => $request->pre_checklist,
                'post_checklist' => $request->post_checklist,
                'required_tools' => $request->required_tools,
                'status'         => 1,
            ]);

            return response()->json(['status' => true, 'message' => 'Procedure created successfully', 'data' => $procedure]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => false, 'message' => $e->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $procedure = Procedure::find($id);
        if (!$procedure) {
            return response()->json(['status' => false, 'message' => 'Procedure not found'], 404);
        }
        return response()->json(['status' => true, 'data' => $procedure]);
    }

    public function update(Request $request, $id)
    {
        $procedure = Procedure::find($id);
        if (!$procedure) {
            return response()->json(['status' => false, 'message' => 'Procedure not found'], 404);
        }

        try {
            $request->validate([
                'title'      => 'required|string|max:255',
                'asset_type' => 'required|string|max:255',
            ]);

            $procedure->update([
                'title'          => $request->title,
                'procedure_code' => $request->procedure_code,
                'description'    => $request->description,
                'asset_type'     => $request->asset_type,
                'work_category'  => $request->work_category,
                'steps'          => $request->steps,
                'pre_checklist'  => $request->pre_checklist,
                'post_checklist' => $request->post_checklist,
                'required_tools' => $request->required_tools,
            ]);

            return response()->json(['status' => true, 'message' => 'Procedure updated successfully', 'data' => $procedure]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => false, 'message' => $e->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
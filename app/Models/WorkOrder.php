<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'asset_id',
        'client_id',
        'procedure_id',
        'status',
        'scheduled_date',
        'completed_date',
        'description',
        'order_type',
        'priority',
        'compliance_date',
        'assigned_date',
        'tentative_removal_date',
        'abc_ind',
        'scheduling_grp',
        'haz_area',
        'act_type',
        'cnfn_no',
        'no_men',
        'dur_hrs',
        'st_txt_key',
        'oper_no',
        'catalog_profile',
        'om_manual_doc_no',
        'material_no_desc',
        'recurrence',
        'scaff_crane',
        'wizard_data',
        'wizard_current_step',
        'wizard_status',
    ];

    protected $casts = [
        'wizard_data' => 'array',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }

    public function resources()
    {
        return $this->belongsToMany(ResourceModel::class, 'work_order_resource', 'work_order_id', 'resource_id');
    }

    public function tools()
    {
        return $this->belongsToMany(ToolsEquipment::class, 'work_order_tool', 'work_order_id', 'tool_id');
    }

    public function inventories()
    {
        return $this->belongsToMany(Inventory::class, 'work_order_inventory', 'work_order_id', 'inventory_id')
            ->withPivot('quantity_used')
            ->withTimestamps();
    }

    public function inspection()
    {
        return $this->hasOne(WoInspection::class, 'workorder_id');
    }

    public function validation()
    {
        return $this->hasOne(Validation::class, 'workorder_id');
    }

    public function preparation()
    {
        return $this->hasOne(WoPreparation::class, 'workorder_id');
    }

    public function approval()
    {
        return $this->hasOne(WoApproval::class, 'workorder_id');
    }

    public function execution()
    {
        return $this->hasOne(WoExecution::class, 'workorder_id');
    }

    public function closure()
    {
        return $this->hasOne(WorkorderClosure::class, 'workorder_id');
    }

    public function histories()
    {
        return $this->hasMany(WorkOrderHistory::class);
    }

    /**
     * Get the related model data for a given wizard step index.
     */
    public function getStepRelation($step)
    {
        $map = [
            0 => 'inspection',
            1 => 'validation',
            2 => 'preparation',
            3 => 'approval',
            4 => 'execution',
            5 => 'closure',
        ];
        return $map[$step] ?? null;
    }
}
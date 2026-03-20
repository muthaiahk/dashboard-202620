<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'asset_id',
        'client_id',
        'procedure_id',
        'status',
        'scheduled_date',
        'completed_date'
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
}

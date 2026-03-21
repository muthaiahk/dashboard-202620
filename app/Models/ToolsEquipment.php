<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolsEquipment extends Model
{
    use HasFactory;

    protected $table = "equipments";

    protected $fillable = ['name', 'type', 'status', 'description', 'serial_number'];

    public function workOrders()
    {
        return $this->belongsToMany(WorkOrder::class, 'work_order_tool', 'tool_id', 'work_order_id');
    }
}
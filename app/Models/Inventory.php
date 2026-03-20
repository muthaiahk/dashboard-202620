<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', // valve, spare_part, calibration
        'name',
        'quantity',
        'location',
        'status'
    ];

    public function workOrders()
    {
        return $this->belongsToMany(WorkOrder::class, 'work_order_inventory', 'inventory_id', 'work_order_id')
                    ->withPivot('quantity_used')
                    ->withTimestamps();
    }
}

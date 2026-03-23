<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleMaintenanceLog extends BaseModel
{

    protected $table = 'vehicle_maintenance_logs';
    protected $fillable = [
        'vehicle_id',
        'purpose',
        'date',
        'ownership',
        'description'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
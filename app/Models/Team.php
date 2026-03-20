<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_name',
        'supervisor_id',
        'technician_id',
        'driver_id',
        'other_staff_ids',
    ];

    // Convert JSON → array automatically
    protected $casts = [
        'other_staff_ids' => 'array',
    ];

    /*
    |---------------------------------------
    | Relationships (single user roles)
    |---------------------------------------
    */

    public function supervisor()
    {
        return $this->belongsTo(ResourceModel::class, 'supervisor_id');
    }

    public function technician()
    {
        return $this->belongsTo(ResourceModel::class, 'technician_id');
    }

    public function driver()
    {
        return $this->belongsTo(ResourceModel::class, 'driver_id');
    }

    /*
    |---------------------------------------
    | Helper: get all staff users
    |---------------------------------------
    */

    public function otherStaffUsers()
    {
        return ResourceModel::whereIn('id', $this->other_staff_ids ?? [])->get();
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends BaseModel
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
        return ResourceModel::with('role')->whereIn('id', $this->other_staff_ids ?? [])->get();
    }

    protected $appends = ['all_members_data'];

    public function getAllMembersDataAttribute()
    {
        $members = [];
        if ($this->supervisor) $members[] = ['role' => 'Supervisor', 'name' => $this->supervisor->name, 'status' => $this->supervisor->status];
        if ($this->technician) $members[] = ['role' => 'Technician', 'name' => $this->technician->name, 'status' => $this->technician->status];
        if ($this->driver) $members[] = ['role' => 'Driver', 'name' => $this->driver->name, 'status' => $this->driver->status];

        foreach ($this->otherStaffUsers() as $staff) {
            $members[] = [
                'role' => $staff->role ? $staff->role->name : 'Staff',
                'name' => $staff->name,
                'status' => $staff->status
            ];
        }

        return $members;
    }
}
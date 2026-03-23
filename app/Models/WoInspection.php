<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WoInspection extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'workorder_id',
        'site_condition_notes',
        'obstruction_notes',
        'special_tools_required',
        'access_issues',
        'safety_concerns',
        'permit_number',
        'permit_transferred_by',
        'staff_mobile_no',
        'staff_email_id',
        'assigned_team_id',
        'permit_upload'
    ];

    // 🔗 संबंध → Workorder
    public function workorder()
    {
        return $this->belongsTo(Workorder::class);
    }

    // 🔗 Assigned User
    public function assignedTeam()
    {
        return $this->belongsTo(User::class, 'assigned_team_id');
    }
}
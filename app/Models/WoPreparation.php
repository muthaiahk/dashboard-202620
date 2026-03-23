<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WoPreparation extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'workorder_id',
        'pre_ptw_approved',
        'pre_gate_pass_valid',
        'pre_weather_verified',
        'pre_equipment_readiness',
        'pre_team_certs_valid',
        'pre_loto_applied',
        'assigned_tools',
        'pre_checklist',
        'escalate',
        'tech_notes',
    ];

    protected $casts = [
        'pre_ptw_approved' => 'boolean',
        'pre_gate_pass_valid' => 'boolean',
        'pre_weather_verified' => 'boolean',
        'pre_equipment_readiness' => 'boolean',
        'pre_team_certs_valid' => 'boolean',
        'pre_loto_applied' => 'boolean',
        'escalate' => 'boolean',
        'assigned_tools' => 'array',
        'pre_checklist' => 'array',
    ];

    public function workorder()
    {
        return $this->belongsTo(WorkOrder::class, 'workorder_id');
    }
}

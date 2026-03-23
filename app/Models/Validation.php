<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'workorder_id',
        'tools',
        'assigned_members',
        'obstruction_notes',
        'special_tools',
        'access_issues',
        'safety_concerns',
        'site_condition_notes',
        'documents_permits'
    ];

    // 🔗 Workorder relation
    public function workorder()
    {
        return $this->belongsTo(Workorder::class);
    }
}
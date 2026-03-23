<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WoExecution extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'workorder_id',
        'safety_checklist',
        'procedure_checklist',
        'remarks',
    ];

    protected $casts = [
        'safety_checklist' => 'array',
        'procedure_checklist' => 'array',
    ];

    public function workorder()
    {
        return $this->belongsTo(WorkOrder::class, 'workorder_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WoApproval extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'workorder_id',
        'escalate',
        'tech_notes',
    ];

    protected $casts = [
        'escalate' => 'boolean',
    ];

    public function workorder()
    {
        return $this->belongsTo(WorkOrder::class, 'workorder_id');
    }
}

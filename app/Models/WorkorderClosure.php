<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkorderClosure extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'workorder_id',
        'before_image',
        'during_image',
        'after_image',
        'workflow_status',
        'final_status',
    ];

    // 🔗 Workorder relation
    public function workorder()
    {
        return $this->belongsTo(Workorder::class);
    }
}
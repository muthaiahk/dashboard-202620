<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'procedure_code', 'description', 'asset_type',
        'work_category', 'steps', 'pre_checklist', 'post_checklist',
        'required_tools', 'status'
    ];

    protected $casts = [
        'steps'          => 'array',
        'pre_checklist'  => 'array',
        'post_checklist' => 'array',
        'required_tools' => 'array',
    ];

    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class);
    }
}

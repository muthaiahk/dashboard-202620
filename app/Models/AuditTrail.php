<?php

// app/Models/AuditTrail.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditTrail extends BaseModel
{
    protected $fillable = [
        'role',
        'module',
        'action',
        'model',
        'model_id',
        'old_values',
        'new_values',
        'details',
        'updated_by'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
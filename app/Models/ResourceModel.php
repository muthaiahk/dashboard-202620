<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceModel extends Model
{
    use HasFactory;

    protected $table = 'resources';

    protected $fillable = [
        'name',
        'mobile_number',
        'email',
        'role_id',
        'status',
        'address',
        'certificates',
        'permits',
        'avatar'
    ];

    protected $casts = [
        'certificates' => 'array',
        'permits' => 'array',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
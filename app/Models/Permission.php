<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['module'];

    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->withPivot('is_create', 'is_read', 'is_update', 'is_delete', 'is_approve')
            ->withTimestamps();
    }
}
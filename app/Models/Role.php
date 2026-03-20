<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'status'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)
            ->withPivot('is_create', 'is_read', 'is_update', 'is_delete', 'is_approve')
            ->withTimestamps();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
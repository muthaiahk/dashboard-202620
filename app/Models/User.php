<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile_number',
        'otp',
        'otp_expires_at',
        'role_id',
        'status',
        'address',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'otp',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'otp_expires_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role && $this->role->name === 'Admin';
    }

    public function hasPermission($module, $action)
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (!$this->role) {
            return false;
        }

        $permission = $this->role->permissions()->where('module', $module)->first();

        if (!$permission) {
            return false;
        }

        return (bool) ($permission->pivot->$action ?? false);
    }

    public function hasAnyPermission($module)
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (!$this->role) {
            return false;
        }

        $permission = $this->role->permissions()->where('module', $module)->first();

        if (!$permission) {
            return false;
        }

        $pivot = $permission->pivot;
        return (bool) (($pivot->is_create ?? false) ||
               ($pivot->is_read ?? false) ||
               ($pivot->is_update ?? false) ||
               ($pivot->is_delete ?? false) ||
               ($pivot->is_approve ?? false));
    }
}
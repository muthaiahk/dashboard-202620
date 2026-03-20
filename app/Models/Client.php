<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'address',
        'status'
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class);
    }
}

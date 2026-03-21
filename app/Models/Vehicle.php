<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $table = 'vehicles';

    protected $fillable = [
        'vehicle_name',
        'brand',
        'manufacturer',
        'model',
        'registered_number',
        'engine_number',
        'chasis_number',
        'current_location',
        'capacity',
        'length',
    ];
}
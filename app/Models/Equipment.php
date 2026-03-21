<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';

    protected $fillable = [
        'equipment_name',
        'category',
        'serial_number',
        'manufacturer',
        'model',
        'ownership',
        'current_status',
        'current_location',
        'certificate',
        'expiry_date',
    ];

    protected $dates = ['expiry_date'];

    public function maintenances()
    {
        return $this->hasMany(EquipmentMaintenance::class, 'equipment_id');
    }
}
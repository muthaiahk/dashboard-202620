<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentMaintenance extends Model
{
    use HasFactory;

    protected $table = 'equipment_maintenance';

    protected $fillable = [
        'equipment_id',
        'purpose',
        'date',
        'description',
        'ownership',
    ];

    /**
     * Get the equipment this maintenance belongs to.
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }
}
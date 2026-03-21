<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tag_number',
        'client_id',
        'sector_id',
        'plant_id',
        'room_id',
        'description',
        'valve_type',
        'actual_size',
        'estimated_size',
        'pressure_class',
        'work_center',
        'latitude',
        'longitude',
        'special_tools',
        'scaff_crane',
        'status'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function sector()
    {
        return $this->belongsTo(SectorModel::class);
    }

    public function plant()
    {
        return $this->belongsTo(PlantModel::class);
    }

    public function room()
    {
        return $this->belongsTo(RoomModel::class);
    }

    public function procedures()
    {
        return $this->hasMany(Procedure::class);
    }
}
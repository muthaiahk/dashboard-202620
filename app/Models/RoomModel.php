<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomModel extends Model
{
    use HasFactory;
    public $table      = "rooms";
    public $primaryKey = 'id';


    protected $fillable = [
        'plant_id',
        'sector_id',
        'name',
        'status'
    ];

    public function sector()
    {
        return $this->belongsTo(SectorModel::class, 'sector_id', 'id');
    }

    public function plants()
    {
        return $this->belongsTo(PlantModel::class, 'plant_id', 'id');
    }
}

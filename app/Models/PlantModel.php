<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantModel extends Model
{
    use HasFactory;
    public $table      = "plants";
    public $primaryKey = 'id';


    protected $fillable = [
        'sector_id',
        'name',
        'status'
    ];

    public function sector()
    {
        return $this->belongsTo(SectorModel::class, 'sector_id', 'id');
    }
}

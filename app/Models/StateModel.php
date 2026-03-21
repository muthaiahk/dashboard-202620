<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateModel extends Model
{
    use HasFactory;
    public $table      = "states";
    public $primaryKey = 'sno';


    protected $fillable = [
        'country_id',
        'name',
        'status'
    ];
}

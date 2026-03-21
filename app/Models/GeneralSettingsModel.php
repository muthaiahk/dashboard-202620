<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSettingsModel extends Model
{
    use HasFactory;
    public $table      = "general_settings";
    public $primaryKey = 'id';


    protected $fillable = [
        'title',
        'url',
        'registered_name',
        'country_id',
        'state_id',
        'city_id'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryModel extends BaseModel
{
    use HasFactory;
    public $table      = "countries";
    public $primaryKey = 'sno';


    protected $fillable = [
        'name',
        'status'
    ];
}
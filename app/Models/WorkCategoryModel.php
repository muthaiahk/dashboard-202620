<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkCategoryModel extends BaseModel
{
    use HasFactory;
    public $table      = "work_category";
    public $primaryKey = 'id';


    protected $fillable = [
        'name',
        'status'
    ];
}
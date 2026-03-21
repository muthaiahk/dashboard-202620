<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $fillable = [
        'company_name',
        'mobile_no',
        'email_id',
        'location',
        'address',
        'sector_details',
        'description',
        'status'
    ];
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class);
    }
}
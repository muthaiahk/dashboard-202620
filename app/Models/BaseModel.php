<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BaseModel extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // log all fields
            ->logOnlyDirty() // only changed
            ->useLogName(class_basename($this)) // model name
            ->setDescriptionForEvent(function (string $eventName) {
                return class_basename($this) . " {$eventName}";
            });
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class NotificationUser extends Pivot
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'notification_id',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, NotificationUser::class)
            ->withPivot(['seen_at']);
    }
}

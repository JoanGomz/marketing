<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{
    use HasTimestamps;

    protected $fillable = [
        'user_last_update',
        'user_creator'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check() && $model->isFillable('user_creator')) {
                $model->user_creator = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check() && $model->isFillable('user_last_update')) {
                $model->user_last_update = Auth::id();
            }
        });
    }
}

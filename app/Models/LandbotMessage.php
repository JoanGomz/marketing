<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandbotMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'message_id',
        'message_timestamp',
        'raw_data',
        'conversation_data',
        'is_finished',
        'conversation_date',
        'landbot_chat_id',
        'author_type',
        'customer_phone',
        'conversation_id'
    ];

    protected $casts = [
        'raw_data' => 'array',
        'conversation_data' => 'array',
        'message_timestamp' => 'datetime',
        'conversation_date' => 'datetime',
        'is_finished' => 'boolean'
    ];
}

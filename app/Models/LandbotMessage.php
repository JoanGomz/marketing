<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LandbotMessage extends Model
{
    use HasFactory;

    protected $table = 'landbot_messages';

    protected $fillable = [
        'customer_id',
        'message_id',
        'content',
        'sender_type',
        'message_timestamp',
        'raw_data',
        'conversation_data',
        'customer_name',
        'customer_email',
        'customer_phone',
        'is_finished',
        'conversation_date',
        'chat_id',
        'is_first_message',
        'is_robot',
        'exist'
    ];

    protected $casts = [
        'message_timestamp' => 'datetime',
        'conversation_date' => 'datetime',
        'is_finished' => 'boolean',
        'is_first_message' => 'boolean',
        'is_robot' => 'boolean',
        'exist' => 'boolean',
        'raw_data' => 'array',
        'conversation_data' => 'array'
    ];

    protected $dates = [
        'message_timestamp',
        'conversation_date',
        'created_at',
        'updated_at'
    ];

    // Scope para obtener mensajes por chat
    public function scopeByChatId($query, $chatId)
    {
        return $query->where('chat_id', $chatId);
    }

    // Scope para obtener solo mensajes del bot
    public function scopeBotMessages($query)
    {
        return $query->where('is_robot', true);
    }

    // Scope para obtener solo mensajes del cliente
    public function scopeCustomerMessages($query)
    {
        return $query->where('is_robot', false);
    }

    // Scope para obtener primeros mensajes
    public function scopeFirstMessages($query)
    {
        return $query->where('is_first_message', true);
    }

    // Accessor para formatear la fecha del mensaje
    public function getFormattedMessageTimestampAttribute()
    {
        return $this->message_timestamp ? 
            $this->message_timestamp->format('d/m/Y H:i:s') : null;
    }

    // Accessor para obtener el contenido limpio
    public function getCleanContentAttribute()
    {
        return strip_tags($this->content);
    }
}
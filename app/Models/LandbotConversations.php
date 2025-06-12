<?php

namespace App\Models;

use App\Models\BaseModel;

class LandbotConversations extends BaseModel
{


    protected $table = 'landbot_conversations';


    protected $fillable = [
        'id',
        'nombre',
        'telefono',
        'landbot_chat_id',
        'created_at',
        'deleted_at',
        'updated_at',
        'status',
        'user_asing_id',
    ];

    public function lastMessage()
    {
        return $this->hasOne(LandbotMessage::class, 'conversation_id')
            ->latest('created_at'); // ult
    }
}

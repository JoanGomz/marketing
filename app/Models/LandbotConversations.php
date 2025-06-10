<?php

namespace App\Models;

use App\Models\BaseModel;

class LandbotConversations extends BaseModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'landbot_conversations';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
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
}

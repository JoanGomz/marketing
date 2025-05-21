<?php

namespace App\Models\Operation;

use App\Models\BaseModel;

class Parks extends BaseModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'parks';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [

        'id',
        'name',
        'location',
        'capacity',
        'is_deleted',
        'user_creator',
        'user_last_update',
        'created_at',
        'updated_at',
    ];
}

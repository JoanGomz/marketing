<?php

namespace App\Models\Base;

use App\Models\BaseModel;

class Pais extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'is_deleted'
    ];
}

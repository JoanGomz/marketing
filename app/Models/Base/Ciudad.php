<?php

namespace App\Models\Base;

use App\Models\BaseModel;

class Ciudad extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ciudad';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'is_deleted',
        'id_pais'
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'id_pais', 'id');
    }
}

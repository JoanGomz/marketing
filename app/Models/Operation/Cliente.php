<?php

namespace App\Models\Operation;

use App\Models\Base\Ciudad;
use App\Models\BaseModel;

class Cliente extends BaseModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'client';

    /**
     * Set Values
     */
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'identificacion',
        'nombre',
        'apellido',
        'nombre_completo',
        'celular',
        'email',
        'direccion',
        'tipo_documento',
        'genero',
        'fecha_nacimiento',
        'id_ciudad',
        'is_deleted'
    ];
}

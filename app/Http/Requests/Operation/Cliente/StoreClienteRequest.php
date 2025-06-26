<?php

namespace App\Http\Requests\Operation\Cliente;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'identificacion' => ['required', 'string', 'min:9', 'max:11'],
            'nombre' => ['required', 'string'],
            'apellido' => ['required', 'string'],
            'nombre_completo' => ['required', 'string'],
            'celular' => ['required', 'string', 'min:10', 'max:10'],
            'direccion' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'tipo_documento' => ['required', 'string'],
            'genero' => ['required', 'string'],
            'fecha_nacimiento' => ['required', 'string'],
            'id_ciudad' => ['required', 'integer'],
            'id_centro_comercial' => ['required', 'integer'],
        ];
    }
}

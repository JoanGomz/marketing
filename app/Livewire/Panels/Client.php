<?php

namespace App\Livewire\Panels;

use App\Http\Controllers\Base\CiudadController;
use App\Http\Controllers\Operation\ClienteController;
use App\Http\Controllers\Operation\ParksController;
use App\Traits\traitCruds;
use Livewire\Component;

class Client extends Component
{
    use traitCruds;

    public $response;
    //validaciones
    public $id_client;
    public string $identificacion;
    public $nombre;
    public $apellido;
    public $nombre_completo;
    public $celular;
    public $direccion;
    public $email;
    public $tipo_documento;
    public $genero;
    public $fecha_nacimiento;
    public $id_ciudad;
    public $id_park;
    //FUNCIÓN DE VALIDACIÓN DE CAMPOS POST
    protected function rules()
    {
        return [
            'identificacion' => 'required|string|min:9|max:20',
            'nombre' => 'required|string|min:2|max:50',
            'apellido' => 'required|string|min:2|max:50',
            'celular' => 'required|string|min:10|max:15',
            'direccion' => 'required|string|min:5|max:255',
            'email' => 'required|email|max:100',
            'tipo_documento' => 'required|string|in:CC,TI,CE,PS,NIT',
            'genero' => 'required|string|in:M,F,OTROS,NO BINARIO',
            'fecha_nacimiento' => 'required|date|before:now-3years|after:1950-01-01',
            'id_ciudad' => 'required|integer'
        ];
    }
    public function unirNombre()
    {
        $this->nombre_completo = $this->nombre . " " . $this->apellido;
    }
    public function clear() {}
    public function setEditingClient($id, $identificacion, $nombre, $apellido, $celular, $direccion, $email, $tipo_documento, $genero, $fecha_nacimiento, $id_ciudad,$id_park)
    {
        $this->id_client = $id;
        $this->identificacion = $identificacion;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->celular = $celular;
        $this->direccion = $direccion;
        $this->email = $email;
        $this->tipo_documento = $tipo_documento;
        $this->genero = $genero;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->id_ciudad = $id_ciudad;
        $this->id_park = $id_park;
        $this->dispatch('open-update-form');
    }
    public function updateClient()
    {
        try {
            $this->unirNombre();
            $request = new \Illuminate\Http\Request([
                'identificacion' => $this->identificacion,
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'nombre_completo' => $this->nombre_completo,
                'celular' => $this->celular,
                'direccion' => $this->direccion,
                'email' => $this->email,
                'tipo_documento' => $this->tipo_documento,
                'genero' => $this->genero,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'id_ciudad' => $this->id_ciudad,
                'id_centro_comercial' =>$this->id_park
            ]);
            $this->response = app(ClienteController::class)->update($request, $this->id_client);
            if ($this->response['status'] == 'success') {
                $this->dispatch('update-form-submitted');
            }
            $this->endPetition();
        } catch (\Throwable $th) {
            $this->handleException($th, 'Ha ocurrido un error al actualizar el cliente');
        }
    }
    public function render()
    {
        $data = app(ClienteController::class)->indexPaginated($this->page, $this->perPage, $this->search);
        $ciudades = app(CiudadController::class)->index();
        $parques = app(ParksController::class)->index();
        return view('livewire.panels.client', [
            'data' => $data,
            'cities' => $ciudades,
            'parks' => $parques
        ]);
    }
}

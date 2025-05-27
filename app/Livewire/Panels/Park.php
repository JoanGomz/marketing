<?php

namespace App\Livewire\Panels;

use App\Http\Controllers\Operation\ParksController;
use App\Traits\traitCruds;
use Livewire\Component;

class Park extends Component
{
    use traitCruds;
    public $name;
    public $location;
    public $capacity;

    public $editingParkId;
    public $response;
    protected function rules()
    {
        return [
            'name' => 'required|min:4|string',
            'location' => 'required|min:5',
            'capacity' => 'required|min:1'
        ];
    }
    // METODO PARA ASIGNAR LOS DATOS A LOS CAMPOS
    public function setEditingPark($id, $name, $location, $capacity)
    {
        $this->editingParkId = $id;
        $this->name = $name;
        $this->location = $location;
        $this->capacity= $capacity;
        $this->dispatch("open-update-form");
    }
    public function create()
    {
        $this->validateWithSpinner();
        try {
            $request = new \Illuminate\Http\Request();
            $request->merge([
                'name' => $this->name,
                'location' => $this->location,
                'capacity' => $this->capacity
            ]);
            $this->response = app(ParksController::class)->store($request);
            
            if($this->response['status'] == 'success') {
                $this->dispatch('create-form-submitted');
                $this->clear();
            }
            $this->endPetition();
        } catch (\Throwable $th) {
            $this->handleException($th, "Ocurrio un error en la creación del parque");
        }
    }
    public function updatePark()
    {
        $this->validateWithSpinner();
        try {
            $request = new \Illuminate\Http\Request();
            $request->merge([
                'name' => $this->name,
                'location' => $this->location,
                'capacity' => $this->capacity
            ]);
            $this->response = app(ParksController::class)->update($request, $this->editingParkId);
            if($this->response['status'] == 'success') {
                $this->dispatch('update-form-submitted');
                $this->clear();
            }
            $this->endPetition();
        } catch (\Throwable $th) {
            $this->handleException($th, "Ocurrio un error en la actualización del parque");
        }
    }
    public function delete($id)
    {
        try {
            $this->response = app(ParksController::class)->destroy($id);
            $this->endPetition();
        } catch (\Throwable $th) {
            $this->handleException($th, "Ocurrio un error al eliminar el parque");
        }
    }
    public function clear(){
        $this->reset([
            'name',
            'location',
            'capacity'
        ]);
    }
    public function render()
    {
        $centros = app(ParksController::class)->index();
        return view('livewire.panels.park',[
            'centros' => $centros
        ]);
    }
}

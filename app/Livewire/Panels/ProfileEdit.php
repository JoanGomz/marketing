<?php

namespace App\Livewire\Panels;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Admin\UserController;
use App\Traits\traitCruds;
use Illuminate\Support\Facades\Auth;

class ProfileEdit extends Component
{
    //IMPORTACIÓN DE TRAIT DEL LOS CRUD
    use traitCruds;
    //ATRIBUTOS MODELO
    public $name;
    public $email;
    public $response;
    //METODOS VARIOS
    //FUNCIÓN DE VALIDACIÓN DE CAMPOS POST
    protected function rules()
    {
        return [
            'name' => 'min:4|string',
            'email' => 'required|min:5|email'
        ];
    }
    //FUNCIÓN POR DEFECTO
    public function mount()
    {
        // Cargar los usuarios
        $this->refreshData();
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }
    public function clear() {}
    
    //METODOS DE SOLICITUDES
    //METODO GET DATA
    public function refreshData(){}
    //METODO PUT
    //METODO PUT
    public function updateUser()
    {
        $this->validateWithSpinner();
        try {
            // Crear un Request con los datos actualizados
            $request = new \Illuminate\Http\Request();
            $request->merge([
                'name' => $this->name,
                'email' => $this->email
            ]);
            $id=Auth::user()->id;
            $this->response = app(UserController::class)->update($request, $id);
            if($this->response['status'] == 'success') {
                $this->dispatch('update-form-submitted');
            }
        } catch (\Throwable $th) {
            $this->handleException($th, "Ocurrio un error en la actualización del usuario");
        }
    }
    //METODO DELETE
    public function delete($id)
    {
        try {
            $this->response = app(UserController::class)->destroy($id);
            $this->endPetition();
            Auth::logout();
            return redirect()->route('login');
        } catch (\Throwable $th) {
            $this->handleException($th, "Ocurrio un error al eliminar el usuario");
        }
    }
}

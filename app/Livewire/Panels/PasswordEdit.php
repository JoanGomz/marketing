<?php

namespace App\Livewire\Panels;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Http\Controllers\Admin\UserController;
use App\Traits\traitCruds;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
class PasswordEdit extends Component
{
    //IMPORTACIÓN DE TRAIT DEL LOS CRUD
    use traitCruds;
    //ATRIBUTOS MODELO
    public $contraseña;
    public $confirmación_contraseña;
    public $response;
    //METODOS VARIOS
    //FUNCIÓN DE VALIDACIÓN DE CAMPOS POST
    protected function rules()
    {
        return [
            'contraseña' => ['required', 'min:8', Password::min(8)->mixedCase()],
            'confirmación_contraseña' => ['required','same:contraseña','min:8', Password::min(8)->mixedCase()]
        ];
    }
    //FUNCIÓN POR DEFECTO
    public function mount()
    {
        // Cargar los usuarios
        $this->refreshData();
    }
    public function clear() {}

    //METODOS DE SOLICITUDES
    //METODO GET DATA
    public function refreshData() {}
    //METODO PUT
    //METODO PUT
    public function updatePassword()
    {
        $this->validateWithSpinner();
        try {
            // Crear un Request con los datos actualizados
            $request = new \Illuminate\Http\Request();
            $request->merge([
                'password' => $this->contraseña,
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ]);
            $this->contraseña = '';
            $this->confirmación_contraseña = '';
            $id = Auth::user()->id;
            $this->response = app(UserController::class)->update($request, $id);
            if($this->response['status'] == 'success') {
                $this->dispatch('update-form-submitted');
            }
        } catch (\Throwable $th) {
            $this->handleException($th, "Ocurrio un error en la actualización de la contraseña");
        }
    }
}

<?php

namespace App\Livewire\Panels;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Operation\ParksController;
use App\Traits\traitCruds;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class User extends Component
{
    use traitCruds;
    //ATRIBUTOS MODELO
    public $id;
    public $name;
    public $email;
    public $role_check;
    public $id_mall;
    public $password;
    public $response;
    //METODOS VARIOS
    //FUNCIÓN DE VALIDACIÓN DE CAMPOS POST
    private function rulesOnly()
    {
        return [
            'name' => 'required|min:4|string',
            'email' => 'required|min:5|email',
            'role_check' => 'required|min:1',
            'id_mall' => 'required|min:1',
            'password' => ['nullable', 'min:8', Password::min(8)->mixedCase()]
        ];
    }
    protected function rules()
    {
        return [
            'name' => 'required|min:4|string',
            'email' => 'required|min:5|email',
            'role_check' => 'required|min:1',
            'id_mall' => 'required',
            'password' => ['required', 'min:8', Password::min(8)->mixedCase()]
        ];
    }
    public function clear()
    {
        $this->reset('id', 'name', 'email', 'role_check', 'password');
        $this->response = '';
    }

    //ESTABLECER MODELOS Y DISPLAY DE FORMULARIO DE EDICIÓN
    public function setEditingUser($userData)
    {
        $this->id = $userData['id'];
        $this->name = $userData['name'];
        $this->email = $userData['email'];
        $this->role_check = $userData['role'] ?? '';
        $this->id_mall = $userData['mall']==='' ? '' : (int)$userData['mall'];
        $this->dispatch('open-update-form');
    }
    //METODOS DE SOLICITUDES
    //METODO POST
    public function create()
    {
        $this->validateWithSpinner();
        try {
            //VALIDACIÓN DE CAMPOS Y ESTADO DE CARGA
            $request = new \Illuminate\Http\Request();
            $request->merge([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'role_id' => $this->role_check,
                'parks_id' => $this->id_mall
            ]);
            $this->response = app(UserController::class)->store($request);

            if ($this->response['status'] == 'success') {
                $this->dispatch('create-form-submitted');
            }
            $this->endPetition();
        } catch (\Throwable $th) {
            $this->handleException($th, "Ocurrio un error en la creación del usuario");
        }
    }
    //METODO PUT
    public function updateUser()
    {
        $this->validateWithSpinnerUpdate();
        try {
            // Crear un Request con los datos actualizados
            $request = new \Illuminate\Http\Request();
            if ($this->password == null) {
                $request->merge([
                    'name' => $this->name,
                    'email' => $this->email,
                    'role_id' => $this->role_check,
                    'parks_id' => $this->id_mall
                ]);
            } else {
                $request->merge([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => $this->password,
                    'role_id' => $this->role_check,
                    'parks_id' => $this->id_mall
                ]);
            }

            $this->response = app(UserController::class)->update($request, $this->id);
            if ($this->response['status'] == 'success') {
                $this->dispatch('update-form-submitted');
            }
            $this->endPetition();
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
        } catch (\Throwable $th) {
            $this->handleException($th, "Ocurrio un error al eliminar el usuario");
        }
    }
    public function render()
    {
        $data = app(UserController::class)->indexPaginated($this->page, $this->perPage, $this->search);
        $park = app(ParksController::class)->index();
        $roles = app(UserController::class)->getRoles();
        return view('livewire.panels.user', [
            'data' => $data,
            'parks' => $park,
            'roles' => $roles
        ]);
    }
}

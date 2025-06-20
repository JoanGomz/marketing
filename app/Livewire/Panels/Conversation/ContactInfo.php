<?php

namespace App\Livewire\Panels\Conversation;

use App\Http\Controllers\Base\CiudadController;
use App\Http\Controllers\LandbotWebhookController;
use App\Http\Controllers\Operation\ClienteController;
use App\Traits\traitCruds;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class ContactInfo extends Component
{
    use traitCruds;
    public $noteText;
    public $response;
    public $dataClient;
    public $nameWhatsApp;
    public $telClient;
    public $notes;
    public $conversationId;

    //Modelos del formulario de cliente
    public $id_client;
    public $identificacion;
    public $tipo_documento;
    public $nombre;
    public $apellido;
    public $celular;
    public $genero;
    public $fecha_nacimiento;
    public $email;
    public $direccion;
    public $id_ciudad;
    public $nombre_completo;
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
    public function setEditingClient()
    {
        if (!$this->dataClient || !isset($this->dataClient['data'])) {
            return; // O manejar el error como prefieras
        }
        $this->id_client=$this->dataClient['data']->id;
        $this->identificacion = $this->dataClient['data']->identificacion;
        $this->nombre = $this->dataClient['data']->nombre;
        $this->apellido = $this->dataClient['data']->apellido;
        $this->celular = $this->dataClient['data']->celular;
        $this->direccion = $this->dataClient['data']->direccion;
        $this->email = $this->dataClient['data']->email;
        $this->tipo_documento = $this->dataClient['data']->tipo_documento;
        $this->genero = $this->dataClient['data']->genero;
        $this->fecha_nacimiento = $this->dataClient['data']->fecha_nacimiento;
        $this->id_ciudad = $this->dataClient['data']->id_ciudad;
        $this->js('$store.forms.updateFormVisible = true');
    }
    //Método para unir los nombres y así crear el campo nombre completo requerido por el back
    public function unirNombre()
    {
        $this->nombre_completo = $this->nombre . " " . $this->apellido;
    }
    public function clear() {}
    #[On("load-info-client")]
    public function loadData($telClient, $userName, $note = null, $conversationId)
    {
        $this->nameWhatsApp = $userName;
        $this->telClient = $telClient;
        $this->notes = $note;
        $this->conversationId = $conversationId;
        $this->celular = strval($telClient);
        $request = new \Illuminate\Http\Request();
        $request->merge(['search' => $telClient]);
        $this->dataClient = app(ClienteController::class)->getUser($request);
    }
    public function saveNote()
    {
        try {
            $request = new \Illuminate\Http\Request();
            $request->merge(['note' => $this->noteText]);
            $response = app(LandbotWebhookController::class)->saveNote($request, $this->conversationId);
            if ($response['status'] === "success") {
                $this->notes = $this->noteText;
                $this->callNotification($response['message'], $response['status']);
                $this->noteText = "";
            } else {
                $this->callNotification($response['message'], $response['status']);
            }
        } catch (\Throwable $th) {
            $this->handleException($th, 'Ha ocurrido un error al crear la nota del cliente');
        }
    }
    //Método para crear cliente en caso de no encontrar el cliente en el buscador
    public function create()
    {
        strval($this->celular);
        $this->validateWithSpinner();
        try {
            $this->unirNombre();
            $request = new \Illuminate\Http\Request();
            $request->merge([
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
                'conversation_id' => $this->conversationId,
                'id_centro_comercial' => Auth::user()->id_centro_comercial
            ]);
            $this->response = app(ClienteController::class)->store($request);

            if ($this->response['status'] == 'success') {
                $this->js('$store.forms.createFormVisible = false');
                $this->loadData($this->celular, $this->nombre_completo, $this->notes, $this->conversationId);
                $this->dispatch('updateConversations');
            }
            $this->endPetition();
        } catch (\Throwable $th) {
            $this->handleException($th, 'Ha ocurrido un error al crear el cliente');
        }
    }
    public function update()
    {
        strval($this->celular);
        $this->validateWithSpinner();
        try {
            $this->unirNombre();
            $request = new \Illuminate\Http\Request();
            $request->merge([
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
                'conversation_id' => $this->conversationId,
                'id_centro_comercial' => Auth::user()->id_centro_comercial
            ]);
            $this->response = app(ClienteController::class)->update($request,$this->id_client);

            if ($this->response['status'] == 'success') {
                $this->js('$store.forms.updateFormVisible = false');
                $this->loadData($this->celular, $this->nombre_completo, $this->notes, $this->conversationId);
                $this->dispatch('updateConversations');
            }
            $this->endPetition();
        } catch (\Throwable $th) {
            $this->handleException($th, 'Ha ocurrido un error al crear el cliente');
        }
    }
    public function render()
    {
        $cities = app(CiudadController::class)->index();
        return view('livewire.panels.conversation.contact-info', [
            'cities' => $cities
        ]);
    }
}

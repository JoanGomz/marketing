<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;

use App\Http\Requests\Operation\Cliente\StoreClienteRequest;
use App\Http\Requests\Operation\Cliente\UpdateClienteRequest;
use App\Models\LandbotConversations;
use App\Models\Operation\Cliente;

use App\Services\Operation\ClienteService as ClientService;

use Carbon\Carbon;

use Illuminate\Http\Request;

class ClienteController extends Controller
{
    private const PERMISSION = 'cliente';
    private ClientService $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->validatePermission(self::PERMISSION);
        $this->clientService = $clientService;
    }

    public function index()
    {
        $this->validatePermission(self::PERMISSION);
        try {
            $client = $this->clientService->getAllClients();
            return $this->responseLivewire('success', '', $client);
        } catch (\Exception $ex) {
            return $this->responseLivewire('error', $ex->getMessage(), []);
        }
    }

    /**
     * Retorna los items paginados
     */
    public function indexPaginated($page, $items, $search = '')
    {
        $this->validatePermission(self::PERMISSION);
        try {
            $response = $this->clientService->getPaginated($page, $items, $search);

            return $this->responseLivewire('success', 'success', $response);
        } catch (\Exception $ex) {
            return $this->responseLivewire('error', $ex->getMessage(), []);
        }
    }

    public function store(Request $request)
    {
        $this->validatePermission(self::PERMISSION, 'create');
        try {
            $validatedData = $request->validate((new StoreClienteRequest())->rules());
            $this->validateExistence($request->identificacion, $request->tipo_documento);
            $this->validations($request);

            $client = $this->clientService->create($validatedData);

            $conversation = LandbotConversations::where('id', $request['conversation_id'])->first();
            if ($conversation) {
                $conversation->client_id = $client->id;
                $conversation->save();
            }

            return $this->responseLivewire('success', 'El cliente se creó exitosamente', $client);
        } catch (\Exception $ex) {
            return $this->responseLivewire('error', $ex->getMessage(), []);
        }
    }

    public function update(Request $request, int $clientId)
    {
        $this->validatePermission(self::PERMISSION, 'update');
        try {
            $validatedData = $request->validate((new UpdateClienteRequest())->rules());
            $client = $this->clientService->findById($clientId);

            if (!$client instanceof Cliente) {
                throw new \Exception('El cliente no existe');
            }

            if ($client->identificacion !== $request->identificacion) {
                $this->validateExistence($request->identificacion, $request->tipo_documento);
            }

            $this->validations($request);
            $client = $this->clientService->update($validatedData, $clientId);

            return $this->responseLivewire('success', 'El cliente se actualizó exitosamente', $client);
        } catch (\Exception $ex) {
            return $this->responseLivewire('error', $ex->getMessage(), []);
        }
    }

    public function destroy(int $clientId)
    {
        $this->validatePermission(self::PERMISSION, 'delete');
        try {
            $client = $this->clientService->findById($clientId);

            if (!$client instanceof Cliente) {
                throw new \Exception('El cliente no existe');
            }

            $this->clientService->delete($client->id);
            return $this->responseLivewire('success', 'El cliente se eliminó correctamente', []);
        } catch (\Exception $ex) {
            return $this->responseLivewire('error', $ex->getMessage(), []);
        }
    }

    private function validations(Request $request)
    {
        $this->validateDocument($request->tipo_documento);
        $this->validateGenre($request->genero);
        $this->validateDate($request->fecha_nacimiento);
    }

    private function validateDocument(string $type)
    {
        $valideValues = ['CC', 'CE', 'PS'];
        if (!in_array(strtoupper($type), $valideValues)) {
            throw new \Exception('El tipo de documento ingresado por el cliente no es valido');
        }
    }

    private function validateGenre(string $genre)
    {
        $valideValues = ['M', 'F', 'NO BINARIO', 'OTROS'];
        if (!in_array(strtoupper($genre), $valideValues)) {
            throw new \Exception('El genero ingresado por el cliente no es valido');
        }
    }

    private function validateDate(string $date)
    {
        try {
            if (!str_contains($date, '-')) {
                throw new \Exception('Formato de fecha de nacimiento incorrecto');
            }
            $dateFormat = Carbon::createFromFormat('Y-m-d', $date);
            if (!$dateFormat || $dateFormat->format('Y-m-d') !== $date || $dateFormat->format('Y-m-d') >= Carbon::now()->format('Y-m-d')) {
                throw new \Exception('La fecha de nacimiento ingresada por el cliente no es valida.');
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    private function validateExistence(string $identification, string $type)
    {
        $client = $this->clientService->findByIdentification($identification, $type);
        if ($client instanceof Cliente) {
            throw new \Exception('El cliente ya se encuentra registrado');
        }
    }

    public function getUser(Request $request)
    {
        $client = $this->clientService->findUser($request->search);
        if ($client instanceof Cliente) {
            return $this->responseLivewire('success', 'El cliente se encontró exitosamente', $client);
        }

        return $this->responseLivewire('success', 'Usuario no encontrado', []);
    }

    public function createOrUpdateClient(Request $request)
    {
        if ($request->id) {
            $this->update($request, $request->id);
        } else {
            $this->store($request);
        }
    }
}

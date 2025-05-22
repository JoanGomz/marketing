<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operation\Parks\StoreParksRequest;
use App\Http\Requests\Operation\Parks\UpdateParksRequest;
use App\Models\Operation\Parks;
use App\Services\Operation\ParksService;
use Illuminate\Http\Request;

class ParksController extends Controller
{

    private ParksService $parksService;

    public function __construct(ParksService $parksService)

    {
        $this->parksService = $parksService;
    }

    public function index()
    {
        try {
            $parks = $this->parksService->getAll();
            return $this->responseLivewire('success', '', $parks);
        } catch (\Exception $ex) {
            return $this->responseLivewire('error', $ex->getMessage(), []);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate((new StoreParksRequest())->rules());
            $park = $this->parksService->create($validatedData);
            return $this->responseLivewire('success', 'El parque se creó exitosamente', $park);
        } catch (\Exception $ex) {
            return $this->responseLivewire('error', $ex->getMessage(), []);
        }
    }

    public function update(Request $request, int $parkId)
    {
        try {
            $validatedData = $request->validate((new UpdateParksRequest())->rules());

            $park = $this->parksService->findById($parkId);
            if (!$park instanceof Parks) {
                throw new \Exception('El parque no existe');
            }
            $park = $this->parksService->update($validatedData, $park->id);
            return $this->responseLivewire('success', 'El parque se actualizó exitosamente', $park);
        } catch (\Exception $ex) {
            return $this->responseLivewire('error', $ex->getMessage(), []);
        }
    }

    public function destroy(int $parkId): array
    {
        try {
            $park = $this->parksService->findById($parkId);
            if (!$park instanceof Parks) {
                throw new \Exception('El parque no existe');
            }
            $this->parksService->delete($park->id);

            return $this->responseLivewire('success', 'El parque se eliminó correctamente', []);
        } catch (\Exception $ex) {
            return $this->responseLivewire('error', $ex->getMessage(), []);
        }
    }
}

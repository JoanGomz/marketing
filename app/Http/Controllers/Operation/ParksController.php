<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Operation\Parks\StoreParksRequest as ParksStoreParksRequest;
use App\Http\Requests\Operation\Parks\UpdateParksRequest as ParksUpdateParksRequest;
use App\Livewire\Panels\Park;
use App\Models\Operation\Parks;
use App\Services\Operation\ParksService as parksService;

class ParksController extends Controller
{

    public function index()
    {
        try {
            $parks = Parks::all();
            return $this->responseLivewire('success', '', $parks);
        } catch (\Exception $ex) {
            return $this->responseLivewire('error', $ex->getMessage(), []);
        }
    }
    public function store(Request $request)
    {
        try {
            $park = Parks::create($request->all());
            return $this->responseLivewire('success', 'El centro comercial se creó exitosamente', $park);
        } catch (\Exception $ex) {
            return $this->responseLivewire('error', $ex->getMessage(), []);
        }
    }
    public function update(Request $request, int $parkId)
    {
        try {
            $parks = Parks::find($parkId);
            if (!$parks instanceof Parks) {
                throw new \Exception('El centro comercial no existe');
            }
            $park = $parks->update($request->all());
            return $this->responseLivewire('success', 'El centro comercial se actualizó exitosamente', $park);
        } catch (\Exception $ex) {
            return $this->responseLivewire('error', $ex->getMessage(), []);
        }
    }
    public function destroy(int $parkId): array
    {
        try {
            $park = Parks::find($parkId);
            if (!$park) {
                return $this->responseLivewire('error', 'El parque no existe', []);
            }
            $record = $park->where('id', $parkId)->where('is_deleted', 0);
            $record->update(['is_deleted' => 1]);
            return $this->responseLivewire('success', 'El parque se eliminó correctamente', []);
        } catch (\Exception $ex) {
            return $this->responseLivewire('error', $ex->getMessage(), []);
        }
    }
}

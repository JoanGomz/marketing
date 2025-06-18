<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;

use App\Http\Requests\Base\Ciudad\StoreCiudadRequest;
use App\Http\Requests\Base\Ciudad\UpdateCiudadRequest;

use App\Models\Base\Ciudad;

use App\Services\Base\CiudadService;

use Illuminate\Http\Request;

class CiudadController extends Controller
{
    private const PERMISSION = 'city';

    private CiudadService $cityService;

    public function __construct(CiudadService $cityService)
    {
        $this->validatePermission(self::PERMISSION);
        $this->cityService = $cityService;
    }

    public function index()
    {
        $cities = $this->cityService->getAllCities();
        return $this->responseLivewire('success', '', $cities->toArray());
    }

    /**
     * retorna todas las ciudades paginadas
     */
    public function indexPaginated($page, $items, $search = '')
    {
        try {
            $response = $this->cityService->getPaginated($page, $items, $search);

            return $this->responseLivewire('success', 'success', $response);
        } catch (\Exception $ex) {
            return $this->responseLivewire('error', $ex->getMessage(), []);
        }
    }


    public function store(Request $request)
    {
        try {
            $this->validatePermission(self::PERMISSION, 'create');
            $validatedData = $request->validate((new StoreCiudadRequest())->rules());

            $city = $this->cityService->create($validatedData);
            return $this->responseLivewire('success', 'La ciudad se creó exitosamente', $city);
        } catch (\Exception $ex) {
            return $this->responseLivewire('error', $ex->getMessage(), []);
        }
    }

    public function update(Request $request, int $cityId)
    {
        try {
            $this->validatePermission(self::PERMISSION, 'update');
            $city = $this->cityService->findById($cityId);
            if (!$city instanceof Ciudad) {
                throw new \Exception('La ciudad no existe');
            }

            $validatedData = $request->validate((new UpdateCiudadRequest())->rules());

            $city = $this->cityService->update($validatedData, $cityId);
            return $this->responseLivewire('success', 'La ciudad se actualizó exitosamente', $city);
        } catch (\Exception $ex) {
            return $this->responseLivewire('error', $ex->getMessage(), []);
        }
    }

    public function destroy(int $cityId)
    {
        $this->validatePermission(self::PERMISSION, 'delete');
        $this->cityService->delete($cityId);
        return $this->responseLivewire('success', 'La ciudad se eliminó correctamente', []);
    }
}

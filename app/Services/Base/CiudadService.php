<?php

namespace App\Services\Base;

use App\Models\Base\Ciudad;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class CiudadService extends BaseService
{
    public function __construct(Ciudad $ciudad)
    {
        parent::__construct($ciudad);
    }

    /**
     * Retorna las ciudades paginadas
     * @param int $page
     * @param int $items
     * @param string $search
     */
    public function getPaginated($page, $items, $search = '')
    {
        $query = $this->model::query();

        $query->where('is_deleted', 0);
        $query->with('Departamento');

        // buscador
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('nombre', 'like', "%{$search}%");
            });
        }

        $query->orderBy('id', 'desc');
        return $query->paginate($items, ['*'], 'page', $page);
    }

    public function searchByName(string $name)
    {
        return Ciudad::where('nombre', '=',  $name)->where('is_deleted', 0)->first();
    }

    public function getAllCities()
    {
        return Ciudad::where('is_deleted', 0)
            ->orderBy('id', 'desc')
            ->get();
    }
}

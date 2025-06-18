<?php

namespace App\Services\Operation;

use App\Models\Operation\Cliente;
use App\Services\BaseService;

class ClienteService extends BaseService
{
    public function __construct(Cliente $client)
    {
        parent::__construct($client);
    }

    public function getAllClients()
    {
        // return $this->model->where('is_deleted', 0)->with('city')->get();
        return $this->model->where('is_deleted', 0)->get();
    }

    /**
     * Retorna los items paginados
     * @param int $page
     * @param int $items
     * @param string $search
     */
    public function getPaginated($page, $items, $search = '')
    {
        $query = $this->model::query();

        $query->where('is_deleted', 0);

        // buscador
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('nombre_completo', 'like', "%{$search}%")
                    ->orWhere('identificacion', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('celular', 'like', "%{$search}%");
            });
        }

        $query->orderBy('id', 'desc');
        return $query->paginate($items, ['*'], 'page', $page);
    }

    public function findByIdentification(string $identification, string $type)
    {
        return $this->model->where('identificacion', $identification)->where('tipo_documento', $type)->where('is_deleted', 0)->first();
    }

    public function findUser(string $search)
    {
        return $this->model
            ->where('is_deleted', 0)
            ->where(function ($query) use ($search) {
                $query->where('celular', $search)
                    ->orWhere('identificacion', $search);
            })
            ->first();
    }
}

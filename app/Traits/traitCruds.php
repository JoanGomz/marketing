<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use App\Models\User;
use Livewire\WithPagination;

trait traitCruds
{
    // Variable para mantener la página actual
    public $page = 1;

    // Variables para filtros (opcional)
    public $search = '';
    public $perPage = 10;

    // Para mantener el estado de la paginación en la URL
    protected $queryString = ['page' => ['except' => 1]];

    public function resetPage()
    {
        // Debes usar la variable correcta según cómo esté configurada tu paginación
        $this->page = 1; // Esto podría ser $this->currentPage = 1, dependiendo de tu implementación
    }
    public function updatedSearch()
    {
        // Resetear la paginación cuando se actualiza la búsqueda
        $this->resetPage();
    }
    // Método para cambiar de página manualmente si necesitas botones personalizados
    public function goToPage($page)
    {
        $this->page = $page;
    }
    protected function handleException(\Throwable $th, string $defaultMessage)
    {
        Log::error('Rol Management Error: ' . $th->getMessage());
        dump($th);
        $this->callNotification(
            $defaultMessage,
            'error'
        );
    }
    //METODO PARA LLAMAR A LA NOTIFICACIÓN
    protected function callNotification($message, $type)
    {
        $this->dispatch('showNotification', [
            'message' => $message,
            'type' => $type,
            'duration' => 4000
        ]);
    }
    public function showLoading($message = 'Cargando...')
    {
        $this->dispatch('show-loading', [
            'message' => $message
        ]);
    }
    protected function endPetition()
    {
        $this->callNotification($this->response['message'], $this->response['status']);
        $this->dispatch('hide-loading');
        if ($this->response['status'] == 'success') {
            if (method_exists($this, 'refreshData')) {
                $this->refreshData();
            }
            if (method_exists($this, 'clear')) {
                $this->clear();
            }
        }
    }
    public function validateWithSpinner()
    {
        try {
            $this->validate($this->rules());
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('hide-loading');
            $this->validate($this->rules());
        }
    }
        //OPCTIONAL EN CASO DE TENER REGLAS DIFERENTES (NO OLVIDAR CREAR LA FUNCIÓN rulesOnly EN EL COMPONENTE)
    public function validateWithSpinnerUpdate()
    {
        try {
            $this->validate($this->rulesOnly());
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('hide-loading');
            $this->validate($this->rulesOnly());
        }
    }
}

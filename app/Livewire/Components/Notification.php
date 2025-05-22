<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class Notification extends Component
{
    public $message = '';
    public $type = 'success';
    public $show = false;
    public $duration = 3000;
    
    #[On('showNotification')]
    public function showNotification($data = null)
    {
        if (is_null($data)) {
            $this->message = 'Operación completada';
            $this->type = 'success';
            $this->duration = 3000;
        } else if (is_array($data)) {
            $this->message = $data['message'] ?? 'Operación completada';
            $this->type = $data['type'] ?? 'success';
            $this->duration = $data['duration'] ?? 3000;
        } else {
            $this->message = $data;
            $this->type = 'info';
        }
        
        $this->show = true;
    }
    
    public function render()
    {
        return view('livewire.components.notification');
    }
}
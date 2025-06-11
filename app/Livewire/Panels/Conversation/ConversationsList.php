<?php

namespace App\Livewire\Panels\Conversation;

use App\Http\Controllers\LandbotWebhookController;
use Livewire\Component;

class ConversationsList extends Component
{
    public $conversations;
    public $loading;
    public function mount()
    {
        $this->loadConversations();
    }
    public function loadConversations()
    {
        $this->loading = true;
        
        try {
            $this->conversations = app(LandbotWebhookController::class)->getAllConversations();
            
            // Asegurar que es un array
            if (!is_array($this->conversations)) {
                $this->conversations = [];
                session()->flash('error', 'Error en formato de datos');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al cargar conversaciones');
        } finally {
            $this->loading = false;
        }
    }
    public function render()
    {
        return view('livewire.panels.conversation.conversations-list');
    }
}

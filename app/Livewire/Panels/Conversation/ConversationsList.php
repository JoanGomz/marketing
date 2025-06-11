<?php

namespace App\Livewire\Panels\Conversation;

use Livewire\Component;

class ConversationsList extends Component
{
    public $loading;
    public function loadConversations()
    {
        $this->loading = true;
        
        try {
            
            
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

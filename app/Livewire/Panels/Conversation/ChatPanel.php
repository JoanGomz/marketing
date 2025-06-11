<?php

namespace App\Livewire\Panels\Conversation;

use Livewire\Component;

class ChatPanel extends Component
{
    public $data;
    public function mount(){
        $this->data=$this->leerJson();
    }
    public function leerJson(){
        $pathJson= public_path('data/conversation2.json');
         if (!file_exists($pathJson)) {
            return [];
        }
        $data = file_get_contents($pathJson);
        return json_decode($data, true) ?? [];
    }
    public function render()
    {
        return view('livewire.panels.conversation.chat-panel');
    }
}

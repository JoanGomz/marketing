<?php

namespace App\Livewire\Panels\Conversation;

use App\Http\Controllers\Operation\ClienteController;
use Livewire\Attributes\On;
use Livewire\Component;

class ContactInfo extends Component
{
    public $noteText;

    public $dataClient;
    public $nameWhatsApp;
    public $telClient;
    public $notes;
    public $conversationId;
    public function clear(){

    }
    #[On("load-info-client")]
    public function loadData($telClient,$userName, $note=null, $conversationId)
    {
        $this->nameWhatsApp=$userName;
        $this->telClient=$telClient;
        $this->notes=$note;
        $this->conversationId=$conversationId;
        $request = new \Illuminate\Http\Request();
        $request->merge(['search' => $telClient]);
        $this->dataClient = app(ClienteController::class)->getUser($request);
    }
    public function saveNote(){
        
    }
    public function render()
    {
        return view('livewire.panels.conversation.contact-info');
    }
}

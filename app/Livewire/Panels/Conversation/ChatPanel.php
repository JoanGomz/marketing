<?php

namespace App\Livewire\Panels\Conversation;

use App\Http\Controllers\LandbotWebhookController;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatPanel extends Component
{
    public $conversationId;
    public $userName;
    public $conversationStatus;
    public $mensajes = [];

    public $status;
    public $text;
    #[On('load-conversation')]
    public function loadConversation($conversationId, $userName, $status)
    {
        $this->userName = $userName;
        $this->conversationStatus = $status;
        $this->mensajes = app(LandbotWebhookController::class)->getConversationHistory($conversationId);
        $this->conversationId = $conversationId;
        $this->dispatch('smoothScrollToBottom');
    }
    public function updatedStatus(){
        $request = new \Illuminate\Http\Request();
        $request->merge(['status' => $this->status]);
        $response = app(LandbotWebhookController::class)->changeStatusConversation($request,$this->conversationId);
    }
    public function sendMessage()
    {
        $request = new \Illuminate\Http\Request();
        $request->merge(['text' => $this->text]);
    }
    public function render()
    {
        return view('livewire.panels.conversation.chat-panel');
    }
}

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
    public $mensajes=[];
    #[On('load-conversation')]
    public function loadConversation($conversationId,$userName,$status)
    {
        $this->userName=$userName;
        $this->conversationStatus=$status;
        $this->mensajes=app(LandbotWebhookController::class)->getConversationHistory($conversationId);
        $this->conversationId = $conversationId;
    }
    public function render()
    {
        return view('livewire.panels.conversation.chat-panel');
    }
}

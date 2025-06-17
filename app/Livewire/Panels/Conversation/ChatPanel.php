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
    #[On('updateChat')]
    public function updateConversation()
    {
        if (!$this->conversationId) {
            return;
        }

        $newMessages = app(LandbotWebhookController::class)->getConversationHistory($this->conversationId);


        $currentCount = count($this->mensajes['data']['messages'] ?? []);
        $newCount = count($newMessages['data']['messages'] ?? []);

        if ($currentCount === $newCount) {
            // No hay mensajes nuevos, salir sin renderizar
            $this->skipRender();
            return;
        }

        // Solo actualizar si hay mensajes nuevos
        $this->mensajes = $newMessages;

        // Solo hacer scroll si hay mensajes nuevos
        $this->dispatch('smoothScrollToBottom');
    }
    #[On('load-conversation')]
    public function loadConversation($conversationId, $userName, $status)
    {
        $this->userName = $userName;
        $this->conversationStatus = $status;
        $this->mensajes = app(LandbotWebhookController::class)->getConversationHistory($conversationId);
        $this->conversationId = $conversationId;
        $this->dispatch('smoothScrollToBottom');
        // dump($this->mensajes);
    }
    public function updatedStatus()
    {
        $request = new \Illuminate\Http\Request();
        $request->merge(['status' => $this->status]);
        $response = app(LandbotWebhookController::class)->changeStatusConversation($request, $this->conversationId);
    }
    public function sendMessage()
    {
        $firstMessage = $this->mensajes['data']['messages'][0];
        $request = new \Illuminate\Http\Request();
        $request->merge([
            'messages' => [
                [
                    '_raw' => [
                        'chat' => $firstMessage['landbot_chat_id'],
                        'author_type' => 'usuario',
                    ],
                    'data' => [
                        'body' => $this->text
                    ],
                    'customer' => [
                        'phone' => $firstMessage['customer_phone'],
                        'name' => $this->userName,
                    ]
                ]
            ]
        ]);
        $response = app(LandbotWebhookController::class)->handleWebhook($request);
        if ($response['status'] === "success") {
            $this->updateConversation();
        }
        $this->text = "";
    }
    public function render()
    {
        return view('livewire.panels.conversation.chat-panel');
    }
}

<?php

namespace App\Livewire\Panels\Conversation;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LandbotWebhookController;
use App\Traits\traitCruds;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatPanel extends Component
{
    use traitCruds;
    public $conversationId;
    public $userName;
    public $conversationStatus;
    public $assigned;
    public $mensajes = [];
    public $canWrite;
    public $status;
    public $text;

    public $response;
    public $showConfirmModal = false;
    protected function rulesMessage()
    {
        return [
            'text' => 'required|min:1|string'
        ];
    }
    #[On('activate-conversation')]
    public function activateConversation($conversationId)
    {
        if ($this->conversationId == $conversationId) {
            $request = new \Illuminate\Http\Request();
            $request->merge(['status' => 'activo']);
            $response = app(LandbotWebhookController::class)->changeStatusConversation($request, $conversationId);

            if ($response['status'] === "success") {
                $this->conversationStatus = 'activo';
            }
        }
    }
    //Método llamado desde websocket o evento para actualizar la conversación
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
        $this->dispatch('scrollChat');
    }
    //Método llamado desde lista de conversaciones para cargar las conversaciones del chat seleccionado
    #[On('load-conversation')]
    public function loadConversation($conversationId, $userName, $status, $canWrite)
    {
        $this->userName = $userName;
        $this->conversationStatus = $status;
        $this->canWrite = $canWrite;
        $this->mensajes = app(LandbotWebhookController::class)->getConversationHistory($conversationId);
        $this->conversationId = $conversationId;
        $this->dispatch('smoothScrollToBottom');
    }
    public function endConversation()
    {
        $request = new \Illuminate\Http\Request();
        $request->merge(['status' => "finalizado"]);
        $this->response = app(LandbotWebhookController::class)->changeStatusConversation($request, $this->conversationId);
        if ($this->response['status'] === "success") {
            $this->dispatch('updateConversations');
            $this->status = "finalizado";
            $this->conversationStatus = $this->status;
        }
        $this->endPetition();
    }
    public function updatedStatus()
    {
        if ($this->status === "finalizado") {
            $this->showConfirmModal = true;
            $this->status = "pendiente";
            return;
        }
        $request = new \Illuminate\Http\Request();
        $request->merge(['status' => $this->status]);
        $response = app(LandbotWebhookController::class)->changeStatusConversation($request, $this->conversationId);
        if ($response['status'] === "success") {
            $this->dispatch('updateConversations');
            $this->conversationStatus = $this->status;
        }
    }
    public function updatedAssigned()
    {
        try {
            $request = new \Illuminate\Http\Request();
            $request->merge(['user_id' => $this->assigned]);
            $response = app(LandbotWebhookController::class)->assignUserToConversation($request, $this->conversationId);
            if ($response['status'] === "success") {
                $this->updateConversation();
                $this->callNotification($response['message'], $response['status']);
            } else {
                $this->callNotification($response['message'], $response['status']);
            }
        } catch (\Throwable $th) {
            dump($th);
        }
    }
    public function sendMessage()
    {
        $this->validate($this->rulesMessage());
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
        } else {
            $this->callNotification($response['data'], $response['status']);
        }
        $this->reset('text');
    }
    public function launchBot()
    {
        $response = app(LandbotWebhookController::class)->restartBot($this->conversationId);
        $this->callNotification($response['message'], $response['status']);
    }
    public function render()
    {
        $advisors = app(UserController::class)->getAsesor();
        return view('livewire.panels.conversation.chat-panel', [
            'advisors' => $advisors
        ]);
    }
}

<?php

namespace App\Livewire\Panels\Conversation;

use App\Http\Controllers\LandbotWebhookController;
use Livewire\Attributes\On;
use Livewire\Component;

class ConversationsList extends Component
{
    public $selectedConversationId;
    public $loading = false;
    public $firstLoad = 0;

    // Propiedades para filtros
    public $search = '';
    public $status = '';

    // Propiedad para tracking de cambios
    public $lastQuery = '';

    public function mount()
    {
        $this->loading = false;
    }
    #[On('updateConversations')]
    public function updateConversations(){
        $this->status='';
    }
    public function selectConversation($conversationId, $userName, $status)
    {
        $this->selectedConversationId = $conversationId;

        $this->dispatch(
            'load-conversation',
            conversationId: $conversationId,
            userName: $userName,
            status: $status
        )->to('panels.conversation.chat-panel');

        $request = new \Illuminate\Http\Request();
        $request->merge(['status' => 'activo']);
        $response = app(LandbotWebhookController::class)->changeStatusConversation($request,$conversationId);
    }
    public function render()
    {
        try {
            // Construir query string para detectar cambios
            $currentQuery = md5($this->search . $this->status);

            // Cargar conversaciones con parámetros
            $conversations = app(LandbotWebhookController::class)->getAllConversations($this->status);

            // Auto-seleccionar primera conversación si es primera carga Y hay datos
            if ($this->firstLoad == 0 && isset($conversations['data']) && count($conversations['data']) > 0) {
                $this->firstLoad = 1;

                $firstConversation = $conversations['data'][0];
                $conversationId = $firstConversation['id'];
                $userName = $firstConversation['nombre'];
                $status = $firstConversation['status'];
                $telefono = $firstConversation['telefono'];
                $notas= $firstConversation['notas'];
                $this->selectedConversationId = $conversationId;

                $this->js("
                    setTimeout(() => {
                        \$wire.dispatch('load-conversation', {
                            conversationId: {$conversationId},
                            userName: '{$userName}',
                            status: '{$status}'
                        });
                    }, 50);
                ");
                $this->js("
                    setTimeout(() => {
                        \$wire.dispatch('load-info-client', {
                            telClient: {$telefono},
                            note: '{$notas}'
                        });
                    }, 50);
                ");
            }

            $this->lastQuery = $currentQuery;
        } catch (\Exception $e) {
            $conversations = ['data' => []];
            session()->flash('error', 'Error al cargar conversaciones');
        }

        return view('livewire.panels.conversation.conversations-list', [
            'conversations' => $conversations
        ]);
    }
}

<?php

namespace App\Livewire\Panels\Conversation;

use App\Http\Controllers\LandbotWebhookController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
    private function determineCanWrite($fecha)
    {
        $lastMessageCarbon = Carbon::parse($fecha);
        $now = Carbon::now();

        if ($lastMessageCarbon->diffInHours($now) > 24) {
            return false;
        }
        return true;
    }
    #[On('updateConversations')]
    public function updateConversations()
    {
        $this->status = '';
    }
    public function selectConversation($conversationId, $userName, $status, $telefono, $nota = null, $updated_data)
    {
        if ($conversationId === $this->selectedConversationId) {
            return;
        }
        $canWrite = $this->determineCanWrite($updated_data);
        $this->selectedConversationId = $conversationId;
        $this->dispatch(
            'load-conversation',
            conversationId: $conversationId,
            userName: $userName,
            status: $status,
            canWrite: $canWrite
        )->to('panels.conversation.chat-panel');
        $this->dispatch(
            'load-info-client',
            telClient: $telefono,
            userName: $userName,
            note: $nota,
            conversationId: $conversationId
        )->to('panels.conversation.contact-info');
        if ($status != 'activo') {
            $this->dispatch('activate-conversation', $conversationId)->to('panels.conversation.chat-panel');
        }
    }
    public function render()
    {
        try {
            function determineCanWrite($fecha)
            {
                $lastMessageCarbon = Carbon::parse($fecha);
                $now = Carbon::now();

                if ($lastMessageCarbon->diffInHours($now) > 24) {
                    return false;
                }
                return true;
            }
            $currentQuery = md5($this->search . $this->status);

            if (Auth::user()->role_id === 3) {
                $conversations = app(LandbotWebhookController::class)->getAllConversations($this->status, Auth::user()->id);
            } else {
                $conversations = app(LandbotWebhookController::class)->getAllConversations($this->status);
            }


            // Auto-seleccionar primera conversación si es primera carga Y hay datos
            if ($this->firstLoad == 0 && isset($conversations['data']) && count($conversations['data']) > 0) {
                $this->firstLoad = 1;

                $firstConversation = $conversations['data'][0];
                $conversationId = $firstConversation['id'];
                $userName = $firstConversation['nombre'];
                $status = $firstConversation['status'];
                $telefono = $firstConversation['telefono'];
                $notas = $firstConversation['notas'];
                $canWrite = determineCanWrite($firstConversation['updated_at']);
                $this->selectedConversationId = $conversationId;

                $this->js("
                    setTimeout(() => {
                        \$wire.dispatch('load-conversation', {
                            conversationId: {$conversationId},
                            userName: '{$userName}',
                            status: '{$status}',
                            canWrite: $canWrite
                        });
                    }, 50);
                ");
                $this->js("
                    setTimeout(() => {
                        \$wire.dispatch('load-info-client', {
                            telClient: {$telefono},
                            userName: '{$userName}',
                            note: '{$notas}',
                            conversationId: {$conversationId},
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
            'conversations' => $conversations,
            'pruebaUsuario' => Auth::user()->id
        ]);
    }
}

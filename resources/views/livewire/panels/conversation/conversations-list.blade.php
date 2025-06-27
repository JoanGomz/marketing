<div class="w-full lg:w-1/4 bg-white border-r overflow-y-auto resize-x min-w-[330px] shadowCard z-20">
    <div class="p-4 border-b items-center flex flex-wrap gap-2">
        <div class="flex items-center flex-1 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 pl-2 text-white absolute" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input id="searchInput" type="text" wire:model.live="search" placeholder="Buscar conversación"
                class="w-full bg-gray-400 placeholder-white pl-8 rounded-md">
        </div>
        <button type="button" wire:click="actualizar" wire:loading.attr="disabled" wire:target="actualizar"
            title="Actualizar"
            class="group bg-blue-50 hover:bg-blue-100 disabled:bg-blue-25 border border-blue-100 hover:border-blue-200 disabled:border-blue-50 w-10 h-10 rounded-full transition-all duration-200 flex items-center justify-center">
            <i class="fa-solid fa-rotate-right text-blue-600 hover:text-blue-700 disabled:text-blue-400 text-sm transition-colors duration-200"
                wire:loading.class="animate-spin" wire:target="actualizar"></i>
        </button>
    </div>

    <div class="p-2 border-b flex justify-between flex-1 flex-col">
        <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Seleccione estado</label>
        <select wire:model.live="status" id="status"
            class="bg-gray-50 border mb-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value="">Todos</option>
            <option value="en espera">En espera</option>
            <option value="pendiente">Pendiente</option>
            <option value="finalizado">Finalizado</option>
        </select>
        {{-- <button id="all" data-filter="all" wire:click="$set('status', '')"
            class="px-1 py-1 rounded-md text-sm font-medium {{ $status === '' ? 'bg-brand-aqua' : '' }} hover:bg-brand-aqua bg-opacity-70 text-brand-darkPurple">
            Todos
        </button>
        <button id="pending" data-filter="pendiente" wire:click="$set('status', 'pendiente')"
            class="px-1 py-1 rounded-md text-sm font-medium text-gray-500 hover:bg-yellow-100 {{ $status === 'pendiente' ? 'bg-yellow-100' : '' }} hover:text-yellow-800">
            Pendiente
        </button>
        <button id="waiting" data-filter="En espera" wire:click="$set('status', 'en espera')"
            class="px-1 py-1 rounded-md text-sm font-medium text-gray-500 hover:bg-purple-100 {{ $status === 'en espera' ? 'bg-purple-100' : '' }} hover:text-purple-800">
            En espera
        </button>
        <button id="waiting" data-filter="En espera" wire:click="$set('status', 'en espera')"
            class="px-1 py-1 rounded-md text-sm font-medium text-gray-500 hover:bg-purple-100 {{ $status === 'en espera' ? 'bg-purple-100' : '' }} hover:text-purple-800">
            Finalizado
        </button> --}}
    </div>
    <div>
        @forelse ($conversations['data'] as $item)
            <div class="chat-item p-4 border-b cursor-pointer transition-colors {{ $selectedConversationId === $item->id ? 'bg-gray-500 text-white' : 'hover:bg-gray-50' }}"
                wire:click="selectConversation({{ json_encode($item['id']) }}, {{ json_encode($item['nombre']) }}, {{ json_encode($item['status']) }}, {{ json_encode($item['telefono']) }}, {{ json_encode($item['notas'] ?? '') }}, {{ json_encode($item['updated_at']) }})"
                data-status="{{ strtolower($item->status) }}">

                <div class="flex justify-between items-start mb-1">
                    <div class="font-bold">
                        {{ $item['client']->nombre ?? ('~' . $item->nombre ?? 'Sin nombre') }}
                    </div>
                    <div
                        class="text-xs {{ $selectedConversationId === $item->id ? 'text-gray-200' : 'text-gray-500' }}">
                        {{ $item->telefono }}
                    </div>
                </div>

                <div
                    class="text-xs mb-2 truncate {{ $selectedConversationId === $item->id ? 'text-gray-200' : 'text-gray-600' }}">
                    @php
                        $messageText = 'Sin mensaje';

                        if (isset($item['lastMessage']['conversation_data'])) {
                            $data = $item['lastMessage']['conversation_data'];

                            // Si conversation_data es string JSON, decodificarlo
                            if (is_string($data)) {
                                $data = json_decode($data, true) ?? [];
                            }
                            if (isset($data['body']['text'])) {
                                $messageText = $data['body']['text'];
                            } elseif (isset($data['body']) && is_string($data['body'])) {
                                $messageText = $data['body'];
                            } elseif (isset($data['header']['text'])) {
                                $messageText = $data['header']['text'];
                            } elseif (isset($data['text'])) {
                                $messageText = $data['text'];
                            } elseif (isset($data['action']['button'])) {
                                $messageText = 'Menú: ' . $data['action']['button'];
                            }
                        }
                    @endphp

                    {{ $messageText }}
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span
                            class="w-2 h-2 rounded-full mr-2 
                                @if ($item->status === 'pendiente') bg-yellow-400
                                @elseif($item->status === 'asignado a')
                                    bg-blue-400
                                @elseif($item->status === 'en espera')
                                    bg-purple-400
                                @elseif($item->status === 'finalizado')
                                    bg-gray-400
                                @else
                                    bg-brand-aqua @endif
                            "></span>
                        <span
                            class="status-text text-xs capitalize {{ $selectedConversationId === $item->id ? 'text-gray-200' : 'text-gray-700' }}">
                            {{ $item->status }}
                        </span>
                    </div>

                    @if ($item->status === 'pendiente')
                        <span
                            class="bg-brand-redStar text-white text-xs rounded-full w-2 h-2 flex items-center justify-center">
                            <!-- Contenido del indicador -->
                        </span>
                    @endif
                </div>
            </div>
        @empty
        @endforelse
    </div>
</div>

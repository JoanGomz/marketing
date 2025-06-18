<div class="w-full lg:w-1/4 bg-white border-r overflow-y-auto resize-x min-w-[330px] shadowCard z-20">
    <div class="p-4 border-b">
        <div class="flex items-center py-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 pl-2 text-white absolute" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input id="searchInput" type="text" placeholder="Buscar conversación"
                class="w-full bg-gray-400 placeholder-white pl-8 rounded-md">
        </div>
    </div>
    
    <div class="p-2 border-b flex justify-between">
        <button id="all" data-filter="all" wire:click="$set('status', '')"
            class="px-1 py-1 rounded-md text-sm font-medium {{ $status === '' ? 'bg-brand-aqua' : '' }} hover:bg-brand-aqua bg-opacity-70 text-brand-darkPurple">
            Todos
        </button>
        <button id="pending" data-filter="pendiente" wire:click="$set('status', 'pendiente')"
            class="px-1 py-1 rounded-md text-sm font-medium text-gray-500 hover:bg-yellow-100 {{ $status === 'pendiente' ? 'bg-yellow-100' : '' }} hover:text-yellow-800">
            Pendiente
        </button>
        <button id="assigned" data-filter="asignado" wire:click="$set('status', 'asignado a')"
            class="px-1 py-1 rounded-md text-sm font-medium text-gray-500 hover:bg-blue-100 {{ $status === 'asignado a' ? 'bg-blue-100' : '' }} hover:text-blue-800">
            Asignado
        </button>
        <button id="waiting" data-filter="En espera" wire:click="$set('status', 'en espera')"
            class="px-1 py-1 rounded-md text-sm font-medium text-gray-500 hover:bg-purple-100 {{ $status === 'en espera' ? 'bg-purple-100' : '' }} hover:text-purple-800">
            En espera
        </button>
    </div>
    <div>
        @forelse ($conversations['data'] as $item)
            <div class="chat-item p-4 border-b cursor-pointer transition-colors {{ $selectedConversationId === $item->id ? 'bg-gray-500 text-white' : 'hover:bg-gray-50' }}"
                wire:click="selectConversation({{ $item->id }}, '{{ $item->nombre }}', '{{ $item->status }}','{{$item->telefono}}','{{$item->notas}}')"
                data-status="{{ strtolower($item->status) }}">

                <div class="flex justify-between items-start mb-1">
                    <div class="font-bold">~{{ $item->nombre }}</div>
                    <div
                        class="text-xs {{ $selectedConversationId === $item->id ? 'text-gray-200' : 'text-gray-500' }}">
                        {{ $item->telefono }}
                    </div>
                </div>

                <div
                    class="text-xs mb-2 truncate {{ $selectedConversationId === $item->id ? 'text-gray-200' : 'text-gray-600' }}">
                    {{-- {{ $item['lastMessage']['conversation_data']['body'] ?? 'Sin mensaje' }} --}}
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

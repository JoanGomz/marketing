<div class="flex-1 flex flex-col resize-x z-10">
    <!-- Cabecera de la conversación -->
    <div class="bg-brand-darkPurple p-4  flex justify-between items-center font-bold text-white z-20"
        style="box-shadow: 0px 8px 12px rgba(0, 0, 0, 0.48);">
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 mr-3">
                C
            </div>
            <div>
                <div class="font-bold">{{ $userName ? $userName : '--' }}</div>
                <div class="flex items-center text-sm">
                    <div class="w-2 h-2 mr-2 rounded-full bg-green-400"></div>
                    <span id="estado-chat"
                        class="font-bold capitalize">{{ $conversationStatus ? $conversationStatus : '--' }}</span>
                </div>
            </div>
        </div>
        <div class="flex gap-4">
            <button id="info-button" class="rounded-md p-2 pr-6 text-sm px-6 bg-gray-500">Información</button>
            <select wire:model.live="status" class="form-select text-black">
                <option value="">Estado</option>
                <option value="en espera">En espera</option>
                <option value="pendiente">Pendiente</option>
            </select>
            {{-- <select id="estado" class="rounded-md p-2  pr-6 text-sm text-black bg-[#94D4A0]">
                <option value="">Cambiar estado</option>
                <option value="pending">Pendiente</option>
                <option value="waiting">En espera</option>
                <option value="completed">Finalizado</option>
            </select> --}}
            <select id="asesor" class="rounded-md p-2 pr-6 text-sm text-black">
                <option value="">Asignar a</option>
                <option value="1">Juan Pérez</option>
                <option value="2">Ana López</option>
                <option value="3">Carlos Ruiz</option>
            </select>
        </div>
    </div>

    <!-- Historial de mensajes -->
    <div class="flex-1 flex flex-col min-h-0">
        <div class="flex-1 p-4 overflow-y-auto space-y-2 bg-gray-50 " id="content-conversation"
            style="background-image: url('/Images/Asesor/patron.png'); background-size: 100%; background-repeat: repeat;">
            @if ($mensajes)
                @forelse ($mensajes["data"]['messages'] as $item)
                    @php
                        // Manejar conversation_data de forma segura
                        if (is_array($item['conversation_data'])) {
                            $conversationData = $item['conversation_data'];
                        } elseif (is_string($item['conversation_data'])) {
                            $conversationData = json_decode($item['conversation_data'], true) ?: [];
                        } else {
                            $conversationData = [];
                        }

                        // Función helper para obtener valores de forma segura
                        $getBodyText = function ($data) {
                            if (isset($data['body'])) {
                                return is_string($data['body'])
                                    ? $data['body']
                                    : (isset($data['body']['text'])
                                        ? $data['body']['text']
                                        : '');
                            }
                            return '';
                        };

                        // Función para verificar si es un mensaje con botones o listas
                        $hasInteractiveElements = function ($data) {
                            return isset($data['buttons']) || isset($data['action']);
                        };
                    @endphp

                    @if ($item['author_type'] === 'cliente')
                        <!-- Mensaje del cliente -->
                        <div wire:key="message-{{ $item['id'] ?? $loop->index }}"
                            class="mb-4 flex justify-start min-w-[400px]">
                            <div class="max-w-md rounded-lg p-4 bg-white border min-w-[400px] shadowCard">
                                <div>{{ $getBodyText($conversationData) }}</div>
                                <div class="text-xs mt-1 text-gray-500">
                                    {{ \Carbon\Carbon::parse($item['message_timestamp'])->format('g:i A') }}
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Mensaje del asesor -->
                        <div wire:key="message-{{ $item['id'] ?? $loop->index }}" class="mb-4 flex justify-end">
                            <div class="max-w-md rounded-lg p-4 bg-brand-blueStar text-white shadowCard">
                                @if (!$hasInteractiveElements($conversationData))
                                    <!-- Mensaje de texto simple -->
                                    <div>{{ $getBodyText($conversationData) }}</div>
                                @else
                                    <!-- Mensaje con elementos interactivos -->

                                    <!-- Header del mensaje -->
                                    @if (isset($conversationData['header']['text']))
                                        <div class="font-bold text-lg mb-2">{{ $conversationData['header']['text'] }}
                                        </div>
                                    @elseif (isset($conversationData['title']))
                                        <div class="font-bold">{{ $conversationData['title'] }}</div>
                                    @endif

                                    <!-- Cuerpo del mensaje -->
                                    @if ($getBodyText($conversationData))
                                        <div class="mb-3">{{ $getBodyText($conversationData) }}</div>
                                    @endif

                                    <!-- Footer del mensaje -->
                                    @if (isset($conversationData['footer']['text']) && $conversationData['footer']['text'])
                                        <div class="font-light text-xs mb-3">{{ $conversationData['footer']['text'] }}
                                        </div>
                                    @elseif (isset($conversationData['footer']) && is_string($conversationData['footer']))
                                        <div class="font-light text-xs mb-3">{{ $conversationData['footer'] }}</div>
                                    @endif

                                    <!-- Botones tradicionales -->
                                    @if (isset($conversationData['buttons']) && is_array($conversationData['buttons']))
                                        @foreach ($conversationData['buttons'] as $button)
                                            <div class="mt-2">
                                                <button
                                                    class="bg-[#0997AF] hover:bg-blue-600 text-white px-4 py-2 rounded-lg w-full text-left">
                                                    {{ is_array($button) ? $button['label'] ?? '' : $button }}
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif

                                    <!-- WhatsApp List (action con sections) -->
                                    @if (isset($conversationData['action']['sections']) && is_array($conversationData['action']['sections']))
                                        <div class="mt-3">
                                            @if (isset($conversationData['action']['button']))
                                                <div class="text-sm font-medium mb-2 text-blue-200">
                                                    {{ $conversationData['action']['button'] }}</div>
                                            @endif

                                            @foreach ($conversationData['action']['sections'] as $section)
                                                @if (isset($section['rows']) && is_array($section['rows']))
                                                    <div class="space-y-1">
                                                        @foreach ($section['rows'] as $row)
                                                            <div
                                                                class="bg-white/10 hover:bg-white/20 rounded-lg p-3 cursor-pointer transition-colors">
                                                                <div class="font-medium">{{ $row['title'] ?? '' }}
                                                                </div>
                                                                @if (isset($row['description']) && $row['description'])
                                                                    <div class="text-xs text-blue-200 mt-1">
                                                                        {{ $row['description'] }}</div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                @endif

                                <div class="flex justify-end">
                                    <div class="text-xs mt-1 right-2 text-blue-100">
                                        {{ \Carbon\Carbon::parse($item['message_timestamp'])->format('g:i A') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="text-center text-gray-500">No hay mensajes</div>
                @endforelse
            @endif


        </div>
        <form class="flex items-center bg-gray-100 rounded-lg px-4 py-2" wire:submit.prevent="sendMessage">
            <input wire:model="text" type="text"
                placeholder="{{ $canWrite ? ' Escribe tu respuesta...' : 'No puedes enviar mensajes después de 24 horas del ultimo mensaje del cliente' }}"
                {{ $canWrite ? '' : 'disabled' }}
                class="flex-1 bg-transparent border-none {{ $canWrite ? '' : 'cursor-not-allowed' }}">
            <div class="flex space-x-2 ml-2">
                <button class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                    </svg>
                </button>
                <button class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            </div>
            <button class="ml-2 bg-brand-blueStar text-white rounded-md px-4 py-2 shadowCard">
                Enviar
            </button>
        </form>

    </div>

</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messagesContainer = document.getElementById("content-conversation");

            const conectarPrueba = () => {
                if (window.ably && window.ably.connection.state === 'connected') {
                    const channel = window.ably.channels.get('chat');

                    channel.subscribe((message) => {
                        Livewire.dispatch('updateChat');
                        Livewire.dispatch('updateConversations');
                        scrollChat();
                    });
                } else {
                    setTimeout(conectarPrueba, 200);
                }
            };

            conectarPrueba();

            function scrollChat() {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                // alert("Entro"); // Remover en producción
            }

            // ✅ AGREGAR: Escuchar el evento de Livewire
            document.addEventListener('scrollChat', function() {
                scrollChat();
            });
        });
    </script>
@endpush

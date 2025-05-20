@props(['data'])

<!-- Paginación -->
<div class="flex justify-center items-center mb-4 mt-4">
    <div class="buttons flex gap-2">
        @php
            $isPaginated = false;
            $currentPage = 1;
            $lastPage = 1;
            
            // Verifica si data tiene la estructura de una respuesta paginada
            if (isset($data['data'])) {
                // Caso de objeto de paginación de Laravel
                if (is_object($data['data']) && method_exists($data['data'], 'lastPage')) {
                    $currentPage = $data['data']->currentPage();
                    $lastPage = $data['data']->lastPage();
                    $isPaginated = true;
                } 
                // Caso de array con metadatos de paginación
                elseif (is_array($data['data']) && isset($data['meta']['last_page'])) {
                    $currentPage = $data['meta']['current_page'];
                    $lastPage = $data['meta']['last_page'];
                    $isPaginated = true;
                }
            }
            
            // Lógica para mostrar un número limitado de botones con puntos suspensivos
            $window = 3; // Número de páginas a mostrar a cada lado de la página actual
            $startPage = max($currentPage - $window, 1);
            $endPage = min($currentPage + $window, $lastPage);
            
            $showStartDots = $startPage > 1;
            $showEndDots = $endPage < $lastPage;
        @endphp

        @if ($isPaginated)
            <!-- Botón de página anterior -->
            @if ($currentPage > 1)
                <button aria-label="Botón página anterior" wire:click="goToPage({{ $currentPage - 1 }})"
                    class="p-2 px-3 bg-gray-200 text-gray-700 rounded">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
            @endif
            
            <!-- Primera página siempre visible -->
            @if ($startPage > 1)
                <button wire:click="goToPage(1)"
                    class="p-2 px-3 rounded {{ $currentPage == 1 ? 'bg-brand-purple text-white' : 'bg-gray-200 text-gray-700' }}">
                    1
                </button>
                
                <!-- Puntos suspensivos al inicio si es necesario -->
                @if ($showStartDots && $startPage > 2)
                    <span class="p-2 px-3">...</span>
                @endif
            @endif
            
            <!-- Páginas intermedias -->
            @for ($i = $startPage; $i <= $endPage; $i++)
                <button wire:click="goToPage({{ $i }})"
                    class="p-2 px-3 rounded {{ $currentPage == $i ? 'bg-brand-purple text-white' : 'bg-gray-200 text-gray-700' }}">
                    {{ $i }}
                </button>
            @endfor
            
            <!-- Puntos suspensivos al final si es necesario -->
            @if ($showEndDots && $endPage < $lastPage - 1)
                <span class="p-2 px-3">...</span>
            @endif
            
            <!-- Última página siempre visible si no es igual a la actual -->
            @if ($endPage < $lastPage)
                <button wire:click="goToPage({{ $lastPage }})"
                    class="p-2 px-3 rounded {{ $currentPage == $lastPage ? 'bg-brand-purple text-white' : 'bg-gray-200 text-gray-700' }}">
                    {{ $lastPage }}
                </button>
            @endif
            
            <!-- Botón de página siguiente -->
            @if ($currentPage < $lastPage)
                <button aria-label="Botón página siguiente" wire:click="goToPage({{ $currentPage + 1 }})"
                    class="p-2 px-3 bg-gray-200 text-gray-700 rounded">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            @endif
        @elseif ($lastPage == 1)
            <!-- Si solo hay una página, mostrar solo el botón 1 -->
            <button class="p-2 px-3 rounded bg-brand-purple text-white">
                1
            </button>
        @endif
    </div>
</div>
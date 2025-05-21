<div class="space-4 p-4">
    <!-- Encabezado de página -->
    <div class="bg-white  rounded-lg shadow-md overflow-hidden p-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800 ">{{ __('Gestión de parques') }}</h1>
            <p class="text-sm text-gray-500 ">Gestiona los datos de tus parques</p>
        </div>
    </div>

    <!-- Tarjeta principal para navegación de pestañas -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mt-4">
        <!-- Contenido de las pestañas -->
        <div class="p-4">
            <div class="flex flex-col gap-4">
                <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                    <div x-data="{ formVisible: false }" class="text-gray-900">
                        <!--HEADER Y BUSCADOR DE LA SECCIÓN-->
                        <div class="bg-white rounded-lg">
                            <div class="relative mt-1 flex flex-col gap-4 lg:flex-row justify-between">
                                <div
                                    class="hidden absolute inset-y-0 rtl:inset-r-0 start-0 lg:flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 " aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0  1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <!-- Buscar parques -->
                                <x-input-search mode="cardSearch" placeholder="Buscar Parques"></x-input-search>
                                <div>
                                    <!-- Boton Agregar Parque -->
                                    <x-primary-button mode="showCreate">Crear Parque</x-primary-button>
                                </div>
                            </div>
                        </div>
                        <!--FORMULARIO DE ACTUALIZACIÓN DE CENTROS COMERCIALES-->
                        <div x-show="$store.forms.updateFormVisible"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                            class="form my-6 p-4 bg-slate-200 rounded-lg   overflow-hidden shadow-sm sm:rounded-lg pb-4">
                            <h3 class="text-lg font-medium">Actualizar Parque</h3>
                            <form wire:submit.prevent="updateMall" class="mt-4">
                                <div class="mb-5">
                                    <label for="name"
                                        class="block mb-2 text-sm font-medium text-gray-900 ">Nombre</label>
                                    <input wire:model="name" type="text" id="name"
                                        class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                        placeholder="Ej: Bulevar Niza" />
                                    @error('name')
                                        <span class="error text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex gap-4 mb-5">
                                    <div class="w-full">
                                        <label for="address"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Dirección</label>
                                        <div class="relative">
                                            <input wire:model="address" type="text" id="address"
                                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                placeholder="Ej: Calle 22 5b-22" />
                                            @error('address')
                                                <span class="error text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <x-primary-button mode="submit">Actualizar Parque</x-primary-button>
                                    <x-primary-button mode="cancelUpdate">Cancelar</x-primary-button>
                                </div>
                            </form>
                        </div>
                        <!--FORMULARIO DE CREACIÓN DE CENTROS COMERCIALES-->
                        <div x-show="$store.forms.createFormVisible"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                            class="my-6 p-4 bg-slate-200 rounded-lg  ">
                            <h3 class="text-lg font-medium">Crear Parque</h3>
                            <form wire:submit.prevent="create" class="mt-4">
                                <div class="mb-5">
                                    <label for="name"
                                        class="block mb-2 text-sm font-medium text-gray-900 ">Nombre</label>
                                    <input wire:model="name" type="text" id="name"
                                        class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                        placeholder="Ej: Bulevar Niza" />
                                    @error('name')
                                        <span class="error text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex gap-4 mb-5">
                                    <div class="w-full">
                                        <label for="address"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Dirección</label>
                                        <div class="relative">
                                            <input wire:model="address" type="text" id="address"
                                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                placeholder="Ej: Calle 22 5b-22" />
                                            @error('address')
                                                <span class="error text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <label for="name"
                                        class="block mb-2 text-sm font-medium text-gray-900 ">Capacidad</label>
                                    <input wire:model="name" type="text" id="name"
                                        class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                        placeholder="Ej: Bulevar Niza" />
                                    @error('name')
                                        <span class="error text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex space-x-2">
                                    <x-primary-button mode="submit">Crear Parque</x-primary-button>
                                    <x-primary-button mode="cancelCreate">Cancelar</x-primary-button>
                                </div>
                            </form>
                        </div>
                        <!--GRID PARA LAS TARJETAS DE LOS CENTROS COMERCIALES-->
                        <div
                            class="p-4 bg-white rounded-lg mb-2 w-full max-h-[600px] overflow-x-auto grid grid-cols-1 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-3 gap-6 px-4 py-4">
                            @if (isset($centros['data']) && is_array($centros['data']) && count($centros['data']) > 0)
                                @forelse ($centros['data'] as $item)
                                    <div
                                        class="div p-4 bg-gradient-to-br from-indigo-700 to-purple-800 rounded-xl shadow-xl overflow-hidden relative">
                                        <div class="p-4 relative z-10">
                                            <!-- Badge de ID -->
                                            <span
                                                class="absolute top-3 right-3 bg-black/30 backdrop-blur-sm px-3 py-1 text-xs font-mono rounded-full text-white/90 font-semibold">#{{ $item->id }}</span>

                                            <!-- Encabezado con ícono -->
                                            <div class="flex items-center mb-4">
                                                <div class="bg-white/10 p-2 rounded-lg mr-3 backdrop-blur-sm">
                                                    <svg class="h-5 w-5 text-white" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M9 14h6">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <h2 class="text-2xl font-bold tracking-tight text-white">
                                                    {{ $item->nombre }}</h2>
                                            </div>

                                            <!-- Información con iconos -->
                                            <div class="space-y-3 mb-5">
                                                <div class="flex items-start">
                                                    <svg class="h-5 w-5 text-blue-200 mt-0.5 mr-2 flex-shrink-0"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <p class="text-sm text-blue-100">
                                                        <span class="font-semibold text-white">Horarios:</span><br>
                                                        Lunes a domingos: {{ $item->horarios }}
                                                    </p>
                                                </div>

                                                <div class="flex items-start">
                                                    <svg class="h-5 w-5 text-blue-200 mt-0.5 mr-2 flex-shrink-0"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                                        </path>
                                                    </svg>
                                                    <p class="text-sm text-blue-100">
                                                        <span class="font-semibold text-white">Dirección:</span><br>
                                                        {{ $item->direccion }}
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Autor y Ciudad -->
                                            <div class="flex flex-wrap gap-2 mb-3">
                                                <div class="flex-1">
                                                    <span
                                                        class="inline-block w-full px-2.5 py-1.5 rounded-lg text-xs font-medium bg-blue-700/50 text-white backdrop-blur-sm border border-blue-500/30">
                                                        <span class="font-semibold">Autor:</span>
                                                        @if ($item->user_creator)
                                                            {{ $item->user_creator }}
                                                        @else
                                                            <span>Desconocido</span>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="flex-1">
                                                    <span
                                                        class="inline-block w-full px-2.5 py-1.5 rounded-lg text-xs font-medium bg-indigo-700/50 text-white backdrop-blur-sm border border-indigo-500/30">
                                                        <svg class="h-3 w-3 inline-block mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m4 0v-5a1 1 0 011-1h2a1 1 0 011 1v5">
                                                            </path>
                                                        </svg>
                                                        {{ $item->nombre_ciudad }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Fechas -->
                                            <div class="flex flex-wrap gap-2 mb-3">
                                                <div class="flex-1">
                                                    <span
                                                        class="inline-block w-full px-2.5 py-1.5 rounded-lg text-xs font-medium bg-blue-700/50 text-white backdrop-blur-sm border border-blue-500/30">
                                                        <span class="font-semibold">Creado:</span>
                                                        @if ($item->create_at)
                                                            {{ \Carbon\Carbon::parse($item->create_at)->locale('es')->format('d/m/Y h:i A') }}
                                                        @else
                                                            <span>Desconocido</span>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="flex-1">
                                                    <span
                                                        class="inline-block w-full px-2.5 py-1.5 rounded-lg text-xs font-medium bg-indigo-700/50 text-white backdrop-blur-sm border border-indigo-500/30">
                                                        <span class="font-semibold">Actualizado:</span>
                                                        @if ($item->update_at)
                                                            {{ \Carbon\Carbon::parse($item->update_at)->locale('es')->format('d/m/Y h:i A') }}
                                                            {{ $item->user_last_update }}
                                                        @else
                                                            <span>No actualizado</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Compañía -->
                                            <div class="flex flex-wrap gap-2 mb-5">
                                                <div class="flex-1">
                                                    <span
                                                        class="inline-block w-full px-2.5 py-1.5 rounded-lg text-xs font-medium bg-blue-700/50 text-white backdrop-blur-sm border border-blue-500/30">
                                                        <span class="font-semibold">Compañía:</span>
                                                        @if ($item->company_name)
                                                            {{ $item->company_name }}
                                                        @else
                                                            <span>No vinculada</span>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="flex-1">
                                                    <span
                                                        class="inline-block w-full px-2.5 py-1.5 rounded-lg text-xs font-medium bg-indigo-700/50 text-white backdrop-blur-sm border border-indigo-500/30">
                                                        <span class="font-semibold">Nit:</span>
                                                        @if ($item->nit)
                                                            {{ $item->nit }}
                                                        @else
                                                            <span>No vinculada</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Botones -->
                                            @if (auth()->user()->can('park.update') || auth()->user()->can('park.delete'))
                                                <div class="flex gap-2 mt-auto">
                                                    @can('park.update')
                                                        <button
                                                            wire:click="setEditingMall(
                                                {{ $item->id }}, 
                                                '{{ $item->nombre }}', 
                                                '{{ $item->horarios }}', 
                                                '{{ $item->direccion }}',
                                                '{{ $item->id_ciudad }}',
                                                '{{ $item->company_name }}'
                                                )"
                                                            class="bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-medium px-4 py-2 rounded-lg flex-1 shadow-sm transition-colors duration-200 border border-white/10 flex items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                            Editar
                                                        </button>
                                                    @endcan
                                                    @can('park.delete')
                                                        <button
                                                            @click="window.dispatchEvent(new CustomEvent('show-delete-modal', {
                                                            detail: { 
                                                                id: {{ $item->id }},
                                                                name: '{{ $item->nombre }}'
                                                            }
                                                        }))"
                                                            class="bg-red-500/70 hover:bg-red-600/90 backdrop-blur-sm text-white font-medium px-4 py-2 rounded-lg flex-1 shadow-sm transition-colors duration-200 border border-red-500/30 flex items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            Eliminar
                                                        </button>
                                                    @endcan
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Efectos de profundidad y estilo -->
                                        <div
                                            class="absolute -top-20 -right-20 w-40 h-40 bg-blue-400/20 rounded-full blur-xl">
                                        </div>
                                        <div
                                            class="absolute -bottom-8 -left-8 w-32 h-32 bg-indigo-500/20 rounded-full blur-xl">
                                        </div>
                                    </div>
                                @empty
                                    <h1>No hay parques</h1>
                                @endforelse
                            @else
                                {{-- Your empty state content here --}}
                                <p>No centers available.</p>
                            @endif
                        </div>
                        <!--Codigo ALPINE para llamar desde livewire-->
                        <div x-init="window.addEventListener('create-form-submitted', () => {
                            $store.forms.hideCreateForm();
                        });
                        
                        window.addEventListener('update-form-submitted', () => {
                            $store.forms.hideUpdateForm();
                        });
                        window.addEventListener('open-update-form', () => {
                            $store.forms.showUpdateForm();
                        });">
                        </div>
                        <!--MODAL DE CONFIRMACIÓN-->
                        @include('components.confirmation-modal')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="space-4 p-4">
    <!-- Encabezado de página -->
    <div class="bg-white  rounded-lg shadow-md overflow-hidden p-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800 ">{{ __('Gestión de clientes') }}</h1>
            <p class="text-sm text-gray-500 ">Gestiona los datos de tus cliente </p>
        </div>
    </div>
    <!-- Tarjeta principal para navegación de pestañas -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mt-4">
        <!-- Contenido de las pestañas -->
        <div class="pt-4">
            <div class="flex flex-col gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div x-data="{ formVisible: false }" class="text-gray-900">
                        <!--header y menu de navegación-->
                        <div class="px-4 bg-white rounded-lg mb-4">
                            <div class="relative mt-1 flex flex-col gap-4 lg:flex-row justify-between">
                                <x-input-search mode="tableSearch" placeholder="Buscar clientes"></x-input-search>
                            </div>
                        </div>
                        @if (Auth::user()->role_id === 1 || Auth::user()->role_id === 2)
                            <!--FORMULARIO DE ACTUALIZACIÓN DE CLIENTES -->
                            <div x-show="$store.forms.updateFormVisible"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-90"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-90"
                                class="my-6 p-4 mx-4 bg-slate-200 rounded-lg   overflow-hidden shadow-sm sm:rounded-lg pb-4">
                                <div class="p-6 text-gray-900 ">
                                    <h1 class="font-bold text-lg pb-2">Actualización de clientes</h1>
                                    <form wire:submit="updateClient" class="max-w-full">
                                        <!-- Primera fila: Identificación y Tipo de Documento -->
                                        <div class="flex flex-wrap gap-4 mb-5">
                                            <div class="flex-1 min-w-[200px]">
                                                <label for="identificacion"
                                                    class="block mb-2 text-sm font-medium text-gray-900 ">Identificación</label>
                                                <input wire:model="identificacion" type="text" id="identificacion"
                                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                                    placeholder="Ej: 213232123" />
                                                @error('identificacion')
                                                    <span class="error text-red-600">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="w-[200px]">
                                                <label for="tipo_documento"
                                                    class="block mb-2 text-sm font-medium text-gray-900 ">Tipo
                                                    de
                                                    Documento</label>
                                                <select wire:model="tipo_documento" id="tipo_documento"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5      ">
                                                    <option value="">Selecciona tipo</option>
                                                    <option value="CC">CC</option>
                                                    <option value="CE">CE</option>
                                                    <option value="PS">PS</option>
                                                </select>
                                                @error('tipo_documento')
                                                    <span class="error text-red-600">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Segunda fila: Nombre y Apellido -->
                                        <div class="flex flex-wrap gap-4 mb-5">
                                            <div class="flex-1 min-w-[200px]">
                                                <label for="nombre"
                                                    class="block mb-2 text-sm font-medium text-gray-900 ">Nombre</label>
                                                <input wire:model="nombre" type="text" id="nombre"
                                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                                    placeholder="Ej: Angel" />
                                                @error('nombre')
                                                    <span class="error text-red-600">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="flex-1 min-w-[200px]">
                                                <label for="apellido"
                                                    class="block mb-2 text-sm font-medium text-gray-900 ">Apellido</label>
                                                <input wire:model="apellido" type="text" id="apellido"
                                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                                    placeholder="Ej: Ramirez" />
                                                @error('apellido')
                                                    <span class="error text-red-600">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Tercera fila: Celular, Género y Fecha de Nacimiento -->
                                        <div class="flex flex-wrap gap-4 mb-5">
                                            <div class="w-[200px]">
                                                <label for="celular"
                                                    class="block mb-2 text-sm font-medium text-gray-900 ">Celular</label>
                                                <input wire:model="celular" type="text" id="celular"
                                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                                    placeholder="Ej: 3103035137" minlength="10" maxlength="10" />
                                                @error('celular')
                                                    <span class="error text-red-600">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="w-[200px]">
                                                <label for="genero"
                                                    class="block mb-2 text-sm font-medium text-gray-900 ">Género</label>
                                                <select wire:model="genero" id="genero"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5      ">
                                                    <option value="">Selecciona género</option>
                                                    <option value="M">M</option>
                                                    <option value="F">F</option>
                                                    <option value="NO BINARIO">NO BINARIO</option>
                                                    <option value="OTROS">OTROS</option>
                                                </select>
                                                @error('genero')
                                                    <span class="error text-red-600">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="flex-1 min-w-[200px]">
                                                <label for="fecha_nacimiento"
                                                    class="block mb-2 text-sm font-medium text-gray-900 ">Fecha de
                                                    Nacimiento</label>
                                                <input wire:model="fecha_nacimiento" type="date"
                                                    id="fecha_nacimiento"
                                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                                    placeholder="YYYY-MM-DD" />
                                                @error('fecha_nacimiento')
                                                    <span class="error text-red-600">{{ $message }}</span>
                                                @enderror
                                                <small class="text-xs text-gray-500">Formato: "Y-m-d"</small>
                                            </div>
                                        </div>

                                        <!-- Cuarta fila: Dirección y Ciudad -->
                                        <div class="flex flex-wrap gap-4 mb-5">
                                            <div class="flex-1 min-w-[200px]">
                                                <label for="direccion"
                                                    class="block mb-2 text-sm font-medium text-gray-900 ">Dirección</label>
                                                <input wire:model="direccion" type="text" id="direccion"
                                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                                    placeholder="Ej: Calle 2 2 2" />
                                                @error('direccion')
                                                    <span class="error text-red-600">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="w-[250px]">
                                                <label for="id_ciudad"
                                                    class="block mb-2 text-sm font-medium text-gray-900 ">Ciudad</label>
                                                <select wire:model="id_ciudad" id="id_ciudad"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5      ">
                                                    <option value="">Selecciona ciudad</option>
                                                    @forelse ($cities['data'] as $item)
                                                        <option value="{{ $item['id'] }}">{{ $item['nombre'] }}
                                                        </option>
                                                    @empty
                                                        <option>No hay ciudades disponibles</option>
                                                    @endforelse
                                                </select>
                                                @error('id_ciudad')
                                                    <span class="error text-red-600">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Quinta fila: Email y Parque -->
                                        <div class="flex flex-wrap gap-4 mb-5">
                                            <div class="mb-5 flex-1">
                                                <label for="email"
                                                    class="block mb-2 text-sm font-medium text-gray-900 ">Email</label>
                                                <input wire:model="email" type="email" id="email"
                                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                                    placeholder="Ej: angel.ramirez@epam.com" />
                                                @error('email')
                                                    <span class="error text-red-600">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-5 flex-1">
                                                <label for="id_park"
                                                    class="block mb-2 text-sm font-medium text-gray-900 ">Parque</label>
                                                <select wire:model="id_park" id="id_park"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5      ">
                                                    <option value="">Selecciona parque</option>
                                                    @forelse ($parks['data'] as $item)
                                                        <option value="{{ $item['id'] }}">{{ $item['name'] }}
                                                        </option>
                                                    @empty
                                                        <option>No hay parques disponibles</option>
                                                    @endforelse
                                                </select>
                                                @error('id_park')
                                                    <span class="error text-red-600">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Botones -->
                                        <div class="flex gap-4">
                                            <x-primary-button mode="submit">Actualizar Cliente</x-primary-button>
                                            <x-primary-button mode="cancelUpdate">Cancelar</x-primary-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        <!--TABLA DE CLIENTES DE LOS PARQUES-->
                        <div
                            class="
                    [&::-webkit-scrollbar-track]:rounded-full
                    [&::-webkit-scrollbar-track]:bg-gray-100
                    [&::-webkit-scrollbar-thumb]:rounded-full
                    [&::-webkit-scrollbar-thumb]:bg-gray-300
                    overflow-x-auto
                     px-4 pb-2">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                <thead
                                    class="text-xs text-center text-gray-900 rounded-tl-xl rounded-tr-xl uppercase bg-gray-300 shadow-inner shadow-gray-600">
                                    <tr>
                                        <th scope="col" class="px-2 py-3 rounded-tl-xl">
                                            Numero de identificación
                                        </th>
                                        <th scope="col" class="px-4 py-3">
                                            nombre
                                        </th>
                                        <th scope="col" class="px-2 py-3">
                                            Celular
                                        </th>
                                        <th scope="col" class="px-2 py-3">
                                            Email
                                        </th>
                                        <th scope="col" class="px-4 py-3">
                                            Fecha Nacimiento
                                        </th>
                                        <th scope="col" class="px-4 py-3">
                                            Creado
                                        </th>
                                        <th scope="col" class="px-4 py-3">
                                            Actualizado
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Ciudad
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Parque
                                        </th>
                                        <th scope="col" class="px-4 py-3 rounded-tr-xl">
                                            ACCIONES
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @forelse ($data['data'] as $item)
                                        <tr
                                            class="row items-center bg-white border-b-2  border-gray-300 hover:bg-gray-50 ">
                                            <th scope="row"
                                                class="px-2 py-4 font-semibold text-black whitespace-now">
                                                {{ $item['identificacion'] }}
                                                </td>
                                            <td class="px-4 py-4">
                                                {{ $item['nombre_completo'] }}
                                            </td>

                                            <td class="px-2 py-4">
                                                {{ $item['celular'] }}
                                            </td>
                                            <td class="px-2 py-4">
                                                {{ $item['email'] }}
                                            </td>
                                            <td class="px-4 py-4">
                                                {{ $item['fecha_nacimiento'] ? $item['fecha_nacimiento'] : 'Sin registrar' }}
                                            </td>
                                            <td class="px-4 py-4">
                                                {{ $item['create_at'] }}
                                            </td>
                                            <td class="px-4 py-4">
                                                {{ $item['update_at'] }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($item['city'] == null)
                                                    <span
                                                        class="bg-brand-purple text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded">Sin
                                                        ciudad</span>
                                                @elseif($item['city']->nombre == null)
                                                    <span
                                                        class="bg-brand-purple text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded">Sin
                                                        ciudad</span>
                                                @else
                                                    {{ $item['city']->nombre }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($item['park'] == null)
                                                    <span
                                                        class="bg-brand-purple text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded">Sin
                                                        parque</span>
                                                @elseif($item['park']->name == null)
                                                    <span
                                                        class="bg-brand-purple text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded">Sin
                                                        parque</span>
                                                @else
                                                    {{ $item['park']->name }}
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 flex gap-4">
                                                <button aria-label="Botón editar"
                                                    wire:click="setEditingClient(
                                                                                        {{ $item['id'] }}, 
                                                                                        {{ $item['identificacion'] }}, 
                                                                                        '{{ $item['nombre'] }}', 
                                                                                        '{{ $item['apellido'] }}',  
                                                                                        '{{ $item['celular'] }}',
                                                                                        '{{ $item['direccion'] }}', 
                                                                                        '{{ $item['email'] }}', 
                                                                                        '{{ $item['tipo_documento'] }}', 
                                                                                        '{{ $item['genero'] }}', 
                                                                                        '{{ $item['fecha_nacimiento'] }}', 
                                                                                        '{{ $item['id_ciudad'] }}',
                                                                                         '{{ $item['id_centro_comercial'] }}'
                                                                                    )">
                                                    <i class="fa-solid fa-square-pen fa-xl text-blue-500 "></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center">No hay clientes
                                                disponibles</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <x-buttons-pagination :data="$data"></x-buttons-pagination>
                        <!--Codigo ALPINE para llamar desde livewire-->
                        <div x-init="window.addEventListener('update-form-submitted', () => {
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

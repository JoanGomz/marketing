<div class="space-4 p-4">
    <!-- Encabezado de página -->
    <div class="bg-white  rounded-lg shadow-md overflow-hidden p-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800 ">{{ __('Gestión de usuarios') }}</h1>
            <p class="text-sm text-gray-500 ">Gestiona los datos de tus usuarios</p>
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
                                <x-input-search mode="tableSearch" placeholder="Buscar usuarios"></x-input-search>
                                @if (Auth::user()->role_id === 1)
                                    <div>
                                        <x-primary-button mode="showCreate">
                                            Nuevo Usuario
                                        </x-primary-button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if (Auth::user()->role_id === 1 || Auth::user()->role_id === 2)
                            <!--Div de actualización de usuarios-->
                            <div x-show="$store.forms.updateFormVisible" x-cloak
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-90"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-90"
                                class="my-6 p-4 mx-4 bg-slate-200 rounded-lg">
                                <h3 class="text-lg font-medium">Editar Usuario</h3>
                                <form wire:submit.prevent="updateUser" class="max-w-full">
                                    <div class="mb-4">
                                        <label for="name_update"
                                            class="block text-sm font-medium {{ Auth::user()->role_id === 2 ? 'text-gray-500' : 'text-gray-900' }}">
                                            Nombre
                                        </label>
                                        <input wire:model="name" {{ Auth::user()->role_id === 2 ? 'disabled' : '' }}
                                            type="text" name="name_update" id="name_update"
                                            class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 {{ Auth::user()->role_id === 2 ? 'bg-gray-100 border-gray-200 text-gray-500 cursor-not-allowed' : 'bg-white border-gray-300 text-gray-900 focus:border-indigo-500' }}">
                                        @error('name')
                                            <span class="error text-red-600">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="email_update"
                                            class="block text-sm font-medium {{ Auth::user()->role_id === 2 ? 'text-gray-500' : 'text-gray-900' }}">
                                            Email
                                        </label>
                                        <input wire:model="email" {{ Auth::user()->role_id === 2 ? 'disabled' : '' }}
                                            type="email" name="email_update" id="email_update"
                                            class="mt-1 block w-full rounded-md shadow-sm {{ Auth::user()->role_id === 2 ? 'bg-gray-100 border-gray-200 text-gray-500 cursor-not-allowed focus:ring-gray-300' : 'bg-white border-gray-300 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500' }}">
                                        @error('email')
                                            <span class="error text-red-600">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-5 flex gap-4">
                                        <div class="flex flex-col">
                                            <label for="role_select_update"
                                                class="block mb-2 text-sm font-medium {{ Auth::user()->role_id === 2 ? 'text-gray-500' : 'text-gray-900' }}">
                                                Seleccionar Rol
                                            </label>
                                            <select wire:model="role_check" name="role_select_update" id="role_select_update"
                                                {{ Auth::user()->role_id === 2 ? 'disabled' : '' }}
                                                class="role.select2 text-sm rounded-lg block w-full p-2.5 {{ Auth::user()->role_id === 2 ? 'bg-gray-100 border-gray-200 text-gray-500 cursor-not-allowed focus:ring-gray-300 focus:border-gray-300' : 'bg-gray-50 border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500' }}">
                                                <option value="">Selecciona un rol</option>
                                                @forelse ($roles['data'] as $item)
                                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                                @empty
                                                    <option>No hay roles disponibles</option>
                                                @endforelse
                                            </select>
                                            @error('role_check')
                                                <span class="error text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="flex flex-col">
                                            <label for="mall_update"
                                                class="block mb-2 text-sm font-medium {{ Auth::user()->role_id === 2 ? 'text-gray-500' : 'text-gray-900' }}">
                                                Seleccionar Centro Comercial
                                            </label>
                                            <select wire:model="id_mall" name="mall_update" id="mall_update"
                                                {{ Auth::user()->role_id === 2 ? 'disabled' : '' }}
                                                class="role.select2 text-sm rounded-lg block w-full p-2.5 {{ Auth::user()->role_id === 2 ? 'bg-gray-100 border-gray-200 text-gray-500 cursor-not-allowed focus:ring-gray-300 focus:border-gray-300' : 'bg-gray-50 border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500' }}">
                                                <option value="">Selecciona una ciudad</option>
                                                @forelse ($parks['data'] as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @empty
                                                    <option>No hay centros comerciales disponibles</option>
                                                @endforelse
                                            </select>
                                            @error('id_mall')
                                                <span class="error text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-5 flex-1">
                                            <label for="password_update" class="block mb-2 text-sm font-medium text-gray-900">
                                                Contraseña
                                            </label>
                                            <div class="relative">
                                                <input wire:model="password" type="password" name="password_update" id="password_update"
                                                    class="password shadow-xs text-sm rounded-lg block w-full p-2.5 bg-gray-50 border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500" />
                                                <div class="absolute inset-y-0 z-20 right-2 pl-3 flex items-center">
                                                    <i 
                                                        class="open-eye fa-solid fa-eye-low-vision text-gray-400 cursor-pointer"></i>
                                                    <i style="display: none;"
                                                        class="close-eye fa-solid fa-eye text-gray-400 cursor-pointer"></i>
                                                </div>
                                            </div>
                                            @error('password')
                                                <span class="error text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Botones -->
                                    <div class="flex gap-4">
                                        <x-primary-button mode="submit">Actualizar usuario</x-primary-button>
                                        <x-primary-button mode="cancelUpdate">Cancelar</x-primary-button>
                                    </div>
                                </form>
                            </div>
                        @endif
                        @if (Auth::user()->role_id === 1)
                            <!--Div de creación de usuarios-->
                            <div x-show="$store.forms.createFormVisible" x-cloak
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-90"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-90"
                                class="form my-6 p-4 mx-4 bg-slate-200 rounded-lg overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-9xt-gray-900">
                                    <h3 class="text-lg font-medium">Creación de Usuarios</h3>
                                    <form wire:submit="create" class="max-w-full">
                                        <div class="flex min-w-[200px] gap-4">
                                            <div class="mb-5 flex-1">
                                                <label for="name"
                                                    class="block mb-2 text-sm font-medium text-gray-9xt-">Nombre</label>
                                                <input wire:model="name" type="text" name="name" id="name"
                                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                                    placeholder="Ej: Juan Perez" />
                                                @error('name')
                                                    <span class="error text-red-600">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-5 flex-1">
                                                <label for="email"
                                                    class="block mb-2 text-sm font-medium text-gray-9xt-">Correo
                                                    Electronico</label>
                                                <input wire:model="email" name="email" id="email"
                                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                                    placeholder="Ej: example@example.com" />
                                                @error('email')
                                                    <span class="error text-red-600">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-5 flex gap-4">
                                            <div class="flex flex-col">
                                                <label for="role_select"
                                                    class="block mb-2 text-sm font-medium text-gray-9xt-">Seleccionar
                                                    Rol</label>
                                                <select class="role.select2" wire:model="role_check" name="role_select" id="role_select"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 xt-  ">
                                                    <option value="">Selecciona un rol</option>
                                                    @forelse ($roles['data'] as $item)
                                                        <option value="{{ $item['id'] }}">{{ $item['name'] }}
                                                        </option>
                                                    @empty
                                                        <option>No hay roles disponibles</option>
                                                    @endforelse
                                                </select>
                                                @error('role_check')
                                                    <span class="error text-red-600">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="flex flex-col">
                                                <label for="mall"
                                                    class="block mb-2 text-sm font-medium text-gray-9xt-">Seleccionar
                                                    parque</label>
                                                <select class="role.select2" wire:model="id_mall" name="mall" id="mall"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 xt-  ">
                                                    <option value="">Selecciona una ciudad</option>
                                                    @forelse ($parks['data'] as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}
                                                        </option>
                                                    @empty
                                                        <option>No hay parques disponibles</option>
                                                    @endforelse
                                                </select>
                                                @error('id_mall')
                                                    <span class="error text-red-600">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-5 flex-1">
                                                <label for="password"
                                                    class="block mb-2 text-sm font-medium text-gray-900">
                                                    Contraseña
                                                </label>
                                                <div class="relative">
                                                    <input wire:model="password" type="password" name="password" id="password"
                                                        class="password shadow-xs text-sm rounded-lg block w-full p-2.5 bg-gray-50 border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500" />
                                                    <div
                                                        class="absolute inset-y-0 z-20 right-2 pl-3 flex items-center">
                                                        <i
                                                            class="open-eye fa-solid fa-eye-low-vision text-gray-400 cursor-pointer"></i>
                                                        <i  style="display: none;"
                                                            class="close-eye fa-solid fa-eye text-gray-400 cursor-pointer"></i>
                                                    </div>
                                                </div>
                                                @error('password')
                                                    <span class="error text-red-600">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="flex gap-4">
                                            <x-primary-button mode="submit">Crear usuario</x-primary-button>
                                            <x-primary-button mode="cancelCreate">Cancelar</x-primary-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        <!--Tabla con la información de usuarios-->
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
                                        <th scope="col" class=" py-3 rounded-tl-xl">
                                            Id
                                        </th>
                                        <th scope="col" class=" py-3">
                                            Nombre
                                        </th>
                                        <th scope="col" class=" py-3">
                                            Correo electronico
                                        </th>
                                        <th scope="col" class=" py-3">
                                            Rol
                                        </th>
                                        <th scope="col" class=" py-3">
                                            Creado
                                        </th>
                                        <th scope="col" class=" py-3">
                                            Actualizado
                                        </th>
                                        <th scope="col" class=" py-3">
                                            Autor
                                        </th>
                                        <th scope="col" class=" py-3">
                                            Parque
                                        </th>
                                        @if (Auth::user()->role_id === 1 || Auth::user()->role_id === 2)
                                            <th scope="col" class="px-6 py-3 rounded-tr-xl">
                                                Acción
                                            </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @forelse ($data['data'] as $item)
                                        <tr
                                            class="row items-center  bg-white border-b-2  border-gray-300 hover:bg-gray-50 ">
                                            <th scope="row"
                                                class="px-2 py-4 font-semibold text-black whitespace-now">
                                                {{ $item['id'] }}
                                            </th>
                                            <td class="px-2 py-4">
                                                {{ $item['name'] }}
                                            </td>
                                            <td class="px-2 py-4">
                                                {{ $item['email'] }}
                                            </td>
                                            <td class="px-2 py-4">
                                                @if ($item['role'] && $item['role']->name)
                                                    {{ $item['role']->name }}
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td class="px-2 py-4">
                                                {{ \Carbon\Carbon::parse($item->create_at)->locale('es')->format('d/m/Y h:i A') }}
                                            </td>
                                            <td class="px-2 py-4">
                                                {{ \Carbon\Carbon::parse($item->update_at)->locale('es')->format('d/m/Y h:i A') }}
                                            </td>
                                            <td class="px-2 py-4">
                                                @if ($item['user_creator'] > 0)
                                                    {{ $item['user_creator'] }}
                                                @else
                                                    <span
                                                        class="bg-brand-aqua text-brand-purple text-xs font-medium me-2 px-2.5 py-0.5 rounded">Administrador</span>
                                                @endif
                                                {{ $item['user_creator'] }}
                                            </td>
                                            <td class="px-2 py-4">
                                                @if ($item['park'] && $item['park']->name)
                                                    {{ $item['park']->name }}
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            @if (Auth::user()->role_id === 1 || Auth::user()->role_id === 2)
                                                <td class="px-2 py-4 flex gap-2 justify-center">
                                                    <button aria-label="Editar usuario"
                                                        wire:click="setEditingUser(@js([ 'id' => $item['id'], 'name' => $item['name'], 'email' => $item['email'], 'role' => $item['role']->id ?? '', 'mall' => $item['park'] ? $item['park']->id : '', ]))">
                                                        <i class="fa-solid fa-square-pen fa-xl text-blue-500 "></i>
                                                    </button>
                                                    @if (Auth::user()->role_id === 1)
                                                        <button type="button" aria-label="Eliminar usuario"
                                                            @click="window.dispatchEvent(new CustomEvent('show-delete-modal', {
                                                        detail: { 
                                                            id: {{ $item['id'] }},
                                                            name: '{{ $item['name'] }}'
                                                        }
                                                        }))">
                                                            <i class="fa-solid fa-trash fa-xl text-red-500"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-2 py-4 text-center">No hay usuarios
                                                disponibles</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <x-buttons-pagination :data="$data"></x-buttons-pagination>
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
        @push('scripts')
            @vite(['resources/js/view-password.js'])
        @endpush
    </div>
</div>

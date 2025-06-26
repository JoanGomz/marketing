<div id="Info-Panel"
    class="w-full lg:w-1/4 bg-white border-l lg:block overflow-y-auto  transition-all duration-400 z-20 shadowCard">
    <div class="p-4">
        <div class="flex justify-between gap-4 border-b pb-2 mb-3 items-center">
            <h3 class="font-bold">Información del cliente</h3>

            @if (isset($dataClient['data']['email']) && $dataClient['data']['email'])
                <div class="">
                    <x-primary-button wire:click="setEditingClient">Actualizar</x-primary-button>
                </div>
            @else
                <div class="">
                    <x-primary-button mode="showCreate">Registrar</x-primary-button>
                </div>
            @endif
        </div>
        <div class="space-y-4">
            <div>
                <p class="text-sm text-gray-500">Nombre completo</p>
                <p class="font-medium">
                    {{ $dataClient && $dataClient['message'] !== 'Usuario no encontrado' ? $dataClient['data']['nombre_completo'] ?? ($nameWhatsApp ?? '--') : $nameWhatsApp ?? '--' }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="font-medium">
                    {{ $dataClient && $dataClient['message'] !== 'Usuario no encontrado' ? $dataClient['data']['email'] ?? '--' : '--' }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Teléfono</p>
                <p class="font-medium">
                    {{ $dataClient && $dataClient['message'] !== 'Usuario no encontrado' ? $dataClient['data']['telefono'] ?? ($telClient ?? '--') : $telClient ?? '--' }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Género</p>
                <p class="font-medium">
                    {{ $dataClient && $dataClient['message'] !== 'Usuario no encontrado' ? $dataClient['data']['genero'] ?? '--' : '--' }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Parque</p>
                <p class="font-medium">
                    {{ $dataClient && $dataClient['message'] !== 'Usuario no encontrado' ? $dataClient['data']->park['name'] ?? '--' : '--' }}
                </p>
            </div>
        </div>
        <div class="pt-4 border-t flex flex-col gap-4">
            <h4 class="font-medium mb-2">Notas</h4>
            <div class="text-sm p-2 bg-gray-50 rounded border">
                <div class="text-sm text-gray-700">{{ $notes ? $notes : 'Sin notas' }}
                </div>
            </div>
            <form wire:submit.prevent="saveNote">
                <textarea wire:model="noteText" class="w-full p-2 border rounded-md text-sm resize-none" rows="2"
                    placeholder="Agregar notas... (Enter: guardar, Shift+Enter: nueva línea)" x-data
                    @keydown.enter.prevent="
                                if ($event.shiftKey) {
                                    $event.target.value += '\n';
                                    $wire.set('noteText', $event.target.value);
                                } else {
                                    $refs.hiddenBtn.click();
                                }
                            ">
                        </textarea>

                <button type="submit" x-ref="hiddenBtn" class="hidden">Guardar</button>
            </form>
        </div>
        <div>
            <h3 class="font-bold border-b pb-2 mb-3">Mensajes rapidos</h3>
            <div class="pt-4">
                <h4 class="font-medium mb-2">Mensajes predeterminados</h4>
                <div class="space-y-2">
                    <div class="text-sm p-2 bg-gray-50 rounded border cursor-pointer">
                        <div class="font-medium">#Mensaje de bienvenida</div>
                        <div class="message-pred text-xs text-gray-500">Bienvenido a la atención en linea de StarPark,
                            ¿En que podemos ayudarte? ¿Desde que sede te comunicas?</div>
                    </div>
                    <div class="text-sm p-2 bg-gray-50 rounded border cursor-pointer">
                        <div class="font-medium">#Finalizar conversación</div>
                        <div class="message-pred text-xs text-gray-500">Para nosotros es un placer ayudarte, a
                            continuación te brindaremos una encuesta para que puedas calificar nuestra atención.</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Formulario registro de clientes -->
        <div x-show="$store.forms.createFormVisible" x-cloak
            x-transition:enter="transition ease-out duration-200 delay-100"
            x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
            class="fixed inset-0 z-40 overflow-y-auto flex items-center justify-center"
            @open-client-modal.window="$store.forms.showCreateForm()"
            @close-client-modal.window="$store.forms.hideCreateForm()">
            <!-- Overlay de fondo oscuro -->
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
                @click="$store.forms.createFormVisible = false">
            </div>
            <div
                class="relative bg-white rounded-lg shadow-xl mx-auto max-w-lg w-[500px] transform transition-all mt-20 z-50 p-6 duration-300">
                <!-- Botón de cerrar en la esquina superior derecha -->
                <button @click="$store.forms.createFormVisible = false"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-times"></i>
                </button>
                <form wire:submit="create" class="max-w-full">
                    <div class="flex flex-col items-center">
                        <h2 class="text-lg font-semibold text-brand-darkPurple text-center uppercase mb-4">Registro
                            cliente
                        </h2>
                    </div>
                    <!-- Primera fila: Identificación y Tipo de Documento -->
                    <div class="flex flex-wrap gap-4 mb-5">
                        <div class="flex-1">
                            <label for="identificacion"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Identificación</label>
                            <input wire:model="identificacion" type="text" id="identificacion"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                placeholder="Ej: 213232123" />
                            @error('identificacion')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex-1">
                            <label for="tipo_documento" class="block mb-2 text-sm font-medium text-gray-900 ">Tipo
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
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Segunda fila: Nombre y Apellido -->
                    <div class="flex flex-wrap gap-4 mb-5">
                        <div class="flex-1">
                            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 ">Nombre</label>
                            <input wire:model="nombre" type="text" id="nombre"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                placeholder="Ej: Angel" />
                            @error('nombre')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex-1">
                            <label for="apellido" class="block mb-2 text-sm font-medium text-gray-900 ">Apellido</label>
                            <input wire:model="apellido" type="text" id="apellido"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                placeholder="Ej: Ramirez" />
                            @error('apellido')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Tercera fila: Celular, Género y Fecha de Nacimiento -->
                    <div class="flex flex-wrap gap-4 mb-5">
                        <div class="flex-1">
                            <label for="celular" class="block mb-2 text-sm font-medium text-gray-900">Celular</label>
                            <input wire:model="celular" type="int" id="celular" disabled
                                class="cursor-not-allowed shadow-xs bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                placeholder="Ej: 3103035137" minlength="10" maxlength="10" />
                            @error('celular')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex-1">
                            <label for="genero" class="block mb-2 text-sm font-medium text-gray-900 ">Género</label>
                            <select wire:model="genero" id="genero"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5      ">
                                <option value="">Selecciona género</option>
                                <option value="M">M</option>
                                <option value="F">F</option>
                                <option value="NO BINARIO">NO BINARIO</option>
                                <option value="OTROS">OTROS</option>
                            </select>
                            @error('genero')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4 mb-5">
                        <div class="flex-1">
                            <label for="fecha_nacimiento" class="block mb-2 text-sm font-medium text-gray-900 ">Fecha
                                de
                                Nacimiento</label>
                            <input wire:model="fecha_nacimiento" type="date" id="fecha_nacimiento"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                placeholder="YYYY-MM-DD" />
                            @error('fecha_nacimiento')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex-1">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Email</label>
                            <input wire:model="email" type="email" id="email"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                placeholder="Ej: angel.ramirez@epam.com" />
                            @error('email')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- Cuarta fila: Dirección y Ciudad -->
                    <div class="flex flex-wrap gap-4 mb-5">
                        <div class="flex-1">
                            <label for="direccion"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Dirección</label>
                            <input wire:model="direccion" type="text" id="direccion"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                placeholder="Ej: Calle 2 2 2" />
                            @error('direccion')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex-1">
                            <label for="id_ciudad"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Ciudad</label>
                            <select wire:model="id_ciudad" id="id_ciudad"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5      ">
                                <option value="">Selecciona ciudad</option>
                                @forelse ($cities['data'] as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['nombre'] }}</option>
                                @empty
                                    <option>No hay ciudades disponibles</option>
                                @endforelse
                            </select>
                            @error('id_ciudad')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @if (Auth::user()->role_id === 1 || Auth::user()->role_id === 2)
                        <div class="flex-1">
                            <label for="id_park"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Parques</label>
                            <select wire:model="id_park" id="id_park"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5      ">
                                <option value="">Selecciona parque</option>
                                @forelse ($parks['data'] as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['nombre'] }}</option>
                                @empty
                                    <option>No hay parques disponibles</option>
                                @endforelse
                            </select>
                            @error('id_park')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                    <!-- Botones -->
                    <div class="flex gap-4">
                        <x-primary-button class="flex-1" mode="submit">Añadir Usuario</x-primary-button>
                        <x-primary-button class="flex-1" mode="cancelCreate">Cancelar</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Formulario actualización de clientes -->
        <div x-show="$store.forms.updateFormVisible" x-cloak
            x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
            x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
            class="fixed inset-0 z-40 overflow-y-auto flex items-center justify-center "
            @open-client-modal.window="$store.forms.createFormVisible = true"
            @close-client-modal.window="$store.forms.createFormVisible = false">>
            <!-- Overlay de fondo oscuro -->
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
                @click="$store.forms.updateFormVisible = false">
            </div>
            <div
                class="relative bg-white rounded-lg shadow-xl mx-auto max-w-lg w-[500px] transform transition-all mt-20 z-50 p-6 duration-300">
                <!-- Botón de cerrar en la esquina superior derecha -->
                <button @click="$store.forms.updateFormVisible = false"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-times"></i>
                </button>
                <form wire:submit="update" class="max-w-full">
                    <div class="flex flex-col items-center">
                        <h2 class="text-lg font-semibold text-brand-darkPurple text-center uppercase mb-4">
                            Actualización
                            cliente
                        </h2>
                    </div>
                    <!-- Primera fila: Identificación y Tipo de Documento -->
                    <div class="flex flex-wrap gap-4 mb-5">
                        <div class="flex-1">
                            <label for="identificacion"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Identificación</label>
                            <input wire:model="identificacion" type="text" id="identificacion"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                placeholder="Ej: 213232123" />
                            @error('identificacion')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex-1">
                            <label for="tipo_documento" class="block mb-2 text-sm font-medium text-gray-900 ">Tipo
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
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Segunda fila: Nombre y Apellido -->
                    <div class="flex flex-wrap gap-4 mb-5">
                        <div class="flex-1">
                            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 ">Nombre</label>
                            <input wire:model="nombre" type="text" id="nombre"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                placeholder="Ej: Angel" />
                            @error('nombre')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex-1">
                            <label for="apellido"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Apellido</label>
                            <input wire:model="apellido" type="text" id="apellido"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                placeholder="Ej: Ramirez" />
                            @error('apellido')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Tercera fila: Celular, Género y Fecha de Nacimiento -->
                    <div class="flex flex-wrap gap-4 mb-5">
                        <div class="flex-1">
                            <label for="celular" class="block mb-2 text-sm font-medium text-gray-900">Celular</label>
                            <input wire:model="celular" type="int" id="celular" disabled
                                class="cursor-not-allowed shadow-xs bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                placeholder="Ej: 3103035137" minlength="10" maxlength="10" />
                            @error('celular')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex-1">
                            <label for="genero" class="block mb-2 text-sm font-medium text-gray-900 ">Género</label>
                            <select wire:model="genero" id="genero"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5      ">
                                <option value="">Selecciona género</option>
                                <option value="M">M</option>
                                <option value="F">F</option>
                                <option value="NO BINARIO">NO BINARIO</option>
                                <option value="OTROS">OTROS</option>
                            </select>
                            @error('genero')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4 mb-5">
                        <div class="flex-1">
                            <label for="fecha_nacimiento" class="block mb-2 text-sm font-medium text-gray-900 ">Fecha
                                de
                                Nacimiento</label>
                            <input wire:model="fecha_nacimiento" type="date" id="fecha_nacimiento"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                placeholder="YYYY-MM-DD" />
                            @error('fecha_nacimiento')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex-1">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Email</label>
                            <input wire:model="email" type="email" id="email"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                placeholder="Ej: angel.ramirez@epam.com" />
                            @error('email')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- Cuarta fila: Dirección y Ciudad -->
                    <div class="flex flex-wrap gap-4 mb-5">
                        <div class="flex-1">
                            <label for="direccion"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Dirección</label>
                            <input wire:model="direccion" type="text" id="direccion"
                                class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5       "
                                placeholder="Ej: Calle 2 2 2" />
                            @error('direccion')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex-1">
                            <label for="id_ciudad"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Ciudad</label>
                            <select wire:model="id_ciudad" id="id_ciudad"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5      ">
                                <option value="">Selecciona ciudad</option>
                                @forelse ($cities['data'] as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['nombre'] }}</option>
                                @empty
                                    <option>No hay ciudades disponibles</option>
                                @endforelse
                            </select>
                            @error('id_ciudad')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @if (Auth::user()->role_id === 1 || Auth::user()->role_id === 2)
                        <div class="flex-1 mb-2">
                            <label for="id_park"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Parques</label>
                            <select wire:model="id_park" id="id_park"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5      ">
                                <option value="">Selecciona parque</option>
                                @forelse ($parks['data'] as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['nombre'] }}</option>
                                @empty
                                    <option>No hay parques disponibles</option>
                                @endforelse
                            </select>
                            @error('id_park')
                                <span class="error text-red-600 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                    <!-- Botones -->
                    <div class="flex gap-4">
                        <x-primary-button class="flex-1" mode="submit">Actualizar</x-primary-button>
                        <x-primary-button class="flex-1" mode="cancelCreate">Cancelar</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mensajesPredeterminados = document.querySelectorAll('.message-pred');
            const inputChat = document.getElementById("message-input");
            mensajesPredeterminados.forEach(function(elemento) {
                elemento.addEventListener('click', function(e) {
                    inputChat.value = this.textContent;
                    inputChat.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                })
            });
        });
    </script>
@endpush

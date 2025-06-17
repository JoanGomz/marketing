<div id="Info-Panel"
    class="w-full lg:w-1/4 bg-white border-l lg:block overflow-y-auto  transition-all duration-400 z-20 shadowCard">
    <div class="p-4">
        <h3 class="font-bold border-b pb-2 mb-3">Información del cliente</h3>
        @if ($dataClient)
            @if ($dataClient['message'] != 'Usuario no encontrado')
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Nombre completo</p>
                        <p class="font-medium">Carlos Gómez Martínez</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium">carlos.gomez@ejemplo.com</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Teléfono</p>
                        <p class="font-medium">+52 123 456 7890</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Cliente desde</p>
                        <p class="font-medium">15 Mar 2023</p>
                    </div>
                </div>
            @else
                <div class="space-y-4 mb-4">
                    <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Nombre completo</p>
                        <p class="font-medium">--</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium">--</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Teléfono</p>
                        <p class="font-medium">--</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Cliente desde</p>
                        <p class="font-medium">--</p>
                    </div>
                </div>
                </div>
            @endif
        @endif
        <div class="pt-4 border-t flex flex-col gap-4">
            <h4 class="font-medium mb-2">Notas</h4>
            @if ($dataClient)
                @if ($dataClient['message'] != 'Usuario no encontrado')
                    <div class="text-sm p-2 bg-gray-50 rounded border">
                        <div class="text-xs text-gray-500">Usuario con problemas frecuentes en la recarga por PSE.
                            revisar
                        </div>
                    </div>
                @endif
            @endif
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
                    <div class="text-sm p-2 bg-gray-50 rounded border">
                        <div class="font-medium">#Mensaje de bienvenida</div>
                        <div class="text-xs text-gray-500">Bienvenido a la atención en linea de StarPark, ¿En que
                            podemos ayudarte? ¿Desde que sede te comunicas?</div>
                    </div>
                    <div class="text-sm p-2 bg-gray-50 rounded border">
                        <div class="font-medium">#Finalizar conversación</div>
                        <div class="text-xs text-gray-500">Para nosotros es un placer ayudarte, a continuación te
                            brindaremos una encuesta para que puedas calificar nuestra atención.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

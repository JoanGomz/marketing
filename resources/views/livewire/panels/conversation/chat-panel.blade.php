<div class="flex-1 flex flex-col resize-x z-10">
    <!-- Cabecera de la conversación -->
    <div class="bg-brand-darkPurple p-4  flex justify-between items-center font-bold text-white z-20" style="box-shadow: 0px 8px 12px rgba(0, 0, 0, 0.48);">
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 mr-3">
                C
            </div>
            <div>
                <div class="font-bold">Carlos Gómez</div>
                <div class="flex items-center text-sm">
                    <div class="w-2 h-2 mr-2 rounded-full bg-green-400"></div>
                    <span id="estado-chat"  class="font-bold">Asignado</span>
                </div>
            </div>
        </div>

        <div class="flex gap-4">
            <button id="info-button" class="rounded-md p-2 pr-6 text-sm px-6 bg-gray-500">Información</button>
            <select id="estado" class="rounded-md p-2  pr-6 text-sm text-black bg-[#94D4A0]">
                <option value="">Cambiar estado</option>
                <option value="pending">Pendiente</option>
                <option value="assigned" selected>Asignado</option>
                <option value="waiting">En espera</option>
                <option value="completed">Finalizado</option>
            </select>
            <select id="asesor" class="rounded-md p-2 pr-6 text-sm text-black">
                <option value="">Asignar a</option>
                <option value="1" selected>Juan Pérez</option>
                <option value="2">Ana López</option>
                <option value="3">Carlos Ruiz</option>
            </select>
        </div>
    </div>

    <!-- Historial de mensajes -->
    <div id="content-conversation" class="flex-1 overflow-y-auto p-4 bg-gray-50" style="background-image: url('/Images/Asesor/patron.png'); background-size: 100%;
            background-repeat: repeat;">
        <!-- Mensajes del sistema -->
        <div class="flex justify-center mb-4">
            <div class="bg-gray-200 text-gray-600 text-xs rounded-full px-3 py-1">
                Hoy, 9:30 AM
            </div>
        </div>
    </div>

    <!-- Input para responder -->
    <div class="p-4 bg-white border-t">
        <div class="flex items-center bg-gray-100 rounded-lg px-4 py-2">
            <input type="text" placeholder="Escribe tu respuesta..." class="flex-1 bg-transparent border-none">
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
        </div>
        <div class="flex justify-between mt-2 text-xs text-gray-500">
            <div>
                <input type="checkbox" id="internal" class="mr-1">
                <label for="internal">Nota interna</label>
            </div>
            <div>
                <button class="text-brand-blueStar hover:underline">Usar plantilla</button>
            </div>
        </div>
    </div>
</div>

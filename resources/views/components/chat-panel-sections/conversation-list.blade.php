<div class="w-full lg:w-1/4 bg-white border-r overflow-y-auto resize-x min-w-[330px] shadowCard z-20">
    <div class="p-4 border-b">
        <div class="flex items-center py-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 pl-2 text-white absolute" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input  id="searchInput"
                type="text" 
                placeholder="Buscar conversación" 
                class="w-full bg-gray-400 placeholder-white pl-8 rounded-md"
            >
        </div>
    </div>
    
    <div class="p-2 border-b flex justify-between">
        <button id="all" data-filter="all" class="px-1 py-1 rounded-md text-sm font-medium bg-brand-aqua bg-opacity-70 text-brand-darkPurple">
            Todos
        </button>
        <button id="pending" data-filter="pendiente" class="px-1 py-1 rounded-md text-sm font-medium text-gray-500 hover:bg-yellow-100 hover:text-yellow-800">
            Pendiente
        </button>
        <button id="assigned" data-filter="asignado" class="px-1 py-1 rounded-md text-sm font-medium text-gray-500 hover:bg-blue-100 hover:text-blue-800">
            Asignado
        </button>
        <button id="waiting" data-filter="En espera" class="px-1 py-1 rounded-md text-sm font-medium text-gray-500 hover:bg-purple-100 hover:text-purple-800">
            En espera
        </button>
    </div>
    
    <div id="conversaciones">
        <!-- Conversaciones generadas por consumo de api -->
    </div>
</div>
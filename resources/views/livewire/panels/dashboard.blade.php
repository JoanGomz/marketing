<div class="min-h-screen bg-gray-100 ">
    <div class="py-4">
        <!-- Header con información de usuario -->
        <div class="mx-auto sm:px-4 lg:px-4 mb-6">
            <div class="bg-white shadowCard hover:shadow  rounded-lg  overflow-hidden">
                <div class="p-4">
                    <h1 class="text-xl font-semibold text-gray-900 ">
                        Bienvenid@ <a 
                            class="text-brand-blueStar ">Asesor</a> a
                        Mercadeo
                    </h1>
                    <p class="text-sm text-gray-600  mt-1">
                        Actualmente tienes el rol de <span
                            class="font-medium">Administrador</span>
                    </p>
                </div>
            </div>
        </div>
        <!-- Usando laravel mix pasamos la data consumida por el componente a el archivo de js -->
        <script>
            
        </script>
        <!-- Contenedor principal de gráficos -->
        <div class="mx-auto sm:px-4 lg:px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Gráfico 1: CardUsuarios -->
                <div class="bg-white shadowCard  hover:shadow overflow-hidden  rounded-lg">
                    {{-- <div class="p-4 border-b border-gray-200 ">
                        <h2 class="font-semibold text-center text-lg text-gray-900 ">Usuarios por
                            Parques</h2>
                    </div> --}}
                    <div class="p-4">
                        <div class="w-full" style="min-height: 300px" id="spark1">
                        </div>
                    </div>
                </div>
                <!--Grafico 2: CardConversaciones -->
                <div class="bg-white shadowCard hover:shadow  overflow-hidden  rounded-lg">
                    {{-- <div class="p-4 border-b border-gray-200 ">
                        <h2 class="font-semibold text-center text-lg text-gray-900 ">Usuarios por
                            Parques</h2>
                    </div> --}}
                    <div class="p-4">
                        <div class="w-full" style="min-height: 300px" id="spark2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="{{ mix('resources/js/dashBoard/dashboardCharts.js') }}"></script>
</div>

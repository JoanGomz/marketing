<div class="min-h-screen bg-gray-100">
    <div class="py-4">
        <!-- Header con información de usuario -->
        <div class="mx-auto sm:px-4 lg:px-4 mb-6">
            <div class="bg-white shadowCard hover:shadow  rounded-lg  overflow-hidden">
                <div class="p-4">
                    <h1 class="text-xl font-semibold text-gray-900 ">
                        Bienvenid@ <a class="text-brand-blueStar">{{ Auth::user()->name }}</a> a
                        Mercadeo
                    </h1>
                    <p class="text-sm text-gray-600  mt-1">
                        Actualmente tienes el rol de <span
                            class="font-medium">{{ Auth::user()->role_id === 1 ? 'Torre Central' : 'Asesor' }}</span>
                    </p>
                </div>
            </div>
        </div>
        <!-- Usando laravel mix pasamos la data consumida por el componente a el archivo de js -->
        <script>
            window.user = @json(Auth::user());
            window.chartConversations = @json($cant_conversations['data']);
            window.chartEvents = @json($events['data']);
        </script>
        <!-- Contenedor principal de gráficos -->
        <div class="mx-auto sm:px-4 lg:px-4">
            <div class="grid grid-cols-1 {{ Auth::user()->role_id === 2 ? 'md:grid-cols-3' : 'md:grid-cols-2' }} gap-4">
                @if (Auth::user()->role_id === 1)
                    <!-- Card Usuarios con animación y gradiente -->
                    <div
                        class="bg-gradient-to-br from-brand-blueStar to-brand-redStar shadowCard hover:shadow overflow-hidden rounded-lg p-8 relative group">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent transform -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out">
                        </div>
                        <div class="p-4 relative z-10">
                            <div class="w-full flex flex-col items-center text-white">
                                <i
                                    class="fa-solid fa-users font-bold p-2 fa-2xl group-hover:scale-110 transition-transform duration-300 drop-shadow-lg"></i>
                                <p class="font-bold p-2 pt-4 text-4xl drop-shadow-md">{{ $users['data'] }}</p>
                                <h3 class="font-bold p-2 opacity-90">Usuarios en el sistema</h3>
                            </div>
                        </div>
                    </div>
                @endif
                @if (Auth::user()->role_id === 1 || Auth::user()->role_id === 2)
                    <!-- Card Conversaciones con animación y gradiente -->
                    <div
                        class="{{ Auth::user()->role_id === 2 ? 'col-span-1' : '' }} bg-gradient-to-br from-brand-blueStar to-brand-redStar shadowCard hover:shadow overflow-hidden rounded-lg p-4 relative group flex items-center justify-center min-h-[200px]">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent transform -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out">
                        </div>

                        <div class="relative z-10">
                            <div class="w-full flex flex-col items-center text-white">
                                <i
                                    class="fa-solid fa-comments font-bold p-2 fa-2xl group-hover:scale-110 transition-transform duration-300 drop-shadow-lg"></i>
                                <p class="font-bold p-2 pt-4 text-4xl drop-shadow-md">
                                    {{ $cant_conversations['data']['total_conversaciones'] }}</p>
                                <h3 class="font-bold p-2 opacity-90">Conversaciones</h3>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- Card Conversaciones por sede con animación y gradiente -->
                <div class="bg-white shadowCard hover:shadow overflow-hidden rounded-lg p-4 relative group col-span-1">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-transparent via-brand-blueStar/10 to-transparent transform -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out">
                    </div>
                    <div class="relative z-10">
                        <div class="w-full flex flex-col items-center" id="spark1">

                        </div>
                    </div>
                </div>

                <div class="bg-white shadowCard hover:shadow overflow-hidden rounded-lg p-4 relative group col-span-1">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-transparent via-brand-blueStar/10 to-transparent transform -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out">
                    </div>
                    <div class="relative z-10">
                        <div class="w-84 flex flex-col items-center" id="chart2">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="{{ mix('resources/js/dashBoard/dashboardCharts.js') }}"></script>
</div>

<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="bg-white/10 backdrop-blur-lg rounded-2xl overflow-hidden shadow-xl">
        <div class="p-8">
            <div class="text-center flex flex-col justify-center items-center mb-8">
                <img class="h-20 w-20" src="/Images/Logos/4.webp" alt="logo-noCard">
                <div class="h-0.5 w-24 bg-brand-aqua mx-auto mt-4 rounded-full"></div>
                <p class="mt-4 text-gray-300">Ingresa tus credenciales para acceder</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-envelope text-gray-400"></i>
                        </div>
                        <input placeholder="Correo Electrónico" id="email"
                            class="w-full px-4 py-4 bg-purple-800/50 text-white placeholder-gray-400 rounded-lg 
         border border-transparent 
         shadow-[inset_4px_0_6px_-4px_rgba(0,0,0,0.3)]
         focus:outline-none focus:ring-2 focus:ring-purple-500 pl-10 font-secondary text-xs"
                            type="email" name="email" value="{{ old('email') }}" autofocus
                            autocomplete="username" />
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400"></i>
                        </div>
                        <input name="password" type="password" placeholder="Contraseña" id="password"
                            class="w-full px-4 py-4 bg-purple-800/50 text-white placeholder-gray-400 rounded-lg 
         border border-transparent 
         shadow-[inset_4px_0_6px_-4px_rgba(0,0,0,0.3)]
         focus:outline-none focus:ring-2 focus:ring-purple-500 pl-10"
                            autocomplete="current-password" />
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>



                <!-- Login Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 rounded-lg text-white overflow-hidden transition-all duration-300 ease-out bg-brand-purple
                     hover:from-blue-700 hover:bg-gradient-button focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-lg">
                        <!-- Líneas animadas en los bordes -->
                        <span
                            class="absolute top-0 left-0 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full"></span>
                        <span
                            class="absolute bottom-0 right-0 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full"></span>
                        <span
                            class="absolute top-0 right-0 h-0 w-0.5 bg-white transition-all duration-300 delay-150 group-hover:h-full"></span>
                        <span
                            class="absolute bottom-0 left-0 h-0 w-0.5 bg-white transition-all duration-300 delay-150 group-hover:h-full"></span>

                        <!-- Efecto de onda/brillo -->
                        <span
                            class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>

                        <!-- Íconos y texto -->
                        <span class="relative flex items-center">
                            <!-- Ícono de candado cerrado (visible por defecto) -->
                            <i
                                class="fa-solid fa-lock absolute transition-opacity duration-300 group-hover:opacity-0"></i>
                            <!-- Ícono de candado abierto (aparece en hover) -->
                            <i
                                class="fa-solid fa-lock-open absolute opacity-0 transition-opacity duration-300 group-hover:opacity-100"></i>
                            <!-- Espaciador para mantener alineación -->
                            <span class="w-4 mr-2"></span>
                            <span class="font-medium">Iniciar sesión</span>
                        </span>
                    </button>
                </div>


            </form>
        </div>
    </div>
</x-guest-layout>

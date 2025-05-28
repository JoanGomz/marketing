<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Mercadeo' }}</title>
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Livewire Styles -->
    @livewireStyles
    <!-- Scripts de la cabecera -->
    @stack('head-scripts')
</head>

<body class="bg-[#F9FAFF] font-['Segoe_UI',Tahoma,Geneva,Verdana,sans-serif]">
    <!-- Contenedor del menú de hamburguesa - SIEMPRE VISIBLE -->
    <div id="menu-button" class="fixed top-4 left-4 z-50 cursor-pointer">
        <button id="sidebar-toggle" class="text-[#0997AF] focus:outline-none transition-colors duration-300">
            <i class="fa-solid fa-bars text-xl pt-1"></i>
        </button>
    </div>
    <!-- Sidebar -->
    <div id="sidebar-wrapper" class="fixed inset-y-0 left-0 z-20 transition-all duration-300 ease-in-out">
        <aside id="sidebar"
            class="bg-brand-darkPurple text-white w-64 h-full flex flex-col transition-alla duration-300">
            <div class="p-4 border-b border-gray-700 flex justify-end pr-14 pt-5">
                <h1 class="font-bold text-xl">StarPark</h1>
            </div>
            <nav class="flex-1 flex flex-col pt-4">
                <ul>
                    @if (Auth::user()->role_id === 1 || Auth::user()->role_id === 2)
                        <li
                            class="px-4 py-4 hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-4">
                                <i class="fa-solid fa-house"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->role_id === 1 || Auth::user()->role_id === 2)
                        <li class="px-4 py-4 hover:bg-gray-700 {{ request()->routeIs('users') ? 'bg-gray-700' : '' }}">
                            <a href="{{ route('users') }}" class="flex items-center gap-4">
                                <i class="fa-solid fa-users"></i>
                                <span>Usuarios</span>
                            </a>
                        </li>
                    @endif
                    <li
                        class="px-4 py-4 hover:bg-gray-700 {{ request()->routeIs('conversations') ? 'bg-gray-700' : '' }}">
                        <a href="{{ route('conversations') }}" class="flex items-center gap-4">
                            <i class="fa-solid fa-headset"></i>
                            <span>Conversaciones</span>
                        </a>
                    </li>
                    @if (Auth::user()->role_id === 1 || Auth::user()->role_id === 2)
                        <li class="px-4 py-4 hover:bg-gray-700 {{ request()->routeIs('park') ? 'bg-gray-700' : '' }}">
                            <a href="{{ route('park') }}" class="flex items-center gap-4">
                                <i class="fa-solid fa-gamepad"></i>
                                <span>Parques</span>
                            </a>
                        </li>
                    @endif
                </ul>
                <!-- Información de versión -->
                <div class="mt-auto flex p-4 border-t justify-center border-gray-800 w-full pb-10">
                    <img class="w-32" style="filter: drop-shadow(6px 4px 2px rgba(0, 0, 0, 0.427))"
                        fetchpriority="high" src="/Images/Logos/7.webp" alt="logo-noCard">
                </div>
            </nav>
        </aside>
    </div>
    <!-- Capa de fondo oscuro para móviles cuando el sidebar está abierto -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-10 hidden"></div>

    <!-- Contenido principal - Ahora fuera del sidebar-wrapper -->
    <div id="content-wrapper" class="flex-1 transition-all duration-300 ease-in-out ml-0">
        <!-- Barra superior compacta -->
        <header
            class="bg-gradient-to-r from-[#150840] to-[#0997AF] bg-opacity-40 fixed top-0 right-0 left-0 z-30 transition-all  duration-300">
            <div class="flex justify-between items-center h-16 px-4 sm:px-6 lg:px-8">
                <!-- Título -->
                <div class="p-4 flex justify-end pr-14 pt-5">
                    <img class="w-48" style="filter: drop-shadow(6px 4px 2px rgba(0, 0, 0, 0.427))"
                        fetchpriority="high" src="/Images/Logos/STARP.avif" alt="logo-StarPark">
                </div>
                <!-- Menú de usuario alineado completamente a la derecha -->
                <div class="flex items-center">
                    <div class="flex justify-end">
                        <div class="text-sm text-white mr-4 font-bold uppercase">
                            @switch(Auth::user()->role_id)
                                @case(1)
                                    Administrador
                                    @break
                                @case(2)
                                    Torre Central
                                    @break
                                @case(3)
                                    Asesor
                                    @break
                                @default
                                    
                            @endswitch
                        </div>
                    </div>
                    <div class="relative" x-data="{ open: false }" x-cloak>
                        <button @click="open = !open"
                            class="w-full h-full flex items-center px-3 py-2 rounded-full bg-[#0997AF] hover:bg-[#3fb8ce] transition-colors duration-150 focus:outline-none"
                            style="box-shadow: 0 8px 12px rgba(0, 0, 0, 0.408);">
                            <div
                                class="h-8 w-8 rounded-full bg-orange-400 flex items-center justify-center text-white font-semibold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <p class="ml-2 mr-1 hidden lg:flex text-sm font-medium text-white capitalize">
                                {{ Auth::user()->name }}
                            </p>
                        </button>
                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                            <div class="px-4 py-3 text-sm text-gray-600 border-b">
                                <div class="font-medium">{{ auth()->user()->name ?? 'Usuario' }}</div>
                                <div class="text-xs text-gray-500">{{ auth()->user()->email ?? 'usuario@ejemplo.com' }}
                                </div>
                            </div>

                            <x-dropdown-link href="{{ route('edit.profile.livewire') }}" class="flex items-center">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                    </path>
                                </svg>
                                {{ __('Editar perfil') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('edit.password') }}" class="flex items-center">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                {{ __('Cambiar contraseña') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <div class="flex items-center">
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        Cerrar sesión
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Contenedor principal con margen superior para la barra fija -->
        <main id="main-content" class="flex flex-col h-screen ml-64 transition-all duration-300">
            <!-- Header spacer -->
            <div class="h-16"></div>
            <!-- Opcional: Barra superior de sección -->
            @if (isset($header))
                <header class="bg-white shadow flex-shrink-0">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
            <!-- Contenido del componente hijo -->
            <div class="flex-1 overflow-auto ">
                <nocard-loading></nocard-loading>
                {{Auth::user()}}
                {{ $slot }}
            </div>
        </main>
    </div>
    <!-- Capa de fondo oscuro para móviles cuando el sidebar está abierto -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden"></div>
    <!-- Livewire Scripts -->
    @livewireScripts
    <!-- Scripts personalizados al final del body -->
    @stack('scripts')
    @include('components.loading-notification')
    @livewire('components.notification')

</body>

</html>

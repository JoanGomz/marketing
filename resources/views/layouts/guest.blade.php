<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Administra fácilmente las conversaciones con clientes y genera cotizaciones profesionales para STAR PARK. Optimiza tu gestión comercial con nuestra plataforma integral.">
        <title>Mercadeo</title>
        <!--Entro el guest.blade.php-->
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css'])
    </head>
    <body class="font-sans antialiased text-gray-800">         
    <div class="min-h-screen bg-gradient-button flex flex-col justify-center items-center p-4 relative">
        <!-- Marca de agua -->
        <div class="absolute bottom-4 right-4 opacity-30 z-50">
            <img src="{{ asset('Images/Logos/spoon-trasp.png') }}" alt="Logo-Spoon" class="w-24">
        </div>
        <div class="w-full max-w-md">                 
            {{ $slot }}             
        </div>    
        @stack('scripts')     
    </div>     
</body>
</html>
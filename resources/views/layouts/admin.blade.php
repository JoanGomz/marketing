<x-app-layout>
    <!-- Estilos adicionales -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Contenido de la navegación -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- ... existing code ... -->
        </div>
    </div>

    <!-- Contenido principal -->
    <main class="p-8">
        {{ $slot }}
    </main>
</x-app-layout> 
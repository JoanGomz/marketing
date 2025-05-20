<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>
    <form method="post" wire:submit.prevent="updatePassword()" class="mt-6 space-y-6">
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
            <input wire:model="contraseña" type="password"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('contraseña')
                <span class="error text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmación de contraseña</label>
            <input wire:model="confirmación_contraseña" type="password"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('confirmación_contraseña')
                <span class="error text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button @click="window.dispatchEvent(new CustomEvent('show-loading', { 
                detail: { message: 'Cargando...' } 
            }))">{{ __('Update Password') }}</x-primary-button>
        </div>
    </form>
</section>

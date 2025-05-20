<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>
    <form method="post" wire:submit.prevent="updateUser()" class="mt-6 space-y-6">
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input wire:model="name" type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('name')
                <span class="error text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input wire:model="email" type="email"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('email')
                <span class="error text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button mode="submit" >Guardar</x-primary-button>
        </div>
    </form>
</section>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="h-full">
            <div class="p-4 sm:p-8 bg-white  shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</div>

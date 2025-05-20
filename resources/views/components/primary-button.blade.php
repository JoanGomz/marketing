@props([
    'mode' => 'default',
    'action' => '',
])

@php
    // Configuramos según el "modo"
    $type = 'button';
    $size = 'w-full';
    $color = 'bg-gradient-button text-white';
    $icon = "";
    $attributesToAdd = [];

    switch ($mode) {
        case 'submit':
            $type = 'submit';
            $attributesToAdd['@click'] = $action ?: 'window.dispatchEvent(new CustomEvent(\'show-loading\', {
                             detail: { message: \'Cargando...\' }
                         }))';
            $attributesToAdd['wire:loading.attr'] = 'disabled';
            $size = 'w-42';
            break;

        case 'showCreate':
            $type = 'button';
            $attributesToAdd['@click'] = $action ?: '$wire.clear(); $store.forms.showCreateForm()';
            $icon = "<svg class=\"w-4 h-4 mr-2\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" 
                  d=\"M12 6v6m0 0v6m0-6h6m-6 0H6\"></path>
            </svg>";
            break;

        case 'cancelCreate':
            $type = 'button';
            $color = 'bg-gray-300 text-gray-700';
            $attributesToAdd['@click'] = $action ?: '$wire.clear(); $store.forms.hideCreateForm()';
            $size = 'w-32';
            break;
        case 'cancelUpdate':
            $type = 'button';
            $color = 'bg-gray-300 text-gray-700';
            $attributesToAdd['@click'] = $action ?: '$wire.clear(); $store.forms.hideUpdateForm()';
            $size = 'w-32';
            break;
    }
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge($attributesToAdd)->class("$size $color px-4 py-2 rounded-lg text-sm font-medium flex items-center transition duration-150 ease-in-out  justify-center") }}
>
    {!! $icon !!}
    {{ $slot }}
</button>
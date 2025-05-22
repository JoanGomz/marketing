<div
    x-data="{
        show: @entangle('show'),
        hideAfterTimeout() {
            if (this.show) {
                setTimeout(() => {
                    this.show = false;
                }, {{ $duration }});
            }
        }
    }"
    x-init="$watch('show', value => { if(value) hideAfterTimeout() })"
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed bottom-4 right-4 z-50"
    style="display: none;"
>
    <div class="min-w-[300px] bg-white shadow-lg rounded-lg pointer-events-auto">
        <div class="p-6">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0">
                    @switch($type)
                        @case('success')
                            <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                            @break
                        @case('error')
                            <i class="fas fa-times-circle text-red-500 text-2xl"></i>
                            @break
                        @case('warning')
                            <i class="fas fa-exclamation-circle text-yellow-500 text-2xl"></i>
                            @break
                        @case('info')
                            <i class="fas fa-info-circle text-blue-500 text-2xl"></i>
                            @break
                        @case('loading')
                            <div class="animate-spin text-blue-500 text-2xl">
                                <i class="fas fa-spinner"></i>
                            </div>
                            @break
                    @endswitch
                </div>
                <div class="flex-1">
                    <p class="text-base font-medium text-gray-900 ">
                        {{ $message }}
                    </p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button
                        @click="show = false"
                        class="text-gray-400 hover:text-gray-500 focus:outline-none "
                    >
                        <span class="sr-only">Cerrar</span>
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
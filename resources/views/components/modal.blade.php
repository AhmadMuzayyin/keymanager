@props(['id', 'title' => '', 'maxWidth' => 'lg'])

@php
    $maxWidthClasses = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
    ];
    $maxWidthClass = $maxWidthClasses[$maxWidth] ?? 'max-w-lg';
@endphp

<div x-data="{ show: false }" @open-modal.window="if ($event.detail === '{{ $id }}') show = true"
    @close-modal.window="if ($event.detail === '{{ $id }}') show = false"
    @keydown.escape.window="if (show) show = false" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="modal-title" role="dialog" aria-modal="true">

    {{-- Backdrop --}}
    <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="show = false">
    </div>

    {{-- Modal Container --}}
    <div class="flex min-h-screen items-center justify-center p-4">
        {{-- Modal Content --}}
        <div x-show="show" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4" @click.stop
            class="relative w-full {{ $maxWidthClass }} bg-white rounded-2xl shadow-2xl overflow-hidden">

            {{-- Header --}}
            @if ($title)
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-lg font-semibold text-slate-800" id="modal-title">
                        {{ $title }}
                    </h3>
                    <button @click="show = false" type="button"
                        class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Body --}}
            <div class="p-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

@props(['type' => 'info', 'message' => ''])

@php
    $styles = [
        'success' => [
            'bg' => 'bg-emerald-50 border-emerald-200',
            'text' => 'text-emerald-800',
            'icon' => 'text-emerald-500',
            'icon_path' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        'error' => [
            'bg' => 'bg-red-50 border-red-200',
            'text' => 'text-red-800',
            'icon' => 'text-red-500',
            'icon_path' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        'warning' => [
            'bg' => 'bg-amber-50 border-amber-200',
            'text' => 'text-amber-800',
            'icon' => 'text-amber-500',
            'icon_path' =>
                'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
        ],
        'info' => [
            'bg' => 'bg-blue-50 border-blue-200',
            'text' => 'text-blue-800',
            'icon' => 'text-blue-500',
            'icon_path' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
    ];
    $style = $styles[$type] ?? $styles['info'];
@endphp

<div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-2"
    class="mb-4 p-4 rounded-xl border {{ $style['bg'] }} {{ $style['text'] }} flex items-start" role="alert">
    <svg class="w-5 h-5 {{ $style['icon'] }} mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $style['icon_path'] }}"></path>
    </svg>
    <div class="flex-1">
        <p class="text-sm font-medium">{{ $message }}</p>
    </div>
    <button @click="show = false" class="ml-3 {{ $style['text'] }} hover:opacity-70 transition-opacity">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

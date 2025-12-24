@props(['type' => 'button'])

<button
    {{ $attributes->merge([
        'type' => $type,
        'class' => 'inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white 
                       bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl shadow-md shadow-amber-500/20
                       hover:from-amber-600 hover:to-orange-600 hover:shadow-lg hover:shadow-amber-500/30 hover:-translate-y-0.5
                       focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2
                       disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0
                       transition-all duration-200',
    ]) }}>
    {{ $slot }}
</button>

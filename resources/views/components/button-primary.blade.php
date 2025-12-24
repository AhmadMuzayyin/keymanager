@props(['type' => 'button'])

<button
    {{ $attributes->merge([
        'type' => $type,
        'class' => 'inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white 
                       bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-md shadow-indigo-500/20
                       hover:from-indigo-700 hover:to-purple-700 hover:shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                       disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0
                       transition-all duration-200',
    ]) }}>
    {{ $slot }}
</button>

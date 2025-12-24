@props(['type' => 'button'])

<button
    {{ $attributes->merge([
        'type' => $type,
        'class' => 'inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-slate-700 
                       bg-white border border-slate-200 rounded-xl shadow-sm
                       hover:bg-slate-50 hover:border-slate-300 hover:-translate-y-0.5
                       focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2
                       disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0
                       transition-all duration-200',
    ]) }}>
    {{ $slot }}
</button>

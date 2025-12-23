@props(['type' => 'button'])

<button type="{{ $type }}"
    {{ $attributes->merge(['class' => 'px-4 py-2 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition duration-150 ease-in-out']) }}>
    {{ $slot }}
</button>

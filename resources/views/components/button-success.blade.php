@props(['type' => 'button'])

<button type="{{ $type }}"
    {{ $attributes->merge(['class' => 'px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-150 ease-in-out']) }}>
    {{ $slot }}
</button>

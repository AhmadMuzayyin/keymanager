@props(['type' => 'button'])

<button type="{{ $type }}"
    {{ $attributes->merge(['class' => 'px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-150 ease-in-out']) }}>
    {{ $slot }}
</button>

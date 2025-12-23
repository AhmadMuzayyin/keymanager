@props(['type' => 'button'])

<button
    {{ $attributes->merge(['type' => $type, 'class' => 'px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out']) }}>
    {{ $slot }}
</button>

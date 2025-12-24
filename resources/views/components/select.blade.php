@props(['label' => '', 'name' => '', 'options' => [], 'selected' => '', 'required' => false, 'placeholder' => ''])

<div class="{{ $label ? 'mb-4' : '' }}">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 mb-1.5">
            {{ $label }}
            @if ($required)
                <span class="text-red-500 ml-0.5">*</span>
            @endif
        </label>
    @endif
    <div class="relative">
        <select {{ $name ? "name={$name} id={$name}" : '' }} {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' => 'w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 
                                                   appearance-none cursor-pointer
                                                   focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white
                                                   disabled:bg-slate-100 disabled:text-slate-500 disabled:cursor-not-allowed
                                                   transition-all duration-200',
            ]) }}>
            @if ($placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif
            @if (count($options) > 0)
                @foreach ($options as $value => $optionLabel)
                    <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>
                        {{ $optionLabel }}
                    </option>
                @endforeach
            @else
                {{ $slot }}
            @endif
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>
    @if ($name)
        @error($name)
            <p class="mt-1.5 text-sm text-red-600 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ $message }}
            </p>
        @enderror
    @endif
</div>

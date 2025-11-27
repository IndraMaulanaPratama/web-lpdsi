@props([
    'label' => '',
    'type' => 'text',
    'name' => '',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'error' => '',
    'helperText' => '',
    'showPasswordToggle' => false,
    'width' => 'full', // full, auto, max, min, atau nilai custom
    'containerClass' => '',
    'inputClass' => '',
])

@php
    $isPassword = $type === 'password';
    $hasError = !empty($error);

    // Menentukan kelas width berdasarkan prop width
    $widthClasses = [
        'full' => 'w-full',
        'auto' => 'w-auto',
        'max' => 'w-max',
        'min' => 'w-min',
    ];

    $inputWidth = array_key_exists($width, $widthClasses)
        ? $widthClasses[$width]
        : $width;

    // Kelas untuk container
    $containerClasses = ' ' . $containerClass;

    // Kelas untuk input
    $inputBaseClasses = 'px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200';
    $inputClasses = $inputBaseClasses .
                   ' ' . $inputWidth .
                   ($hasError ? ' border-red-500' : ' border-gray-300 dark:border-gray-600') .
                   ' ' . $inputClass;
@endphp

<div class="{{ $containerClasses }}" x-data="{ showPassword: false }">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            :type="{{ $isPassword && $showPasswordToggle ? 'showPassword ? \'text\' : \'password\'' : "'$type'" }}"
            placeholder="{{ $placeholder }}"
            value="{{ $value }}"
            @if ($required) required @endif
            @if ($disabled) disabled @endif
            @if ($readonly) readonly @endif
            {{ $attributes->merge(['class' => $inputClasses]) }}
        />

        @if ($isPassword && $showPasswordToggle)
            <button
                type="button"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
                @click="showPassword = !showPassword"
            >
                <i class="fa" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
            </button>
        @endif
    </div>

    @if ($helperText)
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $helperText }}</p>
    @endif

    @if ($hasError)
        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $error }}</p>
    @endif
</div>

@props([
    'label' => '',
    'name' => '',
    'placeholder' => '',
    'rows' => 4,
    'value' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'error' => null,
    'helperText' => '',
    'responsive' => true, // Tambah prop responsive
    'width' => 'full', // full, auto, max, min, atau nilai custom
    'height' => 'auto', // auto atau nilai custom seperti 200px
    'containerClass' => '', // Class tambahan untuk container
    'textareaClass' => '', // Class tambahan untuk textarea
    'resize' => true, // apakah boleh di-resize oleh user
])

@php
    $hasError = !empty($error);

    // Menentukan kelas width berdasarkan prop width
    $widthClasses = [
        'full' => 'w-full',
        'auto' => 'w-auto',
        'max' => 'w-max',
        'min' => 'w-min',
    ];

    $textareaWidth = array_key_exists($width, $widthClasses) ? $widthClasses[$width] : $width;

    // Menentukan kelas height
    $heightClass = $height === 'auto' ? '' : $height;

    // Kelas untuk container
    $containerClasses = 'mb-4 ' . $containerClass;

    // Kelas untuk textarea
    $textareaBaseClasses =
        'px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200';
    $textareaClasses =
        $textareaBaseClasses .
        ' ' .
        $textareaWidth .
        ($hasError ? ' border-red-500' : ' border-gray-300 dark:border-gray-600') .
        ($resize ? '' : ' resize-none') .
        ' ' .
        $textareaClass;

    // Tambahkan kelas height jika spesifik
    if ($heightClass) {
        $textareaClasses .= ' ' . $heightClass;
    }
@endphp

<div class="{{ $containerClasses }}">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}"
        @if ($required) required @endif @if ($disabled) disabled @endif
        @if ($readonly) readonly @endif {{ $attributes->merge(['class' => $textareaClasses]) }}>{{ old($name, $value) }}</textarea>

    @if ($helperText)
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $helperText }}</p>
    @endif

    @if ($hasError)
        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $error }}</p>
    @endif
</div>

@props([
    'label' => '',
    'name' => '',
    'options' => [],
    'selected' => '',
    'placeholder' => 'Pilih opsi',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'error' => '',
    'helperText' => '',
    'width' => 'full',
    'containerClass' => '',
    'selectClass' => '',
    'hasGroups' => false, // Untuk menandai apakah options memiliki grouping
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

    $selectWidth = array_key_exists($width, $widthClasses) ? $widthClasses[$width] : $width;

    // Kelas untuk container
    $containerClasses = 'mb-4 ' . $containerClass;

    // Kelas untuk select
    $selectBaseClasses =
        'px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200';
    $selectClasses =
        $selectBaseClasses .
        ' ' .
        $selectWidth .
        ($hasError ? ' border-red-500' : ' border-gray-300 dark:border-gray-600') .
        ' ' .
        $selectClass;
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

    <select id="{{ $name }}" name="{{ $name }}" @if ($required) required @endif
        @if ($disabled) disabled @endif @if ($readonly) readonly @endif
        {{ $attributes->merge(['class' => $selectClasses]) }}>
        <option value="">{{ $placeholder }}</option>

        @if ($hasGroups)
            @foreach ($options as $groupLabel => $groupOptions)
                <optgroup label="{{ $groupLabel }}">
                    @foreach ($groupOptions as $key => $option)
                        <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>
                            {{ $option }}
                        </option>
                    @endforeach
                </optgroup>
            @endforeach
        @else
            @foreach ($options as $key => $option)
                <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @endforeach
        @endif
    </select>

    @if ($helperText)
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $helperText }}</p>
    @endif

    @if ($hasError)
        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $error }}</p>
    @endif
</div>

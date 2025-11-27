@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'checked' => false,
    'required' => false,
    'disabled' => false,
    'error' => '',
    'helperText' => '',
])

@php
    $hasError = !empty($error);
@endphp

<div class="mb-4">
    <label class="flex items-center">
        <input type="radio" name="{{ $name }}" value="{{ $value }}"
            @if ($checked) checked @endif @if ($required) required @endif
            @if ($disabled) disabled @endif
            {{ $attributes->merge(['class' => 'rounded-full border-gray-300 text-primary-600 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600' . ($hasError ? ' border-red-500' : '')]) }} />
        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </span>
    </label>

    @if ($helperText)
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 ml-6">{{ $helperText }}</p>
    @endif

    @if ($hasError)
        <p class="text-sm text-red-600 dark:text-red-400 mt-1 ml-6">{{ $error }}</p>
    @endif
</div>

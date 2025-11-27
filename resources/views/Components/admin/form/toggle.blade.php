@props([
    'label' => '',
    'name' => '',
    'value' => false,
    'required' => false,
    'disabled' => false,
    'error' => '',
    'helperText' => '',
])

@php
    $hasError = !empty($error);
@endphp

<div class="mb-4" x-data="{ enabled: {{ $value ? 'true' : 'false' }} }">
    <label class="flex items-center justify-between">
        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </span>
        <button type="button" :class="enabled ? 'bg-primary-600' : 'bg-gray-200 dark:bg-gray-600'"
            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
            @click="enabled = !enabled" :aria-pressed="enabled">
            <span :class="enabled ? 'translate-x-5' : 'translate-x-0'"
                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
        </button>
        <input type="hidden" name="{{ $name }}" :value="enabled ? 1 : 0">
    </label>

    @if ($helperText)
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $helperText }}</p>
    @endif

    @if ($hasError)
        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $error }}</p>
    @endif
</div>

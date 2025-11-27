@props([
    'title' => '',
    'open' => false,
    'icon' => null,
    'variant' => 'default', // default, bordered, shadow
    'padding' => 'p-4', // Padding untuk content
    'headerClass' => '',
    'contentClass' => '',
])

@php
    $collapseId = uniqid('collapse-');

    // Variant classes
    $variantClasses = [
        'default' => 'border border-gray-200 dark:border-gray-700 rounded-lg',
        'bordered' =>
            'border border-gray-200 dark:border-gray-700 rounded-lg divide-y divide-gray-200 dark:divide-gray-700',
        'shadow' => 'shadow-md rounded-lg',
    ];

    $containerClass = $variantClasses[$variant] . ' ' . $attributes->get('class', '');
@endphp

<div x-data="{ isOpen: {{ $open ? 'true' : 'false' }} }" class="{{ $containerClass }}" {{ $attributes->except('class') }}>
    <!-- Header -->
    <button type="button" @click="isOpen = !isOpen"
        class="w-full flex items-center justify-between {{ $variant === 'bordered' ? 'p-4' : 'p-4 rounded-t-lg' }} text-left font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 {{ $headerClass }}"
        :aria-expanded="isOpen">
        <div class="flex items-center">
            @if ($icon)
                <i class="fa {{ $icon }} mr-3 text-gray-500 dark:text-gray-400"></i>
            @endif
            <span>{{ $title }}</span>
        </div>

        <i class="fa fa-chevron-down transform transition-transform duration-200" :class="{ 'rotate-180': isOpen }"></i>
    </button>

    <!-- Content -->
    <div x-show="isOpen" x-collapse class="{{ $padding }} {{ $contentClass }}">
        {{ $slot }}
    </div>
</div>

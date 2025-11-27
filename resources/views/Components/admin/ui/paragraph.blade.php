@props([
    'size' => 'base',
])

@php
    $sizeClasses = match ($size) {
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'base' => 'text-base',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        '2xl' => 'text-2xl',
        '3xl' => 'text-3xl',
        '4xl' => 'text-4xl',
        default => 'text-base',
    };
@endphp

<p class="{{ $sizeClasses }} text-gray-500 dark:text-gray-400 mt-1">
    {{ $slot }}
</p>

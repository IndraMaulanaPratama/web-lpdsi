@props([
    'variant' => 'primary',
    'size' => 'md',
    'outline' => false,
    'disabled' => false,
    'loading' => false,
    'icon' => null,
    'iconPrefix' => 'bi', // bi (Bootstrap Icons) atau fa (Font Awesome)
    'iconPosition' => 'left',
    'type' => 'button',
    'href' => null,
    'target' => '_self',
])

@php
    // Base classes
    $baseClasses =
        'inline-flex items-center justify-center font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200';

    // Size classes
    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    // Variant classes (solid)
    $variantClasses = [
        'primary' => 'bg-primary-600 hover:bg-primary-700 focus:ring-primary-500 text-white',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500 text-white',
        'success' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500 text-white',
        'danger' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500 text-white',
        'warning' => 'bg-yellow-500 hover:bg-yellow-600 focus:ring-yellow-500 text-white',
        'info' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white',
        'light' => 'bg-gray-100 hover:bg-gray-200 focus:ring-gray-500 text-gray-900',
        'dark' => 'bg-gray-800 hover:bg-gray-900 focus:ring-gray-500 text-white',
    ];

    // Outline variant classes
    $outlineVariantClasses = [
        'primary' =>
            'border border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white focus:ring-primary-500',
        'secondary' => 'border border-gray-600 text-gray-600 hover:bg-gray-600 hover:text-white focus:ring-gray-500',
        'success' => 'border border-green-600 text-green-600 hover:bg-green-600 hover:text-white focus:ring-green-500',
        'danger' => 'border border-red-600 text-red-600 hover:bg-red-600 hover:text-white focus:ring-red-500',
        'warning' =>
            'border border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-white focus:ring-yellow-500',
        'info' => 'border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white focus:ring-blue-500',
        'light' => 'border border-gray-300 text-gray-700 hover:bg-gray-100 focus:ring-gray-500',
        'dark' => 'border border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white focus:ring-gray-500',
    ];

    // Disabled classes
    $disabledClasses = 'opacity-50 cursor-not-allowed';

    // Combine classes
    $classes = $baseClasses . ' ' . $sizeClasses[$size];

    if ($outline) {
        $classes .= ' ' . $outlineVariantClasses[$variant];
    } else {
        $classes .= ' ' . $variantClasses[$variant];
    }

    if ($disabled) {
        $classes .= ' ' . $disabledClasses;
    }

    // Add custom classes from attributes
    $classes .= ' ' . ($attributes->get('class') ?? '');
@endphp

@if ($href)
    <a href="{{ $href }}" target="{{ $target }}" {{ $attributes->merge(['class' => $classes]) }}
        @if ($disabled) aria-disabled="true" @endif>
        @include('components.admin.button.button-content')
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}
        @if ($disabled) disabled @endif @if ($loading) aria-busy="true" @endif>
        @include('components.admin.button.button-content')
    </button>
@endif

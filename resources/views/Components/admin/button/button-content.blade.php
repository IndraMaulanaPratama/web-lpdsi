@props([
    'icon' => null,
    'iconPrefix' => 'bi',
    'iconPosition' => 'left',
    'loading' => false,
])

@if ($loading)
    <span class="inline-flex items-center">
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
        Loading...
    </span>
@else
    @if ($icon && $iconPosition === 'left')
        @if ($iconPrefix === 'fa')
            <i class="fa {{ $icon }} mr-2"></i>
        @else
            <i class="bi bi-{{ $icon }} mr-2"></i>
        @endif
    @endif

    <span>{{ $slot }}</span>

    @if ($icon && $iconPosition === 'right')
        @if ($iconPrefix === 'fa')
            <i class="fa {{ $icon }} ml-2"></i>
        @else
            <i class="bi bi-{{ $icon }} ml-2"></i>
        @endif
    @endif
@endif

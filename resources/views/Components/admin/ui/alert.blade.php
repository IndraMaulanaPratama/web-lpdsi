@props([
    'type' => 'success', // success, error, warning, info
    'title' => '',
    'message' => '',
    'icon' => true,
])

@php
    $configs = [
        'success' => [
            'bg' => 'bg-green-50 dark:bg-green-900/30',
            'border' => 'border border-green-200 dark:border-green-800',
            'text' => 'text-green-800 dark:text-green-300',
            'icon' => 'fa-check-circle',
            'iconColor' => 'text-green-500',
        ],
        'error' => [
            'bg' => 'bg-red-50 dark:bg-red-900/30',
            'border' => 'border border-red-200 dark:border-red-800',
            'text' => 'text-red-800 dark:text-red-300',
            'icon' => 'fa-exclamation-circle',
            'iconColor' => 'text-red-500',
        ],
        'warning' => [
            'bg' => 'bg-yellow-50 dark:bg-yellow-900/30',
            'border' => 'border border-yellow-200 dark:border-yellow-800',
            'text' => 'text-yellow-800 dark:text-yellow-300',
            'icon' => 'fa-exclamation-triangle',
            'iconColor' => 'text-yellow-500',
        ],
        'info' => [
            'bg' => 'bg-blue-50 dark:bg-blue-900/30',
            'border' => 'border border-blue-200 dark:border-blue-800',
            'text' => 'text-blue-800 dark:text-blue-300',
            'icon' => 'fa-info-circle',
            'iconColor' => 'text-blue-500',
        ],
    ];

    $config = $configs[$type] ?? $configs['success'];
@endphp

<div class="{{ $config['bg'] }} {{ $config['border'] }} {{ $config['text'] }} rounded-lg p-4 mb-4">
    <div class="flex items-start">
        @if($icon)
            <div class="flex-shrink-0">
                <i class="fa {{ $config['icon'] }} {{ $config['iconColor'] }} text-lg mt-0.5"></i>
            </div>
        @endif

        <div class="ml-3">
            @if($title)
                <h3 class="text-sm font-semibold">
                    {{ $title }}
                </h3>
            @endif

            @if($message)
                <div class="text-sm mt-1">
                    {{ $message }}
                </div>
            @else
                <div class="text-sm mt-1">
                    {{ $slot }}
                </div>
            @endif
        </div>
    </div>
</div>

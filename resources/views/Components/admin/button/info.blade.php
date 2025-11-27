@props([
    'variant' => 'info',
    'outline' => false,
])

<x-admin.button.button variant="info" :outline="$outline" {{ $attributes }}>
    {{ $slot }}
</x-admin.button.button>

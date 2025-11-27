@props([
    'variant' => 'warning',
    'outline' => false,
])

<x-admin.button.button variant="warning" :outline="$outline" {{ $attributes }}>
    {{ $slot }}
</x-admin.button.button>

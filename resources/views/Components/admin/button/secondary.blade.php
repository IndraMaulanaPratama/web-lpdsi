@props([
    'variant' => 'secondary',
    'outline' => false,
])

<x-admin.button.button variant="secondary" :outline="$outline" {{ $attributes }}>
    {{ $slot }}
</x-admin.button.button>

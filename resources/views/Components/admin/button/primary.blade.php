@props([
    'variant' => 'primary',
    'outline' => false,
])

<x-admin.button.button variant="primary" :outline="$outline" {{ $attributes }}>
    {{ $slot }}
</x-admin.button.button>

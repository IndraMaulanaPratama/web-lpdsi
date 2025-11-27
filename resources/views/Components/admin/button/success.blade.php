@props([
    'variant' => 'success',
    'outline' => false,
])

<x-admin.button.button variant="success" :outline="$outline" {{ $attributes }}>
    {{ $slot }}
</x-admin.button.button>

@props([
    'variant' => 'danger',
    'outline' => false,
])

<x-admin.button.button variant="danger" :outline="$outline" {{ $attributes }}>
    {{ $slot }}
</x-admin.button.button>

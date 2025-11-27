@props([
    'title' => '',
    'message' => '',
    'icon' => true,
])

<x-admin.ui.alert type="error" :title="$title" :message="$message" :icon="$icon" {{ $attributes }}>
    {{ $slot }}
</x-admin.ui.alert>

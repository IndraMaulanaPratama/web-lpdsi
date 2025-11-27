@props([
    'title' => '',
    'message' => '',
    'icon' => true,
])

<x-admin.ui.alert type="warning" :title="$title" :message="$message" :icon="$icon" {{ $attributes }}>
    {{ $slot }}
</x-admin.ui.alert>

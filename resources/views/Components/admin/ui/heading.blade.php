@props([
    'title' => '',
    'icon' => null, // default null tapi buat contoh bisa pakai bi-menu-button
])

<h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
    <i class="bi {{ $icon }} mr-2"></i> {{ $title ?? null }}
</h3>

@props([
    'title' => '',
    'icon' => null,
])


<div class="my-4 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <x-admin.ui.heading :title=$title :icon=$icon/>

    {{ $slot }}
</div>

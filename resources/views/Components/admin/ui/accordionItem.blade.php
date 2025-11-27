@props([
    'title' => '',
    'open' => false,
    'icon' => null,
    'index' => 0,
])

<div x-data="{ isOpen: {{ $open ? 'true' : 'false' }} }" class="border border-gray-200 dark:border-gray-700 rounded-lg">
    <!-- Header -->
    <button type="button" @click="$parent.toggleItem({{ $index }})"
        :aria-expanded="$parent.isOpen({{ $index }})"
        class="w-full flex items-center justify-between p-4 text-left font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 rounded-t-lg"
        x-effect="isOpen = $parent.isOpen({{ $index }})">
        <div class="flex items-center">
            @if ($icon)
                <i class="fa {{ $icon }} mr-3 text-gray-500 dark:text-gray-400"></i>
            @endif
            <span>{{ $title }}</span>
        </div>

        <i class="fa fa-chevron-down transform transition-transform duration-200"
            :class="{ 'rotate-180': $parent.isOpen({{ $index }}) }"></i>
    </button>

    <!-- Content -->
    <div x-show="$parent.isOpen({{ $index }})" x-collapse class="p-4">
        {{ $slot }}
    </div>
</div>

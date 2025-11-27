<div class="sidebar-transition w-64 bg-white dark:bg-gray-800 shadow-md fixed inset-y-0 left-0 z-50 flex flex-col"
    :class="{ 'ml-0': sidebarOpen, '-ml-64': !sidebarOpen }" x-show="true">

    <!-- Header -->
    <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
        <h1 class="text-xl font-bold text-primary-600 dark:text-white">Admin Panel</h1>
        <button @click="sidebarOpen = false" class="p-1 rounded-md md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Profile -->
    <div class="p-4">
        <div class="flex items-center space-x-4 p-2 mb-6">
            <div class="relative">
                <img class="w-12 h-12 rounded-full"
                    src="{{ Auth::user()->avatar 
                        ? asset('storage/' . Auth::user()->avatar) 
                        : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(Auth::user()->email))) . '?s=200&d=mp' }}"
                    alt="{{ Auth::user()->name }}">
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
            </div>
            <div>
                <h2 class="font-semibold text-gray-800 dark:text-white">{{ Auth::user()->name }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->nama_role ?? 'Admin' }}</p>
            </div>
        </div>
    </div>

    <!-- Menu Scrollable -->
    <div class="flex-1 overflow-y-auto px-4 space-y-2">
        <nav>
            @if (session()->has('menus'))
                @foreach (session()->get('menus') as $menu)
                    @if ($menu->parent_id == null)
                        <div x-data="{ open: false }">
                            <a href="{{ $menu->url }}" 
                               @if ($menu->children->count()) @click.prevent="open = !open" @endif
                               class="flex items-center justify-between py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                                <span><i class="{{ $menu->icon }} px-2"></i> {{ $menu->name }}</span>
                                @if ($menu->children->count())
                                    <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                                @endif
                            </a>
                            @if ($menu->children->count())
                                <ul x-show="open" x-transition
                                    class="ml-6 mt-1 space-y-1 border-l border-gray-300 dark:border-gray-700 pl-3">
                                    @foreach ($menu->children as $child)
                                        <li>
                                            <a href="{{ $child->url }}" 
                                               class="flex items-center py-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                                                <i class="{{ $child->icon }} px-2"></i> {{ $child->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endif
                @endforeach
            @endif
        </nav>
    </div>

    <!-- Footer -->
    <div class="sticky bottom-0 w-full p-4 border-t dark:border-gray-700 bg-white dark:bg-gray-800">
        <button @click="toggleDarkMode()"
            class="flex items-center w-full px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
            <template x-if="!darkMode">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </template>
            <template x-if="darkMode">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </template>
            <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
        </button>
    </div>
</div>

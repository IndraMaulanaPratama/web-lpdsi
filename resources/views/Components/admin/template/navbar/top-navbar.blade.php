<header class="bg-white dark:bg-gray-800 shadow-sm z-10">
    <div class="flex items-center justify-between px-4 py-3">
        <div class="flex items-center">
            <button @click="sidebarOpen = true"
                class="p-1 mr-4 rounded-md text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Dashboard</h2>
        </div>

        <div class="flex items-center space-x-4">
            <!-- Search Box -->
            <div class="relative hidden md:block">
                <input type="text" placeholder="Search..."
                    class="w-64 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute right-3 top-2.5 text-gray-400"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <!-- Notifications -->
            <div class="relative">
                <button
                    class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
            </div>

            <!-- User Menu -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2">
                    {{-- <img class="w-8 h-8 rounded-full"
                        src="https://ui-avatars.com/api/?name=Admin+User&background=3b82f6&color=fff" alt="Admin User"> --}}
                        <img 
                        class="w-8 h-8 rounded-full object-cover"
                        src="{{ Auth::user()->avatar 
                            ? asset('storage/' . Auth::user()->avatar)
                            : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(Auth::user()->email))) . '?s=200&d=mp' }}"
                        alt="{{ Auth::user()->name }}">
                    <span
                        class="hidden md:inline-block text-gray-700 dark:text-gray-300">{{ Auth()->user()->name }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50">
                    <a href="{{ route('admin.profile') }}"
                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                        Profile
                    </a>
                    <div class="border-t border-gray-100 dark:border-gray-700"></div>
                    <a href="{{ route('logout') }}"
                        class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>

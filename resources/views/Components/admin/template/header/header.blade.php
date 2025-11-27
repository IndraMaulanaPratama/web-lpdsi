<header class="bg-white shadow-md py-4 px-4">
    <div class="flex items-center justify-between">
        <button onclick="toggleSidebar()" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>

        <div class="flex items-center">
            <div x-data="{ dropdownOpen: false }" class="relative">
                <button @click="dropdownOpen = !dropdownOpen"
                    class="relative block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none">
                    <img class="object-cover w-full h-full"
                    src="{{ Auth::user()->avatar 
                        ? asset('storage/' . Auth::user()->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random' }}"
                    alt="Your avatar">
                </button>

                <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"
                    style="display: none;"></div>

                <div x-show="dropdownOpen"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10"
                    style="display: none;">
                    {{-- <a href="{{ route('profile') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-500 hover:text-white">Profile</a> --}}
                        <a href="{{ route('admin.profile') }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Profile
                        </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-500 hover:text-white">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

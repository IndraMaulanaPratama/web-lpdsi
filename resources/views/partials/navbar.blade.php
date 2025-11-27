<header class="bg-white/40 backdrop-blur-md shadow-md fixed w-full top-0 left-0 z-50">
    <div class="container mx-auto flex flex-wrap items-center justify-between p-4">
        <!-- Logo -->
        <div class="flex items-center space-x-3" style="font-family: 'Maddac', sans-serif;">
            <img src="{{ asset('images/Logo_IPDN.png') }}" alt="Logo" class="h-12 w-auto">
            <h1 class="text-base md:text-lg font-bold text-white-800 leading-tight"
                style="font-family: 'Mucitan Sans', sans-serif;">
                Lembaga Pengolahan Data & Sistem Informasi
            </h1>
        </div>

        <!-- Menu -->
        <nav class="hidden md:flex items-center space-x-6 text-gray-700 font-medium" 
            style="font-family: 'Poppins', sans-serif;">
            <a href="{{ url('/') }}" class="hover:text-blue-600">Beranda</a>

        <div class="relative group inline-block">
            <!-- Tombol -->
            <button class="flex items-center hover:text-blue-600">
                Profil
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

                <!-- Dropdown -->
                <div class="absolute top-full left-0 hidden group-hover:block bg-white shadow-lg w-48 rounded-lg z-50">
                    <a href="{{ url('/') }}#sambutan" class="block px-4 py-2 hover:bg-gray-100">Sambutan Kepala LPDSI</a>
                    <a href="{{ url('/') }}#visimisi" class="block px-4 py-2 hover:bg-gray-100">Visi & Misi</a>
                    <a href="{{ route('struktur') }}" class="block px-4 py-2 hover:bg-gray-100">Struktur Organisasi</a>
                    <a href="{{ route('galeri.index') }}" class="block px-4 py-2 hover:bg-gray-100">Galeri</a>
                </div>
            </div>

            <script>
            function toggleDropdown() {
                document.getElementById("dropdownMenu").classList.toggle("hidden");
            }

            // Tutup dropdown kalau klik di luar
            window.addEventListener("click", function(e) {
                const dropdown = document.getElementById("dropdownMenu");
                const button = document.querySelector("#profileDropdown button");
                if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add("hidden");
                }
            });
            </script>
             <!-- Dropdown SOP -->
            <div class="relative group inline-block">
                <button class="flex items-center hover:text-blue-600">
                    SOP
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div class="absolute top-full left-0 hidden group-hover:block bg-white shadow-lg w-56 rounded-lg z-50">
                    <a href="{{ route('sop.show', 'LKSI') }}" class="block px-4 py-2 hover:bg-gray-100">SOP LKSI</a>
                    <a href="{{ route('sop.show', 'PDDIKTI') }}" class="block px-4 py-2 hover:bg-gray-100">SOP PDDIKTI</a>
                    <a href="{{ route('sop.show', 'LB') }}" class="block px-4 py-2 hover:bg-gray-100">SOP Lab Bahasa</a>
                    <a href="{{ route('sop.show', 'LP') }}" class="block px-4 py-2 hover:bg-gray-100">SOP Lab Pemerintahan</a>
                </div>
            </div>

             <!-- Dropdown Panduan -->
            <div class="relative group inline-block">
                <button class="flex items-center hover:text-blue-600">
                    Panduan
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div class="absolute top-full left-0 hidden group-hover:block bg-white shadow-lg w-56 rounded-lg z-50">
                    <a href="{{ route('panduan.show', 'LKSI') }}" class="block px-4 py-2 hover:bg-gray-100">Panduan LKSI</a>
                    <a href="{{ route('panduan.show', 'PDDIKTI') }}" class="block px-4 py-2 hover:bg-gray-100">Panduan PDDIKTI</a>
                    <a href="{{ route('panduan.show', 'LB') }}" class="block px-4 py-2 hover:bg-gray-100">Panduan Lab Bahasa</a>
                    <a href="{{ route('panduan.show', 'LP') }}" class="block px-4 py-2 hover:bg-gray-100">Panduan Lab Pemerintahan</a>
                </div>
            </div>

            <a href="{{ route('kerjasama') }}" class="hover:text-blue-600">Kerjasama</a>
            <a href="{{ route('berita.index') }}" class="hover:text-blue-600">Berita</a>
            <a href="{{ route('kontak') }}" class="hover:text-blue-600">Kontak</a>
        </nav>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-toggle" class="md:hidden text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white shadow-lg">
        <a href="{{ url('/') }}" class="block px-4 py-2 hover:bg-gray-100">Beranda</a>
        <a href="{{ url('/') }}#sambutan" class="block px-4 py-2 hover:bg-gray-100">Sambutan Kepala LPDSI</a>
        <a href="{{ url('/') }}#visimisi" class="block px-4 py-2 hover:bg-gray-100">Visi & Misi</a>
        <a href="{{ route('struktur') }}" class="block px-4 py-2 hover:bg-gray-100">Struktur Organisasi</a>
        <a href="{{ route('galeri.index') }}" class="block px-4 py-2 hover:bg-gray-100">Galeri</a>

         <!-- Dropdown SOP (Mobile) -->
        <div class="border-t border-gray-200"></div>
        <p class="px-4 pt-2 text-gray-600 font-semibold">SOP</p>
        <a href="{{ route('sop.show', 'LKSI') }}" class="block px-6 py-2 hover:bg-gray-100">SOP LKSI</a>
        <a href="{{ route('sop.show', 'PDDIKTI') }}" class="block px-6 py-2 hover:bg-gray-100">SOP PDDIKTI</a>
        <a href="{{ route('sop.show', 'LB') }}" class="block px-6 py-2 hover:bg-gray-100">SOP Lab Bahasa</a>
        <a href="{{ route('sop.show', 'LP') }}" class="block px-6 py-2 hover:bg-gray-100">SOP Lab Pemerintahan</a>
        
        <!-- Dropdown Panduan (Mobile) -->
        <div class="border-t border-gray-200"></div>
        <p class="px-4 pt-2 text-gray-600 font-semibold">Panduan</p>
        <a href="{{ route('panduan.show', 'LKSI') }}" class="block px-4 py-2 hover:bg-gray-100">Panduan LKSI</a>
        <a href="{{ route('panduan.show', 'PDDIKTI') }}" class="block px-4 py-2 hover:bg-gray-100">Panduan PDDIKTI</a>
        <a href="{{ route('panduan.show', 'LB') }}" class="block px-4 py-2 hover:bg-gray-100">Panduan Lab Bahasa</a>
        <a href="{{ route('panduan.show', 'LP') }}" class="block px-4 py-2 hover:bg-gray-100">Panduan Lab Pemerintahan</a>
        
        <div class="border-t border-gray-200"></div>
        <a href="{{ route('kerjasama') }}" class="block px-4 py-2 hover:bg-gray-100">Kerjasama</a>
        <a href="{{ route('berita.index') }}" class="block px-4 py-2 hover:bg-gray-100">Berita</a>
        <a href="{{ route('kontak') }}" class="block px-4 py-2 hover:bg-gray-100">Kontak</a>
    </div>
</header>

<script>
    const toggleBtn = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    toggleBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>

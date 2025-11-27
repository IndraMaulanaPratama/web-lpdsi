<footer class="mt-10 text-white bg-blue-800">
    <div class="container mx-auto flex flex-wrap justify-between gap-4 p-8">
        
        <!-- Logo & Deskripsi -->
        <div class="w-full md:w-[220px] text-center">
            <img src="{{ asset('images/Logo_IPDN.png') }}" alt="Logo" class="h-20 w-auto mx-auto mb-3"> 
            <h2 class="font-bold text-lg leading-snug">
                Lembaga Pengolahan Data<br>Dan Sistem Informasi
            </h2>
        </div>


        <!-- Tautan Cepat -->
        <div class="w-[150px]">
            <h3 class="font-semibold text-base mb-2">Tautan Cepat</h3>
            <ul class="space-y-1 text-sm">
                <li><a href="{{ url('/') }}" class="hover:underline">Beranda</a></li>
                <li><a href="#" class="hover:underline">Layanan</a></li>
                <li><a href="#" class="hover:underline">Tentang Kami</a></li>
                <li><a href="#" class="hover:underline">Dokumentasi</a></li>
            </ul>
        </div>

        <!-- Kontak Kami -->
        <div class="w-[220px]">
            <h3 class="font-semibold text-base mb-2">Kontak Kami</h3>
            <p class="text-sm leading-relaxed">
                Jl. Raya Bandung - Sumedang No.Km.20, Cibeusi, Kec. Jatinangor, Kabupaten Sumedang
            </p>
            <p class="text-sm mt-2">✉ helpdesk.lpdsi@ipdn.ac.id</p>
        </div>

        <!-- Google Maps -->
        <div class="w-[280px] h-48 rounded-xl overflow-hidden shadow-lg">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3027.371237531936!2d107.76440185649518!3d-6.932998966160185!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68c4a7804a9185%3A0xb2b8ca78f8238e3b!2sInstitut%20Pemerintahan%20Dalam%20Negeri!5e1!3m2!1sid!2sid!4v1756390398219!5m2!1sid!2sid" 
                class="w-full h-full border-0"
                allowfullscreen 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>

    <!-- Sosmed -->
    <!-- <div class="flex justify-center space-x-4 mt-4">
        <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" class="h-6"></a>
        <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733558.png" class="h-6"></a>
        <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" class="h-6"></a>
        <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733561.png" class="h-6"></a>
    </div> -->

    <!-- Copyright -->
    <div class="text-center text-xs bg-blue-800 py-2 mt-4">
        © 2025 LPDSI. All rights reserved. | 
        <a href="#" class="underline">Kebijakan Privasi</a>
    </div>
</footer>

@extends('layouts.app')

@section('content')
<section class="py-32 px-6 md:px-16 bg-gray-100 min-h-screen flex justify-center">

    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-lg p-8">

        {{-- 🧭 Breadcrumb (rata kiri tapi sejajar konten utama) --}}
        <nav class="flex items-center text-sm text-gray-600 mb-6 space-x-1">
            <a href="{{ route('home') }}" class="hover:text-blue-600 flex items-center space-x-1">
                <i class="fa fa-home text-gray-500"></i>
                <span>Beranda</span>
            </a>
            <!-- <span class="text-gray-400">›</span>
            <a href="{{ url('/#agenda') }}" class="hover:text-blue-600">Agenda</a> -->
            <span class="text-gray-400">›</span>
            <span class="font-semibold text-blue-800">{{ $agenda->judul }}</span>
        </nav>

        {{-- 📰 Judul --}}
        <h1 class="text-3xl md:text-4xl font-bold text-blue-900 mb-4 leading-tight">
            {{ $agenda->judul }}
        </h1>

        {{-- 🕒 Tanggal & Lokasi --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-6 text-gray-600 mb-8 text-sm">
            <div class="flex items-center space-x-2">
                <i class="fa fa-calendar text-blue-700"></i>
                <span>{{ \Carbon\Carbon::parse($agenda->tanggal)->format('d F Y') }}</span>
            </div>
            @if(!empty($agenda->lokasi))
            <div class="flex items-center space-x-2 mt-2 sm:mt-0">
                <i class="fa fa-map-marker-alt text-red-600"></i>
                <span>{{ $agenda->lokasi }}</span>
            </div>
            @endif
        </div>

        {{-- 🖼️ Gambar --}}
        @if(!empty($agenda->gambar))
            <div class="mb-8 text-center">
                <img src="{{ asset('storage/' . $agenda->gambar) }}" 
                     alt="{{ $agenda->judul }}" 
                     class="w-full max-w-lg mx-auto rounded-xl shadow-md object-cover">
            </div>
        @endif

        {{-- 📜 Deskripsi --}}
        <div class="prose max-w-none text-gray-800 leading-relaxed text-justify">
            {!! $agenda->deskripsi ?? '<p>Tidak ada deskripsi untuk agenda ini.</p>' !!}
        </div>

        {{-- 🔗 Share Sosial Media --}}
        <div class="mt-10 border-t pt-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Bagikan</h3>
            <div class="flex flex-wrap items-center space-x-3">
                {{-- WhatsApp --}}
                <a href="https://wa.me/?text={{ urlencode($agenda->judul . ' - ' . url()->current()) }}" 
                   target="_blank" 
                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-full flex items-center space-x-2 transition">
                    <i class="fab fa-whatsapp"></i><span></span>
                </a>

                {{-- Facebook --}}
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                   target="_blank" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full flex items-center space-x-2 transition">
                    <i class="fab fa-facebook-f"></i><span></span>
                </a>

                {{-- X / Twitter --}}
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($agenda->judul) }}" 
                   target="_blank" 
                   class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-full flex items-center space-x-2 transition">
                    <i class="fab fa-x-twitter"></i><span></span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

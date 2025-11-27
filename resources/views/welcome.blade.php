@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Banner Section -->
<div class="relative min-h-screen flex items-center justify-center bg-cover bg-center text-white"
     style="background-image: url('{{ asset('images/banner.jpg') }}');">
    <div class="absolute inset-0 bg-gradient-to-b from-blue-900/80 via-blue-800/70 to-blue-900/80"></div>

    <div class="relative z-10 text-center px-6 max-w-4xl">
        <h1 class="text-5xl md:text-6xl font-extrabold mb-6 leading-tight tracking-tight font-sans">
            Lembaga Pengolahan Data & Sistem Informasi
        </h1>
        <p class="text-lg md:text-xl mb-8 text-gray-200 leading-relaxed font-light">
            Menyediakan layanan pengolahan data terpadu dan sistem informasi modern untuk mendukung tata kelola pemerintahan yang efektif dan transparan.
        </p>
        <a href="#layanan"
           class="inline-block bg-yellow-300 text-blue-900 px-8 py-4 rounded-full font-semibold hover:bg-yellow-400 transition duration-300 shadow-lg">
            Jelajahi Layanan
        </a>
    </div>
</div>

<!-- Layanan Utama -->
<div id="layanan" class="bg-gray-50">
    <div class="container mx-auto pt-28 pb-20 grid grid-cols-1 md:grid-cols-2 gap-10 px-6">
        @php
            $layanan = [
                ['title' => 'Laboratorium Komputer dan Sistem Informasi', 'desc' => 'Sistem analisis dan pengolahan data secara real-time.', 'route' => 'layanan.komputer'],
                ['title' => 'Laboratorium Bahasa', 'desc' => 'Pelatihan dan pengujian kemampuan bahasa berbasis teknologi.', 'route' => 'layanan.bahasa'],
                ['title' => 'Laboratorium Pemerintahan', 'desc' => 'Simulasi dan pengembangan sistem pemerintahan modern.', 'route' => 'layanan.pemerintahan'],
                ['title' => 'Pangkalan Data Pendidikan Tinggi', 'desc' => 'Manajemen data akademik secara terintegrasi.', 'route' => 'layanan.pddikti'],
            ];
        @endphp

        @foreach($layanan as $item)
        <a href="{{ route($item['route']) }}"
           class="bg-white border border-gray-100 shadow-md rounded-2xl p-10 hover:bg-gray-100 hover:shadow-xl hover:-translate-y-1 transform transition duration-300 text-center group">
            <h3 class="text-2xl font-semibold mb-3 text-blue-900 group-hover:font-extrabold">
                {{ $item['title'] }}
            </h3>
            <p class="text-gray-600">{{ $item['desc'] }}</p>
        </a>
        @endforeach
    </div>
</div>

<!-- Sambutan Kepala -->
<section id="sambutan" class="relative py-20 px-6 overflow-hidden bg-gradient-to-r from-blue-900 via-blue-800 to-blue-700">
    <div class="absolute top-0 -left-20 w-96 h-96 bg-blue-500 rounded-full mix-blend-overlay filter blur-3xl opacity-40"></div>
    <div class="absolute bottom-0 -right-20 w-96 h-96 bg-indigo-500 rounded-full mix-blend-overlay filter blur-3xl opacity-40"></div>

    <div class="relative container mx-auto flex flex-col md:flex-row items-center gap-12 text-white max-w-7xl px-10 bg-white/5 backdrop-blur-sm p-10 rounded-3xl shadow-2xl">
        
        {{-- FOTO SAMBUTAN --}}
        <div class="flex-shrink-0">
            <div class="relative">
                @if(isset($sambutan) && is_object($sambutan) && $sambutan->foto)
                    <img src="{{ asset('storage/' . $sambutan->foto) }}"
                        alt="{{ $sambutan->judul }}" 
                        class="rounded-2xl shadow-xl max-w-sm object-cover border-4 border-blue-200">
                @else
                    <img src="{{ asset('images/default-profile.png') }}" 
                        alt="Default Foto Kepala Lembaga"
                        class="rounded-2xl shadow-xl max-w-sm object-cover border-4 border-blue-200">
                @endif
            </div>

            @if(isset($sambutan) && is_object($sambutan) && isset($sambutan->nama))
                <p class="text-white font-semibold mt-6 text-center text-lg">
                    {{ $sambutan->nama }}
                </p>
                <p class="text-blue-200 text-center italic">
                    Kepala Lembaga Pengolahan Data & Sistem Informasi
                </p>
            @endif
        </div>

        {{-- TEKS SAMBUTAN --}}
        <div class="max-w-3xl text-center md:text-left md:ml-4">
            @if(isset($sambutan))
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">
                    {{ $sambutan->judul }}
                </h2>
                <blockquote class="text-lg leading-relaxed text-gray-100 space-y-4">
                    {!! $sambutan->konten !!}
                </blockquote>
            @else
                <p class="text-gray-200 text-center md:text-left">Belum ada sambutan yang ditambahkan.</p>
            @endif
        </div>

    </div>
</section>


<!-- Visi Misi -->
<section id="visimisi" class="bg-gray-50 py-20">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-extrabold text-center text-blue-800 mb-14 tracking-wide">
            Visi & Misi
        </h2>

        @if ($visiMisi)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">
                <!-- Visi -->
                <div class="bg-gradient-to-br from-blue-800 to-blue-700 text-white p-10 rounded-3xl shadow-xl transform hover:-translate-y-2 transition duration-300">
                    <h3 class="text-3xl font-bold mb-6 text-center text-white-300">Visi</h3>
                    <p class="text-lg leading-relaxed text-justify font-semibold">
                        {!! $visiMisi->visi !!}
                    </p>
                </div>

                <!-- Misi -->
                <div class="bg-gradient-to-br from-blue-800 to-blue-700 text-white p-10 rounded-3xl shadow-xl transform hover:-translate-y-2 transition duration-300">
                    <h3 class="text-3xl font-bold mb-6 text-center text-white-300">Misi</h3>
                    <div class="space-y-3 text-lg leading-relaxed text-justify font-semibold">
                        {!! $visiMisi->misi !!}
                    </div>
                </div>
            </div>
        @else
            <p class="text-center text-gray-500 text-lg">
                Data Visi & Misi belum tersedia.
            </p>
        @endif
    </div>
</section>


<!-- Berita Kampus -->
<section class="mt-10 mb-16 px-6 md:px-16">
    <h2 class="text-2xl font-bold text-blue-900 mb-6">Berita Terbaru</h2>
    <div class="container mx-auto px-6 max-w-7xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse(($berita ?? collect()) as $item)
                <article class="bg-white border border-gray-200 rounded-2xl shadow p-4 hover:shadow-xl transition">
                    {{-- Gambar --}}
                    <img class="w-full h-48 object-cover rounded-xl"
                         src="{{ $item->gambar ? asset('storage/'.$item->gambar) : asset('images/placeholder.jpg') }}"
                         alt="{{ $item->judul }}">

                    {{-- Judul --}}
                    <h3 class="mt-4 text-xl font-semibold text-blue-900">{{ $item->judul }}</h3>

                    {{-- Tanggal & Penulis --}}
                    <div class="mt-2 text-sm text-gray-500 flex items-center gap-2">
                        <span class="inline-block">
                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                        </span>
                    </div>

                    {{-- Tombol --}}
                    <a href="{{ route('berita.show', $item->slug) }}"
                       class="inline-block mt-4 text-yellow-500 hover:text-yellow-600 font-medium">
                        Baca Selengkapnya →
                    </a>
                </article>
            @empty
                <div class="col-span-3 text-center border rounded-2xl p-10 bg-gray-50">
                    <p class="text-gray-500">Belum ada berita.</p>
                    @isset($tampilkanTombolSelengkapnya)
                        <a href="{{ route('berita.index') }}"
                           class="mt-4 inline-block px-6 py-3 rounded-full bg-blue-800 text-white hover:bg-blue-900">
                            Semua Berita
                        </a>
                    @endisset
                </div>
            @endforelse
        </div>

        {{-- Tombol "Lihat Semua" --}}
        <div class="text-center mt-12">
            <a href="{{ route('berita.index') }}"
               class="inline-block px-8 py-3 rounded-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-semibold hover:bg-blue-900 transition">
                Lihat Semua
            </a>
        </div>
    </div>
</section>

<!-- Agenda -->
<section class="mt-10 mb-16 px-6 md:px-16">
    <h2 class="text-2xl font-bold text-blue-900 mb-6">Agenda</h2>
    <div class="bg-gradient-to-br from-blue-800 to-blue-700 p-6 rounded-2xl shadow-lg text-white max-w-6xl mx-auto">
        @if(isset($agendas) && $agendas->count())
            @foreach($agendas as $agenda)
                <div class="border-b border-blue-600 last:border-none py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between hover:bg-blue-700/40 rounded-xl px-3 transition">
                    <div class="flex items-center space-x-3">
                        <span class="font-semibold text-lg text-yellow-300">
                            {{ \Carbon\Carbon::parse($agenda->tanggal)->format('d-m-Y') }}
                        </span>
                        <a href="{{ route('agenda.show', $agenda->id) }}" 
                        class="font-medium text-lg text-white hover:text-yellow-300 transition">
                        {{ $agenda->judul }}
                        </a>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-center py-4">Belum ada agenda terbaru.</p>
        @endif
    </div>
</section>

@endsection

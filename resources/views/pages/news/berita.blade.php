@extends('layouts.app')

@section('title', 'Berita')

@section('content')
<div class="container mx-auto py-32 px-4 lg:px-12 max-w-7xl">
    <h1 class="text-3xl font-bold text-gray-800 mb-10 text-center">Berita</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($berita as $item)
            <div class="relative rounded-xl overflow-hidden shadow-lg group bg-white">
                {{-- Gambar --}}
                @if($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}"
                        alt="{{ $item->judul }}"
                        class="w-full h-72 object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <img src="{{ asset('images/placeholder.jpg') }}"
                        alt="Placeholder"
                        class="w-full h-72 object-cover group-hover:scale-105 transition-transform duration-500">
                @endif

                {{-- Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex flex-col justify-end p-6">
                    {{-- Judul --}}
                    <h2 class="text-white text-xl font-bold leading-snug mb-2">
                        {{ $item->judul }}
                    </h2>

                    {{-- Tanggal --}}
                    <p class="text-gray-200 text-sm mb-3">
                        {{ $item->created_at->translatedFormat('d F Y') }}
                    </p>

                    {{-- Tombol --}}
                    <a href="{{ route('berita.show', $item->slug) }}"
                       class="bg-blue-700 text-white font-semibold px-4 py-2 rounded-full w-fit hover:bg-blue-400 transition">
                        Lihat Selengkapnya
                    </a>
                </div>
            </div>
        @empty
            <p class="text-center col-span-3 text-gray-500">Belum ada berita.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8 flex justify-center">
        {{ $berita->links() }}
    </div>

    {{-- Tombol Slide Berikutnya (muncul jika berita >= 10) --}}
    @if($berita->count() >= 10 && $berita->hasMorePages())
        <div class="text-center mt-10">
            <a href="{{ $berita->nextPageUrl() }}"
               class="inline-block bg-blue-700 text-white font-semibold px-8 py-3 rounded-full shadow hover:bg-blue-800 transition">
                Slide Berikutnya →
            </a>
        </div>
    @endif
</div>
@endsection

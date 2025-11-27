@extends('layouts.app')

@section('title', $detail->judul)

@section('content')
<div class="container mx-auto py-32 px-4 max-w-4xl">

    {{-- Breadcrumb Navigation --}}
    <nav class="flex items-center text-gray-600 text-sm mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2 md:space-x-3">
            {{-- Home --}}
            <li>
                <a href="{{ route('home') }}" class="inline-flex items-center hover:text-blue-600 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 1.707a1 1 0 00-1.414 0l-8 8a1 1 0 001.414 1.414L3 10.414V17a1 1 0 001 1h4a1 1 0 001-1v-3h2v3a1 1 0 001 1h4a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-8-8z"/>
                    </svg>
                    Beranda
                </a>
            </li>

            {{-- Panah pemisah --}}
            <li>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 6 10">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l4 4-4 4" />
                </svg>
            </li>

            {{-- Halaman Berita --}}
            <li>
                <a href="{{ route('berita.index') }}" class="text-gray-600 hover:text-blue-600 transition-colors">
                    Berita
                </a>
            </li>

            {{-- Panah pemisah --}}
            <li>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 6 10">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l4 4-4 4" />
                </svg>
            </li>

            {{-- Halaman aktif --}}
            <li class="text-blue-700 font-medium">{{ $detail->judul }}</li>
        </ol>
    </nav>

    {{-- Judul --}}
    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
        {{ $detail->judul }}
    </h1>

    {{-- Metadata + Share --}}
    <div class="flex items-center justify-between text-sm text-gray-500 mb-6">
        
        {{-- Kiri: Penulis, tanggal, estimasi baca --}}
        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-gray-600"></i>
                </div>
                <span>{{ $detail->penulis ?? 'Admin' }}</span>
            </div>
            <span>{{ $detail->created_at->format('d M Y') }}</span>
            <span>• {{ str_word_count($detail->isi) / 200 > 1 ? round(str_word_count($detail->isi) / 200) : 1 }} min read</span>
        </div>

        {{-- Kanan: Share --}}
        <div class="flex items-center space-x-2">
            <span class="font-medium text-gray-700 mr-2">Share with:</span>
            {{-- Facebook --}}
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
               target="_blank" 
               class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-600 text-white hover:bg-blue-700">
                <i class="fab fa-facebook-f text-sm"></i>
            </a>
            {{-- Twitter --}}
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($detail->judul) }}" 
               target="_blank" 
               class="w-8 h-8 flex items-center justify-center rounded-full bg-sky-500 text-white hover:bg-sky-600">
                <i class="fab fa-twitter text-sm"></i>
            </a>
            {{-- LinkedIn --}}
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" 
               target="_blank" 
               class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-700 text-white hover:bg-blue-800">
                <i class="fab fa-linkedin-in text-sm"></i>
            </a>
            {{-- Telegram --}}
            <a href="https://t.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($detail->judul) }}" 
               target="_blank" 
               class="w-8 h-8 flex items-center justify-center rounded-full bg-sky-400 text-white hover:bg-sky-500">
                <i class="fab fa-telegram-plane text-sm"></i>
            </a>
            {{-- WhatsApp --}}
            <a href="https://api.whatsapp.com/send?text={{ urlencode($detail->judul . ' ' . request()->fullUrl()) }}" 
               target="_blank" 
               class="w-8 h-8 flex items-center justify-center rounded-full bg-green-600 text-white hover:bg-green-700">
                <i class="fab fa-whatsapp text-sm"></i>
            </a>
        </div>
    </div>

    {{-- Gambar --}}
    @if ($detail->gambar)
        <img src="{{ asset('storage/' . $detail->gambar) }}" 
             alt="{{ $detail->judul }}" 
             class="w-full max-h-[450px] object-contain rounded-lg mb-8">
    @endif

    {{-- Isi berita --}}
    <div class="prose max-w-none text-gray-800 leading-relaxed mb-10">
        {!! $detail->isi !!}
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Kerjasama')

@section('content')
<section class="py-24 px-6 md:px-16 bg-gray-100 min-h-screen">
    <div class="max-w-6xl mx-auto">

        {{-- 🧭 Breadcrumb --}}
        <nav class="flex items-center text-sm text-gray-600 mb-8 space-x-1">
            <a href="{{ route('home') }}" class="hover:text-blue-600 flex items-center space-x-1">
                <i class="fa fa-home text-gray-500"></i>
                <span>Beranda</span>
            </a>
            <span class="text-gray-400">›</span>
            <span class="font-semibold text-blue-800">Kerjasama</span>
        </nav>

        {{-- 🏢 Judul Utama --}}
        <h1 class="text-4xl font-bold text-blue-900 mb-12 text-center">Mitra Kerjasama</h1>

        {{-- 🇮🇩 Mitra Dalam Negeri --}}
        <div class="mb-16">
            <h2 class="text-2xl font-semibold text-black-800 mb-8 text-center">
                Mitra Dalam Negeri
            </h2>

            @if($mitraDalam->isEmpty())
                <p class="text-center text-gray-500">Belum ada mitra dalam negeri</p>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                    @foreach($mitraDalam as $mitra)
                        <div class="bg-white rounded-xl shadow-md flex items-center justify-center w-48 h-48 p-4 transition transform hover:scale-105 hover:shadow-lg">
                            <img src="{{ asset('storage/'.$mitra->logo) }}" 
                                alt="Logo {{ $mitra->nama ?? 'Mitra' }}" 
                                class="max-h-32 w-auto object-contain">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- 🌏 Mitra Luar Negeri --}}
        <div>
            <h2 class="text-2xl font-semibold text-black-800 mb-8 text-center">
                Mitra Luar Negeri
            </h2>

            @if($mitraLuar->isEmpty())
                <p class="text-center text-gray-500">Belum ada mitra luar negeri</p>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                    @foreach($mitraLuar as $mitra)
                        <div class="bg-white rounded-xl shadow-md flex items-center justify-center w-48 h-48 p-4 transition transform hover:scale-105 hover:shadow-lg">
                            <img src="{{ asset('storage/'.$mitra->logo) }}" 
                                alt="Logo Mitra" 
                                class="w-32 h-auto object-contain">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</section>
@endsection

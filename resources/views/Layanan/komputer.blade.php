@extends('layouts.app')

@section('title', 'Laboratorium Komputer dan Sistem Informasi')

@section('content')
<div class="relative min-h-screen bg-white-20 py-32 px-6">
    {{-- Decorative background --}}
    <!-- <div class="absolute top-0 left-0 w-72 h-72 bg-blue-200 opacity-30 blur-3xl rounded-full -z-10"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-100 opacity-40 blur-3xl rounded-full -z-10"></div> -->

    <div class="container mx-auto max-w-5xl">
        {{-- Breadcrumb Navigation --}}
        <nav class="flex items-center text-gray-600 text-sm mb-10" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2 md:space-x-3">
                <li>
                    <a href="{{ url('/') }}" class="inline-flex items-center hover:text-blue-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 1.707a1 1 0 00-1.414 0l-8 8a1 1 0 001.414 1.414L3 10.414V17a1 1 0 001 1h4a1 1 0 001-1v-3h2v3a1 1 0 001 1h4a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-8-8z"/>
                        </svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 6 10">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l4 4-4 4" />
                    </svg>
                </li>
                <li class="text-blue-700 font-medium">Laboratorium Komputer</li>
            </ol>
        </nav>

        {{-- Konten --}}
        @if($lab)
            <div class="bg-white/80 backdrop-blur-xl shadow-lg rounded-2xl p-10 border border-blue-50">
                {{-- Judul --}}
                <h1 class="text-4xl font-bold text-blue-900 mb-6 tracking-tight leading-tight">
                    {{ $lab->judul }}
                </h1>

                {{-- Deskripsi --}}
                <p class="text-black-700 text-lg leading-relaxed mb-10">
                    {{ $lab->deskripsi }}
                </p>

                {{-- Tugas --}}
                @if($lab->tugas)
                    <h2 class="text-2xl font-semibold text-black-800 mb-4 flex items-center">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg> -->
                        Tugas Utama
                    </h2>
                    <ul class="list-disc list-inside text-gray-700 space-y-3 text-base">
                        @foreach(explode("\n", $lab->tugas) as $item)
                            @if(trim($item) !== '')
                                <li class="pl-1">{{ trim($item) }}</li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        @else
            {{-- Jika belum ada data --}}
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-6 rounded-2xl shadow-sm">
                <p class="font-medium">Belum ada data laboratorium komputer yang ditambahkan oleh admin.</p>
            </div>
        @endif
    </div>
</div>
@endsection

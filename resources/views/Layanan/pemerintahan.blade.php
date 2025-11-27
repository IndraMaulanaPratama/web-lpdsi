@extends('layouts.app')

@section('title', 'Laboratorium Pemerintahan')

@section('content')
<div class="relative min-h-screen bg-white py-32 px-6">
    <div class="absolute top-0 left-0 w-72 h-72 bg-blue-200 opacity-30 blur-3xl rounded-full -z-10"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-100 opacity-40 blur-3xl rounded-full -z-10"></div>

    <div class="container mx-auto max-w-5xl">
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
                <li class="text-blue-700 font-medium">Laboratorium Pemerintahan</li>
            </ol>
        </nav>

        <div class="bg-white/80 backdrop-blur-xl shadow-lg rounded-2xl p-10 border border-blue-50">
            <h1 class="text-4xl font-bold text-blue-900 mb-6">{{ $lab->judul ?? 'Laboratorium Pemerintahan' }}</h1>

            <p class="text-black-700 text-lg leading-relaxed mb-10">
                {!! nl2br(e($lab->deskripsi ?? 'Belum ada deskripsi tersedia.')) !!}
            </p>

            @if (!empty($lab->tugas))
                <h2 class="text-2xl font-semibold text-black-800 mb-4">Tugas Utama</h2>
                <p class="text-gray-700 leading-relaxed mb-6">
                    {!! nl2br(e($lab->tugas)) !!}
                </p>
            @endif

            <h2 class="text-2xl font-semibold text-black-800 mb-4">Akses Link</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>
                    <a href="http://labpemmus.ipdn.ac.id/" target="_blank" class="text-blue-600 hover:underline">
                        http://labpemmus.ipdn.ac.id/
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

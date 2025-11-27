@extends('layouts.app')

@section('title', 'Struktur Organisasi')

@section('content')
<section class="py-24 px-6 md:px-16 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto text-center">

        {{-- Judul --}}
        <h1 class="text-3xl md:text-4xl font-bold text-blue-900 mb-10">
            {{ $structure->title ?? 'Struktur Organisasi' }}
        </h1>

        {{-- Gambar Struktur --}}
        @if($structure && $structure->image)
            <div class="bg-white p-6 md:p-10 rounded-2xl shadow-lg inline-block">
                <img src="{{ asset('storage/' . $structure->image) }}" 
                     alt="{{ $structure->title }}" 
                     class="rounded-xl mx-auto max-w-full md:max-w-4xl object-contain transition-transform duration-300 hover:scale-105">
            </div>
        @else
            <p class="text-gray-500 mt-6">Belum ada struktur organisasi yang ditambahkan.</p>
        @endif

    </div>
</section>
@endsection

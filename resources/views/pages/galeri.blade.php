@extends('layouts.app')

@section('title', 'Galeri')

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
            <span class="font-semibold text-blue-800">Galeri</span>
        </nav>

        {{-- 🖼️ Judul --}}
        <h1 class="text-4xl font-bold text-blue-900 mb-10 text-center">Galeri</h1>

        {{-- 📁 Level = YEAR --}}
        @if($level === 'year')
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @foreach ($years as $year)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition duration-300 p-6 text-center group">
                        <div class="flex justify-center mb-4">
                            <div class="bg-gradient-to-br from-blue-700 to-blue-500 rounded-full p-4 group-hover:scale-110 transform transition">
                                <i class="fa fa-folder text-white text-4xl"></i>
                            </div>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $year->year }}</h2>
                        <a href="{{ route('galeri.year', $year->slug) }}" 
                           class="inline-block text-blue-700 font-medium hover:text-blue-900 transition">
                            Lihat Kegiatan
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- 🎉 Level = EVENT --}}
        @if($level === 'event')
            <h2 class="text-2xl font-semibold mb-8 text-center text-blue-800">
                Kegiatan Tahun {{ $year->year }}
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @foreach ($events as $event)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition duration-300 p-6 text-center group">
                        <div class="flex justify-center mb-4">
                            <div class="bg-gradient-to-br from-yellow-500 to-yellow-400 rounded-full p-4 group-hover:scale-110 transform transition">
                                <i class="fa fa-folder-open text-white text-4xl"></i>
                            </div>
                        </div>
                        <h2 class="text-lg font-bold text-gray-800 mb-2">{{ $event->name }}</h2>
                        <a href="{{ route('galeri.event', [$year->slug, $event->slug]) }}" 
                           class="inline-block text-blue-700 font-medium hover:text-blue-900 transition">
                            Lihat Foto 
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- 🖼️ Level = PHOTO --}}
        @if($level === 'photo')
            <h2 class="text-2xl font-semibold mb-8 text-center text-blue-800">
                {{ $event->name }} ({{ $year->year }})
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @foreach ($photos as $photo)
                    
                    {{-- 🎥 Jika ada video YouTube --}}
                    @if ($photo->video_url)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                            <div class="relative w-full h-56 bg-black">
                                <iframe 
                                    src="{{ $photo->video_url }}" 
                                    title="YouTube video"
                                    class="absolute inset-0 w-full h-full rounded-lg object-cover"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                            <!-- <div class="p-4 text-center">
                                <p class="font-medium text-gray-700">{{ $photo->title }}</p>
                            </div> -->
                        </div>
                    @endif

                    {{-- 🖼️ Jika ada gambar --}}
                    @if ($photo->image && file_exists(public_path('storage/' . $photo->image)))
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                            <img src="{{ asset('storage/' . $photo->image) }}" 
                                alt="{{ $photo->title ?? 'Foto Galeri' }}" 
                                class="w-full h-56 object-contain bg-white">
                            <!-- <div class="p-4 text-center">
                                <p class="font-medium text-gray-700">{{ $photo->title }}</p>
                            </div> -->
                        </div>
                    @endif

                    {{-- 🚫 Jika tidak ada media sama sekali --}}
                    @if (!$photo->video_url && !$photo->image)
                        <div class="bg-white rounded-2xl shadow-lg flex items-center justify-center h-56 text-gray-400">
                            <span>Tidak ada media</span>
                        </div>
                    @endif

                @endforeach
            </div>

            {{-- 🔙 Tombol Kembali --}}
            <div class="mt-10 text-center">
                <a href="{{ route('galeri.year', $year->slug) }}" 
                class="inline-flex items-center text-blue-700 hover:text-blue-900 font-medium transition">
                    <i class="fa fa-arrow-left mr-2"></i> Kembali ke kegiatan
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

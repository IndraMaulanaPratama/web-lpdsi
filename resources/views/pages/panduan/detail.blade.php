@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white-80 py-24 px-4">
    <div class="container mx-auto max-w-4xl">
        <!-- Breadcrumb -->
        <nav class="text-sm text-blue-900/70 mb-6 font-medium">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> /
            <a href="{{ route('panduan.show', $panduan->divisi->name ?? 'LKSI') }}" class="hover:underline">
                Panduan {{ $panduan->divisi->name ?? '' }}
            </a> /
            <span class="text-blue-900 font-semibold">{{ $panduan->judul }}</span>
        </nav>

        <!-- Box Artikel -->
        <article class="border border-blue-200 rounded-xl p-6 bg-white shadow-md hover:shadow-lg transition relative">
            <!-- Judul -->
            <h1 class="text-3xl font-semibold text-blue-900 mb-4 leading-tight text-center tracking-tight">
                {{ $panduan->judul }}
            </h1>

            <!-- Info Penulis -->
            <div class="flex items-center justify-center text-sm text-black-800/80 mb-6">
                <span>Oleh <span class="font-semibold">{{ $panduan->penulis ?? 'Admin' }}</span></span>
                <span class="mx-2">•</span>
                <span>{{ $panduan->created_at->diffForHumans() }}</span>
            </div>

            <!-- Gambar -->
            @if($panduan->image)
                <img src="{{ asset('storage/' . $panduan->image) }}" 
                     alt="{{ $panduan->judul }}" 
                     class="rounded-lg shadow-md mb-6 w-full max-h-[400px] object-cover">
            @endif

            <!-- Isi Artikel -->
            <div class="prose prose-lg max-w-none text-black-900 leading-relaxed mb-8">
                {!! $panduan->isi !!}
            </div>

            <hr class="my-4 border-blue-200">

            <!-- Like / Comment / Share -->
            <div class="flex items-center justify-between text-blue-900/80 text-sm">
                <div class="flex items-center space-x-6">
                    <!-- Like -->
                    <form id="like-form" action="{{ route('panduan.like', $panduan->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center space-x-2 hover:text-black-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ session('liked_'.$panduan->id) ? 'text-red-500' : 'text-blue-400' }}" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18l-6.828-6.828a4 4 0 010-5.656z" clip-rule="evenodd" />
                            </svg>
                            <span id="like-count">{{ $panduan->likes_count ?? 0 }}</span> Suka
                        </button>
                    </form>

                    <!-- Komentar -->
                    <button type="button" onclick="toggleCommentForm()" class="flex items-center space-x-2 hover:text-black-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m-5 8l5-5H6a2 2 0 01-2-2V7a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2h-1l-5 5z" />
                        </svg>
                        <span id="comment-count">{{ $panduan->komentar->count() ?? 0 }}</span> Komentar
                    </button>
                </div>

                <!-- Share -->
                <div x-data="{ openShare: false, copied: false }" class="relative inline-block">
                    <button 
                        @click="openShare = !openShare"
                        type="button"
                        class="flex items-center space-x-2 hover:text-blue-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.06c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.44 9.31 6.77 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.77 0 1.44-.3 1.96-.77l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/>
                        </svg>
                        <span>Bagikan</span>
                    </button>

                    <!-- Popup Share -->
                    <div 
                        x-show="openShare"
                        @click.outside="openShare = false"
                        @keydown.escape="openShare = false"
                        x-transition
                        class="absolute mt-3 right-0 bg-white border border-gray-200 shadow-2xl rounded-2xl p-5 w-80 z-50">
                        
                        <!-- Header -->
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-gray-900 font-bold text-lg flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.06c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.44 9.31 6.77 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.77 0 1.44-.3 1.96-.77l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/>
                                </svg>
                                Bagikan Artikel
                            </h3>
                            <button 
                                @click="openShare = false"
                                type="button"
                                class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Sosial Media -->
                        <div class="grid grid-cols-4 gap-3 mb-4">
                            <!-- WhatsApp -->
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($panduan->judul . ' ' . url()->current()) }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="flex flex-col items-center gap-2 p-3 rounded-xl bg-green-50 hover:bg-green-100 transition-all transform hover:scale-110">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-green-500 text-white font-bold text-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5" fill="currentColor">
                                        <path d="M380.9 97.1C339 55.1 283.2 32 224.2 32 100.9 32 1 131.9 1 255.2c0 45 11.8 88.9 34.3 127.6L0 480l100.7-34c36.1 19.8 76.5 30.2 118.6 30.2h.1c123.3 0 223.2-99.9 223.2-223.2 0-59-23.1-114.8-65.1-156.9zM224.2 438c-37.4 0-74.2-10-106.3-28.9l-7.6-4.5-59.8 20.2 19.9-61.5-4.9-7.8c-21.3-33.8-32.5-72.9-32.5-113.8 0-116.9 95.2-212.1 212.1-212.1 56.6 0 109.8 22 149.8 62s62.3 93.1 62.3 149.8c0 116.9-95.2 212.1-212 212.1zm121.1-163.5c-6.6-3.3-39.1-19.3-45.1-21.5s-10.5-3.3-15 3.3-17.2 21.5-21.1 26-7.8 5-14.4 1.7c-6.6-3.3-27.9-10.3-53.1-32.8-19.6-17.4-32.8-38.9-36.6-45.5s-.4-10.1 2.9-13.4c3-3 6.6-7.8 9.9-11.7s4.4-6.6 6.6-11.1 1.1-8.3-.6-11.6-15-36.1-20.6-49.3c-5.4-13-10.9-11.2-15-11.4s-8.3-.2-12.8-.2-11.7 1.7-17.8 8.3c-6.1 6.6-23.4 22.8-23.4 55.6s24 64.6 27.3 69.1 47.2 72.2 114.4 101.2c16 6.9 28.5 11 38.2 14.1 16 5.1 30.6 4.4 42.1 2.7 12.8-1.9 39.1-16 44.6-31.4 5.6-15.4 5.6-28.5 3.9-31.4s-6-4.5-12.6-7.8z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-gray-700">WhatsApp</span>
                            </a>

                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                               target="_blank"
                               rel="noopener noreferrer"
                               class="flex flex-col items-center gap-2 p-3 rounded-xl bg-blue-50 hover:bg-blue-100 transition-all transform hover:scale-110">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-600 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </div>
                                <span class="text-xs font-medium text-gray-700">Facebook</span>
                            </a>

                            <!-- X (Twitter) -->
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($panduan->judul) }}" 
                               target="_blank"
                               rel="noopener noreferrer"
                               class="flex flex-col items-center gap-2 p-3 rounded-xl bg-gray-100 hover:bg-gray-200 transition-all transform hover:scale-110">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-black text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24h-6.654l-5.207-6.807-5.97 6.807H2.2l7.73-8.835L1.7 2.25h6.822l4.713 6.231 5.41-6.231zM5.554 19.75h3.037L18.97 5.481h-3.039L5.554 19.75z"/></svg>
                                </div>
                                <span class="text-xs font-medium text-gray-700">X</span>
                            </a>

                            <!-- Email -->
                            <a href="mailto:?subject={{ urlencode($panduan->judul) }}&body={{ urlencode(url()->current()) }}" 
                               class="flex flex-col items-center gap-2 p-3 rounded-xl bg-orange-50 hover:bg-orange-100 transition-all transform hover:scale-110">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-orange-500 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                </div>
                                <span class="text-xs font-medium text-gray-700">Email</span>
                            </a>
                        </div>

                        <!-- Copy Link -->
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Salin Tautan</label>
                            <div class="flex items-center gap-2 bg-gray-100 rounded-lg px-3 py-2 hover:bg-gray-150 transition">
                                <input 
                                    type="text" 
                                    readonly 
                                    value="{{ url()->current() }}" 
                                    class="flex-1 bg-transparent text-gray-600 text-sm focus:outline-none truncate font-mono">
                                <button 
                                    type="button"
                                    @click="navigator.clipboard.writeText('{{ url()->current() }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                    :class="copied ? 'text-green-600' : 'text-blue-600 hover:text-blue-800'"
                                    class="text-sm font-semibold transition-colors whitespace-nowrap">
                                    <span x-show="!copied">Salin</span>
                                    <span x-show="copied" class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        Tersalin
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <!-- Komentar -->
        <div id="comment-section" class="max-w-2xl mx-auto mt-6 overflow-hidden transition-all duration-300" style="max-height:none; opacity:1;">
            <div class="backdrop-blur-md bg-blue-100/40 border border-blue-200 rounded-2xl shadow-md p-6 mt-6">
                <h2 class="text-2xl font-bold text-blue-900 mb-4 text-center">Tinggalkan Komentar</h2>

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-center font-medium shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <form id="comment-form" action="{{ route('panduan.comment', $panduan->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-blue-900 mb-1">Nama</label>
                        <input type="text" name="nama" id="nama"
                            class="w-full border border-blue-200 rounded-lg bg-white px-4 py-2 text-blue-900 focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                            placeholder="Masukkan nama kamu" required>
                    </div>

                    <div>
                        <label for="komentar" class="block text-sm font-semibold text-blue-900 mb-1">Komentar</label>
                        <textarea name="komentar" id="komentar" rows="3"
                            class="w-full border border-blue-200 rounded-lg bg-white px-4 py-2 text-blue-900 focus:ring-2 focus:ring-blue-500 focus:outline-none transition resize-none"
                            placeholder="Tulis komentarmu di sini..." required></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit"
                            class="bg-blue-800 hover:bg-blue-900 text-white font-semibold px-6 py-2 rounded-lg shadow transition duration-200">
                            Kirim Komentar
                        </button>
                    </div>
                </form>
            </div>

            <!-- List komentar -->
            <div class="mt-6">
                @if($panduan->komentar->count() > 0)
                    <h3 class="text-lg font-semibold text-blue-900 mb-3">Komentar ({{ $panduan->komentar->count() }})</h3>
                    <div class="space-y-4">
                        @foreach($panduan->komentar as $komentar)
                            <div class="bg-white border border-blue-100 rounded-xl p-4 shadow-sm hover:shadow-md transition">
                                <div class="flex items-center justify-between">
                                    <p class="font-semibold text-blue-900">{{ $komentar->nama }}</p>
                                    <p class="text-xs text-blue-800/60">{{ $komentar->created_at->diffForHumans() }}</p>
                                </div>
                                <p class="text-blue-900/90 text-sm mt-2 leading-relaxed">{{ $komentar->isi }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-blue-800 italic">Belum ada komentar.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function toggleCommentForm() {
    const el = document.getElementById('comment-section');
    if (!el) return;

    if (el.style.maxHeight && el.style.maxHeight !== '0px') {
        el.style.maxHeight = '0';
        el.style.opacity = 0;
    } else {
        el.style.opacity = 1;
        el.style.maxHeight = el.scrollHeight + 40 + "px";
        setTimeout(() => {
            const name = document.getElementById('nama');
            if (name) name.focus();
        }, 300);
    }
}
</script>
@endpush

@extends('layouts.app')

@section('content')
<!-- Wrapper dengan background full -->
<div class="min-h-screen w-full from-white-50 via-white to-blue-100 py-32 px-4">

    <!-- Container isi -->
    <div class="max-w-7xl mx-auto">
        <!-- Judul -->
        <h1 class="text-5xl font-bold text-center mb-14 pb-4 border-b-1 border-blue-100 text-blue-900 tracking-tight drop-shadow-md">
            {{ $judul }} 
        </h1>

        <div class="grid grid-cols-12 gap-10">
            <!-- Sidebar -->
           <aside class="col-span-12 md:col-span-3">
        <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-blue-200 p-6 hover:shadow-2xl transition-none">

            <!-- Search Bar -->

            <h2 class="font-semibold text-lg mb-6 text-blue-700 tracking-wide uppercase">Kategori</h2>

            <form method="GET" action="">
                <label class="flex items-center mb-4 cursor-pointer text-gray-800 font-medium hover:text-blue-700 transition-none">
                    <input
                        type="checkbox"
                        name="all"
                        value="1"
                        @checked(request()->has('all'))
                        class="form-checkbox h-5 w-5 text-blue-600 rounded-lg focus:ring-blue-400"
                    >
                    <span class="ml-3">
                        Semua ({{ $totalCount ?? $data->total() }})
                    </span>
                </label>

                @foreach($categories as $category)
                    <div class="pl-4 mb-4 border border-blue-100 rounded-xl p-4 bg-white transition-none">
                        <label class="flex items-center space-x-3 cursor-pointer text-gray-700 font-medium hover:text-blue-700">
                            <input
                                type="checkbox"
                                name="category[]"
                                value="{{ $category->id }}"
                                @checked(is_array(request('category')) && in_array($category->id, request('category')))
                                class="form-checkbox h-4.5 w-4.5 text-blue-600 rounded-md focus:ring-blue-500"
                            >
                            <span>{{ $category->category_name }} ({{ $category->panduans_count }})</span>
                        </label>

                        @if(isset($category->subcategories) && count($category->subcategories))
                            <div class="pl-6 mt-3 space-y-2">
                                @foreach($category->subcategories as $subcat)
                                <label class="flex items-center space-x-2 cursor-pointer text-gray-600 text-sm hover:text-blue-600">
                                    <input
                                        type="checkbox"
                                        name="category[]"
                                        value="{{ $subcat->id }}"
                                        @checked(is_array(request('category')) && in_array($subcat->id, request('category')))
                                        class="form-checkbox h-3.5 w-3.5 text-blue-500 focus:ring-blue-400"
                                    >
                                    <span>{{ $subcat->category_name }} ({{ $subcat->count ?? 0 }})</span>
                                </label>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach

                <button
                    type="submit"
                    class="w-full mt-5 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-semibold py-2.5 rounded-xl shadow-md hover:shadow-lg transition-transform transform hover:-translate-y-0.5"
                >
                    Terapkan Filter
                </button>
            </form>
        </div>
    </aside>


            <!-- Konten utama -->
            <main class="col-span-12 md:col-span-9 space-y-8">
                
                {{-- Form sekarang MENCEGAH reload saat enter, dan HANYA digunakan untuk menyimpan filter kategori --}}
                <form class="flex mb-6 space-x-3">
                    {{-- Input hidden untuk mempertahankan filter kategori/all saat submit form --}}
                    @if(request('category'))
                        @foreach(request('category') as $catId)
                            <input type="hidden" name="category[]" value="{{ $catId }}">
                        @endforeach
                    @endif
                    @if(request('all'))
                        <input type="hidden" name="all" value="1" />
                    @endif

                    <div class="relative flex-1">
                        <input 
                            type="text" 
                            id="search-input" name="search"
                            value="{{ request('search') }}" 
                            placeholder="Cari artikel inspiratif…" 
                            class="w-full px-4 py-2 border border-blue-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        >
                        
                        {{-- BLOK DROPDOWN ALPINE.JS TELAH DIHAPUS TOTAL --}}
                    </div>

                    {{-- Tombol "Reset" (menggunakan onclick JavaScript murni) --}}
                    <button
                        type="submit"
                        {{-- Hapus atribut onclick untuk reset --}}
                        class="bg-blue-500 text-white font-semibold rounded-xl px-4 py-3 shadow-md hover:shadow-lg transition-transform transform hover:-translate-y-0.5"
                        {{-- Mengubah styling agar terlihat seperti tombol utama/aksi --}}
                    >
                        Cari
                    </button>
                </form>

                {{-- Hitungan artikel yang ditemukan, diperbarui secara real-time oleh Alpine --}}
                <h2 class="text-xl font-bold text-gray-900 mb-4" x-text="`${filteredArticles.length} Artikel ditemukan`"></h2>

                <div class="space-y-6">
                    @forelse($data as $item)
                    <article
                        {{-- ATRIBUT BARU: Filter artikel berdasarkan input search secara real-time --}}
                        x-show="isArticleVisible(@json(Str::lower($item->judul)))"
                        class="border border-blue-100 rounded-2xl p-6 bg-white/80 backdrop-blur-lg hover:shadow-2xl hover:-translate-y-1 transition duration-300"
                    >
                        <div class="flex items-center space-x-4 text-sm text-gray-500 mb-3">
                            <span class="font-semibold text-gray-800">{{ $item->penulis ?? 'Admin' }}</span>
                            <span>&middot;</span>
                            <time datetime="{{ $item->created_at->toDateString() }}">{{ $item->created_at->diffForHumans() }}</time>
                        </div>

                        <a href="{{ route('panduan.detail', [$item->divisi->name ?? 'kategori', $item->slug]) }}"
                            class="text-2xl font-semibold text-gray-900 hover:text-blue-600 hover:underline transition leading-snug"
                        >{{ $item->judul }}</a>

                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach($item->tags ?? [] as $tag)
                                <span class="text-blue-600 border border-blue-400 bg-blue-50 rounded-full px-3 py-1 text-xs font-semibold">#{{ $tag }}</span>
                            @endforeach
                        </div>

                        <div class="flex items-center flex-wrap gap-5 text-gray-700 text-sm mt-5">
                            <div class="flex items-center space-x-1">
                                ❤️ <span>{{ $item->likes_count }} suka</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                💬 <span>{{ $item->komentar_count }} komentar</span>
                            </div>
                        </div>
                    </article>
                    @empty
                    {{-- Pesan ini hanya muncul jika $data KOSONG dari Controller (filter backend) --}}
                    <p class="text-center text-gray-600 italic bg-white/60 p-6 rounded-xl shadow-sm">Tidak ada artikel ditemukan</p>
                    @endforelse
                </div>

                {{-- Paginasi dihapus karena semua data dimuat untuk real-time search --}}
                {{-- @if(method_exists($data, 'total') && $data->total() > 10)
                    <div class="mt-10">{{ $data->appends(request()->query())->links() }}</div>
                @endif --}}
            </main>
        </div>
    </div>
</div>

@push('scripts')
{{-- 1. Library Dependencies --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script>
$(function() {
    // Ambil data suggestions yang di-pass dari Controller ke Blade
    const suggestionsData = @json($suggestions);
    
    // Konversi data menjadi format untuk Autocomplete
    const sourceData = suggestionsData.map(item => ({
        label: item.judul, 
        value: item.judul, 
        slug: item.slug, 
        divisi: item.divisi,
        // ⭐ Pastikan properti ini dikirim dari Controller
        content_raw: item.content_raw || '', 
        // ⭐ TAMBAHKAN properti SNIPPET (konten yang dipotong)
        snippet: item.snippet || '' 
    }));

    // Inisialisasi Autocomplete
    $("#search-input").autocomplete({
        minLength: 2,
        source: function(request, response) {
            const term = request.term.toLowerCase();
            
            // LOGIKA FILTER: Mencari di Judul ATAU Isi Artikel
            const filtered = sourceData.filter(item => {
                const titleMatch = item.label.toLowerCase().includes(term);
                const contentMatch = item.content_raw.includes(term); 
                
                return titleMatch || contentMatch; 
            });

            // Batasi 8 hasil teratas
            response(filtered.slice(0, 8));
        },
        
        // Event saat item dipilih (tetap sama)
        select: function(event, ui) {
            event.preventDefault();
            const selectedItem = ui.item;
            
            $("#search-input").val(selectedItem.label); 
            
            const categorySlug = selectedItem.divisi || 'kategori';
            window.location.href = `/panduan/${categorySlug}/${selectedItem.slug}`; 
        }
    });
    
    // ⭐ KUSTOMISASI TOTAL RENDER ITEM ⭐
    // Fungsi ini menggantikan default rendering untuk menampilkan judul dan snippet
    $.ui.autocomplete.prototype._renderItem = function(ul, item) {
        const term = this.term.toLowerCase();
        // Buat Regex untuk highlighting, diterapkan pada Judul dan Snippet
        const qRegex = new RegExp("(" + $.ui.autocomplete.escapeRegex(term) + ")", "gi");
        
        // 1. Highlight Judul
        const highlightedTitle = item.label.replace(qRegex, "<strong class='text-blue-500'>$1</strong>");
        
        // 2. Highlight Snippet
        let highlightedSnippet = item.snippet;
        if (highlightedSnippet) {
            // Kita juga highlight teks di snippet
            highlightedSnippet = highlightedSnippet.replace(qRegex, "<strong class='text-blue-500'>$1</strong>");
        }

        // 3. Gabungkan Judul dan Snippet ke dalam HTML
        let outputHtml = "<div class='font-semibold text-gray-900'>" + highlightedTitle + "</div>";
        
        if (highlightedSnippet) {
            // Gunakan class kecil (text-xs) untuk snippet
            outputHtml += "<div class='text-xs text-gray-600 mt-1'>" + highlightedSnippet + "</div>";
        }
        
        // Gunakan jQuery untuk membuat <li> baru dan memasukkan HTML kustom
        return $("<li>")
            .append("<div>" + outputHtml + "</div>")
            .appendTo(ul);
    };
});
</script>
@endpush
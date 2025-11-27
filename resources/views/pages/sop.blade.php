@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full from-white-50 via-white to-blue-100 py-32 px-4">

    <div class="max-w-7xl mx-auto">
        <!-- Judul -->
        <h1 class="text-5xl font-bold text-center mb-14 pb-4 border-b-1 border-blue-100 text-blue-900 tracking-tight drop-shadow-md">
            {{ $judul }}
        </h1>

        <div class="grid grid-cols-12 gap-10" x-data="{ search: '' }">
            <!-- Sidebar -->
            <aside class="col-span-12 md:col-span-3">
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-blue-200 p-6 shadow-xl hover:shadow-2xl transition-none">
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
                            <span class="ml-3">Semua</span>
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
                                    <span>{{ $category->category_name }}</span>
                                </label>
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

                <!-- Search bar responsif -->
                <div class="flex mb-6 space-x-3">
                    <div class="relative w-full">
                        <input 
                            type="text" 
                            x-model="search" 
                            placeholder="Cari dokumen SOP…" 
                            class="w-full px-4 py-2 pl-10 border border-blue-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none bg-white/80 backdrop-blur-md"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                @php
                    $perPage = 15;
                    if ($data instanceof \Illuminate\Contracts\Pagination\Paginator || $data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
                        $sopData = $data;
                    } else {
                        $collection = collect($data ?? []);
                        if ($collection->count() > $perPage) {
                            $page = request()->get('page', 1);
                            $sopData = new \Illuminate\Pagination\LengthAwarePaginator(
                                $collection->forPage($page, $perPage)->values(),
                                $collection->count(),
                                $perPage,
                                $page,
                                ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(), 'query' => request()->query()]
                            );
                        } else {
                            $sopData = $collection->values();
                        }
                    }
                @endphp

                @if(!empty($sopData) && count($sopData) > 0)
                    <div class="bg-white/80 backdrop-blur-lg border border-blue-100 rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition">
                        <table class="w-full table-auto text-left">
                            <thead class="bg-blue-500 border-b border-blue-100">
                                <tr>
                                    <th class="px-6 py-3 text-sm font-bold text-white uppercase tracking-wider w-20">No</th>
                                    <th class="px-6 py-3 text-sm font-bold text-white uppercase tracking-wider">Nama SOP</th>
                                    <th class="px-6 py-3 text-sm font-bold text-white uppercase tracking-wider text-center w-48">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-blue-50">
                                @foreach($sopData as $index => $item)
                                    @php
                                        $fileUrl = asset('storage/' . ($item->sop_file ?? ''));
                                    @endphp
                                    <tr x-show="('{{ strtolower($item->sop_name ?? '') }}').includes(search.toLowerCase())" class="hover:bg-blue-50/70 transition">
                                        <td class="px-6 py-4 text-gray-700 font-medium">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-gray-800 font-semibold">{{ $item->sop_name ?? '-' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            @if (!empty($item->sop_file) && file_exists(public_path('storage/' . $item->sop_file)))
                                                <div class="flex justify-center items-center gap-4">
                                                    <a href="{{ $fileUrl }}" target="_blank" rel="noopener noreferrer"
                                                       class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                        Lihat
                                                    </a>
                                                    <a href="{{ $fileUrl }}" download
                                                       class="inline-flex items-center gap-1 text-green-600 hover:text-green-800 font-semibold transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" />
                                                        </svg>
                                                        Download
                                                    </a>
                                                </div>
                                            @else
                                                <span class="text-gray-400 italic">Tidak ada file</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($sopData instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="mt-10">
                            {{ $sopData->appends(request()->query())->links() }}
                        </div>
                    @endif
                @else
                    <p class="text-center text-gray-600 italic bg-white/60 p-6 rounded-xl shadow-sm mt-10">
                        Belum ada dokumen SOP untuk bagian ini.
                    </p>
                @endif
            </main>
        </div>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection

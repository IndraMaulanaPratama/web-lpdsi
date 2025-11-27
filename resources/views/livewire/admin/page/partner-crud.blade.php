<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Kelola Mitra</h2>

    {{-- Tombol Tambah --}}
    <button 
        wire:click="$set('showModal', true)"
        class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition">
        + Tambah Mitra
    </button>

    {{-- Pesan Sukses --}}
    @if (session('success'))
        <div class="mt-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Modal Popup --}}
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white w-[90%] md:w-[650px] rounded-2xl shadow-xl p-8 relative">

                {{-- Tombol Close --}}
                <button 
                    wire:click="$set('showModal', false)"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">
                    &times;
                </button>

                <h3 class="text-2xl font-bold mb-6 text-gray-800 text-center">Tambah Mitra Baru</h3>

                {{-- Form --}}
                <form wire:submit.prevent="save" class="space-y-6">
                    {{-- Upload Logo --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Upload Logo</label>
                        <input type="file" wire:model="logo"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200">
                        @error('logo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        {{-- Preview --}}
                        <div class="min-h-[100px]">
                            @if ($logo)
                                <div class="mt-4 text-center">
                                    <p class="text-gray-500 mb-2 text-sm">Preview Logo:</p>
                                    <img src="{{ $logo->temporaryUrl() }}" class="h-24 mx-auto rounded-md shadow">
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Pilih Type --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Jenis Mitra</label>
                        <select wire:model="type"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200">
                            <option value="">-- Pilih Tipe Mitra --</option>
                            <option value="domestic">Mitra Dalam Negeri</option>
                            <option value="foreign">Mitra Luar Negeri</option>
                        </select>
                        @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Simpan Mitra
                    </button>
                </form>
            </div>
        </div>
    @endif

    {{-- Daftar Mitra (Tata Letak Baru Atas Bawah) --}}
    <div class="mt-10 space-y-8">
        
        {{-- Mitra Dalam Negeri --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white border-b pb-2">Mitra Dalam Negeri</h3>
            
            {{-- Container Grid dengan Scrollbar Vertikal --}}
            <div class="max-h-[350px] overflow-y-auto pt-2 pr-2">
                <div class="flex flex-wrap gap-4 justify-start">
                    @forelse($mitraDalam as $partner)
                        {{-- Mitra Card (Responsive Grid Item) --}}
                        <div class="flex-none w-50 h-40 text-center bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md p-3 relative group">
                            <img src="{{ asset('storage/' . $partner->logo) }}" 
                                 class="w-full h-full object-contain rounded p-1" 
                                 onerror="this.onerror=null; this.src='https://placehold.co/176x112/292524/EAEAEA?text=LOGO';"
                                 alt="Logo Mitra">

                            {{-- Tombol Hapus overlay (Muncul saat hover) --}}
                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-40 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity">
                                <button wire:click="delete({{ $partner->id }})"
                                        wire:confirm="Yakin ingin menghapus logo ini?"
                                        class="bg-red-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow hover:bg-red-700 transition">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    @empty
                        <span class="text-gray-400">Belum ada mitra dalam negeri.</span>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Mitra Luar Negeri --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white border-b pb-2">Mitra Luar Negeri</h3>
            
            {{-- Container Grid dengan Scrollbar Vertikal --}}
            <div class="max-h-[350px] overflow-y-auto pt-2 pr-2">
                 <div class="flex flex-wrap gap-4 justify-start">
                    @forelse($mitraLuar as $partner)
                        {{-- Mitra Card (Responsive Grid Item) --}}
                        <div class="flex-none w-44 h-32 text-center bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md p-3 relative group">
                            <img src="{{ asset('storage/' . $partner->logo) }}" 
                                 class="w-full h-full object-contain rounded p-1" 
                                 onerror="this.onerror=null; this.src='https://placehold.co/176x112/292524/EAEAEA?text=LOGO';"
                                 alt="Logo Mitra">
                                 
                            {{-- Tombol Hapus overlay (Muncul saat hover) --}}
                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-40 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity">
                                <button wire:click="delete({{ $partner->id }})"
                                        wire:confirm="Yakin ingin menghapus logo ini?"
                                        class="bg-red-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow hover:bg-red-700 transition">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    @empty
                        <span class="text-gray-400">Belum ada mitra luar negeri.</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
<div class="p-6 space-y-4" 
    x-data="{ openModal: @entangle('showForm') }" 
    x-on:error.window="alert($event.detail.message)"
    x-on:close-modal.window="openModal = false">

    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Manajemen SOP</h3>

    {{-- ALERT AREA --}}
    @if (session()->has('success'))
        <div class="rounded-lg bg-green-100 border border-green-300 text-green-700 p-3">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="rounded-lg bg-red-100 border border-red-300 text-red-700 p-3">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="rounded-lg bg-red-100 border border-red-300 text-red-700 p-3">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- HEADER + SEARCH BAR --}}
    <div class="flex flex-wrap justify-between items-center gap-3">
        <div class="w-full sm:w-1/3">
            <input type="text" wire:model.live="search" placeholder="Cari SOP..."
                   class="w-full border rounded-lg px-3 py-2 shadow-sm focus:ring focus:ring-blue-300 dark:bg-gray-900 dark:border-gray-700">
        </div>
        <div>
            <x-admin.button.primary wire:click="toggleForm" icon="fa-plus" iconPrefix="fa" size="sm">
                Tambah SOP
            </x-admin.button.primary>
        </div>
    </div>

    {{-- DATA TABLE --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mt-4">
        <div class="px-6 py-4 border-b dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Data SOP</h3>
        </div>

        <div class="px-6 py-4 overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-6 py-3">Nama SOP</th>
                        <th class="px-6 py-3">Divisi</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">File</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $item->sop_name }}</td>
                            <td class="px-6 py-4">{{ optional($item->divisi)->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ optional($item->categorySop)->category_name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-sm font-semibold {{ $item->sop_status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $item->sop_status ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-blue-600">
                                @if ($item->sop_file)
                                    <a href="{{ asset('storage/' . $item->sop_file) }}" target="_blank" class="hover:underline">Lihat</a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <x-admin.button.warning wire:click="edit({{ $item->id }})" @click="openModal = true" size="sm" icon="fa-edit" iconPrefix="fa" />
                                    <x-admin.button.danger wire:click="delete({{ $item->id }})" size="sm" icon="fa-trash" iconPrefix="fa" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data SOP</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL FORM --}}
    <div x-show="openModal" x-transition x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        @keydown.escape.window="openModal = false; $wire.showForm = false"
        wire:ignore.self>

        <div class="bg-white dark:bg-gray-800 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-xl shadow-lg p-6 relative">

            <button @click="openModal = false; $wire.showForm = false" type="button"
                class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-xl" aria-label="Close modal">
                ✕
            </button>

            <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">
                {{ $isEdit ? 'Edit SOP' : 'Tambah SOP' }}
            </h3>

            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" enctype="multipart/form-data" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block font-medium mb-1">Nama SOP</label>
                        <input type="text" wire:model="sop_name" class="w-full border rounded p-2 dark:bg-gray-900 dark:border-gray-700">
                        @error('sop_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Divisi</label>
                        <select wire:model="divisi_id" class="w-full border rounded p-2 dark:bg-gray-900 dark:border-gray-700">
                            <option value="">Pilih Divisi</option>
                            @foreach($divisis as $divisi)
                                <option value="{{ $divisi->id }}">{{ $divisi->name }}</option>
                            @endforeach
                        </select>
                        @error('divisi_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Kategori</label>
                        <select wire:model="category_sop_id" class="w-full border rounded p-2 dark:bg-gray-900 dark:border-gray-700">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category_sop_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Status</label>
                        <select wire:model="sop_status" class="w-full border rounded p-2 dark:bg-gray-900 dark:border-gray-700">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label class="block font-medium mb-1">Upload File (PDF/DOC)</label>
                        <input type="file" wire:model="sop_file" class="w-full border rounded p-2 dark:bg-gray-900 dark:border-gray-700">
                        <p class="text-xs text-gray-500 mt-1">Hanya file PDF, maksimal 5 MB.</p>
                    </div>

                </div>

                <x-admin.button.success type="submit" class="mt-2">
                    {{ $isEdit ? 'Update' : 'Simpan' }}
                </x-admin.button.success>
            </form>
        </div>
    </div>
</div>

<div class="p-6" x-data="{ openModal: @entangle('showForm') }">

    {{-- Notifikasi --}}
    @if (session()->has('alert'))
        <div class="mb-4 p-4 rounded-lg 
            {{ session('alert.type') === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            <strong>{{ session('alert.title') }}</strong> — {{ session('alert.message') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">

        <div class="flex justify-between items-center px-6 py-4 border-b dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                Manajemen Laboratorium Komputer
            </h3>

            {{-- FIX tombol tambah --}}
            <x-admin.button.primary 
                @click="openModal = true; $wire.resetForm(); $wire.showForm = true"
                size="sm" icon="plus">
                Tambah Data
            </x-admin.button.primary>
        </div>

        <div class="p-6">
            <div class="relative overflow-x-auto max-h-[500px] overflow-y-auto rounded-md border border-gray-100">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="px-6 py-3 w-1/4">Judul</th>
                            <th class="px-6 py-3 w-1/3">Deskripsi</th>
                            <th class="px-6 py-3 w-1/3">Tugas</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($labs as $lab)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50">
                                <td class="px-6 py-4 dark:text-white font-medium">
                                    {{ $lab->judul }}
                                </td>

                                <td class="px-6 py-4">{{ \Illuminate\Support\Str::limit($lab->deskripsi, 80) }}</td>
                                <td class="px-6 py-4">{{ \Illuminate\Support\Str::limit($lab->tugas, 80) }}</td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">

                                        {{-- Edit --}}
                                        <x-admin.button.warning
                                            wire:click="edit({{ $lab->id }})"
                                            @click="openModal = true"
                                            icon="fa-edit"
                                            iconPrefix="fa"
                                            size="sm" />

                                        {{-- Delete --}}
                                        <x-admin.button.danger
                                            wire:click="delete({{ $lab->id }})"
                                            icon="fa-trash"
                                            iconPrefix="fa"
                                            size="sm" />

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-4">
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $labs->links() }}
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div x-show="openModal" x-transition.opacity x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center 
               bg-black bg-opacity-50 backdrop-blur-sm">

        <div class="bg-white dark:bg-gray-800 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-lg shadow p-6 relative">

            <button @click="openModal = false; $wire.showForm = false"
                class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-xl">
                ✕
            </button>

            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">
                {{ $labId ? 'Edit Data Laboratorium' : 'Tambah Data Laboratorium' }}
            </h3>

            {{-- FORM FIX --}}
            <form wire:submit.prevent="store" class="space-y-4">

                {{-- Judul --}}
                <div>
                    <label class="block text-sm font-medium">Judul</label>
                    <input type="text"
                        wire:model.defer="judul"
                        class="w-full border rounded p-2 dark:bg-gray-900 @error('judul') border-red-500 @enderror">
                    @error('judul') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-medium">Deskripsi</label>
                    <textarea wire:model.defer="deskripsi" rows="6"
                        class="w-full border rounded p-2 dark:bg-gray-900 @error('deskripsi') border-red-500 @enderror"></textarea>
                    @error('deskripsi') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Tugas --}}
                <div>
                    <label class="block text-sm font-medium">Tugas</label>
                    <textarea wire:model.defer="tugas" rows="6"
                        class="w-full border rounded p-2 dark:bg-gray-900 @error('tugas') border-red-500 @enderror"></textarea>
                    @error('tugas') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                        @click="openModal = false">
                        Batal
                    </button>

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

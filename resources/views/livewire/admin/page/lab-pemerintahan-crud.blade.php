<div class="p-6" x-data="{ openModal: @entangle('showForm') }">

    {{-- 🔔 Alert notifikasi --}}
    @if (session()->has('alert'))
        @php
            $alert = session('alert');
        @endphp
        <div class="mb-4 p-4 rounded-lg 
            {{ $alert['type'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            <strong>{{ $alert['title'] }}</strong> — {{ $alert['message'] }}
        </div>
    @endif

    {{-- 🧩 Manajemen Section --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        {{-- Header --}}
        <div class="flex justify-between items-center px-6 py-4 border-b dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                Manajemen Laboratorium Pemerintahan
            </h3>
            <x-admin.button.primary @click="openModal = true" icon="plus" size="sm">
                Tambah Data
            </x-admin.button.primary>
        </div>

        {{-- Tabel --}}
        <div class="p-6">
            <div class="relative overflow-x-auto max-h-[500px] overflow-y-auto rounded-md border border-gray-100">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="px-6 py-3 w-1/4">Judul</th>
                            <th class="px-6 py-3 w-1/3">Deskripsi</th>
                            <th class="px-6 py-3 w-1/2">Tugas</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($labs as $lab)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $lab->judul }}</td>
                                <td class="px-6 py-4">{!! Str::limit($lab->deskripsi, 80) !!}</td>
                                <td class="px-6 py-4">{!! Str::limit($lab->tugas, 80) !!}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <x-admin.button.warning wire:click="edit({{ $lab->id }})"
                                            @click="openModal = true" icon="fa-edit" iconPrefix="fa" size="sm" />
                                        <x-admin.button.danger wire:click="delete({{ $lab->id }})"
                                            icon="trash" size="sm" />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $labs->links() }}
            </div>
        </div>
    </div>

    {{-- 🧩 Modal Popup Form --}}
    <div x-show="openModal" x-transition x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">

        <div
            class="bg-white dark:bg-gray-800 w-full max-w-6xl max-h-[95vh] overflow-y-auto rounded-lg shadow p-6 relative">
            {{-- Tombol close --}}
            <button @click="openModal = false; $wire.showForm = false" type="button"
                class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-xl">
                ✕
            </button>

            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">
                {{ $labId ? 'Edit Data Laboratorium' : 'Tambah Data Laboratorium' }}
            </h3>

            {{-- Form Tambah/Edit --}}
            <form wire:submit.prevent="store" class="space-y-4">
                <div class="grid grid-cols-1 gap-4">
                    <x-admin.form.inputText wire:model="judul" label="Judul" placeholder="Nama Laboratorium" />
                    <x-admin.form.textarea wire:model="deskripsi" label="Deskripsi" placeholder="Tuliskan deskripsi"
                        rows="8" />
                    <x-admin.form.textarea wire:model="tugas" label="Tugas" placeholder="Tuliskan tugas utama"
                        rows="8" />
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end space-x-2 pt-2">
                    <x-admin.button.secondary type="button"
                        @click="openModal = false; $wire.showForm = false">
                        Batal
                    </x-admin.button.secondary>
                    <x-admin.button.success type="submit" icon="save">
                        Simpan
                    </x-admin.button.success>
                </div>
            </form>
        </div>
    </div>
</div>

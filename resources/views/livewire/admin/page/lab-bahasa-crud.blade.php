<div class="p-6"
    x-data="{ openModal: @entangle('showForm') }"
    {{-- ✅ MENAMBAH LISTENER UNTUK MENUTUP FORM DAN REFRESH TABLE --}}
    x-on:closeModal.window="openModal = false"
    x-on:refreshTable.window="$wire.$refresh()">


    {{-- 🔔 Alert Notifikasi Aman --}}
    @if (session()->has('alert'))
        <div class="mb-4 p-4 rounded-lg 
            {{ session('alert.type') === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            <strong>{{ session('alert.title') }}</strong> — {{ session('alert.message') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        {{-- Header --}}
        <div class="flex justify-between items-center px-6 py-4 border-b dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                Manajemen Laboratorium Bahasa
            </h3>
            <x-admin.button.primary 
                @click="openModal = true" 
                {{-- ✅ openModal = true akan membuat $showForm menjadi true via entangle --}}
                size="sm" icon="plus">
                Tambah Data
            </x-admin.button.primary>
        </div>

        {{-- Table --}}
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
                                    {{ e($lab->judul) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Illuminate\Support\Str::limit(e($lab->deskripsi), 80) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Illuminate\Support\Str::limit(e($lab->tugas), 80) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">

                                        {{-- Tombol Edit --}}
                                        <x-admin.button.warning
                                            wire:click="edit({{ $lab->id }})"
                                            @click="openModal = true"
                                            icon="fa-edit"
                                            iconPrefix="fa"
                                            size="sm"
                                            title="Edit" />

                                        {{-- Tombol Hapus --}}
                                        <x-admin.button.danger
                                            wire:click="delete({{ $lab->id }})"
                                            icon="fa-trash"
                                            iconPrefix="fa"
                                            size="sm"
                                            title="Hapus" />
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

            {{-- Close --}}
            <button @click="openModal = false" 
                class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-xl">
                ✕
            </button>

            {{-- Form --}}
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">
                {{ $labId ? 'Edit Data Lab Bahasa' : 'Tambah Data Lab Bahasa' }}
            </h3>

            <form wire:submit.prevent="store" class="space-y-4">

                <x-admin.form.inputText 
                    wire:model.defer="judul"
                    label="Judul"
                    placeholder="Nama Lab Bahasa"
                />

                <x-admin.form.textarea 
                    wire:model.defer="deskripsi"
                    label="Deskripsi"
                    placeholder="Tuliskan deskripsi"
                    rows="8"
                />

                <x-admin.form.textarea 
                    wire:model.defer="tugas"
                    label="Tugas"
                    placeholder="Tuliskan tugas"
                    rows="8"
                />

                <div class="flex justify-end space-x-2">
                    <x-admin.button.secondary 
                        type="button" 
                        @click="openModal = false">
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
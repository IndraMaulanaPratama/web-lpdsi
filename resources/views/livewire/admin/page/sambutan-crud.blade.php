<div x-data="{ openModal: @entangle('isModalOpen') }">

    {{-- Notifikasi --}}
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
            {{ session('message') }}
        </div>
    @endif

    {{-- Tombol Tambah --}}
    <div class="flex justify-end mb-4">
        <button @click="openModal = true"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2">
            <i class="fa fa-plus"></i> Tambah Sambutan
        </button>
    </div>

    {{-- Tabel --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">Judul</th>
                    <th class="px-6 py-3">Foto</th>
                    <th class="px-6 py-3">Konten</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sambutans as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $item->judul }}</td>
                        <td class="px-6 py-4">
                            @if ($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" class="w-16 h-16 object-cover rounded-lg border">
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 truncate max-w-[250px]">
                            {!! Str::limit(strip_tags($item->konten), 100) !!}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-2">
                                <x-admin.button.primary wire:click="edit({{ $item->id }})" @click="openModal = true"
                                    icon="fa-edit" iconPrefix="fa" size="sm" />
                                <x-admin.button.danger wire:click="delete({{ $item->id }})"
                                    icon="fa-trash" iconPrefix="fa" size="sm" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data sambutan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Form --}}
    <div x-show="openModal" x-cloak x-transition wire:ignore.self
        class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">

        <div class="bg-white dark:bg-gray-800 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-lg shadow p-6 relative">

            {{-- Close --}}
            <button @click="openModal = false; $wire.closeModal()"
                class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-xl font-bold">
                &times;
            </button>

            <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">
                {{ $sambutanId ? 'Edit Sambutan' : 'Tambah Sambutan' }}
            </h2>

            <form wire:submit.prevent="store" enctype="multipart/form-data">

                {{-- Judul --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Sambutan</label>
                    <input type="text" wire:model.defer="judul" placeholder="Masukkan judul sambutan"
                        class="w-full border rounded p-2 focus:ring focus:ring-blue-200">
                    @error('judul') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Foto --}}
                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto</label>
                    <input type="file" wire:model="foto"
                        class="w-full border rounded p-2 bg-white dark:bg-gray-900">

                    @if ($sambutanModel && $sambutanModel->foto)
                        <img src="{{ asset('storage/' . $sambutanModel->foto) }}"
                            class="w-16 h-16 mt-2 object-cover rounded-lg border">
                    @endif

                    @error('foto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Konten --}}
                <div class="mt-3" wire:ignore>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konten</label>
                    <textarea id="sambutan">{!! $sambutan !!}</textarea>
                </div>
                @error('sambutan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                {{-- Tombol --}}
                <div class="flex justify-end gap-2">
                    <x-admin.button.success type="submit" class="mt-4">
                        {{ $sambutanId ? 'Update' : 'Tambah' }}
                    </x-admin.button.success>
                </div>

            </form>

        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    let editorKonten = CKEDITOR.replace('sambutan');

    editorKonten.on('change', function() {
        @this.set('sambutan', editorKonten.getData());
    });

    // event untuk reset konten ketika modal ditutup
    Livewire.on('resetEditor', () => {
        editorKonten.setData('');
    });

    // event set konten saat edit
    Livewire.on('setEditorContent', content => {
        editorKonten.setData(content);
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.addEventListener('notify', e => {
        Swal.fire({
            icon: e.detail.type,
            title: e.detail.message,
            confirmButtonColor: '#3085d6',
        });
    });
</script>

@endpush


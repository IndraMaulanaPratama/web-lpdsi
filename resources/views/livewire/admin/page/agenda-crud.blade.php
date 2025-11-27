<div class="p-6" x-data="{ openModal: @entangle('showForm') }">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Manajemen Agenda</h3>

    @if (session()->has('success'))
        <div class="bg-green-200 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mt-6">
        <div class="px-6 py-4 border-b dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Data Agenda</h3>
            <x-admin.button.primary @click="openModal = true" icon="fa-plus" iconPrefix="fa" size="sm">
                Tambah Agenda
            </x-admin.button.primary>
        </div>

        <div class="px-6 py-4">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Judul</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Lokasi</th>
                        <th class="px-6 py-3">Gambar</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($agendas as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $item->judul }}
                            </td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4">{{ $item->lokasi }}</td>
                            <td class="px-6 py-4 text-center">
                                @if ($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}"
                                        class="h-16 mx-auto rounded shadow">
                                @else
                                    <span class="text-gray-500 text-sm">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 flex space-x-2">
                                <x-admin.button.warning wire:click="edit({{ $item->id }})" @click="openModal = true"
                                    size="sm" icon="fa-edit" iconPrefix="fa" />
                                <x-admin.button.danger wire:click="delete({{ $item->id }})" size="sm"
                                    icon="fa-trash" iconPrefix="fa" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data agenda</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $agendas->links() }}
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div x-show="openModal" x-transition x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div
            class="bg-white dark:bg-gray-800 w-full max-w-6xl max-h-[95vh] overflow-y-auto rounded-lg shadow p-6 relative">
            <button @click="openModal = false; $wire.showForm = false" type="button"
                class="absolute top-2 right-2 text-gray-400 hover:text-red-500 z-50">✕</button>
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">
                {{ $isEdit ? 'Edit Agenda' : 'Tambah Agenda' }}
            </h3>

            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" enctype="multipart/form-data">
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-admin.form.inputText wire:model="judul" label="Judul Agenda"
                                placeholder="Masukkan judul agenda" />
                                    @error('judul')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                        </div>
                        <div>
                            <x-admin.form.inputText type="date" wire:model="tanggal" label="Tanggal" />
                                    @error('tanggal')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                        </div>        
                    </div>

                    <div>
                        <x-admin.form.inputText wire:model="lokasi" label="Lokasi" placeholder="Masukkan lokasi kegiatan" />

                        @error('lokasi')
                            <span class="text-red-500 text-xs text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Upload Foto -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto</label>
                        <input type="file" wire:model="gambar"
                            class="w-full border rounded p-2 bg-white dark:bg-gray-900">
                        <p class="text-sm text-gray-600 mt-1">
                            Hanya file gambar (<b>jpg, jpeg, png, webp</b>), maks <b>2 MB</b>
                        </p>

                        @if ($gambar)
                            @if (
                                $gambar->getClientOriginalExtension() == 'jpg' ||
                                    $gambar->getClientOriginalExtension() == 'jpeg' ||
                                    $gambar->getClientOriginalExtension() == 'png' ||
                                    $gambar->getClientOriginalExtension() == 'webp')
                                <p class="text-sm text-gray-600 mt-2">Preview:</p>
                                @if (is_object($gambar))
                                    <img src="{{ $gambar->temporaryUrl() }}" class="h-32 mt-2 rounded shadow">
                                @elseif (is_string($gambar))
                                    <img src="{{ asset('storage/' . $gambar) }}" class="h-32 mt-2 rounded shadow">
                                @endif
                            @endif
                        @endif

                        @error('gambar')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div wire:ignore>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
                        <textarea id="deskripsi" wire:model="deskripsi" class="w-full border rounded p-2">{!! $deskripsi !!}</textarea>
                        @error('deskripsi')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <x-admin.button.success type="submit" class="mt-4">
                        {{ $isEdit ? 'Update' : 'Tambah' }}
                    </x-admin.button.success>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        const editorDeskripsi = CKEDITOR.replace('deskripsi');
        editorDeskripsi.on('change', function() {
            @this.set('deskripsi', editorDeskripsi.getData());
        });
    </script>
@endpush

{{-- resources/views/livewire/admin/page/gallery-crud.blade.php --}}
<x-admin.ui.section title="Data Galeri" icon="bi-images">
    <div class="p-6"
         x-data="galleryComponent()"
         x-init="init()">

        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Manajemen Galeri</h3>

        {{-- Tombol Aksi --}}
        <div class="mb-4 flex space-x-2">
            <x-admin.button.primary size="md" @click="openYear = true" icon="fa-calendar" iconPrefix="fa">
                Album Tahun
            </x-admin.button.primary>

            <x-admin.button.primary size="md" @click="openEvent = true" icon="fa-calendar-day" iconPrefix="fa">
                Album Kegiatan
            </x-admin.button.primary>

            <x-admin.button.primary size="md" @click="openPhoto = true" icon="fa-image" iconPrefix="fa">
                Tambah Foto
            </x-admin.button.primary>
        </div>

        {{-- Modal Tahun --}}
        <div x-show="openYear" x-transition x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="openYear = false"
                 class="bg-white dark:bg-gray-800 w-full max-w-lg rounded-lg shadow p-6 relative">
                <button @click="openYear = false"
                        class="absolute top-2 right-2 text-gray-400 hover:text-red-500 z-50">
                    ✕
                </button>

                <h3 class="text-lg font-semibold mb-4">Tambah/Edit Tahun</h3>

                <form wire:submit.prevent="saveYear">
                    <x-admin.form.inputText wire:model.defer="year" label="Tahun" placeholder="Masukkan Tahun" />
                    <x-admin.button.success type="submit" class="mt-4">
                        {{ $editYearId ? 'Simpan Hasil Edit' : 'Simpan' }}
                    </x-admin.button.success>
                </form>
            </div>
        </div>

        {{-- Modal Event --}}
        <div x-show="openEvent" x-transition x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="openEvent = false"
                 class="bg-white dark:bg-gray-800 w-full max-w-lg rounded-lg shadow p-6 relative">
                <button @click="openEvent = false"
                        class="absolute top-2 right-2 text-gray-400 hover:text-red-500">
                    ✕
                </button>

                <h3 class="text-lg font-semibold mb-4">Tambah/Edit Kegiatan</h3>

                <form wire:submit.prevent="saveEvent">
                    <x-admin.form.inputText wire:model.defer="eventName" label="Nama Event" placeholder="Masukkan Nama Event" />
                    <x-admin.form.select
                        wire:model.defer="eventYearId"
                        label="Pilih Tahun"
                        :options="$years->pluck('year', 'id')"
                        placeholder="-- Pilih Tahun --"
                    />
                    <x-admin.button.success type="submit" class="mt-4">
                        {{ $editEventId ? 'Simpan Hasil Edit' : 'Simpan' }}
                    </x-admin.button.success>
                </form>
            </div>
        </div>

        {{-- Modal Tambah/Edit Foto --}}
        <div x-show="openPhoto" x-transition x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="openPhoto = false"
                class="bg-white dark:bg-gray-800 w-full max-w-lg rounded-lg shadow p-6 relative">

                <button @click="openPhoto = false"
                        class="absolute top-2 right-2 text-gray-400 hover:text-red-500">
                    ✕
                </button>

                <h3 class="text-lg font-semibold mb-4">Tambah Media Galeri</h3>

                <form wire:submit.prevent="savePhoto" enctype="multipart/form-data">

                    {{-- Upload Foto (opsional) --}}
                    <label class="text-sm font-medium">Unggah Foto (Opsional)</label>
                    <input type="file" wire:model="photoImage" accept="image/*"
                        class="block mt-1 w-full text-sm border rounded">

                    @error('photoImage')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    @if ($photoImage)
                        <p class="text-sm text-gray-500 mt-2">Preview:</p>
                        <img src="{{ $photoImage->temporaryUrl() }}"
                            class="w-44 h-28 object-cover rounded border mt-1">
                    @endif

                    {{-- Link YouTube (opsional) --}}
                    <x-admin.form.inputText wire:model.defer="youtubeUrl"
                                            label="Link YouTube (opsional)"
                                            placeholder="https://youtube.com/watch?v=xxx"/>

                    @error('youtubeUrl')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror


                    <x-admin.form.select
                        wire:model.defer="photoEventId"
                        label="Pilih Event"
                        :options="$events->pluck('name', 'id')"
                        placeholder="-- Pilih Event --"
                    />

                    <x-admin.button.success type="submit" class="mt-4">
                        {{ $editPhotoId ? 'Simpan Perubahan' : 'Upload' }}
                    </x-admin.button.success>
                </form>
            </div>
        </div>

        {{-- Tabel Tahun & Event --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 mb-6">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-3 border-b"><h4 class="font-semibold">Daftar Tahun</h4></div>
                <div class="px-6 py-3 max-h-[260px] overflow-y-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-100 sticky top-0 z-10">
                        <tr>
                            <th class="border px-2 py-1">No</th>
                            <th class="border px-2 py-1">Tahun</th>
                            <th class="border px-2 py-1">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($years as $i => $y)
                            <tr>
                                <td class="border p-1 text-center">{{ $i+1 }}</td>
                                <td class="border p-1">{{ $y->year }}</td>
                                <td class="border p-1 text-center">
                                    <x-admin.button.primary size="sm" @click="openYear = true"
                                                            wire:click="editYear({{ $y->id }})"
                                                            icon="fa-edit" iconPrefix="fa"/>
                                    <x-admin.button.danger size="sm"
                                                           wire:click="deleteYear({{ $y->id }})"
                                                           icon="fa-trash" iconPrefix="fa"/>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Event --}}
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-3 border-b"><h4 class="font-semibold">Daftar Kegiatan</h4></div>
                <div class="px-6 py-3 max-h-[260px] overflow-y-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-100 sticky top-0 z-10">
                        <tr>
                            <th class="border px-2 py-1">No</th>
                            <th class="border px-2 py-1">Event</th>
                            <th class="border px-2 py-1">Tahun</th>
                            <th class="border px-2 py-1">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($events as $i => $event)
                            <tr>
                                <td class="border p-1 text-center">{{ $i+1 }}</td>
                                <td class="border p-1">{{ $event->name }}</td>
                                <td class="border p-1">{{ $event->year->year }}</td>
                                <td class="border p-1 text-center">
                                    <x-admin.button.primary size="sm" @click="openEvent = true"
                                        wire:click="editEvent({{ $event->id }})"
                                        icon="fa-edit" iconPrefix="fa"/>

                                    <x-admin.button.danger size="sm"
                                        wire:click="deleteEvent({{ $event->id }})"
                                        icon="fa-trash" iconPrefix="fa"/>

                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-gray-400">Belum ada Event</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Foto --}}
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-3 border-b"><h4 class="font-semibold">Daftar Foto</h4></div>
            <div class="px-6 py-4 flex flex-wrap gap-4">
                @forelse($photos as $photo)

                    {{-- Image Mode --}}
                    @if($photo->image)
                        <div class="w-44 text-center">
                            <img src="{{ asset('storage/'.$photo->image) }}"
                                 class="w-44 h-28 object-cover rounded border cursor-pointer"
                                 @click="openLightbox('{{ asset('storage/'.$photo->image) }}')">

                            <div class="flex justify-center space-x-1 mt-2">
                                <x-admin.button.danger size="sm"
                                    wire:click="deletePhoto({{ $photo->id }})"
                                    icon="fa-trash" iconPrefix="fa"/>
                            </div>
                        </div>
                    @endif

                    {{-- Video Mode --}}
                    @if($photo->video_url)
                        <div class="w-44 text-center">
                            <iframe src="{{ $photo->video_url }}" class="w-44 h-28 rounded border"></iframe>
                            <div class="flex justify-center space-x-1 mt-2">
                                <x-admin.button.danger size="sm"
                                    wire:click="deletePhoto({{ $photo->id }})"
                                    icon="fa-trash" iconPrefix="fa"/>
                            </div>
                        </div>
                    @endif

                @empty
                    <span class="text-gray-400">Belum ada Foto</span>
                @endforelse
            </div>
        </div>

        {{-- Lightbox --}}
        <div x-show="lightboxOpen" x-transition.opacity x-cloak
             @click.self="lightboxOpen = false"
             class="fixed inset-0 z-[999] bg-black bg-opacity-80 flex items-center justify-center p-4">

            <button @click="lightboxOpen = false"
                    class="absolute top-4 right-6 text-white text-3xl font-bold">
                ✕
            </button>

            <img :src="lightboxSrc"
                 class="max-w-full max-h-[85vh] rounded shadow-xl mx-auto">
        </div>

    </div>
</x-admin.ui.section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function galleryComponent() {
        return {
            openYear: @entangle('showYearModal'),
            openEvent: @entangle('showEventModal'),
            openPhoto: @entangle('showPhotoModal'),

            lightboxOpen: false,
            lightboxSrc: '',

            init() {
                document.body.classList.remove("overflow-hidden");

                window.addEventListener('close-modals', () => {
                    this.openYear = false;
                    this.openEvent = false;
                    this.openPhoto = false;
                });

                // 🔥 Listener Notifikasi dari Livewire
                Livewire.on('notify', ({ type, message }) => {
                Swal.fire({
                    icon: type,
                    title: message,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "OK",
                    position: "center",
                    });
                });
            },

            openLightbox(src) {
                this.lightboxSrc = src;
                this.lightboxOpen = true;
                document.body.classList.add("overflow-hidden");
            }
        }
    }
</script>
@endpush

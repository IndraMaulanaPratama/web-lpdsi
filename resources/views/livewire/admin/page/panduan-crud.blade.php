<div class="p-6" x-data="{ openModal: @entangle('showForm') }">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Manajemen Panduan</h2>

    {{-- Alert sukses --}}
    @if (session()->has('success'))
        <div class="bg-green-200 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header + Button Tambah --}}
    <div class="flex justify-between items-center mb-4">
        <input type="text" wire:model.live="search" placeholder="Cari panduan..." 
               class="border rounded-lg px-3 py-2 w-1/3 focus:ring focus:ring-blue-300">

        <button @click="openModal = true" wire:click="resetForm" 
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Tambah Panduan
        </button>
    </div>

    {{-- Tabel --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">Judul</th>
                    <th class="px-4 py-2">Divisi</th>
                    <th class="px-4 py-2">Penulis</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($panduans as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $item->judul }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->divisi->name ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->penulis }}</td>
                        <td class="px-4 py-2 text-center flex justify-center space-x-2">
                            <button @click="openModal = true" wire:click="edit({{ $item->id }})"
                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                Edit
                            </button>
                            <button wire:click="delete({{ $item->id }})"
                                onclick="confirm('Yakin ingin menghapus panduan ini?') || event.stopImmediatePropagation()"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4">
            {{ $panduans->links() }}
        </div>
    </div>

    {{-- Modal Popup Form --}}
    <div x-show="openModal" x-transition x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        @keydown.escape.window="openModal = false; $wire.showForm = false"
        wire:ignore.self
    >
        <div
            class="bg-white w-full max-w-7xl max-h-[95vh] rounded-lg shadow overflow-y-auto p-6 relative dark:bg-gray-800">
            
            {{-- Close Button --}}
            <button @click="openModal = false; $wire.showForm = false"
                class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl font-bold z-50"
                aria-label="Close modal"
            >&times;</button>

            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">
                {{ $isEdit ? 'Edit Panduan' : 'Tambah Panduan' }}
            </h3>

            {{-- Form --}}
            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">Judul</label>
                        <input type="text" wire:model="judul"
                               class="border rounded-lg px-3 py-2 w-full dark:bg-gray-700 dark:text-white">
                        @error('judul') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">Divisi</label>
                        <select wire:model="divisi_id"
                                class="border rounded-lg px-3 py-2 w-full dark:bg-gray-700 dark:text-white">
                            <option value="">-- Pilih Divisi --</option>
                            @foreach($divisis as $div)
                                <option value="{{ $div->id }}">{{ $div->name }}</option>
                            @endforeach
                        </select>
                        @error('divisi_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">Kategori Panduan</label>
                        <select wire:model="category_panduan_id"
                                class="border rounded-lg px-3 py-2 w-full dark:bg-gray-700 dark:text-white">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category_panduan_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">Penulis</label>
                        <input type="text" wire:model="penulis"
                               class="border rounded-lg px-3 py-2 w-full dark:bg-gray-700 dark:text-white">
                        @error('penulis') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-4" wire:ignore>
                    <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">Isi Artikel</label>
                    <textarea name="isiArtikel" class="tinymce-editor" id="isiArtikel"
                              wire:model.defer="isiArtikel" wire:key="editorArtikel">{!! $isiArtikel !!}</textarea>
                </div>

                <div class="mt-4 flex justify-end space-x-3">
                    <button type="button" @click="openModal=false; $wire.showForm=false"
                            class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Batal
                    </button>
                    <button type="submit"
                            class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700">
                        {{ $isEdit ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            initTinyMCE();
        });

        function initTinyMCE() {
            if (tinymce.get('isiArtikel')) {
                tinymce.remove('#isiArtikel');
            }

            tinymce.init({
                selector: '#isiArtikel',
                height: 400,
                menubar: true,
                plugins: 'print preview importcss searchreplace autolink directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars',

                toolbar1: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat',
                toolbar2: 'image media link anchor codesample | ltr rtl | print preview fullscreen | insertdatetime table hr pagebreak | charmap emoticons | help',

                font_formats: 'Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Courier New=courier new,courier; Comic Sans MS=comic sans ms,sans-serif; Helvetica=helvetica; Impact=impact,chicago; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Georgia=georgia,palatino; Tahoma=tahoma,arial,helvetica,sans-serif; Helvetica Neue=Helvetica Neue,Helvetica,Arial,sans-serif; Century Gothic=Century Gothic,sans-serif; Helvetica=helvetica,sans-serif',

                fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',

                automatic_uploads: true,
                images_upload_url: "{{ route('upload.image') }}",
                file_picker_types: 'image',

                file_picker_callback: function (cb, value, meta) {
                    let input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function () {
                        let file = this.files[0];
                        let formData = new FormData();
                        formData.append('file', file);
                        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        formData.append('_token', token);

                        fetch("{{ route('upload.image') }}", {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            credentials: 'same-origin'
                        })
                        .then(res => {
                            if (!res.ok) {
                                throw new Error('HTTP status ' + res.status);
                            }
                            return res.json();
                        })
                        .then(result => {
                            cb(result.location || result.url);
                        })
                        .catch(err => {
                            console.error('Upload error:', err);
                            alert('Upload gambar gagal. Silakan coba lagi.');
                        });
                    };

                    input.click();
                },

                setup: function (editor) {
                    editor.on('change keyup', function () {
                        @this.set('isiArtikel', editor.getContent());
                    });
                }
            });
        }

        document.addEventListener('livewire:updated', function () {
            initTinyMCE();
        });
        document.addEventListener('livewire:rendered', function () {
            initTinyMCE();
        });
        document.addEventListener('livewire:load', function () {
            Livewire.on('close-modal', () => {
                const modal = document.querySelector('[x-data]');
                if (modal && modal.__x) {
                    modal.__x.$data.openModal = false;
                }
            });
        });
        document.addEventListener('livewire:load', function () {
            Livewire.on('edit-mode', () => {
                setTimeout(() => {
                    initTinyMCE();
                }, 300);
            });

            Livewire.on('close-modal', () => {
                const modal = document.querySelector('[x-data]');
                if (modal && modal.__x) {
                    modal.__x.$data.openModal = false;
                }
            });
        });
    </script>
@endpush
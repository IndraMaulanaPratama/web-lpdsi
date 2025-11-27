{{-- Section Berita --}}

<div class="p-6" x-data="{ openModal: @entangle('showForm') }">
<h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Manajemen Berita</h3>

{{-- Alert sukses --}}
@if (session()->has('success'))
    <div class="bg-green-200 text-green-700 p-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

{{-- Data Table --}}
<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mt-6">
    <div class="px-6 py-4 border-b dark:border-gray-700 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Data Berita</h3>
        <div class="flex space-x-2">
            <x-admin.button.primary wire:click="toggleForm" @click="openModal = true" icon="fa-plus" iconPrefix="fa" size="sm">
                Tambah Berita
            </x-admin.button.primary>
        </div>
    </div>

    <div class="px-6 py-4">
        <div class="relative overflow-x-auto max-h-[500px] overflow-y-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3">Judul</th>
                        <th class="px-6 py-3">Lihat</th>
                        <th class="px-6 py-3">Penulis</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($berita as $item)
                        <tr class="bg-white border-b dark:bg-gray-800">
                            <td class="px-6 py-4">{{ $item->judul }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('berita.show', ['slug' => $item->slug]) }}" target="_blank" class="text-blue-600 underline">
                                    Lihat Detail
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $item->penulis }}</td>
                            <td class="px-6 py-4">{{ $item->tanggal }}</td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    {{-- Edit buka modal --}}
                                    <x-admin.button.warning wire:click="edit({{ $item->id }})"
                                        @click="openModal = true" size="sm" icon="fa-edit" iconPrefix="fa" />
                                    
                                    {{-- Tombol Hapus dengan Konfirmasi Livewire --}}
                                    <x-admin.button.danger 
                                        wire:click="delete({{ $item->id }})" 
                                        wire:confirm="Anda yakin ingin menghapus berita ini?"
                                        size="sm"
                                        icon="fa-trash" iconPrefix="fa" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $berita->links() }}
        </div>
    </div>
</div>

{{-- Modal --}}
<div x-show="openModal" x-transition x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">

    <div class="bg-white dark:bg-gray-800 w-full max-w-7xl max-h-[100vh] overflow-y-auto rounded-lg shadow p-6 relative">
        <button @click="openModal = false; $wire.resetForm()" 
            class="absolute top-2 right-2 text-gray-400 hover:text-red-500">✕</button>

        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">
            {{ $isEdit ? 'Edit Berita' : 'Tambah Berita' }}
        </h3>

        {{-- FORM --}}
        <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" enctype="multipart/form-data">

            <div class="space-y-4">

                {{-- JUDUL + PENULIS --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-admin.form.inputText wire:model="judul" label="Judul Berita" placeholder="Judul Berita" />
                        @error('judul') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <x-admin.form.inputText wire:model="penulis" label="Penulis" placeholder="Nama Penulis" />
                        @error('penulis') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- TANGGAL + GAMBAR --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-admin.form.inputText type="date" wire:model="tanggal" label="Tanggal" />
                        @error('tanggal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Upload Gambar</label>
                        <input type="file" wire:model="gambar" class="w-full border rounded p-2" />
                        <x-admin.ui.paragraph size="sm">
                            Hanya file: <b>jpg, jpeg, png, webp</b> (maks 2 MB)
                        </x-admin.ui.paragraph>

                        @error('gambar') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>
                </div>
    
                {{-- TINYMCE --}}
                @error('isiKonten')
                    <p class="text-red-500 text-xs mb-2">{{ $message }}</p>
                @enderror
                <div class="mt-4" wire:ignore>
                    <label class="block mb-1 font-semibold">Konten</label>
                    <textarea id="isiKonten" class="tinymce-editor" wire:model.defer="isiKonten">{!! $isiKonten !!}</textarea>
                </div>

                {{-- SUBMIT --}}
                <x-admin.button.success type="submit" wire:loading.attr="disabled">
                    {{ $isEdit ? 'Update' : 'Tambah' }}
                </x-admin.button.success>

                <div wire:loading wire:target="gambar">Mengunggah gambar...</div>

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
            // Hapus editor lama kalau sudah ada
            if (tinymce.get('isiKonten')) {
                tinymce.remove('#isiKonten');
            }

            tinymce.init({
                selector: '#isiKonten',
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
                        @this.set('isiKonten', editor.getContent());
                    });
                }
            });
        }

        // Re-init TinyMCE saat Livewire update
        document.addEventListener('livewire:updated', function () {
            initTinyMCE();
        });
        document.addEventListener('livewire:rendered', function () {
            initTinyMCE();
        });

        // Tutup modal lewat event Livewire
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
    <script>
    document.addEventListener('livewire:load', () => {
        Livewire.on('notify', (data) => {
            // Tampilan notif sederhana
            const box = document.createElement('div');
            box.className = `fixed top-4 right-4 px-4 py-3 rounded-lg shadow text-white z-50 
                ${data.type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            box.textContent = data.message;

            document.body.appendChild(box);

            setTimeout(() => {
                box.remove();
            }, 3000);
        });
    });
</script>

@endpush
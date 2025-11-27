{{-- Section Visi & Misi --}}
<div class="p-6" x-data="{ activeTab: 'visi' }">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Manajemen Visi & Misi</h3>

    @if (session()->has('success'))
        <div class="bg-green-200 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white text-center">
            {{ $isEdit ? 'Edit Visi & Misi' : 'Tambah Visi & Misi' }}
        </h3>

        {{-- Tabs --}}
        <div class="flex border-b mb-4 justify-center">
            <button 
                @click="activeTab = 'visi'"
                :class="activeTab === 'visi' ? 'border-blue-500 text-blue-600 font-semibold' : 'text-gray-500'"
                class="px-4 py-2 border-b-2 focus:outline-none">
                Visi
            </button>
            <button 
                @click="activeTab = 'misi'"
                :class="activeTab === 'misi' ? 'border-blue-500 text-blue-600 font-semibold' : 'text-gray-500'"
                class="px-4 py-2 border-b-2 focus:outline-none">
                Misi
            </button>
        </div>

        {{-- Form --}}
        @if ($isEdit)
            <form wire:submit.prevent="update" method="POST">
        @else
            <form wire:submit.prevent="store" method="POST">
        @endif
            @csrf

            <div class="space-y-4">
                <div x-show="activeTab === 'visi'" wire:ignore>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Visi</label>
                    <textarea id="visi" name="visi" wire:key="editorVisi">{!! $visi !!}</textarea>
                </div>

                <div x-show="activeTab === 'misi'" wire:ignore>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Misi</label>
                    <textarea id="misi" name="misi" wire:key="editorMisi">{!! $misi !!}</textarea>
                </div>
                    @if ($isEdit)
                        <x-admin.button.danger 
                            wire:click.prevent="delete({{ $editId }})"
                            type="button">
                            Hapus
                        </x-admin.button.danger>
                        <x-admin.button.success type="submit">
                            Simpan Perubahan
                        </x-admin.button.success>
                    @else
                        <x-admin.button.primary type="submit">
                            Tambah
                        </x-admin.button.primary>
                    @endif
                </div>    
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    const editorVisi = CKEDITOR.replace('visi');
    editorVisi.on('change', function() {
        @this.set('visi', editorVisi.getData());
    });

    const editorMisi = CKEDITOR.replace('misi');
    editorMisi.on('change', function() {
        @this.set('misi', editorMisi.getData());
    });
</script>
@endpush

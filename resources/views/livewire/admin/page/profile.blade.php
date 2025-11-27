<div class="max-w-4xl mx-auto py-8">
    {{-- ✅ Notifikasi sukses --}}
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-green-800 bg-green-100 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center gap-6">
            <div class="relative w-28 h-28 rounded-full overflow-hidden bg-gray-100">
                @if ($avatarPreview)
                    <img src="{{ $avatarPreview }}" alt="avatar" class="object-cover w-full h-full">
                @else
                    <span class="flex items-center justify-center w-full h-full text-gray-400 text-2xl">
                        {{ strtoupper(substr($name, 0, 1)) }}
                    </span>
                @endif
                <label class="absolute bottom-0 right-0 bg-blue-600 text-white p-1.5 rounded-full cursor-pointer">
                    <input type="file" wire:model="avatar" class="hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                </label>
                @error('avatar') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <h2 class="text-2xl font-semibold">{{ $name }}</h2>
                <p class="text-gray-500 text-sm">{{ $email }}</p>
                <p class="text-gray-600 text-sm mt-1">Telepon: {{ $phone ?? '-' }}</p>
            </div>
        </div>

        <hr class="my-6">

       <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Nama</label>
                <input type="text" wire:model.defer="name" class="mt-1 w-full border rounded p-2">
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" wire:model.defer="email" class="mt-1 w-full border rounded p-2">
                @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Password Baru</label>
                <input type="password" wire:model.defer="password" class="mt-1 w-full border rounded p-2">
                @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Konfirmasi Password</label>
                <input type="password" wire:model.defer="password_confirmation" class="mt-1 w-full border rounded p-2">
            </div>

            <div class="col-span-2 flex justify-end mt-4">
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 disabled:opacity-50"
                    wire:loading.attr="disabled">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

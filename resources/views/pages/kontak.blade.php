@extends('layouts.app')

@section('title', 'Kontak')

@section('content')
<div class="bg-white-50 min-h-screen py-32 flex items-center">
    <div class="container mx-auto px-4 max-w-5xl">
        <h1 class="text-4xl font-bold text-blue mb-12 text-center tracking-wide">
            Kontak Kami
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Kolom Kiri: Info Kontak -->
            <div class="bg-white/60 backdrop-blur-md p-8 rounded-2xl shadow-lg">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center border-b pb-4">
                    Informasi Kontak
                </h2>

                <div class="space-y-5">
                    <div class="flex items-start space-x-4">
                        <i class="fas fa-map-marker-alt text-blue-600 text-2xl mt-1"></i>
                        <span class="text-gray-800 leading-relaxed">
                            Jl. Raya Bandung - Sumedang No.Km.20, Cibeusi, Kec. Jatinangor, Kabupaten Sumedang
                        </span>
                    </div>

                    <div class="flex items-center space-x-4">
                        <i class="fas fa-envelope text-blue-600 text-2xl"></i>
                        <span class="text-gray-800">helpdesk.lpdsi@ipdn.ac.id</span>
                    </div>

                    <div class="flex items-center space-x-4">
                        <i class="fas fa-phone text-blue-600 text-2xl"></i>
                        <span class="text-gray-800">(022) 123-4567</span>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Form Hubungi Kami -->
            <div>
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('kontak.kirim') }}" method="POST"
                      class="bg-white/60 backdrop-blur-md p-8 rounded-2xl shadow-lg">
                    @csrf

                    <div class="mb-4">
                        <x-admin.form.inputText name="nama" required="true" label="Nama Lengkap" type="text"
                            placeholder="Nama tanpa gelar" />
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-admin.form.inputText name="email" required="true" label="Alamat Email" type="email"
                            placeholder="email.anda@domain" />
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-md font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Subjek Pesan
                        </label>
                        <div class="grid grid-cols-3">
                            <x-admin.form.radio label="Masukan" name="subjek" value="Masukan" checked />
                            <x-admin.form.radio label="Pengaduan" name="subjek" value="Pengaduan" />
                            <x-admin.form.radio label="Lainnya" name="subjek" value="Lainnya" />
                        </div>
                        @error('subjek')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-admin.form.textarea name="pesan" required="true" width="full" rows="4"
                            label="Pesan" placeholder="Silakan tulis pesan anda di sini..." />
                        @error('pesan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-all duration-200">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

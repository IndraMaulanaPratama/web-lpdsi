@props([
    'title' => 'Data',
    'headers' => [],
    'pagination' => null,
    'exportable' => false,
    'importable' => false,
    'createable' => false,
    'searchable' => false,
    'createUrl' => '#',
    'exportUrl' => '#',
    'importUrl' => '#',
    'emptyMessage' => 'Tidak ada data yang ditemukan.',
    'width' => 'full', // full, auto, max, min, atau nilai custom seperti 1024px
    'responsive' => true,
])

@php
    // Menentukan kelas width berdasarkan prop width
    $widthClasses = [
        'full' => 'w-full',
        'auto' => 'w-auto',
        'max' => 'w-max',
        'min' => 'w-min',
    ];

    $tableWidth = array_key_exists($width, $widthClasses) ? $widthClasses[$width] : $width;
@endphp

<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <!-- Header dengan Judul dan Tombol Aksi -->
    <div
        class="px-6 py-4 border-b dark:border-gray-700 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $title }}</h3>


        @if ($exportable || $importable || $createable)
            <div class="flex flex-wrap gap-2">
                @if ($searchable)
                    <x-admin.form.inputText name="search" placeholder="Cari data ..." />
                @endif

                @if ($exportable)
                    <x-admin.button.primary href="{{ $exportUrl }}" icon="fa-solid fa-download" iconPrefix="fa"
                        size="sm">
                        Export
                    </x-admin.button.primary>
                @endif

                @if ($importable)
                    <x-admin.button.secondary href="{{ $importUrl }}" icon="fa-solid fa-upload" iconPrefix="fa"
                        size="sm" outline>
                        Import
                    </x-admin.button.secondary>
                @endif

                @if ($createable)
                    <x-admin.button.success href="{{ $createUrl }}" icon="fa-solid fa-plus" iconPrefix="fa"
                        size="sm">
                        Tambah {{ str_replace('Recent ', '', $title) }}
                    </x-admin.button.success>
                @endif
            </div>

        @endif
    </div>

    <!-- Table Container -->
    <div class="px-6 py-4 @if ($responsive) overflow-x-auto @endif">
        <table class="{{ $tableWidth }} text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    @foreach ($headers as $key => $header)
                        @if (is_array($header))
                            <th scope="col" class="px-6 py-3 {{ $header['class'] ?? '' }}"
                                @if (isset($header['width'])) style="width: {{ $header['width'] }}" @endif>
                                {{ $header['label'] }}
                            </th>
                        @else
                            <th scope="col" class="px-6 py-3">
                                {{ $header }}
                            </th>
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                {{ $slot }} <!-- Slot untuk table body -->
            </tbody>
        </table>
    </div>

</div>

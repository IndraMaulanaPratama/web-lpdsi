@props([
    'label' => '',
    'name' => '',
    'placeholder' => 'Pilih file',
    'required' => false,
    'disabled' => false,
    'error' => '',
    'helperText' => '',
    'accept' => '', // e.g., 'image/*', '.pdf,.doc,.docx', etc.
    'multiple' => false,
    'width' => 'full', // full, auto, max, min, atau nilai custom
    'containerClass' => '',
    'inputClass' => '',
    'showPreview' => false, // Tampilkan preview untuk file gambar
    'maxSize' => 5, // Ukuran maksimal file dalam MB
    'maxFiles' => 1, // Jumlah maksimal file yang bisa diupload
])


{{-- -------------------------------------------
Opsi Accept yang Umum

.pdf,.doc,.docx - File dokumen
.jpg,.jpeg,.png,.gif - File gambar spesifik
.zip,.rar - File arsip

image/* - Semua jenis gambar
audio/* - File audio
video/* - File video
---------------------------------------------- --}}


@php
    $hasError = !empty($error);
    $inputId = uniqid('file-input-');

    // Menentukan kelas width berdasarkan prop width
    $widthClasses = [
        'full' => 'w-full',
        'auto' => 'w-auto',
        'max' => 'w-max',
        'min' => 'w-min',
    ];

    $inputWidth = array_key_exists($width, $widthClasses) ? $widthClasses[$width] : $width;

    // Kelas untuk container
    $containerClasses = 'mb-4 ' . $containerClass;

    // Kelas untuk input
    $inputBaseClasses =
        'file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition-colors duration-200';
    $inputClasses =
        $inputBaseClasses .
        ' ' .
        $inputWidth .
        ($hasError ? ' border-red-500' : ' border-gray-300 dark:border-gray-600') .
        ' ' .
        $inputClass;
@endphp

<div class="{{ $containerClasses }}" x-data="fileInput{{ $inputId }}()" wire:ignore>
    @if ($label)
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input id="{{ $inputId }}" type="file" name="{{ $name }}"
            @if ($accept) accept="{{ $accept }}" @endif
            @if ($multiple) multiple @endif @if ($required) required @endif
            @if ($disabled) disabled @endif x-on:change="handleFileSelect($event)"
            class="{{ $inputClasses }}" placeholder="test" />
    </div>

    <!-- File Info -->
    <div x-show="files.length > 0" class="mt-2 space-y-2">
        <template x-for="(file, index) in files" :key="index">
            <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 rounded-lg p-2">
                <div class="flex items-center">
                    <template x-if="file.type.includes('image') && showPreview">
                        <img :src="file.preview" class="h-10 w-10 object-cover rounded-md mr-2">
                    </template>
                    <template x-if="!file.type.includes('image') || !showPreview">
                        <div
                            class="h-10 w-10 flex items-center justify-center bg-gray-200 dark:bg-gray-600 rounded-md mr-2">
                            <i class="fa fa-file text-gray-500"></i>
                        </div>
                    </template>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="file.name"></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400" x-text="formatFileSize(file.size)"></p>
                    </div>
                </div>
                <button type="button" @click="removeFile(index)" class="text-red-500 hover:text-red-700">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </template>
    </div>

    <!-- Max Files Warning -->
    <div x-show="files.length > maxFiles" class="mt-2 text-sm text-red-600 dark:text-red-400">
        Maksimal {{ $maxFiles }} file yang diizinkan
    </div>

    @if ($helperText)
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $helperText }}</p>
    @endif

    @if ($hasError)
        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $error }}</p>
    @endif

    <script>
        function fileInput{{ $inputId }}() {
            return {
                files: [],
                maxFiles: {{ $maxFiles }},
                maxSize: {{ $maxSize }} * 1024 * 1024, // Convert to bytes

                handleFileSelect(event) {
                    const selectedFiles = event.target.files;
                    this.processFiles(selectedFiles);
                },

                processFiles(fileList) {
                    for (let i = 0; i < fileList.length; i++) {
                        const file = fileList[i];

                        // Check max files
                        if (this.files.length >= this.maxFiles) {
                            this.showMaxFilesWarning();
                            break;
                        }

                        // Check file size
                        if (file.size > this.maxSize) {
                            alert(`File ${file.name} melebihi ukuran maksimum {{ $maxSize }}MB`);
                            continue;
                        }

                        // Create preview for images
                        if (file.type.includes('image') && {{ $showPreview ? 'true' : 'false' }}) {
                            file.preview = URL.createObjectURL(file);
                        }

                        this.files.push(file);
                    }

                    // Update the actual file input
                    this.updateFileInput();
                },

                removeFile(index) {
                    if (this.files[index].preview) {
                        URL.revokeObjectURL(this.files[index].preview);
                    }
                    this.files.splice(index, 1);
                    this.updateFileInput();
                },

                updateFileInput() {
                    // Create a new DataTransfer object
                    const dataTransfer = new DataTransfer();

                    // Add files to the DataTransfer object
                    this.files.forEach(file => {
                        dataTransfer.items.add(file);
                    });

                    // Update the file input
                    const fileInput = document.getElementById('{{ $inputId }}');
                    fileInput.files = dataTransfer.files;
                },

                formatFileSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                },

                showMaxFilesWarning() {
                    alert(`Maksimal {{ $maxFiles }} file yang diizinkan`);
                }
            }
        }

        document.addEventListener('livewire:load', function() {
            // Initialize component when Livewire is loaded
        });
    </script>
</div>

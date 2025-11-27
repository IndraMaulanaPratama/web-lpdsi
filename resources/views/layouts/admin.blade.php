<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>

    <!-- CSS Libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    @stack('style')
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    @livewireStyles
</head>

<body class="bg-gray-50 dark:bg-gray-900 h-full" x-data="app()" x-cloak>
    <!-- Main Layout -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <x-admin.template.sidebar.sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col ml-0 md:ml-64">
            <!-- Top Navigation -->
            <x-admin.template.navbar.top-navbar />

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- CKEditor 4 -->
    <script src="https://cdn.ckeditor.com/4.22.1/standard-all/ckeditor.js"></script>
    <script>
        // Inisialisasi Alpine.js dan mode gelap
        function app() {
            return {
                darkMode: false,
                sidebarOpen: window.innerWidth >= 768,

                init() {
                    if (
                        localStorage.theme === 'dark' ||
                        (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
                    ) {
                        this.darkMode = true;
                        document.documentElement.classList.add('dark');
                    } else {
                        this.darkMode = false;
                        document.documentElement.classList.remove('dark');
                    }
                },

                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                        localStorage.theme = 'dark';
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.theme = 'light';
                    }
                }
            }
        }

        document.addEventListener('livewire:init', () => {
            if (typeof Alpine !== 'undefined') {
                Alpine.data('app', app);
            }
        });

        // ✅ Inisialisasi CKEditor (support upload gambar)
        function initCkeditor() {
            if (typeof CKEDITOR !== "undefined") {
                if (document.getElementById("konten")) {
                    // Hapus instance lama kalau ada
                    if (CKEDITOR.instances['konten']) {
                        CKEDITOR.instances['konten'].destroy(true);
                    }

                    // Buat instance baru
                    CKEDITOR.replace("konten", {
                        height: 350,
                        extraPlugins: 'uploadimage,image2',
                        removePlugins: 'easyimage,cloudservices',
                        filebrowserUploadUrl: "/upload-image?_token=" + document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content'),
                        filebrowserUploadMethod: 'form',
                        toolbar: [
                            { name: 'document', items: ['Source', '-', 'Preview'] },
                            { name: 'clipboard', items: ['Undo', 'Redo'] },
                            { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
                            { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Blockquote'] },
                            { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'Link'] },
                            { name: 'colors', items: ['TextColor', 'BGColor'] },
                            { name: 'tools', items: ['Maximize'] }
                        ]
                    });
                }
            } else {
                console.error("⚠️ CKEditor belum dimuat dari CDN.");
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            initCkeditor();
        });
    </script>

    @livewireScripts
    @stack('scripts')
</body>
</html>

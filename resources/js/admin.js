// resources/js/admin.js

// ===============================
// Tailwind Config
// ===============================
tailwind.config = {
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                },
                danger: {
                    50: '#fef2f2',
                    100: '#fee2e2',
                    200: '#fecaca',
                    300: '#fca5a5',
                    400: '#f87171',
                    500: '#ef4444',
                    600: '#dc2626',
                    700: '#b91c1c',
                    800: '#991b1b',
                    900: '#7f1d1d',
                }
            }
        }
    }
}

// ===============================
// Import Library
// ===============================
// import Chart from 'chart.js/auto';

// ===============================
// CKEditor Init (via CDN)
// ===============================
// resources/js/ckeditor.js

function initCkeditor() {
    if (typeof CKEDITOR !== "undefined") {
        if (document.getElementById("konten")) {
            // Hapus instance lama kalau ada
            if (CKEDITOR.instances['konten']) {
                CKEDITOR.instances['konten'].destroy(true);
            }

            // Buat instance baru
            CKEDITOR.replace("konten", {
                height: 300,
                removeButtons: 'PasteFromWord',
                extraPlugins: 'uploadimage,image2',
                removePlugins: 'easyimage,cloudservices',

                // 🧠 Tambahkan dua baris penting ini
                filebrowserUploadUrl: "/upload-image?_token=" + document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                filebrowserUploadMethod: 'form'
            });
        }
    } else {
        console.error("CKEditor 4 CDN belum dimuat.");
    }
}

// Jalankan setelah DOM siap
document.addEventListener("DOMContentLoaded", () => {
    initCkeditor();
});



// ===============================
// Chart.js Initialization
// ===============================
function initCharts() {
    // Bar Chart
    const barCanvas = document.getElementById('barChart');
    if (barCanvas) {
        const barCtx = barCanvas.getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue',
                    data: [4500, 5200, 5900, 6200, 7100, 7900],
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // Pie Chart
    const pieCanvas = document.getElementById('pieChart');
    if (pieCanvas) {
        const pieCtx = pieCanvas.getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Admin', 'Editor', 'User'],
                datasets: [{
                    data: [10, 20, 30],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(245, 158, 11, 0.7)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
}

// ===============================
// Run After DOM Ready
// ===============================
document.addEventListener("DOMContentLoaded", () => {
    // Init Charts kalau ada canvas
    if (document.getElementById('barChart') || document.getElementById('pieChart')) {
        initCharts();
    }

    // Init CKEditor kalau ada textarea
    if (document.getElementById('konten')) {
        initCkeditor();
    }
});

{{-- Stop trying to control. --}}
<div x-data="formComponents()" wire:ignore>
    <!-- Basic Input -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            <i class="bi bi-input-cursor-text mr-2"></i>Basic Input
        </h3>
        <div class="space-y-4">
            {{-- Nama Lengkap --}}
            <div>
                <x-admin.form.inputText label="Nama Lengkap" type="text" name="namaLengkap"
                    placeholder="Masukan nama lengkap"
                    helperText="Boleh sama gelar asal jangan sama dia, soalnya punya aku" />
            </div>

            {{-- Alamat Email --}}
            <div>
                <x-admin.form.inputText label="Email" type="email" name="alamatEmail"
                    placeholder="email@contoh.com" />
            </div>

            {{-- Password --}}
            <div>
                {{-- Componen --}}
                {{-- //TODO::Fix bug validasi password component ya ganteng --}}
                <x-admin.form.inputText label="Password" type="password" name="password"
                    placeholder="Masukan password component" required showPasswordToggle />


                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                <div class="relative">
                    <input x-model="password" :type="showPassword ? 'text' : 'password'"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-700 dark:text-white pr-10"
                        placeholder="Masukkan password" @input="validatePassword">
                    <button type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
                        @click="showPassword = !showPassword">
                        <i class="fa" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>

                <div x-show="password.length > 0" class="mt-1">
                    <div class="flex items-center"
                        :class="{ 'text-green-600': passwordStrength >= 1, 'text-gray-400': passwordStrength < 1 }">
                        <i class="fa" :class="passwordStrength >= 1 ? 'fa-check-circle-fill' : 'fa-circle'"></i>
                        <span class="text-xs ml-1">Minimal 8 karakter</span>
                    </div>

                    <div class="flex items-center"
                        :class="{ 'text-green-600': passwordStrength >= 2, 'text-gray-400': passwordStrength < 2 }">
                        <i class="fa" :class="passwordStrength >= 2 ? 'fa-check-circle-fill' : 'fa-circle'"></i>
                        <span class="text-xs ml-1">Mengandung angka</span>
                    </div>
                    <div class="flex items-center"
                        :class="{ 'text-green-600': passwordStrength >= 3, 'text-gray-400': passwordStrength < 3 }">
                        <i class="fa" :class="passwordStrength >= 3 ? 'fa-check-circle-fill' : 'fa-circle'"></i>
                        <span class="text-xs ml-1">Mengandung huruf besar & kecil</span>
                    </div>
                </div>
            </div>

            {{-- Konfirm Password --}}
            <div>
                {{-- //TODO::Fix bug validasi konfirm password component ya ganteng --}}
                <x-admin.form.inputText label="Konfirmasi Password" type="password" name="confirmPassword"
                    placeholder="Konfirm password component" required showPasswordToggle />

                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konfirmasi
                    Password</label>
                <div class="relative">
                    <input x-model="confirmPassword" :type="showConfirmPassword ? 'text' : 'password'"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-700 dark:text-white pr-10"
                        :class="{
                            'border-red-500': confirmPassword.length > 0 && !passwordsMatch,
                            'border-green-500': confirmPassword.length > 0 && passwordsMatch,
                            'border-gray-300 dark:border-gray-600': confirmPassword.length === 0
                        }"
                        placeholder="Konfirmasi password" @input="checkPasswordMatch">
                    <button type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
                        @click="showConfirmPassword = !showConfirmPassword">
                        <i class="fa" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
                <div x-show="confirmPassword.length > 0 && !passwordsMatch"
                    class="mt-1 text-red-600 text-sm flex items-center">
                    <i class="fa fa-exclamation-circle mr-1"></i>
                    <span>Password tidak sesuai</span>
                </div>
                <div x-show="confirmPassword.length > 0 && passwordsMatch"
                    class="mt-1 text-green-600 text-sm flex items-center">
                    <i class="fa fa-check-circle mr-1"></i>
                    <span>Password sesuai</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Select Input -->
    <div class="my-4 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            <i class="bi bi-menu-button mr-2"></i>Select Input
        </h3>
        <div class="space-y-4">

            {{-- Select Conve --}}
            <div class="">
                <x-admin.form.select label="Jurusan" name="major" :options="[
                    'ti' => 'Teknik Informatika',
                    'si' => 'Sistem Informasi',
                    'tk' => 'Teknik Komputer',
                ]" placeholder="Pilih jurusan"
                    required />
            </div>

            {{-- Select Group --}}
            <div class="">
                <x-admin.form.select label="Produk" name="product" :options="[
                    'Elektronik' => [
                        'laptop' => 'Laptop',
                        'smartphone' => 'Smartphone',
                        'tablet' => 'Tablet',
                    ],
                    'Pakaian' => [
                        'shirt' => 'Kemeja',
                        'pants' => 'Celana',
                        'shoes' => 'Sepatu',
                    ],
                ]" :hasGroups="true" required />
            </div>

            {{-- Select Multiple --}}
            <div>
                <x-admin.form.select label="Skills" name="skills[]" :options="[
                    'php' => 'PHP',
                    'js' => 'JavaScript',
                    'python' => 'Python',
                    'java' => 'Java',
                ]" multiple
                    helperText="Gunakan Ctrl/Cmd untuk memilih multiple" />
            </div>
        </div>
    </div>

    <!-- Checkbox & Radio -->
    <div class="my-4 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            <i class="bi bi-check2-square mr-2"></i>Checkbox & Radio
        </h3>
        <div class="space-y-4">
            {{-- Checkbox --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilihan Bahasa
                    Pemrograman</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox"
                            class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">JavaScript</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox"
                            class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600"
                            checked>
                        <span class="ml-2 text-gray-700 dark:text-gray-300">PHP</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox"
                            class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Python</span>
                    </label>
                </div>
            </div>


            {{-- Radio --}}
            <div class="">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status Pengguna</label>
                <x-admin.form.radio label="Aktif" name="status" value="aktif" />
                <x-admin.form.radio label="Tidak Aktif" name="status" value="tidak-aktif" checked />
                <x-admin.form.radio label="Tertunda" name="status" value="tertunda" />
            </div>
        </div>
    </div>

    <!-- Toggle & Color Picker -->
    <div class="my-4 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            <i class="bi bi-toggle-on mr-2"></i>Toggle & Color Picker
        </h3>

        <div class="space-y-6">
            {{-- Toggle --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Toggle Options</label>
                <div class="space-y-4">
                    <x-admin.form.toggle label="Aktifkan Notifikasi" name="notifications" :value="true" />


                    {{-- Toggle pakai javascript --}}
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 dark:text-gray-300">Mode Gelap</span>
                        <button :class="{ 'bg-primary-600': darkMode, 'bg-gray-200 dark:bg-gray-600': !darkMode }"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                            @click="toggleDarkMode()">
                            <span :class="{ 'translate-x-5': darkMode, 'translate-x-0': !darkMode }"
                                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Color Picker --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Warna</label>
                <div class="flex space-x-2">
                    <input type="color"
                        class="h-10 w-10 rounded border border-gray-300 dark:border-gray-600 cursor-pointer"
                        value="#3b82f6">
                    <input type="color"
                        class="h-10 w-10 rounded border border-gray-300 dark:border-gray-600 cursor-pointer"
                        value="#ef4444">
                    <input type="color"
                        class="h-10 w-10 rounded border border-gray-300 dark:border-gray-600 cursor-pointer"
                        value="#10b981">
                    <input type="color"
                        class="h-10 w-10 rounded border border-gray-300 dark:border-gray-600 cursor-pointer"
                        value="#f59e0b">
                </div>
            </div>
        </div>
    </div>

    <!-- Date & Time Picker -->
    <div class="my-4 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            <i class="bi bi-calendar-date mr-2"></i>Date & Time Picker
        </h3>
        <div class="space-y-4">

            {{-- //TODO::input date, time sama date-time-local belum dibuatkan komponenya ganteng --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Lahir</label>
                <input type="date"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Waktu Meeting</label>
                <input type="time"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal & Waktu</label>
                <input type="datetime-local"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
            </div>
        </div>
    </div>

    <!-- Text Area -->
    <div class="my-4 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            <i class="bi bi-textarea-t mr-2"></i>Text Area
        </h3>
        <div class="space-y-4">
            <div>
                <x-admin.form.textarea label="Deskripsi Produk" name="product_description"
                    placeholder="Tulis deskripsi produk yang menarik di sini..." rows="5" required
                    helperText="Deskripsi akan ditampilkan di halaman detail produk" />
            </div>

            <div>
                <x-admin.form.textarea label="Komentar" name="comment" placeholder="Tulis komentar Anda..."
                    rows="3" helperText="Komentar Anda akan membantu kami meningkatkan layanan" />
            </div>
        </div>
    </div>

    {{-- //TODO:: Sampai sini dulu ya ganteng, istirahat dulu aja & jangan bunuh diri hari ini 🌹 --}}
    <!-- File Upload -->
    <div class="my-4 bg-white dark:bg-gray-800 rounded-lg shadow p-6">

        {{-- Penggunaan basic --}}
        <div class="">
            <x-admin.form.file-input label="Upload Foto Profil" name="profile_photo" accept="image/*"
                helperText="Format: JPG, PNG, GIF. Maksimal 5MB" required />
        </div>


        {{-- Penggunaan dalam grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-admin.form.file label="Foto KTP" name="id_card" accept="image/*" placeholder="Pilih File" required />
            <x-admin.form.file label="Foto Selfie dengan KTP" name="selfie_with_id" accept="image/*" required />
        </div>


        {{-- Multiple upload --}}
        <div class="">
            <x-admin.form.file-input label="Upload Gallery Foto" name="gallery_photos" accept="image/*"
                :multiple="true" :maxFiles="5" :showPreview="true" helperText="Maksimal 5 foto, 5MB per foto" />
        </div>

        {{-- Drag and drop --}}
        <div class="">
            <x-admin.form.file-dropzone label="Seret file ke sini" name="attachments" :multiple="true"
                :maxFiles="3" accept=".pdf,.jpg,.png" helperText="Seret file PDF, JPG, atau PNG ke area ini" />
        </div>

        {{-- spesifik file --}}
        <div class="">
            <x-admin.form.file-input label="Upload CV" name="cv" accept=".pdf,.doc,.docx" :maxSize="10"
                helperText="Format PDF atau DOC, maksimal 10MB" required />
        </div>


        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            <i class="bi bi-cloud-upload mr-2"></i>File Upload
        </h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Foto
                    Profil</label>
                <div
                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg">
                    <div class="space-y-1 text-center">
                        <i class="bi bi-cloud-upload text-3xl text-gray-400 mx-auto"></i>
                        <div class="flex text-sm text-gray-600 dark:text-gray-400">
                            <label
                                class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                <span>Upload file</span>
                                <input type="file" class="sr-only">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF up to 10MB</p>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Multiple File
                    Upload</label>
                <input type="file" multiple
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-700 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
            </div>
        </div>
    </div>

    <!-- Range Slider -->
    <div class="my-4 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            <i class="bi bi-sliders mr-2"></i>Range Slider
        </h3>
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Volume: <span
                        x-text="volume"></span>%</label>
                <input type="range" min="0" max="100" x-model="volume" class="w-full">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga: Rp.<span
                        x-text="price"></span></label>
                <input type="range" min="0" max="1000" step="10" x-model="price" class="w-full">
            </div>
        </div>
    </div>

    <!-- Tags Input -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            <i class="bi bi-tags mr-2"></i>Tags Input
        </h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tambahkan Tag</label>
                <div class="flex">
                    <input type="text" x-model="newTag" @keydown.enter.prevent="addTag"
                        @keydown.backspace="handleBackspace" placeholder="Ketik dan tekan Enter"
                        class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-l-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                        x-ref="tagInput">
                    <button @click="addTag"
                        class="px-4 py-2 bg-primary-600 text-white rounded-r-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Tekan Enter untuk menambah tag, Backspace
                    untuk menghapus tag terakhir</p>
            </div>

            <div class="flex flex-wrap items-center min-h-[3rem] p-2 border border-gray-300 dark:border-gray-600 rounded-lg"
                @click="$refs.tagInput.focus()">
                <template x-for="(tag, index) in tags" :key="index">
                    <div class="tag flex items-center">
                        <span x-text="tag" class="mr-1"></span>
                        <button @click="removeTag(index)"
                            class="text-primary-700 dark:text-primary-300 hover:text-primary-900 dark:hover:text-primary-100 ml-1"
                            aria-label="Hapus tag">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                </template>

                <span x-show="tags.length === 0" class="text-gray-500 dark:text-gray-400">
                    Belum ada tag. Ketik dan tekan Enter untuk menambahkan.
                </span>
            </div>

            <div x-show="tags.length > 0" class="flex justify-between items-center">
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    Jumlah tag: <span x-text="tags.length"></span>
                </span>
                <button @click="clearAllTags" class="text-sm text-red-600 hover:text-red-800 dark:hover:text-red-400">
                    <i class="bi bi-trash mr-1"></i>Hapus Semua
                </button>
            </div>
        </div>
    </div>


    @script
        <script>
            function formComponents() {
                return {
                    emailNotifications: true,
                    volume: 50,
                    price: 500,
                    brightness: 75,
                    tags: ['Design', 'Development', 'Marketing'],
                    newTag: '',
                    showPassword: false,
                    showConfirmPassword: false,
                    password: '',
                    confirmPassword: '',
                    passwordStrength: 0,
                    passwordsMatch: false,

                    init() {
                        // Inisialisasi jika diperlukan
                        console.log('Form components initialized');
                    },

                    validatePassword() {
                        let strength = 0;

                        // Minimal 8 karakter
                        if (this.password.length >= 8) strength += 1;

                        // Mengandung angka
                        if (/\d/.test(this.password)) strength += 1;

                        // Mengandung huruf besar dan kecil
                        if (/[a-z]/.test(this.password) && /[A-Z]/.test(this.password)) strength += 1;

                        this.passwordStrength = strength;
                        this.checkPasswordMatch();
                    },

                    checkPasswordMatch() {
                        this.passwordsMatch = this.password === this.confirmPassword && this.password.length > 0;
                    },

                    addTag() {
                        if (this.newTag.trim() !== '') {
                            this.tags.push(this.newTag.trim());
                            this.newTag = '';
                        }
                    },

                    removeTag(index) {
                        this.tags.splice(index, 1);
                    },

                    clearAllTags() {
                        this.tags = [];
                    },

                    handleBackspace(event) {
                        if (this.newTag === '' && this.tags.length > 0) {
                            this.removeTag(this.tags.length - 1);
                        }
                    }
                }
            }

            // Inisialisasi setelah Livewire selesai loading
            document.addEventListener('livewire:load', function() {
                Alpine.data('formComponents', formComponents);
            });
        </script>
    @endscripts
</div>

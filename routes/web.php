<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\GoogleController;
use App\Livewire\Admin\Page\Dashboard;
use App\Livewire\Admin\Page\KomponenTemplate;
use App\Livewire\Admin\Page\ManagemenPengguna;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\KerjasamaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\StrukturController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\SOPController;
use App\Http\Controllers\PostController;
use App\Livewire\Admin\Page\Profile;
use App\Livewire\Admin\Page\PartnerCrud;
use App\Livewire\Admin\Page\OrganizationCrud;
use App\Livewire\Admin\Page\BeritaCrud;
use App\Livewire\Admin\Page\GalleryCrud;
use App\Livewire\Admin\Page\VisiMisiCrud;
use App\Livewire\Admin\Page\SambutanCrud;
use App\Livewire\Admin\Page\LabKomputerCrud;
use App\Livewire\Admin\Page\LabBahasaCrud;
use App\Livewire\Admin\Page\LabPemerintahanCrud;
use App\Livewire\Admin\Page\PddiktiCrud;
use App\Livewire\Admin\Page\AgendaCrud;
use App\Livewire\Admin\Page\SopCrud;
use App\Livewire\Admin\Page\PanduanCrud;    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
// });
// Halaman publik
Route::get('/', [HomeController::class, 'index'])->name('home');

// profile
Route::get('/struktur', [StrukturController::class, 'index'])->name('struktur');

// Galeri Publik
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index'); // tampil semua tahun
Route::get('/galeri/{year}', [GaleriController::class, 'showYear'])->name('galeri.year'); // tampil event di tahun
Route::get('/galeri/{year}/{event}', [GaleriController::class, 'showEvent'])->name('galeri.event'); // tampil foto di event

// SOP
Route::get('/sop/{name}', [SOPController::class, 'show'])->name('sop.show');
// Route::get('/sop', [SOPController::class, 'index'])->name('sop.index');
// Route::get('/sop/lksi', [SOPController::class, 'lksi'])->name('sop.lksi');
// Route::get('/sop/pddikti', [SOPController::class, 'pddikti'])->name('sop.pddikti');
// Route::get('/sop/lab-bahasa', [SOPController::class, 'labBahasa'])->name('sop.lab-bahasa');
// Route::get('/sop/lab-pemerintahan', [SOPController::class, 'labPemerintahan'])->name('sop.lab-pemerintahan');

// Panduan
Route::get('/panduan/{name}', [PanduanController::class, 'index'])->name('panduan.show');
Route::get('/panduan/{divisi}/{slug}', [PanduanController::class, 'detail'])->name('panduan.detail');
Route::post('/panduan/{id}/comment', [PanduanController::class, 'storeComment'])->name('panduan.comment');
Route::post('/panduan/{id}/like', [PanduanController::class, 'like'])->name('panduan.like');

// routes/web.php
Route::get('/search-suggest', function () {
    $query = request('q');

    return \App\Models\Panduan::where('judul', 'like', "%$query%")
        ->limit(7)
        ->pluck('judul');
});

// --- Halaman utama (user) ---
Route::get('/kerjasama', [KerjasamaController::class, 'index'])->name('kerjasama');

// menu berita
//Route::get('/', [BeritaController::class, 'welcome'])->name('welcome');
// daftar berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
// detail berita
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

// route detail agenda
Route::get('/agenda/{id}', [AgendaController::class, 'show'])->name('agenda.show');

Route::get('/admin/organisasi', OrganizationCrud::class)
    ->name('admin.organisasi');

//Route::get('/berita/{id}', function ($id) {
//return view('pages.news.berita-detail');
//});

Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak/kirim', [KontakController::class, 'sendMail'])->name('kontak.kirim');

Route::get('/layanan/komputer', [LayananController::class, 'komputer'])->name('layanan.komputer');
Route::get('/layanan/bahasa', [LayananController::class, 'bahasa'])->name('layanan.bahasa');
Route::get('/layanan/pemerintahan', [LayananController::class, 'pemerintahan'])->name('layanan.pemerintahan');
Route::get('/layanan/pddikti', [LayananController::class, 'pddikti'])->name('layanan.pddikti');

// Google Auth
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Login Page
Route::get('/login/go-digital', Login::class)->name('login');
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');


// Dashboard
// Admin Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('admin.dashboard');
    Route::get('/berita', BeritaCrud::class)->name('admin.berita');
    Route::get('/galeri', GalleryCrud::class)->name('gallery');
    Route::get('/kerjasama', PartnerCrud::class)->name('admin.partner');
    Route::get('/komponen', KomponenTemplate::class)->name('admin.komponen-template');
    Route::get('/pengguna', ManagemenPengguna::class)->name('admin.pengguna');
    Route::get('/visi-misi', VisimisiCrud::class)->name('admin.visimisi');
    Route::get('/sambutan', SambutanCrud::class)->name('admin.sambutan');
    Route::get('/LabKomputer', LabKomputerCrud::class)->name('admin.lab-komputer');
    Route::get('/LabBahasa', LabBahasaCrud::class)->name('admin.lab-bahasa');
    Route::get('/LabPemerintahan', LabPemerintahanCrud::class)->name('admin.lab-pemerintahan');
    Route::get('/PDDIKTI', PddiktiCrud::class)->name('admin.pddikti');
    Route::get('/agenda', AgendaCrud::class)->name('admin.agenda');
    Route::get('/sop', SopCrud::class)->name('admin.sop');
    Route::get('/panduan', PanduanCrud::class)->name('admin.panduan');
    Route::get('/admin/profile', Profile::class)->name('admin.profile');
});
Route::post('/upload-image', function (Request $request) {
    if (!$request->hasFile('file')) {
        return response()->json(['error' => 'No file uploaded'], 422);
    }

    // Tentukan folder tujuan
    $folder = $request->input('folder', 'uploads'); // default 'uploads'
    $folder = Str::slug($folder); // biar aman dari karakter aneh

    // Simpan file ke folder yang ditentukan
    $path = $request->file('file')->store($folder, 'public');

    return response()->json(['location' => asset('storage/' . $path)]);
})->name('upload.image');





// Route::get('/', function () {
//     return view(view: 'welcome');
// })->name('welcome');

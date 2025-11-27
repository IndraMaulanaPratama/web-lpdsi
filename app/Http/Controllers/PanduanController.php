<?php

namespace App\Http\Controllers;

use App\Models\Panduan;
use App\Models\Divisi;
use App\Models\CategoryPanduan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PanduanController extends Controller
{
    public function index(Request $request, $divisi = null)
    {
        // 1. Ambil objek Divisi sekali di awal (untuk efisiensi)
        $div = null;
        if ($divisi) {
            $div = Divisi::where('name', $divisi)->first();
        }

        // QUERY UTAMA untuk PAGINASI ($data) - JANGAN DIUBAH
        $query = Panduan::with('divisi')
            ->withCount(['komentar', 'likes']);

        // ... Filter Search (Tetap sama)
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                    ->orWhere('isi', 'like', '%' . $request->search . '%');
            });
        }

        // ... Filter Category (Tetap sama)
        if ($request->has('category')) {
            $query->whereIn('category_panduan_id', $request->category);
        }

        // 🔥 Filter Query Utama berdasarkan objek $div
        if ($div) {
            $query->where('divisi_id', $div->id);
        }

        // Variabel PAGINATED yang akan digunakan untuk menampilkan daftar artikel
        $data = $query->paginate(9);
        
        // --- VARIABEL BARU TANPA PAGINASI DIMULAI DI SINI ---

        // ⭐️ VARIABEL BARU: Ambil SEMUA artikel yang sesuai dengan filter Divisi saat ini.
        // Variabel ini tidak dipengaruhi oleh filter Search, dan tidak menggunakan paginasi.
        $suggestionsQuery = Panduan::select('id', 'judul', 'slug', 'divisi_id', 'isi')
            ->with('divisi:id,name')
            // Terapkan filter Divisi yang sama
            ->when($div, function ($q) use ($div) {
                return $q->where('divisi_id', $div->id);
            });

        $suggestions = $suggestionsQuery->get()
            ->map(function ($item) {
                return [
                    'id'     => $item->id,
                    'judul'  => $item->judul,
                    'slug'   => $item->slug,
                    // Properti divisi penting untuk navigasi Alpine
                    'divisi' => optional($item->divisi)->name, 
                    'snippet' => Str::limit(strip_tags($item->isi), 100, '...'),
                    'content_raw' => Str::lower(strip_tags($item->isi)),
                    // 'konten' bisa dihilangkan jika hanya digunakan untuk suggestions
                ];
            });
        
        // --- VARIABEL BARU TANPA PAGINASI SELESAI DI SINI ---
        
        // ... (Logika Judul, Total Count, dan Categories tetap sama)
        
        $judul = $divisi
            ? 'Panduan ' . ucfirst($divisi)
            : 'Panduan Magang';

        // 2. Sinkronkan Total Count dengan Divisi (Opsional, bisa dihitung dari $suggestions->count())
        $totalCountDivisi = $suggestions->count(); 

        // 3. Perbaikan: Hitungan Kategori
        $categories = CategoryPanduan::withCount(['panduans' => function ($q) use ($div) {
            if ($div) {
                $q->where('divisi_id', $div->id);
            }
        }])->get();

        return view('pages.panduan.index', [
            'data' => $data, // Variabel Paginasi tetap ada
            'categories' => $categories, 
            'judul' => $judul,
            'totalCount' => $totalCountDivisi,
            'suggestions' => $suggestions, // Variabel non-paginasi (untuk Alpine)
        ]);
    }
    // 🔹 Halaman daftar panduan per divisi
//    public function indexjkjkjkjkjkj(Request $request, $divisi = null)
//     {
//         // 1. Ambil objek Divisi sekali di awal (untuk efisiensi)
//         $div = null;
//         if ($divisi) {
//             $div = Divisi::where('name', $divisi)->first();
//             // Optional: Jika $div tidak ditemukan, Anda bisa return abort(404);
//         }

//         $query = Panduan::with('divisi')
//             ->withCount(['komentar', 'likes']);

//         // ... Filter Search (Tetap sama)
//         if ($request->has('search')) {
//             $query->where(function ($q) use ($request) {
//                 $q->where('judul', 'like', '%' . $request->search . '%')
//                   ->orWhere('isi', 'like', '%' . $request->search . '%');
//             });
//         }

//         // ... Filter Category (Tetap sama)
//         if ($request->has('category')) {
//             $query->whereIn('category_panduan_id', $request->category);
//         }

//         // 🔥 Filter Query Utama berdasarkan objek $div yang sudah diambil
//         if ($div) {
//             $query->where('divisi_id', $div->id);
//         }

//         $data = $query->paginate(9);

//         $judul = $divisi
//             ? 'Panduan ' . ucfirst($divisi)
//             : 'Panduan Magang';

//         // 2. ⭐ Peningkatan: Sinkronkan Total Count dengan Divisi
//         $totalCountDivisi = Panduan::when($div, function ($q) use ($div) {
//             // Hanya hitung jika $div ada (yaitu, divisi_id-nya sama)
//             return $q->where('divisi_id', $div->id);
//         })->count();

//         // 3. AUTOFILL: Ambil semua artikel
//         $allArticles = Panduan::select('id', 'judul', 'isi', 'slug', 'divisi_id')
//             ->with('divisi:id,name')
//             // Tambahkan filter Divisi ke allArticles agar suggestion relevan
//             ->when($div, function ($q) use ($div) {
//                 return $q->where('divisi_id', $div->id);
//             })
//             ->get()
//             ->map(function ($item) {
//                 return [
//                     'id'     => $item->id,
//                     'judul'  => $item->judul,
//                     'slug'   => $item->slug,
//                     'konten' => Str::limit(strip_tags($item->isi), 300),
//                     'divisi' => optional($item->divisi)->name,
//                 ];
//             });
        
//         $suggestions = $allArticles;

//         // 4. ⭐ Perbaikan: Hitungan Kategori yang Efisien
//         // Gunakan objek $div yang sudah diambil, bukan mengambilnya lagi
//         $categories = CategoryPanduan::withCount(['panduans' => function ($q) use ($div) {
//             if ($div) {
//                 $q->where('divisi_id', $div->id);
//             }
//         }])->get();

//         return view('pages.panduan.index', [
//             'data' => $data,
//             'categories' => $categories, 
//             'judul' => $judul,
//             'totalCount' => $totalCountDivisi, // Menggunakan total yang difilter
//             'allArticles' => $allArticles,
//             'suggestions' => $suggestions,
//         ]);
//     }
    // 🔹 Halaman detail panduan
    public function detail($divisi, $slug)
    {
        $div = Divisi::where('name', $divisi)->firstOrFail();

        $panduan = Panduan::where('slug', $slug)
            ->where('divisi_id', $div->id)
            ->with('categoryPanduan')
            ->firstOrFail();

        return view('pages.panduan.detail', compact('panduan', 'div'));
    }
    
    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'komentar' => 'required|string|max:500',
        ]);

        $panduan = Panduan::findOrFail($id);

        $panduan->komentar()->create([
            'nama' => $request->nama,
            'isi' => $request->komentar,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim!');
    }

    public function like($id)
    {
        $panduan = Panduan::findOrFail($id);
        $panduan->increment('likes_count');
        return back();
    }
}

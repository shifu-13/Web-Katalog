<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KategoriRequest;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar semua kategori bahan bangunan.
     * Menggunakan pagination dan penghitungan relasi produk (withCount) untuk efisiensi kueri.
     */
    public function index(Request $request): View
    {
        $search = $request->query('q');

        $kategoris = Kategori::withCount('produks')
            ->when($search, function ($query, $search) {
                // Sanitasi query pencarian nama kategori
                return $query->where('nama', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.kategori.index', compact('kategoris', 'search'));
    }

    /**
     * Menampilkan formulir tambah kategori baru.
     */
    public function create(): View
    {
        return view('admin.kategori.create');
    }

    /**
     * Menyimpan kategori baru ke database.
     * Input telah divalidasi dan diamankan oleh KategoriRequest.
     */
    public function store(KategoriRequest $request): RedirectResponse
    {
        Kategori::create($request->validated());

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir edit kategori.
     * Menggunakan Route Model Binding untuk resolusi model yang aman.
     */
    public function edit(Kategori $kategori): View
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    /**
     * Memperbarui data kategori yang sudah ada.
     */
    public function update(KategoriRequest $request, Kategori $kategori): RedirectResponse
    {
        $kategori->update($request->validated());

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus kategori secara aman.
     * Proteksi integritas data: memblokir penghapusan jika kategori masih memiliki produk tertaut
     * untuk mencegah kehilangan data inventaris yang tidak disengaja.
     */
    public function destroy(Kategori $kategori): RedirectResponse
    {
        // Proteksi integritas data bisnis
        if ($kategori->produks()->exists()) {
            return redirect()->route('admin.kategori.index')
                ->with('error', "Kategori '{$kategori->nama}' tidak dapat dihapus karena masih memiliki produk terkait.");
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}

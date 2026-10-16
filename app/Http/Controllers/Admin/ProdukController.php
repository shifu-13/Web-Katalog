<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProdukRequest;
use App\Http\Requests\Admin\UpdateProdukRequest;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar produk dengan filter dinamis dan paginasi.
     * Menggunakan Eager Loading ('kategori', 'merek') untuk mencegah N+1 query problem.
     */
    public function index(Request $request): View
    {
        $search     = $request->query('q');
        $kategoriId = $request->query('kategori_id');
        $merekId    = $request->query('merek_id');
        $statusStok = $request->query('status_stok');

        $produks = Produk::with(['kategori', 'merek'])
            ->when($search, function ($query, $search) {
                // Pencarian aman berdasarkan nama produk atau deskripsi
                return $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->when($kategoriId, function ($query, $kategoriId) {
                return $query->where('kategori_id', $kategoriId);
            })
            ->when($merekId, function ($query, $merekId) {
                return $query->where('merek_id', $merekId);
            })
            ->when($statusStok !== null && $statusStok !== '', function ($query) use ($statusStok) {
                return $query->where('status_stok', (bool) $statusStok);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Data master untuk filter dropdown
        $kategoris = Kategori::orderBy('nama')->get();
        $mereks    = Merek::orderBy('nama')->get();

        return view('admin.produk.index', compact(
            'produks',
            'kategoris',
            'mereks',
            'search',
            'kategoriId',
            'merekId',
            'statusStok'
        ));
    }

    /**
     * Menampilkan formulir penambahan produk baru.
     * Menyediakan data kategori dan merek untuk elemen <select> dropdown.
     */
    public function create(): View
    {
        $kategoris = Kategori::orderBy('nama')->get();
        $mereks    = Merek::orderBy('nama')->get();

        return view('admin.produk.create', compact('kategoris', 'mereks'));
    }

    /**
     * Menyimpan produk baru dan mengunggah gambar secara aman.
     *
     * Keamanan File Upload:
     * - Validasi tipe MIME dan batasan ukuran dilakukan di StoreProdukRequest.
     * - File disimpan ke disk 'public' dalam subfolder 'produk'.
     * - Laravel secara otomatis meng-hash nama file menjadi string acak unik
     *   untuk mencegah Directory Traversal dan Remote Code Execution (RCE).
     */
    public function store(StoreProdukRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // 1. Dynamic Category & Brand
        $validated['kategori_id'] = $this->resolveKategoriId($validated['kategori_id']);
        $validated['merek_id']    = $this->resolveMerekId($validated['merek_id']);

        // 2. Multiple File Upload
        $gambarPaths = [];
        if ($request->hasFile('gambar')) {
            $files = $request->file('gambar');
            if (!is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $gambarPaths[] = $file->store('produk', 'public');
                }
            }
        }
        $validated['gambar'] = json_encode($gambarPaths);

        Produk::create($validated);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk bahan bangunan berhasil ditambahkan ke katalog.');
    }

    /**
     * Menampilkan formulir edit produk dengan pre-filled data.
     */
    public function edit(Produk $produk): View
    {
        $kategoris = Kategori::orderBy('nama')->get();
        $mereks    = Merek::orderBy('nama')->get();

        return view('admin.produk.edit', compact('produk', 'kategoris', 'mereks'));
    }

    /**
     * Memperbarui informasi produk dan mengelola pergantian file gambar.
     */
    public function update(UpdateProdukRequest $request, Produk $produk): RedirectResponse
    {
        $validated = $request->validated();

        // 1. Dynamic Category & Brand
        $validated['kategori_id'] = $this->resolveKategoriId($validated['kategori_id']);
        $validated['merek_id']    = $this->resolveMerekId($validated['merek_id']);

        // 2. Multiple File Upload
        if ($request->hasFile('gambar')) {
            // Hapus file fisik lama jika ada di disk public lokal
            $oldImages = $produk->gambar;
            if (is_array($oldImages)) {
                foreach ($oldImages as $oldFile) {
                    if ($oldFile && !str_starts_with($oldFile, 'http') && Storage::disk('public')->exists($oldFile)) {
                        Storage::disk('public')->delete($oldFile);
                    }
                }
            }

            // Simpan berkas baru
            $files = $request->file('gambar');
            if (!is_array($files)) {
                $files = [$files];
            }

            $gambarPaths = [];
            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $gambarPaths[] = $file->store('produk', 'public');
                }
            }
            $validated['gambar'] = json_encode($gambarPaths);
        } else {
            // Pertahankan gambar lama jika tidak mengunggah gambar baru
            unset($validated['gambar']);
        }

        $produk->update($validated);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Data produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk dan membersihkan berkas gambar terkait dari server.
     */
    public function destroy(Produk $produk): RedirectResponse
    {
        // Bersihkan seluruh berkas gambar fisik dari public storage
        $images = $produk->gambar;
        if (is_array($images)) {
            foreach ($images as $file) {
                if ($file && !str_starts_with($file, 'http') && Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk beserta berkas gambarnya berhasil dihapus.');
    }

    /**
     * Mengubah status pin (sematkan produk di posisi teratas katalog).
     */
    public function togglePin(Produk $produk): RedirectResponse
    {
        $produk->update([
            'is_pinned' => !$produk->is_pinned,
        ]);

        $statusText = $produk->is_pinned ? 'disematkan di posisi teratas katalog' : 'dilepas dari sematan teratas';

        return back()->with('success', "Status pin produk '{$produk->nama}' berhasil {$statusText}.");
    }

    /**
     * Cari ID kategori berdasarkan ID atau nama, buat baru otomatis jika belum ada.
     */
    protected function resolveKategoriId(string|int $input): int
    {
        $input = trim((string) $input);

        if (is_numeric($input)) {
            $kategori = Kategori::find($input);
            if ($kategori) {
                return $kategori->id;
            }
        }

        $kategori = Kategori::firstOrCreate(['nama' => $input]);
        return $kategori->id;
    }

    /**
     * Cari ID merek berdasarkan ID atau nama, buat baru otomatis jika belum ada.
     */
    protected function resolveMerekId(string|int $input): int
    {
        $input = trim((string) $input);

        if (is_numeric($input)) {
            $merek = Merek::find($input);
            if ($merek) {
                return $merek->id;
            }
        }

        $merek = Merek::firstOrCreate(['nama' => $input]);
        return $merek->id;
    }
}

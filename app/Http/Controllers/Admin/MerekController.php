<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MerekRequest;
use App\Models\Merek;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MerekController extends Controller
{
    /**
     * Menampilkan daftar semua merek bahan bangunan.
     * Menggunakan pagination dan withCount produks untuk memantau pemakaian merek.
     */
    public function index(Request $request): View
    {
        $search = $request->query('q');

        $mereks = Merek::withCount('produks')
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.merek.index', compact('mereks', 'search'));
    }

    /**
     * Menampilkan formulir tambah merek baru.
     */
    public function create(): View
    {
        return view('admin.merek.create');
    }

    /**
     * Menyimpan merek baru ke dalam database setelah lolos validasi MerekRequest.
     */
    public function store(MerekRequest $request): RedirectResponse
    {
        Merek::create($request->validated());

        return redirect()->route('admin.merek.index')
            ->with('success', 'Merek baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir edit merek.
     */
    public function edit(Merek $merek): View
    {
        return view('admin.merek.edit', compact('merek'));
    }

    /**
     * Memperbarui informasi merek di database.
     */
    public function update(MerekRequest $request, Merek $merek): RedirectResponse
    {
        $merek->update($request->validated());

        return redirect()->route('admin.merek.index')
            ->with('success', 'Merek berhasil diperbarui.');
    }

    /**
     * Menghapus merek dengan perlindungan integritas relasi.
     * Mencegah 'orphaned products' atau penghapusan data produk yang tidak disengaja.
     */
    public function destroy(Merek $merek): RedirectResponse
    {
        // Proteksi integritas relasi
        if ($merek->produks()->exists()) {
            return redirect()->route('admin.merek.index')
                ->with('error', "Merek '{$merek->nama}' tidak dapat dihapus karena masih digunakan pada data produk.");
        }

        $merek->delete();

        return redirect()->route('admin.merek.index')
            ->with('success', 'Merek berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Produk;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard utama admin dengan ringkasan statistik toko bahan bangunan.
     * Mengambil metrik agregat secara efisien untuk overview operasional.
     */
    public function dashboard(): View
    {
        // Menghitung metrik ringkasan inventaris
        $totalProduk    = Produk::count();
        $totalKategori  = Kategori::count();
        $totalMerek     = Merek::count();
        $produkHabis    = Produk::where('status_stok', false)->count();
        $produkTersedia = Produk::where('status_stok', true)->count();

        // 5 produk terbaru untuk pemantauan aktivitas terkini
        $produkTerbaru = Produk::with(['kategori', 'merek'])
            ->latest()
            ->take(5)
            ->get();

        // Produk dengan status stok habis yang memerlukan perhatian admin
        $daftarStokHabis = Produk::with(['kategori', 'merek'])
            ->where('status_stok', false)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalKategori',
            'totalMerek',
            'produkHabis',
            'produkTersedia',
            'produkTerbaru',
            'daftarStokHabis'
        ));
    }
}

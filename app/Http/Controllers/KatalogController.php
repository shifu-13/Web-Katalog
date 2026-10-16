<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KatalogController extends Controller
{
    /**
     * Tampilkan halaman katalog satu halaman (Single-Page Catalog).
     */
    public function index(Request $request): View
    {
        $search = $request->query('q');

        $query = Produk::with(['kategori', 'merek']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhereHas('kategori', fn($sub) => $sub->where('nama', 'like', "%{$search}%"))
                  ->orWhereHas('merek', fn($sub) => $sub->where('nama', 'like', "%{$search}%"));
            });
        }

        $produks = $query->orderByDesc('is_pinned')->latest()->paginate(12)->withQueryString();
        $kategoris = Kategori::orderBy('nama', 'asc')->get();

        return view('katalog', [
            'produks' => $produks,
            'kategoris' => $kategoris,
            'initialSearch' => $search ?? '',
        ]);
    }

    /**
     * Endpoint JSON untuk Modal Detail Produk (Master-Detail AJAX).
     */
    public function show(Produk $produk): JsonResponse
    {
        $produk->load(['kategori', 'merek']);

        $nomorWa = '6281234567890';
        $isCustomPrice = empty($produk->harga) || (float) $produk->harga <= 0;
        $hargaFormatted = $isCustomPrice
            ? 'Harga Custom / Hubungi Admin'
            : 'Rp ' . number_format((float) $produk->harga, 0, ',', '.');
        $statusTeks = $produk->status_stok ? 'Tersedia' : 'Habis / Indent';

        $pesanWa = "Halo Admin Berkah Bangunan, saya tertarik dengan produk *{$produk->nama}*. Apakah bisa dibantu informasi lebih lanjut mengenai ketersediaan dan harganya?";
        $whatsappUrl = 'https://wa.me/' . $nomorWa . '?text=' . rawurlencode($pesanWa);

        return response()->json([
            'id' => $produk->id,
            'nama' => $produk->nama,
            'kategori' => $produk->kategori->nama ?? '-',
            'merek' => $produk->merek->nama ?? '-',
            'satuan' => $produk->satuan,
            'harga' => $produk->harga !== null ? (float) $produk->harga : null,
            'harga_formatted' => $hargaFormatted,
            'is_custom_price' => $isCustomPrice,
            'status_stok' => (bool) $produk->status_stok,
            'deskripsi' => $produk->deskripsi,
            'gambar' => $produk->gambar_urls,
            'gambar_utama' => $produk->gambar_url,
            'whatsapp_url' => $whatsappUrl,
        ]);
    }
}

<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProdukRequest extends FormRequest
{
    /**
     * Otorisasi request.
     * Hanya Admin terotentikasi yang diizinkan memperbarui data produk.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Aturan validasi ketat untuk pembaruan produk.
     * Gambar bersifat opsional (nullable); jika diunggah ulang, wajib memenuhi standar keamanan.
     */
    public function rules(): array
    {
        return [
            'nama'        => ['required', 'string', 'max:255'],
            'kategori_id' => ['required', 'string', 'max:255'],
            'merek_id'    => ['required', 'string', 'max:255'],
            'satuan'      => ['required', 'string', 'max:50'],
            'harga'       => ['nullable', 'numeric', 'min:0'],
            'status_stok' => ['required', 'in:0,1'],
            'deskripsi'   => ['required', 'string'],
            // Gambar bersifat opsional saat edit. Bila disertakan, validasi array gambar maksimal 10 file
            'gambar'      => ['nullable', 'array', 'max:10'],
            'gambar.*'    => ['file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    /**
     * Pesan validasi kustom dalam Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'nama.required'        => 'Nama produk wajib diisi.',
            'nama.max'             => 'Nama produk maksimal 255 karakter.',
            'kategori_id.required' => 'Kategori produk wajib diisi atau dipilih.',
            'merek_id.required'    => 'Merek produk wajib diisi atau dipilih.',
            'satuan.required'      => 'Satuan barang wajib diisi.',
            'harga.numeric'        => 'Harga produk harus berupa angka nominal yang valid.',
            'harga.min'            => 'Harga produk tidak boleh bernilai negatif.',
            'status_stok.required' => 'Status ketersediaan stok wajib dipilih.',
            'status_stok.in'       => 'Pilihan status stok tidak valid.',
            'deskripsi.required'   => 'Deskripsi spesifikasi produk wajib diisi.',
            'gambar.array'         => 'Berkas gambar harus berupa daftar foto.',
            'gambar.max'           => 'Maksimal 10 foto produk yang diperbolehkan.',
            'gambar.*.image'       => 'Berkas baru harus berupa gambar valid.',
            'gambar.*.mimes'       => 'Format gambar hanya diperbolehkan: JPG, JPEG, PNG, atau WEBP.',
            'gambar.*.max'         => 'Ukuran masing-masing foto maksimal 2048 KB (2 Megabyte).',
        ];
    }
}

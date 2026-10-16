<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdukRequest extends FormRequest
{
    /**
     * Otorisasi request.
     * Memastikan hanya Admin terotentikasi yang diizinkan menambah produk.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Aturan validasi ketat untuk pembuatan produk baru.
     * Mengamankan tipe file gambar, batasan ukuran, dan validitas relasi foreign key.
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
            // Validasi file upload: array gambar maksimal 10 file, masing-masing max 2048 KB
            'gambar'      => ['required', 'array', 'min:1', 'max:10'],
            'gambar.*'    => ['file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    /**
     * Pesan validasi kustom dalam Bahasa Indonesia untuk kejelasan informasi admin.
     */
    public function messages(): array
    {
        return [
            'nama.required'        => 'Nama produk wajib diisi.',
            'nama.max'             => 'Nama produk maksimal 255 karakter.',
            'kategori_id.required' => 'Kategori produk wajib diisi atau dipilih.',
            'merek_id.required'    => 'Merek produk wajib diisi atau dipilih.',
            'satuan.required'      => 'Satuan barang (cth: Zak, Batang, Dus) wajib diisi.',
            'harga.numeric'        => 'Harga produk harus berupa angka nominal yang valid.',
            'harga.min'            => 'Harga produk tidak boleh bernilai negatif.',
            'status_stok.required' => 'Status ketersediaan stok wajib dipilih.',
            'status_stok.in'       => 'Pilihan status stok tidak valid.',
            'deskripsi.required'   => 'Deskripsi spesifikasi produk wajib diisi.',
            'gambar.required'      => 'Foto produk wajib diunggah minimal 1.',
            'gambar.array'         => 'Foto produk harus berupa daftar berkas gambar.',
            'gambar.min'           => 'Unggah minimal 1 foto produk.',
            'gambar.max'           => 'Maksimal 10 foto produk yang diperbolehkan.',
            'gambar.*.image'       => 'Setiap berkas harus berupa gambar valid.',
            'gambar.*.mimes'       => 'Format gambar hanya diperbolehkan: JPG, JPEG, PNG, atau WEBP.',
            'gambar.*.max'         => 'Ukuran masing-masing foto maksimal 2048 KB (2 Megabyte).',
        ];
    }
}

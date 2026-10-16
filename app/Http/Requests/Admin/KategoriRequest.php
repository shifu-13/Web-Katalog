<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KategoriRequest extends FormRequest
{
    /**
     * Otorisasi request.
     * Memastikan hanya user terotentikasi (Admin) yang dapat mengeksekusi aksi ini.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Aturan validasi ketat untuk data Kategori.
     * Mencegah duplikasi nama kategori dengan mengabaikan ID saat update.
     */
    public function rules(): array
    {
        // Mendapatkan parameter kategori dari route jika sedang dalam proses update
        $kategoriId = $this->route('kategori')?->id ?? $this->route('kategori');

        return [
            'nama' => [
                'required',
                'string',
                'max:100',
                Rule::unique('kategori', 'nama')->ignore($kategoriId),
            ],
        ];
    }

    /**
     * Pesan validasi kustom dalam Bahasa Indonesia untuk UX yang ramah.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.string'   => 'Nama kategori harus berupa teks yang valid.',
            'nama.max'      => 'Nama kategori maksimal 100 karakter.',
            'nama.unique'   => 'Kategori dengan nama tersebut sudah terdaftar.',
        ];
    }
}

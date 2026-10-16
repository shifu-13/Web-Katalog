<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MerekRequest extends FormRequest
{
    /**
     * Otorisasi request.
     * Hanya pengguna terotentikasi yang diizinkan mengelola merek.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Aturan validasi ketat untuk Merek.
     * Rule unique memastikan nama merek tidak berulang di database.
     */
    public function rules(): array
    {
        // Mendapatkan parameter merek dari route jika sedang update
        $merekId = $this->route('merek')?->id ?? $this->route('merek');

        return [
            'nama' => [
                'required',
                'string',
                'max:100',
                Rule::unique('merek', 'nama')->ignore($merekId),
            ],
        ];
    }

    /**
     * Pesan validasi kustom dalam Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama merek wajib diisi.',
            'nama.string'   => 'Nama merek harus berupa teks yang valid.',
            'nama.max'      => 'Nama merek maksimal 100 karakter.',
            'nama.unique'   => 'Merek dengan nama tersebut sudah terdaftar.',
        ];
    }
}

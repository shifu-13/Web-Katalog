<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'nama',
        'kategori_id',
        'merek_id',
        'satuan',
        'harga',
        'status_stok',
        'deskripsi',
        'is_pinned',
        'gambar',
    ];

    protected $casts = [
        'status_stok' => 'boolean',
        'is_pinned' => 'boolean',
        'harga' => 'decimal:2',
        'gambar' => 'array',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function merek(): BelongsTo
    {
        return $this->belongsTo(Merek::class, 'merek_id');
    }

    /**
     * Accessor untuk memastikan gambar selalu mengembalikan array.
     */
    public function getGambarAttribute($value): array
    {
        if (empty($value)) {
            return [];
        }

        if (is_array($value)) {
            return $value;
        }

        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        return [$value];
    }

    /**
     * Mutator untuk menyimpan array gambar sebagai JSON.
     */
    public function setGambarAttribute($value): void
    {
        if (is_array($value)) {
            $this->attributes['gambar'] = json_encode(array_values($value));
        } else {
            $this->attributes['gambar'] = $value;
        }
    }

    /**
     * Accessor untuk mendapatkan daftar semua URL lengkap gambar produk.
     */
    public function getGambarUrlsAttribute(): array
    {
        $images = $this->gambar;

        if (empty($images)) {
            return [asset('images/placeholder.png')];
        }

        $urls = [];
        foreach ($images as $img) {
            if (empty($img)) {
                continue;
            }

            if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                $urls[] = $img;
            } else {
                $urls[] = asset('storage/' . $img);
            }
        }

        return !empty($urls) ? $urls : [asset('images/placeholder.png')];
    }

    /**
     * Accessor untuk mendapatkan URL gambar utama (foto pertama) produk.
     * Mendukung URL eksternal (seeder) maupun file yang diunggah ke storage public.
     */
    public function getGambarUrlAttribute(): string
    {
        $urls = $this->gambar_urls;
        return $urls[0] ?? asset('images/placeholder.png');
    }
}

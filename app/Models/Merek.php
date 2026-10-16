<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Merek extends Model
{
    use HasFactory;

    protected $table = 'merek';

    protected $fillable = [
        'nama',
    ];

    public function produks(): HasMany
    {
        return $this->hasMany(Produk::class, 'merek_id');
    }
}

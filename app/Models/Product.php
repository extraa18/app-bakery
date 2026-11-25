<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'kode', 'nama', 'harga', 'stok', 'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    // Produk yang boleh dijual di halaman kasir
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('aktif', true);
    }

    // Produk yang stoknya hampir habis (untuk dashboard)
    public function scopeStokMenipis(Builder $query, int $batas = 5): Builder
    {
        return $query->where('stok', '<=', $batas);
    }
}
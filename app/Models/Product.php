<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    public const BATAS_STOK_MENIPIS = 5;

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

    public function isStokMenipis(): bool
{
    return $this->stok <= self::BATAS_STOK_MENIPIS;
}

// Dipakai di Blade sebagai $product->harga_rupiah
protected function hargaRupiah(): Attribute
{
    return Attribute::get(fn () => 'Rp '.number_format($this->harga, 0, ',', '.'));
}

    // Produk yang boleh dijual di halaman kasir
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('aktif', true);
    }

    // Produk yang stoknya hampir habis (untuk dashboard)
public function scopeStokMenipis(Builder $query, int $batas = self::BATAS_STOK_MENIPIS): Builder
{
    return $query->where('stok', '<=', $batas);
}
}
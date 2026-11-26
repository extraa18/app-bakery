<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    /**
     * @param  array<int, array{product_id: int|string, qty: int|string}>  $items
     */
    public function checkout(array $items, int $bayar, int $userId): Sale
    {
        // Gabungkan item dengan product_id yang sama: [product_id => total qty]
        $qtyPerProduk = collect($items)
            ->groupBy('product_id')
            ->map(fn ($rows) => (int) $rows->sum('qty'));

        return DB::transaction(function () use ($qtyPerProduk, $bayar, $userId) {
            // Kunci baris produk selama transaksi berjalan, urut berdasarkan id
            $products = Product::whereIn('id', $qtyPerProduk->keys())
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $baris = [];
            $total = 0;

            foreach ($qtyPerProduk as $productId => $qty) {
                $product = $products->get($productId);

                if (! $product) {
                    throw ValidationException::withMessages([
                        'items' => 'Ada produk yang tidak ditemukan.',
                    ]);
                }

                if (! $product->aktif) {
                    throw ValidationException::withMessages([
                        'items' => "Produk \"{$product->nama}\" sedang nonaktif.",
                    ]);
                }

                if ($product->stok < $qty) {
                    throw ValidationException::withMessages([
                        'items' => "Stok \"{$product->nama}\" tidak cukup (tersisa {$product->stok}, diminta {$qty}).",
                    ]);
                }

                // Harga SELALU dari database, bukan dari input browser
                $subtotal = $product->harga * $qty;
                $total += $subtotal;

                $baris[] = ['product' => $product, 'qty' => $qty, 'subtotal' => $subtotal];
            }

            if ($bayar < $total) {
                throw ValidationException::withMessages([
                    'bayar' => 'Pembayaran kurang. Total Rp '.number_format($total, 0, ',', '.')
                        .', dibayar Rp '.number_format($bayar, 0, ',', '.').'.',
                ]);
            }

            $sale = Sale::create([
                'nomor_struk' => 'TMP-'.Str::random(20),
                'user_id' => $userId,
                'total' => $total,
                'bayar' => $bayar,
                'kembalian' => $bayar - $total,
            ]);

            // Nomor struk dibentuk dari ID yang dijamin unik oleh database
            $sale->update([
                'nomor_struk' => sprintf('TRX-%s-%05d', now()->format('Ymd'), $sale->id),
            ]);

            foreach ($baris as $row) {
                $sale->items()->create([
                    'product_id' => $row['product']->id,
                    'qty' => $row['qty'],
                    'harga_satuan' => $row['product']->harga,
                    'subtotal' => $row['subtotal'],
                ]);

                $row['product']->decrement('stok', $row['qty']);
            }

            return $sale;
        });
    }
}
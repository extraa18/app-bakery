<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Product;
use App\Services\CheckoutService;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::aktif()
            ->with('category')
            ->orderBy('nama')
            ->get();

        return view('pos.index', compact('products'));
    }

    public function store(CheckoutRequest $request, CheckoutService $checkout)
    {
        $sale = $checkout->checkout(
            $request->validated('items'),
            (int) $request->validated('bayar'),
            auth()->id()
        );

        // Sementara kembali ke halaman kasir. Di Langkah 10 diganti redirect ke halaman struk.
        return redirect()->route('pos.index')
            ->with('success', "Transaksi {$sale->nomor_struk} berhasil. Kembalian Rp ".number_format($sale->kembalian, 0, ',', '.').'.');
    }
}
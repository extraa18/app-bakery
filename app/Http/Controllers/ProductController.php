<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->query('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('kode', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('nama_kategori')->get();

        return view('products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        return redirect()->route('products.index')
            ->with('success', "Produk \"{$product->nama}\" berhasil ditambahkan.");
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('nama_kategori')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()->route('products.index')
            ->with('success', "Produk \"{$product->nama}\" berhasil diperbarui.");
    }

    public function destroy(Product $product)
    {
        if ($product->saleItems()->exists()) {
            return redirect()->route('products.index')
                ->with('error', "Produk \"{$product->nama}\" sudah pernah terjual, jadi tidak bisa dihapus. Nonaktifkan saja lewat menu Edit.");
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
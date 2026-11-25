@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <h1>Daftar Produk</h1>

    <p><a href="{{ route('products.create') }}" class="btn">+ Tambah Produk</a></p>

    <form action="{{ route('products.index') }}" method="GET" style="margin-top: 16px;">
        <input type="text" name="search" placeholder="Cari nama atau kode produk..." value="{{ request('search') }}" style="max-width: 320px;">
        <button type="submit" class="btn">Cari</button>
        @if (request('search'))
            <a href="{{ route('products.index') }}">Reset</a>
        @endif
    </form>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->kode }}</td>
                    <td>{{ $product->nama }}</td>
                    <td>{{ $product->category->nama_kategori }}</td>
                    <td>{{ $product->harga_rupiah }}</td>
                    <td>
                        {{ $product->stok }}
                        @if ($product->stok == 0)
                            <span class="badge-stok">Habis</span>
                        @elseif ($product->isStokMenipis())
                            <span class="badge-stok">Menipis</span>
                        @endif
                    </td>
                    <td>
                        @if ($product->aktif)
                            <span class="badge-aktif">Aktif</span>
                        @else
                            <span class="badge-nonaktif">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}">Edit</a>
                        |
                        <form class="inline" action="{{ route('products.destroy', $product) }}" method="POST"
                              onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Tidak ada produk yang cocok.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $products->links() }}
@endsection
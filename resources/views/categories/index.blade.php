@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
    <h1>Daftar Kategori</h1>

    <p><a href="{{ route('categories.create') }}" class="btn">+ Tambah Kategori</a></p>

    <table>
        <thead>
            <tr>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah Produk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->nama_kategori }}</td>
                    <td>{{ $category->deskripsi ?? '-' }}</td>
                    <td>{{ $category->products_count }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}">Edit</a>
                        |
                        <form class="inline" action="{{ route('categories.destroy', $category) }}" method="POST"
                              onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $categories->links() }}
@endsection
@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <p><a href="{{ route('products.index') }}">&larr; Kembali ke daftar</a></p>

    <h1>Tambah Produk</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        @include('products._form', ['product' => null, 'tombol' => 'Simpan'])
    </form>
@endsection
@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <p><a href="{{ route('products.index') }}">&larr; Kembali ke daftar</a></p>

    <h1>Edit Produk</h1>

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        @include('products._form', ['tombol' => 'Perbarui'])
    </form>
@endsection
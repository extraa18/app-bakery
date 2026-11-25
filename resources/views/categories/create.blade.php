@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <p><a href="{{ route('categories.index') }}">&larr; Kembali ke daftar</a></p>

    <h1>Tambah Kategori</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        @include('categories._form', ['category' => null, 'tombol' => 'Simpan'])
    </form>
@endsection
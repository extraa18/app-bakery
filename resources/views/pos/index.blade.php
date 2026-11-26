@extends('layouts.app')

@section('title', 'Kasir (form uji)')

@section('content')
    <h1>Kasir (form uji sementara)</h1>
    <p><em>Form ini hanya untuk menguji backend checkout. Isi ketiga baris produk, boleh memilih produk yang sama.</em></p>

    @if ($errors->any())
        <div class="alert-error">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pos.store') }}" method="POST">
        @csrf

        @for ($i = 0; $i < 3; $i++)
            <label>Produk {{ $i + 1 }}</label>
            <select name="items[{{ $i }}][product_id]">
                <option value="">-- pilih produk --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->nama }} ({{ $product->harga_rupiah }}, stok {{ $product->stok }})
                    </option>
                @endforeach
            </select>
            <input type="number" name="items[{{ $i }}][qty]" min="1" value="1" style="margin-top: 6px;">
        @endfor

        <label for="bayar">Bayar (Rp)</label>
        <input type="number" name="bayar" id="bayar" min="0" value="{{ old('bayar') }}">

        <button type="submit" class="btn" style="margin-top: 20px;">Bayar</button>
    </form>
@endsection
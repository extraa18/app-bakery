<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.qty' => 'required|integer|min:1|max:1000',
            'bayar' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Keranjang masih kosong.',
            'items.min' => 'Keranjang masih kosong.',
            'items.*.product_id.required' => 'Ada produk di keranjang yang tidak valid.',
            'items.*.product_id.exists' => 'Ada produk di keranjang yang tidak ditemukan.',
            'items.*.qty.required' => 'Jumlah produk wajib diisi.',
            'items.*.qty.integer' => 'Jumlah produk harus berupa angka bulat.',
            'items.*.qty.min' => 'Jumlah produk minimal 1.',
            'items.*.qty.max' => 'Jumlah produk maksimal 1000 per item.',
            'bayar.required' => 'Nominal bayar wajib diisi.',
            'bayar.integer' => 'Nominal bayar harus berupa angka bulat.',
        ];
    }
}
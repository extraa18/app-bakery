<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|integer|exists:categories,id',
            'kode' => [
                'required', 'string', 'max:20',
                Rule::unique('products', 'kode')->ignore($this->route('product')),
            ],
            'nama' => 'required|string|max:150',
            'harga' => 'required|integer|min:1|max:10000000',
            'stok' => 'required|integer|min:0|max:100000',
            'aktif' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'kode.required' => 'Kode produk wajib diisi.',
            'kode.max' => 'Kode produk maksimal 20 karakter.',
            'kode.unique' => 'Kode produk ini sudah dipakai.',
            'nama.required' => 'Nama produk wajib diisi.',
            'nama.max' => 'Nama produk maksimal 150 karakter.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa angka bulat (tanpa titik atau koma).',
            'harga.min' => 'Harga minimal Rp 1.',
            'harga.max' => 'Harga maksimal Rp 10.000.000.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
            'stok.max' => 'Stok maksimal 100.000.',
            'aktif.required' => 'Status produk wajib diisi.',
        ];
    }
}
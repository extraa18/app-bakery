<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = Category::pluck('id', 'nama_kategori');

        // [kategori, kode, nama, harga (rupiah), stok, aktif]
        $produk = [
            ['Roti Manis', 'RM-001', 'Roti Cokelat', 6000, 25, true],
            ['Roti Manis', 'RM-002', 'Roti Keju', 7000, 20, true],
            ['Roti Manis', 'RM-003', 'Roti Sosis', 8000, 18, true],
            ['Roti Manis', 'RM-004', 'Roti Srikaya', 6500, 3, true],
            ['Roti Manis', 'RM-005', 'Donat Gula', 5000, 30, true],
            ['Roti Manis', 'RM-006', 'Roti Musiman Durian', 12000, 6, false],

            ['Roti Tawar', 'RT-001', 'Roti Tawar Putih', 16000, 12, true],
            ['Roti Tawar', 'RT-002', 'Roti Tawar Gandum', 20000, 10, true],
            ['Roti Tawar', 'RT-003', 'Roti Tawar Susu', 18000, 2, true],

            ['Kue', 'KU-001', 'Bolu Pandan', 12000, 15, true],
            ['Kue', 'KU-002', 'Brownies Cokelat', 15000, 14, true],
            ['Kue', 'KU-003', 'Kue Lapis', 3000, 40, true],
            ['Kue', 'KU-004', 'Bolu Gulung Cokelat', 25000, 8, true],
            ['Kue', 'KU-005', 'Kue Sus Vla', 6000, 0, true],

            ['Pastry', 'PS-001', 'Croissant Original', 15000, 12, true],
            ['Pastry', 'PS-002', 'Pain au Chocolat', 18000, 10, true],
            ['Pastry', 'PS-003', 'Danish Keju', 17000, 9, true],
            ['Pastry', 'PS-004', 'Pie Susu', 8000, 11, true],

            ['Minuman', 'MN-001', 'Es Teh Manis', 5000, 50, true],
            ['Minuman', 'MN-002', 'Kopi Susu', 15000, 30, true],
            ['Minuman', 'MN-003', 'Cokelat Panas', 14000, 25, true],
            ['Minuman', 'MN-004', 'Air Mineral', 4000, 60, true],
        ];

        foreach ($produk as [$namaKategori, $kode, $nama, $harga, $stok, $aktif]) {
            Product::updateOrCreate(
                ['kode' => $kode],
                [
                    'category_id' => $kategori[$namaKategori],
                    'nama' => $nama,
                    'harga' => $harga,
                    'stok' => $stok,
                    'aktif' => $aktif,
                ]
            );
        }
    }
}
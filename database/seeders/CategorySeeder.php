<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Roti Manis', 'deskripsi' => 'Roti isi atau bertabur topping manis, seperti cokelat, keju, dan srikaya.'],
            ['nama_kategori' => 'Roti Tawar', 'deskripsi' => 'Roti tawar loaf utuh untuk sarapan dan sandwich.'],
            ['nama_kategori' => 'Kue', 'deskripsi' => 'Bolu, brownies, kue lapis, dan kue basah lainnya.'],
            ['nama_kategori' => 'Pastry', 'deskripsi' => 'Croissant, danish, dan pastry berlapis mentega.'],
            ['nama_kategori' => 'Minuman', 'deskripsi' => 'Minuman dingin dan panas pendamping roti.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['nama_kategori' => $category['nama_kategori']],
                $category
            );
        }
    }
}
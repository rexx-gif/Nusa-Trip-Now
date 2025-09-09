<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Pantai'],
            ['name' => 'Gunung'],
            ['name' => 'Kota'],
            ['name' => 'Desa Wisata'],
            ['name' => 'Budaya'],
            ['name' => 'Petualangan'],
            // Add more categories as needed
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}

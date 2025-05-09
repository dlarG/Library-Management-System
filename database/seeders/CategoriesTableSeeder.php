<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Fiction', 'description' => 'Imaginary stories and characters'],
            ['name' => 'Non-Fiction', 'description' => 'Factual stories and information'],
            ['name' => 'Science Fiction', 'description' => 'Futuristic, imaginative fiction'],
            ['name' => 'Fantasy', 'description' => 'Magic, supernatural elements, and imaginary worlds'],
            ['name' => 'Mystery', 'description' => 'Stories involving puzzles to be solved'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
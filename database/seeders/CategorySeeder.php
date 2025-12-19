<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Traits\LoadsMockData;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use LoadsMockData;

    /**
     * Poblar la base de datos con datos de prueba
     */
    public function run(): void
    {
        $categories = $this->getCategories();

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Traits\LoadsMockData;
use Illuminate\Database\Seeder;

class ProductUserSeeder extends Seeder
{
    use LoadsMockData;

    /**
     *Poblar la base de datos con datos de prueba
     */
    public function run(): void
    {
        $products = $this->getProducts();

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
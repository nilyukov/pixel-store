<?php

namespace Database\Seeders;

use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        BrandFactory::new()->count(20)->create();

        CategoryFactory::new()
            ->count(10)
            ->has(ProductFactory::new()->count(rand(1, 5)))
            ->create();

        ProductFactory::new()
            ->count(20)
            ->has(CategoryFactory::new()->count(rand(1, 5)))
            ->create();
    }
}

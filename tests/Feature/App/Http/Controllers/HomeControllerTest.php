<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_response(): void
    {
        Product::factory()
            ->count(5)
            ->create([
                'on_home_page' => true,
                'sorting' => 999
            ]);

        $product = Product::factory()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1
            ]);

        Brand::factory()
            ->count(5)
            ->create([
                'on_home_page' => true,
                'sorting' => 999
            ]);

        $brand = Brand::factory()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1
            ]);

        Category::factory()
            ->count(5)
            ->create([
                'on_home_page' => true,
                'sorting' => 999
            ]);

        $category = Category::factory()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1
            ]);

        $this
            ->get(route('home'))
            ->assertOk()
            ->assertViewHas('categories.0', $category)
            ->assertViewHas('brands.0', $brand)
            ->assertViewHas('products.0', $product);

    }
}

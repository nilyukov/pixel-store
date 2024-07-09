<?php

namespace App\Http\Controllers;

use Database\Factories\ProductFactory;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    public function test_success_response(): void
    {
        $product = ProductFactory::new()->createOne();
        $response = $this->get(action(ProductController::class, $product))
            ->assertOk();

        $response->assertStatus(200);
    }
}

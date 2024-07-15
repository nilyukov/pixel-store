<?php

namespace App\Http\Controllers;

use Database\Factories\ProductFactory;
use Domain\Cart\CartManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        CartManager::fake();
    }

    public function test_is_empty_cart()
    {
        $this->get(action([CartController::class, 'index']))
            ->assertStatus(200)
            ->assertViewIs('cart.index')
            ->assertViewHas('items', collect([]));
    }

    public function test_is_not_empty_cart()
    {
        $product = ProductFactory::new()->create();

        cart()->add($product);

        $this->get(action([CartController::class, 'index']))
            ->assertStatus(200)
            ->assertViewIs('cart.index')
            ->assertViewHas('items', cart()->items());
    }

    public function test_added_success()
    {
        $product = ProductFactory::new()->create();

        $this->assertEquals(0, cart()->count());

        $this->post(
            action([CartController::class, 'add'], $product),
            ['quantity' => 3]
        );

        $this->assertEquals(3, cart()->count());
    }

    public function test_quantity_changed_success()
    {
        $product = ProductFactory::new()->create();

        cart()->add($product, 3);

        $this->assertEquals(3, cart()->count());

        $this->post(
            action([CartController::class, 'quantity'], cart()->items()->first()),
            ['quantity' => 5]
        );

        $this->assertEquals(5, cart()->count());
    }

    public function test_deleted_success()
    {
        $product = ProductFactory::new()->create();

        cart()->add($product, 3);

        $this->assertEquals(3, cart()->count());

        $this->delete(
            action([CartController::class, 'delete'], cart()->items()->first())
        );

        $this->assertEquals(0, cart()->count());
    }

    public function test_truncated_success()
    {
        $product = ProductFactory::new()->create();

        cart()->add($product, 3);

        $this->assertEquals(3, cart()->count());

        $this->delete(
            action([CartController::class, 'truncate'])
        );

        $this->assertEquals(0, cart()->count());
    }
}

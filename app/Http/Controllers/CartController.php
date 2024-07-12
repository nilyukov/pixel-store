<?php

namespace App\Http\Controllers;

use Domain\Cart\Models\CartItem;
use Domain\Product\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

class CartController extends Controller
{
    #[Get('/cart', name: 'cart')]
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('cart.index', [
            'items' => cart()->items()
        ]);
    }

    #[Post('/cart/{product}/add', name: 'cart.add')]
    public function add(Product $product): RedirectResponse
    {
        flash()->info('Товар добавлен в корзину');

        cart()->add(
            $product,
            request('quantity', 1),
            request('options', [])
        );

        return redirect()->intended(route('cart'));
    }

    #[Post('/cart/{item}/quantity', name: 'cart.quantity')]
    public function quantity(CartItem $item): RedirectResponse
    {
        cart()->quantity($item, request('quantity', 1));

        flash()->info('Количество товаров изменено');

        return redirect()->intended(route('cart'));
    }

    #[Delete('/cart/{item}/delete', name: 'cart.delete')]
    public function delete(CartItem $item): RedirectResponse
    {
        cart()->delete($item);

        flash()->info('Товар удален из корзины');

        return redirect()->intended(route('cart'));
    }

    #[Delete('/cart/truncate', name: 'cart.truncate')]
    public function truncate(): RedirectResponse
    {
        cart()->truncate();

        flash()->info('Корзина очищена');

        return redirect()->intended(route('cart'));
    }
}

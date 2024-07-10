<?php

namespace App\Http\Controllers;

use App\ViewModels\ProductViewModel;
use Domain\Product\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Spatie\RouteAttributes\Attributes\Get;

class ProductController extends Controller
{
    #[Get('/product/{product:slug}', name: 'product')]
    public function __invoke(Product $product): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        session()->put('also.' . $product->id, $product->id);

        return view('product.show', new ProductViewModel($product));
    }
}

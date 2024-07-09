<?php

namespace App\Http\Controllers;

use Domain\Product\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Spatie\RouteAttributes\Attributes\Get;

class ProductController extends Controller
{
    #[Get('/product/{product:slug}', name: 'product')]
    public function __invoke(Product $product): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $product->load(['optionValues.option']);

        $also = Product::query()
            ->where(function (Builder $query) use ($product) {
                $query->whereIn('id', session('also', []))
                    ->where('id', '!=', $product->id);
            })
            ->get();

        $options = $product->optionValues->mapToGroups(fn($item) => [$item->option->title => $item]);

        session()->put('also.' . $product->id, $product->id);

        return view('product.show', [
            'product' => $product,
            'options' => $options,
            'also' => $also
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CatalogViewMiddleware;
use App\Models\Product;
use Domain\Catalog\Models\Category;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Spatie\RouteAttributes\Attributes\Get;

class CatalogController extends Controller
{
    #[Get('/catalog/{category:slug?}', name: 'catalog', middleware: CatalogViewMiddleware::class)]
    public function __invoke(?Category $category): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $categories = Category::query()
            ->select(['id', 'title', 'slug'])
            ->has('products')
            ->get();

        $products = Product::search()
            ->query(function(Builder $query) use ($category) {
                $query->select(['id', 'title', 'slug', 'thumbnail', 'price', 'json_properties'])
                    ->when($category->exists, function (Builder $query) use ($category) {
                        $query->whereRelation(
                            'categories',
                            'categories.id',
                            '=',
                            $category->id
                        );
                    })
                    ->filtered()
                    ->sorted();
            })
            ->paginate(6);

        return view('catalog.index', [
            'products' => $products,
            'categories' => $categories,
            'category' => $category
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Spatie\RouteAttributes\Attributes\Get;

class CatalogController extends Controller
{
    #[Get('/catalog/{category:slug?}', name: 'catalog')]
    public function __invoke(?Category $category): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $brands = Brand::query()
            ->select(['id', 'title'])
            ->has('products')
            ->get();

        $categories = Category::query()
            ->select(['id', 'title', 'slug'])
            ->has('products')
            ->get();

        $products = Product::query()
            ->select(['id', 'title', 'slug', 'thumbnail', 'price'])
            ->when($category->exists, function (Builder $query) use ($category) {
                $query->whereRelation(
                    'categories',
                    'categories.id',
                    '=',
                    $category->id
                );
            })
            ->filtered()
            ->sorted()
            ->paginate(6);

        return view('catalog.index', [
            'products' => $products,
            'brands' => $brands,
            'categories' => $categories,
            'category' => $category
        ]);
    }
}

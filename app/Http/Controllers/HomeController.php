<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Spatie\RouteAttributes\Attributes\Get;

class HomeController extends Controller
{
    #[Get('/', name: 'home')]
    public function __invoke(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $categories = Category::query()
            ->homePage()
            ->get();

        $products = Product::query()
            ->homePage()
            ->get();

        $brands = Brand::query()
            ->homePage()
            ->get();

        return view('index', compact(
            'categories',
            'products',
            'brands'
        ));
    }
}

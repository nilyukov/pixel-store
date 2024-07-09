<?php

namespace App\Http\Controllers;

use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Domain\Product\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Spatie\RouteAttributes\Attributes\Get;

class HomeController extends Controller
{
    #[Get('/', name: 'home')]
    public function __invoke(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $categories = CategoryViewModel::make()->homePage();

        $products = Product::query()
            ->homePage()
            ->get();

        $brands = BrandViewModel::make()->homePage();

        return view('index', compact(
            'categories',
            'products',
            'brands'
        ));
    }
}

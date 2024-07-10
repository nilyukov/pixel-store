<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CatalogViewMiddleware;
use App\ViewModels\CatalogViewModel;
use Domain\Catalog\Models\Category;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class CatalogController extends Controller
{
    #[Get('/catalog/{category:slug?}', name: 'catalog', middleware: CatalogViewMiddleware::class)]
    public function __invoke(Request $request, ?Category $category): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('catalog.index', new CatalogViewModel($request, $category));
    }
}

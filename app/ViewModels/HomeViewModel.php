<?php

namespace App\ViewModels;

use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Spatie\ViewModels\ViewModel;

class HomeViewModel extends ViewModel
{
    public function __construct()
    {
        //
    }

    public function categories(): Collection|array
    {
        return CategoryViewModel::make()->homePage();
    }

    public function products(): Collection|array
    {
        return Product::query()
            ->homePage()
            ->get();
    }

    public function brands(): Collection|array
    {
        return BrandViewModel::make()->homePage();
    }
}

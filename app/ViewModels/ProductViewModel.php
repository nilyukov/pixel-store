<?php

namespace App\ViewModels;

use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Spatie\ViewModels\ViewModel;

class ProductViewModel extends ViewModel
{
    public function __construct(
        public Product $product
    )
    {
        $this->product->load(['optionValues.option']);
    }

    public function options()
    {
        return $this->product->optionValues->keyValues();
    }

    public function also(): Collection|array
    {
        return Product::query()
            ->where(function (Builder $query) {
                $query->whereIn('id', session('also', []))
                    ->where('id', '!=', $this->product->id);
            })
            ->get();
    }
}

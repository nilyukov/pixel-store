<?php

namespace App\Models;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Casts\PriceCast;
use Support\Traits\HasSlug;
use Support\Traits\HasThumbnail;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'price',
        'on_home_page',
        'sorting'
    ];

    protected $casts = [
        'price' => PriceCast::class
    ];

    protected function thumbnailDir(): string
    {
        return 'products';
    }

    public function brand(): BelongsTo {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany {
        return $this->belongsToMany(Category::class);
    }

    public function scopeHomePage(Builder $query): void
    {
        $query->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }

    public function scopeFiltered(Builder $query): void
    {
        foreach(filters() as $filter) {
            $query = $filter->apply($query);
        }
    }

    public function scopeSorted(Builder $query): void
    {
        $query->when(request('sort'), function (Builder $query) {
            $column = request()->str('sort');
            if ($column->contains(['price', 'title'])) {
                $direction = $column->contains('-') ? 'desc' : 'asc';
                $query->orderBy((string) $column->remove('-'), $direction);
            }
        });

    }
}

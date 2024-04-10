<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'price'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Product $product) {
            $product->slug = $product->slug ?? Str::slug($product->title);
        });
    }

    public function brand(): BelongsTo {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany {
        return $this->belongsToMany(Category::class);
    }
}

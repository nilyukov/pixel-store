<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Brand $brand) {
            $brand->slug = $brand->slug ?? Str::slug($brand->title);
        });
    }

    public function products(): HasMany {
        return $this->hasMany(Product::class);
    }
}

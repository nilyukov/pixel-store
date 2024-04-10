<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Category $category) {
            $category->slug = $category->slug ?? Str::slug($category->title);
        });
    }

    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class);
    }
}

<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $item) {
            $item->slug = $item->slug ?? Str::slug($item->{self::slugFrom()});
        });
    }

    public static function slugFrom(): string
    {
        return 'title';
    }
}

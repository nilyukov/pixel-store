<?php

namespace Domain\Catalog\Facades;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Facade;

/**
 * Get the accessor for the Sorter facade.
 * @method static Builder run(Builder $query)
 * @see \Domain\Catalog\Sorters\Sorter
 *
 */
class Sorter extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return \Domain\Catalog\Sorters\Sorter::class;
    }
}

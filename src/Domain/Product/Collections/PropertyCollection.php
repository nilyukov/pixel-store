<?php

namespace Domain\Product\Collections;

use Illuminate\Support\Collection;

class PropertyCollection extends Collection
{
    public function keyValues(): PropertyCollection
    {
        return $this->mapWithKeys(fn($property) => [$property->title => $property->pivot->value]);
    }
}

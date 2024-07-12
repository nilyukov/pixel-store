<?php

namespace Domain\Product\Collections;

use Illuminate\Database\Eloquent\Collection;

class OptionValueCollection extends Collection
{
    public function keyValues(): \Illuminate\Support\Collection
    {
        return $this->mapToGroups(fn($item) => [$item->option->title => $item]);
    }
}

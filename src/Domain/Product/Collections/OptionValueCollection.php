<?php

namespace Domain\Product\Collections;

use Illuminate\Support\Collection;

class OptionValueCollection extends Collection
{
    public function keyValues(): OptionValueCollection
    {
        return $this->mapToGroups(fn($item) => [$item->option->title => $item]);
    }
}

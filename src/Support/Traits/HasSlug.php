<?php

namespace Support\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(fn (Model $item) => $item->makeSlug());
    }

    protected function makeSlug(): void {
        if (!$this->slug) {
            $this->slug = $this->slugUnique(
                str($this->{$this->slugFrom()})
                    ->slug()
                    ->value()
            );
        }
    }

    protected function slugUnique(string $slug): string {
        $originalSlug = $slug;
        $i = 0;

        while ($this->isSlugExists($slug)) {
            $i++;

            $slug = $originalSlug . '-' . $i;
        }

        return $slug;
    }

    protected function isSlugExists(string $slug): bool {
        return $this->newQuery()->where('slug', $slug)->withoutGlobalScopes()->exists();
    }

    protected function slugFrom(): string
    {
        return 'title';
    }
}

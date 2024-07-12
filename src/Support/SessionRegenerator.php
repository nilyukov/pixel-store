<?php

namespace Support;

use App\Events\AfterSessionRegenerated;
use Closure;

class SessionRegenerator
{
    public static function run(Closure $callback = null): void
    {
        $oldId = request()->session()->getId();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        if (!is_null($callback)) {
            $callback();
        }

        event(new AfterSessionRegenerated(
            $oldId,
            request()->session()->getId()
        ));
    }
}

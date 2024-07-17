<?php

namespace Support;

use Closure;
use Illuminate\Support\Facades\DB;
use Throwable;

class Transaction
{
    /**
     * @throws Throwable
     */
    public static function run(
        Closure $callback,
        Closure $finished = null,
        Closure $onError = null,
    )
    {
        try {
            DB::beginTransaction();

            return tap($callback(), function ($callbackResult) use ($finished) {
                DB::commit();

                if (!is_null($finished)) {
                    $finished($callbackResult);
                }
            });
        } catch (Throwable $e) {
            DB::rollBack();

            if ($onError) {
                $onError($e);
            }

            throw $e;
        }
    }
}

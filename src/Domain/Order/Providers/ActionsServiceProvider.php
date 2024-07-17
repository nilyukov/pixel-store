<?php

namespace Domain\Order\Providers;

use Domain\Order\Actions\NewOrderAction;
use Domain\Order\Contracts\NewOrderActionContract;
use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    public array $bindings = [
        NewOrderActionContract::class => NewOrderAction::class
    ];
}

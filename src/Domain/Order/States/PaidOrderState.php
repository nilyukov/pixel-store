<?php

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatuses;

class PaidOrderState extends OrderState
{
    protected array $allowedTransitions = [
        CanceledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return OrderStatuses::Paid->value;
    }

    public function humanValue(): string
    {
        return 'Оплаченный заказ';
    }
}

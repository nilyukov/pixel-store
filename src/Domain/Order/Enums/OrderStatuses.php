<?php

namespace Domain\Order\Enums;

use Domain\Order\Models\Order;
use Domain\Order\States\CanceledOrderState;
use Domain\Order\States\NewOrderState;
use Domain\Order\States\OrderState;
use Domain\Order\States\PaidOrderState;
use Domain\Order\States\PendingOrderState;

enum OrderStatuses: string
{
    case Canceled = 'canceled';
    case New = 'new';
    case Paid = 'paid';
    case Pending = 'pending';

    public function createState(Order $order): OrderState
    {
        return match ($this) {
            OrderStatuses::New => new NewOrderState($order),
            OrderStatuses::Paid => new PaidOrderState($order),
            OrderStatuses::Pending => new PendingOrderState($order),
            OrderStatuses::Canceled => new CanceledOrderState($order),
        };
    }
}

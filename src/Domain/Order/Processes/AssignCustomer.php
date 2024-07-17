<?php

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\DTOs\NewOrderDTO;
use Domain\Order\Models\Order;

class AssignCustomer implements OrderProcessContract
{
    public function __construct(protected NewOrderDTO $dto)
    {
    }

    public function handle(Order $order, $next)
    {
        $order->orderCustomer()
            ->create($this->dto->customer);

        return $next($order);
    }
}

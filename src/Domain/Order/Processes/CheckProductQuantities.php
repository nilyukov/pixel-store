<?php

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Exceptions\OrderProcessException;
use Domain\Order\Models\Order;
use Exception;

class CheckProductQuantities implements OrderProcessContract
{

    /**
     * @throws OrderProcessException
     */
    public function handle(Order $order, $next)
    {
        foreach (cart()->items() as $item) {
            if ($item->product->quantity < $item->quantity) {
                throw new OrderProcessException('Количество продукции на складе меньше чем вы указали', 400);
            }
        }

        return $next($order);
    }
}

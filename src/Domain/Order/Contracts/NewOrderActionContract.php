<?php

namespace Domain\Order\Contracts;

use Domain\Order\DTOs\NewOrderDTO;
use Domain\Order\Models\Order;

interface NewOrderActionContract
{
    public function __invoke(NewOrderDTO $dto): Order;
}

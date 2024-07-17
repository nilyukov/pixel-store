<?php

namespace Domain\Order\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Domain\Order\Contracts\NewOrderActionContract;
use Domain\Order\DTOs\NewOrderDTO;
use Domain\Order\Models\Order;

class NewOrderAction implements NewOrderActionContract
{
    public function __invoke(NewOrderDTO $dto): Order
    {
        $registerAction = app(RegisterNewUserContract::class);

        if (request()->get('create_account')) {
            $registerAction(NewUserDTO::make(
                $dto->customer['first_name'] . ' ' . $dto->customer['last_name'],
                $dto->customer['email'],
                $dto->password
            ));
        }

        return Order::query()->create([
            'payment_method_id' => $dto->payment_method_id,
            'delivery_type_id' => $dto->delivery_type_id
        ]);
    }
}

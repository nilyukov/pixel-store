<?php

namespace Domain\Order\DTOs;

use App\Http\Requests\OrderFormRequest;
use Support\Traits\Makeable;

readonly class NewOrderDTO
{
    use Makeable;
    public function __construct(
        public array $customer,
        public ?string $password,
        public int $delivery_type_id,
        public int $payment_method_id
    )
    {
    }

    public static function fromRequest(OrderFormRequest $request): self
    {
        return static::make(...$request->only('customer', 'password', 'delivery_type_id', 'payment_method_id'));
    }
}

<?php

namespace Domain\Auth\DTOs;

use Illuminate\Http\Request;
use Support\Traits\Makeable;

readonly class NewUserDTO
{
    use Makeable;
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    )
    {
    }

    public static function fromRequest(Request $request): self
    {
        return static::make(...$request->only('name', 'email', 'password'));
    }
}

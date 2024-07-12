<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Support\SessionRegenerator;

class RegisterNewUserAction implements RegisterNewUserContract
{
    public function __invoke(NewUserDTO $dto): void
    {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => bcrypt($dto->password),
        ]);

        event(new Registered($user));

        SessionRegenerator::run(fn() => auth()->login($user));
    }
}

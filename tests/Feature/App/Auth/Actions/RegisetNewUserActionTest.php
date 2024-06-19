<?php

namespace App\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisetNewUserActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_user_created(): void
    {
        $this->assertDatabaseMissing('users', [
            'email' => 'test@gmail.com'
        ]);

        $action = app(RegisterNewUserContract::class);
        $action(NewUserDTO::make('Test', 'test@gmail.com', '12345678'));

        $this->assertDatabaseHas('users', [
            'email' => 'test@gmail.com'
        ]);
    }
}

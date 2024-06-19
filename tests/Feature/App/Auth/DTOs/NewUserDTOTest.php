<?php

namespace App\Auth\DTOs;

use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\DTOs\NewUserDTO;
use Tests\TestCase;

class NewUserDTOTest extends TestCase
{
    public function test_instance_created_from_form_request(): void
    {
        $dto = NewUserDTO::fromRequest(new SignUpFormRequest([
            'name' => 'test',
            'email' => 'test',
            'password' => 'test'
        ]));

        $this->assertInstanceOf(NewUserDTO::class, $dto);
    }
}

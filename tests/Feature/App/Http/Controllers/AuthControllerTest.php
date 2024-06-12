<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\RequestFactories\SignInFormRequestFactory;
use Tests\RequestFactories\SignUpFormRequestFactory;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function test_login_page_success(): void
    {
        $this->get(action([SignInController::class, 'page']))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');
    }

    public function test_signup_page_success(): void
    {
        $this->get(action([SignUpController::class, 'page']))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.sign-up');
    }

    public function test_forgot_page_success(): void
    {
        $this->get(action([ForgotPasswordController::class, 'page']))
            ->assertOk()
            ->assertSee('Забыли пароль')
            ->assertViewIs('auth.forgot-password');
    }


    public function test_reset_page_success(): void
    {
        $this->get(action([ResetPasswordController::class, 'page'], 'token'))
            ->assertOk()
            ->assertSee('Сброс пароля')
            ->assertViewIs('auth.reset-password');
    }

    public function test_sign_in_success(): void
    {
        $password = '12345678';
        $user = User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => bcrypt($password)
        ]);

        $request = SignInFormRequestFactory::new()->create([
            'email' => $user->email,
            'password' => $password,
        ]);

        $response = $this->post(
            action([SignInController::class, 'handle']),
            $request
        );

        $response->assertValid()->assertRedirect(route('index'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_store_success(): void
    {
        Notification::fake();
        Event::fake();

        $request = SignUpFormRequestFactory::new()->create([
            'name' => 'test',
            'email' => 'test2@gmail.com',
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => $request['email'],
        ]);

        $response = $this->post(
            action([SignUpController::class, 'handle']),
            $request
        );

        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'email' => $request['email'],
        ]);

        $user = User::query()->where('email', $request['email'])->first();

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $this->assertNotEmpty($user);

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('index'));
    }

    function test_log_out_success(): void
    {
        $user = User::factory()->create([
            'email' => 'testing@gmail.com',
        ]);

        $response = $this->actingAs($user)
            ->delete(action([SignInController::class, 'logOut']));

        $this->assertGuest();

        $response->assertRedirect(route('index'));
    }
}

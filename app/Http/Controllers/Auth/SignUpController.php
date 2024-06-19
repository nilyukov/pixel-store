<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

class SignUpController extends Controller
{
    #[Get('/sign-up', name: 'register', middleware: ['guest'])]
    public function page(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('auth.sign-up');
    }

    #[Post('/sign-up', name: 'register.handle')]
    public function handle(SignUpFormRequest $request, RegisterNewUserContract $action): RedirectResponse
    {
        // TODO make try...catch
        $action(NewUserDTO::fromRequest($request));

        return redirect()->intended(route('home'));
    }
}

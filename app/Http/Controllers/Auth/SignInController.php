<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInFormRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

class SignInController extends Controller
{
    #[Get('/login', name: 'login', middleware: ['guest'])]
    public function page(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('auth.login');
    }

    #[Post('/login', name: 'login.handle', middleware: ['throttle:auth'])]
    public function handle(SignInFormRequest $request): RedirectResponse
    {
        if (!auth()->attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'Такого e-mail не существует.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('index'));
    }

    #[Delete('/logout', name: 'logOut')]
    public function logOut(): RedirectResponse
    {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('index');
    }
}

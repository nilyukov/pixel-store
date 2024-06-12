<?php

namespace App\Http\Controllers;

use Spatie\RouteAttributes\Attributes\Get;

class HomeController extends Controller
{
    #[Get('/', name: 'index')]
    public function __invoke()
    {
        return view('index');
    }
}

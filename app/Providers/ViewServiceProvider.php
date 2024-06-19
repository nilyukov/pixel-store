<?php

namespace App\Providers;

use App\Menu\Menu;
use App\Menu\MenuItem;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Vite::macro('image', fn($asset) => $this->asset('resources/images/' . $asset));

        View::composer('*', fn($view) => (
            $view->with(
                'menu',
                Menu::make()
                    ->add(MenuItem::make(route('home'), 'Главная'))
            )
        ));
    }
}

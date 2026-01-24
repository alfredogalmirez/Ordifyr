<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function($view){
            $count = 0;

            if(Auth::check()){
                $cart = Cart::with('items')->where('user_id', Auth::id())->first();
                $count = $cart?->items->sum('quantity') ?? 0;
            }

            $view->with('cartCount', $count);
        });
    }
}

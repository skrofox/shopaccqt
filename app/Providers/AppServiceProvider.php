<?php

namespace App\Providers;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
        //
        View::composer('layouts.header', function ($view) {
            // $cart = Session::get('cart', []);
            $cartCount = 0;

            if (Auth::check()) {
                $cartCount = CartItem::where('user_id', Auth::user()->id)->count();
                // $user = Auth::user();
            }

            $view->with('cartCount', $cartCount);
        });
    }
}

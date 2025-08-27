<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
public const PENJUAL_HOME = '/penjual/dashboard';

    /**
     * Bootstrap any application services.
     */
 

    public function boot()
{
    Inertia::share([
        'auth' => [
            'user' => fn () => Auth::user(),
            'penjual' => fn () => Auth::guard('penjual')->user(),
            'admin' => fn () => Auth::guard('admin')->user(),
        ],
    ]);
}
}

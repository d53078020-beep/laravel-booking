<?php

namespace App\Providers;

use App\Models\Booking;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        View::composer('layouts.default', function ($view) {
            $activeBookingsCount = auth()->check()
                ? Booking::where('user_id', auth()->id())
                ->where('status', '!=', 'cancelled')
                ->count()
                : 0;
            $view->with('activeBookingsCount', $activeBookingsCount);
        });
        Paginator::useBootstrapFive();
    }
}

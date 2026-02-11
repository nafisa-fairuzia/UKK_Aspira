<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Session;
// TAMBAHKAN IMPORT INI:
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
        Paginator::useBootstrapFive();

        view()->composer('*', function ($view) {
            $role = Session::get('role');

            if ($role === 'admin') {
                $unreadNotifications = Notifikasi::forAdmin()
                    ->unread()
                    ->latest()
                    ->take(10)
                    ->get();

                $view->with('unreadNotifications', $unreadNotifications);
            }

            if ($role === 'siswa') {
                $unreadNotifications = Notifikasi::forSiswa()
                    ->unread()
                    ->latest()
                    ->take(10)
                    ->get();

                $view->with('unreadNotifications', $unreadNotifications);
            }
        });
    }
}

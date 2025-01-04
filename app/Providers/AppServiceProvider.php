<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\notifications;

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
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $userId = Auth()->user()->id;
                // Fetch notifications for the logged-in user (based on notify_id)
                // and exclude those the user has already marked as read
                $notifications = notifications::where('notification_for', $userId)
                    ->whereNotIn('id', function ($query) use ($userId) {
                        $query->select('notification_id')
                            ->from('readnotifications')
                            ->where('user_id', $userId);
                    })
                    ->get();

                $view->with('notifications', $notifications);
            }
        });
        Paginator::useBootstrap();
    }
}

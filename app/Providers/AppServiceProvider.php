<?php

namespace App\Providers;

use App\Models\Message;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
            $headerNotifications = collect();
            $unreadNotificationsCount = 0;
            $headerMessages = collect();
            $unreadMessagesCount = 0;

            if (Auth::check()) {
                $headerNotifications = Notification::where('user_id', Auth::id())
                    ->latest()
                    ->take(5)
                    ->get();

                $unreadNotificationsCount = Notification::where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->count();

                $headerMessages = Message::with('sender')
                    ->where('receiver_id', Auth::id())
                    ->latest()
                    ->take(5)
                    ->get();

                $unreadMessagesCount = Message::where('receiver_id', Auth::id())
                    ->where('is_read', false)
                    ->count();
            }

            $view->with('headerNotifications', $headerNotifications);
            $view->with('unreadNotificationsCount', $unreadNotificationsCount);
            $view->with('headerMessages', $headerMessages);
            $view->with('unreadMessagesCount', $unreadMessagesCount);
        });
    }
}

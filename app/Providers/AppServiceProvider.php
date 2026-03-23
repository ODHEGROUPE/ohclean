<?php

namespace App\Providers;

use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
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
        App::setLocale(config('app.locale', 'fr'));
        Carbon::setLocale(App::currentLocale());

        View::composer('admin.partials.header', function ($view) {
            $user = Auth::user();

            if (!$user) {
                $view->with('headerNotifications', collect());
                $view->with('unreadNotificationsCount', 0);
                return;
            }

            $notifications = Notification::with('commande')
                ->where('user_id', $user->id)
                ->latest()
                ->take(8)
                ->get();

            $unreadCount = Schema::hasColumn('notifications', 'lue_at')
                ? Notification::where('user_id', $user->id)->whereNull('lue_at')->count()
                : 0;

            $view->with('headerNotifications', $notifications);
            $view->with('unreadNotificationsCount', $unreadCount);
        });
    }
}

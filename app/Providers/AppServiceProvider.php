<?php
namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use App\Listeners\UpdateLastLoginAt;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider {
    public function register(): void {}
    public function boot(): void {
        Gate::before(function ($user, string $ability) {
            if ($user->hasRole('Owner')) return true;
            return null;
        });
        Gate::define('reports.aging.view', function ($user) {
            return $user->can('aging-receivable.view') || $user->can('aging-payable.view');
        });
        Event::listen(Login::class, UpdateLastLoginAt::class);
    }
}

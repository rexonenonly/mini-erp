<?php
namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use App\Listeners\UpdateLastLoginAt;
use Illuminate\Support\ServiceProvider;
use App\Domain\Accounting\Services\JournalPoster;
use App\Domain\Core\Contracts\StockLedger as StockLedgerContract;
use App\Domain\Core\Contracts\PeriodGuard as PeriodGuardContract;
use App\Domain\Core\Services\PeriodGuard;
use App\Domain\Inventory\Services\StockLedger;
use App\Domain\Accounting\Listeners\CreateJournalEntry;

class AppServiceProvider extends ServiceProvider {
    public function register(): void {
        // Bind domain contracts
        $this->app->singleton(StockLedgerContract::class, StockLedger::class);
        $this->app->singleton(PeriodGuardContract::class, PeriodGuard::class);
        $this->app->bind(JournalPoster::class); // not singleton: accountCache must not cross requests
    }
    public function boot(): void {
        // Register accounting event subscriber
        Event::subscribe(CreateJournalEntry::class);
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

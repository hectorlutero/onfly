<?php

namespace App\Providers;

use App\Models\Expense;
use App\Models\User;
use App\Policies\ExpensePolicy;
use App\Repositories\Contracts\ExpenseRepositoryInterface;
use App\Repositories\ExpenseEloquentORM;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $policies = [
        Expense::class => ExpensePolicy::class,
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ExpenseRepositoryInterface::class,
            ExpenseEloquentORM::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Gate::policy(Expense::class, ExpensePolicy::class);
    }
}

<?php

namespace App\Providers;

use App\Models\Malfunction;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\RolePolicy;
use App\Policies\TicketPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Malfunction::class => RolePolicy::class,
        Ticket::class => TicketPolicy::class,
        User::class => RolePolicy::class,
    ];

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
        $this->registerPolicies();

        // Aqui você pode adicionar gates personalizados, se necessário.
    }
}

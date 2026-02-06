<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        // IMPORTANTE! Ativa as policies e os Gates.
        $this->registerPolicies();

        Gate::define('excluir', function (User $user) {
            return (int) $user->access_level === 1;
        });

        Gate::define('ver-campos', function (User $user) {
            return (int) $user->access_level === 1;
        });

         Gate::define('exclu', function (User $user) {
            return (int) $user->access_level === 2;
        });

        Gate::define('ver-campos', function (User $user) {
            return (int) $user->access_level === 2;
        });
    }
}

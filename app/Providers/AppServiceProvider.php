<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\ServiceProvider;

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
        AnonymousResourceCollection::macro('paginationInformation', function ($request, $paginated, $default) {
            return [
                'pagination' => [
                    'current_page' => $default['meta']['current_page'],
                    'last_page' => $default['meta']['last_page'],
                    'per_page' => $default['meta']['per_page'],
                    'total' => $default['meta']['total'],
                ],
            ];
        });
    }
}

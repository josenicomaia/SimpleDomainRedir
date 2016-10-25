<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use SimpleDomainRedir\Domain\Dns\ResolverFactory as ResolverFactoryContract;
use SimpleDomainRedir\Infrastructure\Dns\ResolverFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ResolverFactoryContract::class, ResolverFactory::class);
    }
}

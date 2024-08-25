<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Payment\ProccessPayment;

class ProccessPaymentProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        
        $this->app->bind('ProccessPaymentFacade', function () {
            return new ProccessPayment();
        });

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

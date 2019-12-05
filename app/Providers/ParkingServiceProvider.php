<?php

namespace App\Providers;

use App\Parking\Manager;
use App\Parking\RateManager;
use App\Parking\Facades\Rates;
use App\Parking\Facades\Parking;
use Illuminate\Support\ServiceProvider;

class ParkingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('parking.rates', function () {
            return new RateManager;
        });

        $this->app->singleton('parking.manager', function () {
            return new Manager;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Rates::add(1, 300)
            ->add(3, 450)
            ->add(6, 675)
            ->max(1015);

        // Parking::setTotalSpaces(10);
        // Parking::setTicketExpiredDelay(15);
    }
}

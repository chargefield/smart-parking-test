<?php

namespace App\Parking\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Parking\RateManager add(int $duration, int $amount)
 * @method static \App\Parking\RateManager max(int $amount)
 * @method static \Illuminate\Support\Collection all()
 * @method static \App\Parking\Rate getRateFromDuration()
 *
 * @see \App\Parking\RateManager
 */
class Rates extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'parking.rates';
    }
}
